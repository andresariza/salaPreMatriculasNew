<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;

/**
 * Description of GrupoImpl
 *
 * @author Andres
 */
class GrupoImpl implements \Sala\lib\GestorDePrematriculas\interfaces\IGrupo {
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
        $db = \Sala\lib\Factory::createDbo();
        $where = " idgrupo = ".$db->qstr($this->getId())
                . " AND codigoestado = 100";
        $listadoHorarios = \Sala\entidad\Horario::getList($where);
        
        $i=0;
        if(!empty($listadoHorarios)){
            foreach($listadoHorarios as $horario){
                $this->horariosGrupo[$i] = new \Sala\lib\GestorDePrematriculas\dto\HorarioDTO($horario->getCodigodia(), $dias[$horario->getCodigodia()], $horario->getHorainicial(), $horario->getHorafinal());
                $i++;
            }
        } else {
            $this->horariosGrupo[$i] = new \Sala\lib\GestorDePrematriculas\dto\HorarioDTO(0, "Sin horario", "00:00", "00:00");
        }
    }
    
    public function quitar() {
        
    }

    public function seleccionar() {
        
    }

}
