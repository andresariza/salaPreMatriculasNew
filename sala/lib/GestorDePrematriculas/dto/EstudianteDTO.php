<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;

/**
 * Description of EstudianteDTO
 *
 * @author Andres
 */
class EstudianteDTO {
    private $id;
    private $codigo;
    private $estado;
    private $nombres;
    private $apellidos;
    private $semestreMatricula;
    
    public function __construct($id, $codigo, $estado, $nombres, $apellidos, $semestreMatricula) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->estado = $estado;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->semestreMatricula = $semestreMatricula;
    }
    public function getId() {
        return $this->id;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getApellidos() {
        return $this->apellidos;
    }
    
    public function getSemestreMatricula() {
        return $this->semestreMatricula;
    }
}
