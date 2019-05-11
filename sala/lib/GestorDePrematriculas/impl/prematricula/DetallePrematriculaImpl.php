<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\prematricula;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\entidad\Grupo;
use \Sala\entidad\ReservaCupo;
use \Sala\lib\GestorDePrematriculas\interfaces\prematricula\IDetallePrematricula;
use \Sala\lib\GestorDePrematriculas\dto\GrupoDTO;

/**
 * Description of DetallePrematriculaImpl
 *
 * @author Andres
 */
class DetallePrematriculaImpl implements IDetallePrematricula{
    private $periodoDTO;
    private $materiaGrupo = array();
    public function __construct($periodoDTO) {
        $this->periodoDTO = $periodoDTO;
    }

    public function agregrarGrupoDetalle($grupoId, $materiaId) {
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
        $this->materiaGrupo[] = array($materiaId,$grupoId);
        return true;
    }

}
