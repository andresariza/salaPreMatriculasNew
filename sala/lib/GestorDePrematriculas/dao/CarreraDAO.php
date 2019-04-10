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
    private $id;
    private $nombre;
    private $nombreCorto;
    private $titulo;
    
    public function __construct() {
    }

    public function consultarCarrera($codigocarrera) {
        $carrera = new \Sala\entidad\Carrera();
        $carrera->setDb();
        $carrera->setCodigocarrera($codigocarrera);
        $carrera->getById();
        
        $this->id = $carrera->getCodigocarrera();
        $this->nombre = $carrera->getNombrecarrera();
        $this->nombreCorto = $carrera->getNombrecortocarrera();
    }
    
    public function getCarreraDTO(){
        return new \Sala\lib\GestorDePrematriculas\dto\CarreraDTO($this->id, $this->nombre, $this->titulo);
    }

}
