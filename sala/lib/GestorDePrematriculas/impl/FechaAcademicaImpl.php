<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;

/**
 * Description of newPHPClass
 *
 * @author Andres
 */
use \Sala\lib\Factory;
class FechaAcademicaImpl implements \Sala\lib\GestorDePrematriculas\interfaces\IFechaAcademica{
    private $carrera;
    private $fechaInicioPrematricula;
    private $fechaFinPrematricula;
    private $periodo;
    
    public function __construct(\Sala\lib\GestorDePrematriculas\dto\CarreraDTO $carrera, \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodo) {
        $this->carrera = $carrera;
        $this->periodo = $periodo;
        //d($this->periodo);
    }

    public function validarFechaAcademica() {
        $db = Factory::createDbo();
        $return = false;
        $where = " codigoperiodo = ".$db->qstr($this->periodo->getCodigoPeriodo())." "
                . " AND codigocarrera = ".$db->qstr($this->carrera->getId())
                . " AND NOW() BETWEEN fechainicialprematricula AND fechafinalprematricula";
        $eFechaAcademica = \Sala\entidad\FechaAcademica::getList($where);
        if(!empty($eFechaAcademica)){
            $return = true;
        }
        return $return;
    }

}
