<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\auxiliaresPlanEstudio;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\entidad\Horario;
use \Sala\entidad\Grupo;
use \Sala\entidad\ReservaCupo;
use \Sala\lib\GestorDePrematriculas\interfaces\auxiliaresPlanEstudio\IGrupo;
use \Sala\lib\GestorDePrematriculas\dto\HorarioDTO;
use \Sala\lib\GestorDePrematriculas\dto\MateriaDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\GrupoDTO;

/**
 * Description of GrupoImpl
 *
 * @author Andres
 */
class GrupoImpl implements IGrupo {
    private $id;
    private $docente;
    private $estado;
    private $materia;
    private $nombre;
    private $codigoGrupo;
    private $cupoMaximo;
    private $cupoOcupado;
    private $cupoElectiva;
    private $matriculadosElectiva;
    private $periodoDTO;
    private $horariosGrupo = array();
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDocente() {
        return $this->docente;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getMateria() {
        return $this->materia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPeriodoDTO() {
        return $this->periodoDTO;
    }
    
    public function getCodigoGrupo() {
        return $this->codigoGrupo;
    }

    public function getCupoMaximo() {
        return $this->cupoMaximo;
    }

    public function getCupoOcupado() {
        return $this->cupoOcupado;
    }

    public function getCupoElectiva() {
        return $this->cupoElectiva;
    }

    public function getMatriculadosElectiva() {
        return $this->matriculadosElectiva;
    }
    public function getHorariosGrupo() {
        return $this->horariosGrupo;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setDocente($docente) {
        $this->docente = $docente;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setMateria($materia) {
        $this->materia = $materia;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPeriodoDTO($periodoDTO) {
        $this->periodoDTO = $periodoDTO;
    }

    public function setCodigoGrupo($codigoGrupo) {
        $this->codigoGrupo = $codigoGrupo;
    }

    public function setCupoMaximo($cupoMaximo) {
        $this->cupoMaximo = $cupoMaximo;
    }

    public function setCupoOcupado($cupoOcupado) {
        $this->cupoOcupado = $cupoOcupado;
    }

    public function setCupoElectiva($cupoElectiva) {
        $this->cupoElectiva = $cupoElectiva;
    }

    public function setMatriculadosElectiva($matriculadosElectiva) {
        $this->matriculadosElectiva = $matriculadosElectiva;
    }
    
    public function setHorariosGrupo() {
        $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
        $db = Factory::createDbo();
        $where = " idgrupo = ".$db->qstr($this->getId())
                . " AND codigoestado = 100";
        $listadoHorarios = Horario::getList($where);
        
        $i=0;
        if(!empty($listadoHorarios)){
            foreach($listadoHorarios as $horario){
                $this->horariosGrupo[$i] = new HorarioDTO($horario->getCodigodia(), $dias[$horario->getCodigodia()], $horario->getHorainicial(), $horario->getHorafinal());
                $i++;
            }
        } else {
            $this->horariosGrupo[$i] = new HorarioDTO(0, "Sin horario", "00:00", "00:00");
        }
    }

    public function getGruposMateria(MateriaDTO $materia, PeriodoDTO $periodoDTO) {
        $return = array();
        $db = Factory::createDbo();
        $where = " codigomateria = ".$db->qstr($materia->getId())
                . " AND matriculadosgrupo < maximogrupo" 
                . " AND codigoperiodo = ".$db->qstr($periodoDTO->getCodigoPeriodo());
        $eGrupo = Grupo::getList($where);
        if(!empty($eGrupo)){
            foreach($eGrupo as $g){
                $GrupoDTO = new GrupoDTO();
                $GrupoDTO->setId($g->getIdgrupo());
                $GrupoDTO->setDocente($g->getNumerodocumento());
                $GrupoDTO->setEstado($g->getCodigoestadogrupo());
                $GrupoDTO->setNombre($g->getNombregrupo());
                $GrupoDTO->setCodigoGrupo($g->getCodigogrupo());
                $GrupoDTO->setCupoMaximo($g->getMaximogrupo());
                $db = Factory::createDbo();
                //7200 -> 2 horas
                $where = " idGrupo = ".$db->qstr($g->getIdgrupo()) 
                        . " AND TIMESTAMPDIFF(SECOND, fechaReserva, NOW()) <= 7200 "
                        . " AND idEstudiante <> ".$db->qstr(Factory::getSessionVar('codigo')) ;
                
                $reserva = ReservaCupo::getList($where);
                
                $GrupoDTO->setCupoOcupado($g->getMatriculadosgrupo()+count($reserva));
                $GrupoDTO->setPeriodoDTO($periodoDTO);
                $GrupoDTO->setHorariosGrupo();
                $return[] = $GrupoDTO;
            }
        }
        return $return;
    }

}
