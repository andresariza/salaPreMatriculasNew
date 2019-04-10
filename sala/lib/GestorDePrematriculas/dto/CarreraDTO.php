<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;
defined('_EXEC') or die;

/**
 * Description of CarreraDTO
 *
 * @author Andres
 */
class CarreraDTO {
    private $id;
    private $nombre;
    private $titulo;
    
    public function __construct($id, $nombre, $titulo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->titulo = $titulo;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTitulo() {
        return $this->titulo;
    }



}
