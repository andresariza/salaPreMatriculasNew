<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\dao;
defined('_EXEC') or die;
use \Sala\entidad\Carrera;
use \Sala\lib\GestorDePrematriculas\interfaces\dao\ICarreraDAO;
use \Sala\lib\GestorDePrematriculas\dto\CarreraDTO;
/**
 * Description of CarreraDAO
 *
 * @author Andres
 */
class CarreraDAO implements ICarreraDAO {
    private $carreraDTO;
    
    public function __construct() {
    }

    public function consultarCarrera($codigocarrera) {
        $carrera = new Carrera();
        $carrera->setCodigocarrera($codigocarrera);
        $carrera->getById();
        
        $this->carreraDTO = new CarreraDTO($carrera->getCodigocarrera(), 
                $carrera->getNombrecarrera(), $carrera->getNombrecortocarrera());
        
        return $this->carreraDTO;
    }

}
