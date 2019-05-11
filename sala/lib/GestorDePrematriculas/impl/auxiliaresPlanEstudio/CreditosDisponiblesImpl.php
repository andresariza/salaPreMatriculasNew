<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\auxiliaresPlanEstudio;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\interfaces\auxiliaresPlanEstudio\ICreditosDisponibles;

/**
 * Description of CreditosDisponiblesImpl
 *
 * @author Andres
 */
class CreditosDisponiblesImpl implements ICreditosDisponibles{
    public function __construct() {}

    public function consultarCreditos(PlanEstudioDTO $planEstudioDTO, EstudianteDTO $estudianteDTO) {
        $creditos = 0;
        //d($estudianteDTO->getSemestreMatricula());
        foreach($planEstudioDTO->getListadoMaterias() as $materia){
            if($materia->getSemestre() == $estudianteDTO->getSemestreMatricula()){
                $creditos += $materia->getNumeroCreditos();
            }
        }
        return $creditos;
    }

}
