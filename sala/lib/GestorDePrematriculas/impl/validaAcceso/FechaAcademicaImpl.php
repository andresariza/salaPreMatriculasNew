<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\validaAcceso;
defined('_EXEC') or die;

/**
 * Description of newPHPClass
 *
 * @author Andres
 */
use \Sala\lib\Factory;
use \Sala\entidad\FechaAcademica;
use \Sala\lib\GestorDePrematriculas\interfaces\validaAcceso\IFechaAcademica;
use \Sala\lib\GestorDePrematriculas\dto\CarreraDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
class FechaAcademicaImpl implements IFechaAcademica{
    private $carrera;
    private $fechaInicioPrematricula;
    private $fechaFinPrematricula;
    private $periodo;
    
    public function __construct(CarreraDTO $carrera, PeriodoDTO $periodo) {
        $this->carrera = $carrera;
        $this->periodo = $periodo;
    }

    public function validarFechaAcademica() {
        $db = Factory::createDbo();
        $return = false;
        $where = " codigoperiodo = ".$db->qstr($this->periodo->getCodigoPeriodo())." "
                . " AND codigocarrera = ".$db->qstr($this->carrera->getId())
                . " AND NOW() BETWEEN fechainicialprematricula AND fechafinalprematricula";
        $eFechaAcademica = FechaAcademica::getList($where);
        if(!empty($eFechaAcademica)){
            $this->fechaInicioPrematricula = $eFechaAcademica[0]->getFechainicialprematricula();
            $this->fechaFinPrematricula = $eFechaAcademica[0]->getFechafinalprematricula();
            $return = true;
        }
        return $return;
    }

}
