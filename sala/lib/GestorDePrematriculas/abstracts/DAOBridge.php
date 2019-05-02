<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\abstracts;
defined('_EXEC') or die;
use \Sala\lib\Factory;

/**
 *
 * @author Andres
 */
abstract class DAOBridge implements \Sala\lib\GestorDePrematriculas\interfaces\IDAOFacade {
    private $CarreraDAO;
    private $EstudianteDAO;
    private $PlanEstudioDAO;
    
    public function __construct() {
        $this->EstudianteDAO = new \Sala\lib\GestorDePrematriculas\dao\EstudianteDAO(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral"));
        $this->CarreraDAO = new \Sala\lib\GestorDePrematriculas\dao\CarreraDAO();
        $this->PlanEstudioDAO = new \Sala\lib\GestorDePrematriculas\dao\PlanEstudioDAO();
    }
    public function getCarreraDAO() {
        return $this->CarreraDAO;
    }

    public function getEstudianteDAO() {
        return $this->EstudianteDAO;
    }

    public function getPlanEstudioDAO() {
        return $this->PlanEstudioDAO;
    }


}
