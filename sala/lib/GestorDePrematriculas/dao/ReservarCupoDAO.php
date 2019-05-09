<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dao;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\entidad\ReservaCupo;
use \Sala\entidad\Grupo;
use \Sala\entidadDAO\ReservaCupoDAO;
use \Sala\lib\GestorDePrematriculas\interfaces\IReservarCupoDAO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\GrupoDTO;

/**
 * Description of RerservaCupoDAO
 *
 * @author Andres
 */
class ReservarCupoDAO implements IReservarCupoDAO{
    
    public function __construct() {}
    
    public function borrarReserva(EstudianteDTO $estudianteDTO, $grupoid) {
        $result = false;
        
        $reservaCupoEnt = $this->validarExisteReserva($estudianteDTO, $grupoid);
        
        if(!empty($reservaCupoEnt->getId())){
            $reservaCupoDAO = new ReservaCupoDAO($reservaCupoEnt);
            $result = $reservaCupoDAO->delete();
        }
        echo json_encode(array("s"=>$result));
    }

    public function consultarReservas(EstudianteDTO $estudianteDTO) {
        $db = Factory::createDbo();
        $return = array();
        $where = " idEstudiante = ".$db->qstr($estudianteDTO->getCodigo());
        
        $reserva = ReservaCupo::getList($where);
        
        if(!empty($reserva)){
            foreach($reserva as $r){
                $entGrupo = new Grupo();
                $entGrupo->setIdgrupo($r->getIdGrupo());
                $entGrupo->getById();
                
                $GrupoDTO = new GrupoDTO();
                $GrupoDTO->setId($entGrupo->getIdgrupo());
                $GrupoDTO->setDocente($entGrupo->getNumerodocumento());
                $GrupoDTO->setEstado($entGrupo->getCodigoestadogrupo());
                $GrupoDTO->setMateria($entGrupo->getCodigomateria());
                $GrupoDTO->setNombre($entGrupo->getNombregrupo());
                $GrupoDTO->setCodigoGrupo($entGrupo->getCodigogrupo());
                $GrupoDTO->setCupoMaximo($entGrupo->getMaximogrupo());
                $GrupoDTO->setCupoOcupado($entGrupo->getMatriculadosgrupo());
                $GrupoDTO->setCupoElectiva($entGrupo->getMaximogrupoelectiva());
                $GrupoDTO->setMatriculadosElectiva($entGrupo->getMatriculadosgrupoelectiva());
                $return[] = $GrupoDTO;
            }
        }
        return $return;
    }

    public function reservarCupo(EstudianteDTO $estudianteDTO, $grupoid) {
        $result = false;
        $reservaCupoEnt = $this->validarExisteReserva($estudianteDTO, $grupoid);
        
        if(empty($reservaCupoEnt->getId())){
            $reservaCupoEnt->setIdEstudiante($estudianteDTO->getCodigo());
            $reservaCupoEnt->setIdGrupo($grupoid);
            $reservaCupoEnt->setFechaReserva(date("Y-m-d H:i:s"));
            
            $reservaCupoDAO = new ReservaCupoDAO($reservaCupoEnt);
            $result = $reservaCupoDAO->save();
        }
        return $result;
    }
    
    private function validarExisteReserva(EstudianteDTO $estudianteDTO, $grupoid){
        $db = Factory::createDbo();
        $return = NULL;
        $where = " idEstudiante = ".$db->qstr($estudianteDTO->getCodigo())." AND idGrupo = ".$db->qstr($grupoid);
        
        $reserva = ReservaCupo::getList($where);
        
        if(!empty($reserva)){
            $return = $reserva[0];
        }else{
            $return = new ReservaCupo();
        }
        return $return;
    }

}
