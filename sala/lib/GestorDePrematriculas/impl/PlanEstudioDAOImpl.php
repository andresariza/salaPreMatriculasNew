<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;

/**
 * Description of PlanEstudioDAOImpl
 *
 * @author Andres
 */
class PlanEstudioDAOImpl implements \Sala\lib\GestorDePrematriculas\interfaces\IPlanEstudioDAO{
    private $id;
    private $nombre;
    private $carreraDTO;
    
    function __construct($carreraDTO) {
        $this->carreraDTO = $carreraDTO;
    }

    public function buscarPlanEstudio() {
        
    }

    public function validarMateriasDisponibles() {
        
    }

}
