<?php

namespace Sala\lib\GestorDePrematriculas\impl\prematricula;
defined('_EXEC') or die;

use \Sala\lib\Factory;
use \Sala\entidad\Materia;
use \Sala\entidad\Prematricula;
use \Sala\entidad\DetallePrematricula;
use \Sala\entidad\Grupo;
use \Sala\entidad\ReservaCupo;
use \Sala\entidadDAO\PrematriculaDAO;
use \Sala\entidadDAO\DetallePrematriculaDAO;
use \Sala\entidadDAO\GrupoDAO;
use \Sala\entidadDAO\ReservaCupoDAO;
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
    private $prematriculaEnt;
    
    public function __construct(EstudianteDTO $estudianteDTO, PeriodoDTO $periodoDTO) {
        $this->estudianteDTO = $estudianteDTO;
        $this->periodoDTO = $periodoDTO;
    }

    public function agregrarPrematricula() {
        $cantidadCreditos = $this->calcularNumeroCreditos(); 
        $this->crearCabeceraPrematricula();
        $ordenPago = $this->crearOrdenPago($cantidadCreditos); 
        $this->crearDetallePrematricula($ordenPago);
        return $ordenPago;
    }

    public function agregrarDetalleMateriaGrupo($materiaId,$grupoId) {
        $this->detalleMateriaGrupo[] = array($materiaId,$grupoId);
        return true;
    }
    
    private function calcularNumeroCreditos(){
        $cantidadCreditos = 0;
        foreach($this->detalleMateriaGrupo as $detalle){
            $materiaEnt = new Materia();
            $materiaEnt->setCodigomateria($detalle[0]);
            $materiaEnt->getById();
            $cantidadCreditos += $materiaEnt->getNumerocreditos();
        }
        return $cantidadCreditos;
    }
    
    private function crearCabeceraPrematricula(){
        $this->prematriculaEnt = new Prematricula();
        $this->prematriculaEnt->setFechaprematricula(date("Y-m-d"));
        $this->prematriculaEnt->setCodigoestudiante($this->estudianteDTO->getCodigo());
        $this->prematriculaEnt->setCodigoperiodo($this->periodoDTO->getCodigoPeriodo());
        $this->prematriculaEnt->setCodigoestadoprematricula(10);
        $this->prematriculaEnt->setSemestreprematricula($this->estudianteDTO->getSemestreMatricula());
        $this->prematriculaEnt->setObservacionprematricula("");
        
        $PrematriculaDAO = new PrematriculaDAO($this->prematriculaEnt);
        $PrematriculaDAO->save();
        
        unset($PrematriculaDAO);
    }
    
    private function crearOrdenPago($cantidadCreditos){
        
        $servicio="http://localhost/peoplesoft/ordenpago/OrdenPago.wsdl?wsdl";
        $parametros=array();
        $parametros['idEstudiante'] = $this->estudianteDTO->getCodigo();
        $parametros['codigoPeriodo'] = $this->periodoDTO->getCodigoPeriodo();
        $parametros['numeroCreditos'] = $cantidadCreditos;
        
        $client = new \SoapClient($servicio, $parametros);
        return $client->crearOrdenPago($parametros);
    }
    
    private function crearDetallePrematricula($numeroOrden){
        $db = Factory::createDbo();
        
        foreach( $this->detalleMateriaGrupo as $detalle){
            $detallePrematriculaEnt = new DetallePrematricula();
            $detallePrematriculaEnt->setIdPrematricula($this->prematriculaEnt->getIdprematricula());
            $detallePrematriculaEnt->setCodigomateria($detalle[0]);
            $detallePrematriculaEnt->setCodigomateriaelectiva(0);
            $detallePrematriculaEnt->setCodigoestadodetalleprematricula(10);
            $detallePrematriculaEnt->setCodigotipodetalleprematricula(10);
            $detallePrematriculaEnt->setIdgrupo($detalle[1]);
            $detallePrematriculaEnt->setNumeroordenpago($numeroOrden);
            
            $DetallePrematriculaDAO = new DetallePrematriculaDAO($detallePrematriculaEnt);
            $DetallePrematriculaDAO->save();
            
            $Grupo = new Grupo();
            $Grupo->setIdgrupo($detalle[1]);
            $Grupo->getById();
            $Grupo->setMatriculadosgrupo($Grupo->getMatriculadosgrupo()+1);
            
            $GrupoDAO = new GrupoDAO($Grupo);
            $GrupoDAO->save();
            
            $where = " idEstudiante = ".$db->qstr($this->estudianteDTO->getCodigo())
                    . " AND idGrupo = ".$db->qstr($detalle[1]);
            $reserva = ReservaCupo::getList($where); 
            if(!empty($reserva)){
                $ReservaCupoDAO = new ReservaCupoDAO($reserva[0]);
                $ReservaCupoDAO->delete(); 
            }
        }
    }
}
