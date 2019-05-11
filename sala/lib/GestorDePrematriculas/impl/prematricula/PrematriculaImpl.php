<?php

namespace Sala\lib\GestorDePrematriculas\impl\prematricula;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\prematricula\IPrematricula;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrematriculaImpl
 *
 * @author Andres
 */
class PrematriculaImpl implements IPrematricula{
    private $estudianteDTO;
    private $periodoDTO;
    private $detalleMateriaGrupo = array();
    
    public function __construct(EstudianteDTO $estudianteDTO, PeriodoDTO $periodoDTO) {
        $this->estudianteDTO = $estudianteDTO;
        $this->periodoDTO = $periodoDTO;
    }

    public function agregrarPrematricula() {
        //echo "aca se debe agregar la funcionalidad de agregar Prematricula";
        return $this;
    }

    public function agregrarDetalleMateriaGrupo($materiaId,$grupoId) {
        /*$entGrupo = new Grupo();
        $entGrupo->setIdgrupo($grupoId);
        $entGrupo->getById(); 
        $GrupoDTO = new GrupoDTO();
        $GrupoDTO->setId($entGrupo->getIdgrupo());
        $GrupoDTO->setDocente($entGrupo->getNumerodocumento());
        $GrupoDTO->setEstado($entGrupo->getCodigoestadogrupo());
        $GrupoDTO->setNombre($entGrupo->getNombregrupo());
        $GrupoDTO->setCodigoGrupo($entGrupo->getCodigogrupo());
        $GrupoDTO->setCupoMaximo($entGrupo->getMaximogrupo());
        $db = Factory::createDbo();
        //7200 -> 2 horas
        $where = " idGrupo = ".$db->qstr($entGrupo->getIdgrupo()) 
                . " AND TIMESTAMPDIFF(SECOND, fechaReserva, NOW()) <= 7200 "
                . " AND idEstudiante <> ".$db->qstr(Factory::getSessionVar('codigo')) ;
        $reserva = ReservaCupo::getList($where);
        $GrupoDTO->setCupoOcupado($entGrupo->getMatriculadosgrupo()+count($reserva));
        $GrupoDTO->setPeriodoDTO($this->periodoDTO);
        $GrupoDTO->setHorariosGrupo();/**/
        $this->detalleMateriaGrupo[] = array($materiaId,$grupoId);
        return true;
    }

}
