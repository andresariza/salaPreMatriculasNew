<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\control;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\impl\prematricula\PrematriculaImpl;
use \Sala\lib\GestorDePrematriculas\impl\prematricula\DetallePrematriculaImpl;
/**
 * Description of ControllerFinalizar
 *
 * @author Andres
 */
class ControllerFinalizar {
    private $prematricula;
    private $detallePrematricula;
    
    public function __construct($estudianteDTO, $periodoDTO) {
        $this->prematricula = new PrematriculaImpl($estudianteDTO, $periodoDTO);
        $this->detallePrematricula = new DetallePrematriculaImpl($periodoDTO);
    }
    
    public function crearDetallePrematricula($idGrupo){
        $this->detallePrematricula->agregrarGrupoDetalle($idGrupo);
    }

}
