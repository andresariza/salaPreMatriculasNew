<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dao;
defined('_EXEC') or die;
/**
 * Description of CarreraDAO
 *
 * @author Andres
 */
class CarreraDAO implements \Sala\lib\GestorDePrematriculas\interfaces\ICarreraDAO {
    private $carreraDTO;
    
    public function __construct() {
    }

    public function consultarCarrera($codigocarrera) {
        $carrera = new \Sala\entidad\Carrera();
        $carrera->setDb();
        $carrera->setCodigocarrera($codigocarrera);
        $carrera->getById();
        
        $this->carreraDTO = new \Sala\lib\GestorDePrematriculas\dto\CarreraDTO($carrera->getCodigocarrera(), 
                $carrera->getNombrecarrera(), $carrera->getNombrecortocarrera());
    }
    
    public function getCarreraDTO(){
        return $this->carreraDTO;
    }

}
