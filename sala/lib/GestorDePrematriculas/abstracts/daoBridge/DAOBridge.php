<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\abstracts\daoBridge;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\daoFacade\IDAOFacade;
use \Sala\lib\GestorDePrematriculas\impl\dao\EstudianteDAO;
use \Sala\lib\GestorDePrematriculas\impl\dao\CarreraDAO;
use \Sala\lib\GestorDePrematriculas\impl\dao\PlanEstudioDAO;
use \Sala\lib\GestorDePrematriculas\impl\dao\ReservarCupoDAO;

/**
 *
 * @author Andres
 */
abstract class DAOBridge implements IDAOFacade {
    private $CarreraDAO;
    private $EstudianteDAO;
    private $PlanEstudioDAO;
    private $ReservaCupoDAO;
    
    public function __construct() {
        $this->EstudianteDAO = new EstudianteDAO();
        $this->CarreraDAO = new CarreraDAO();
        $this->PlanEstudioDAO = new PlanEstudioDAO();
        $this->ReservaCupoDAO = new ReservarCupoDAO();
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

    public function getReservaCupoDAO() {
        return $this->ReservaCupoDAO;
    }
}
