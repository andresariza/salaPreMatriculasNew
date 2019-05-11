<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\control;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\impl\prematricula\PrematriculaImpl;
/**
 * Description of ControllerFinalizar
 *
 * @author Andres
 */
class ControllerFinalizar {
    private $prematriculaImpl;
    
    public function __construct($estudianteDTO, $periodoDTO) {
        $this->prematriculaImpl = new PrematriculaImpl($estudianteDTO, $periodoDTO);
    }
    
    public function crearDetallePrematricula($idGrupo,$idMateria){
        $this->prematriculaImpl->agregrarDetalleMateriaGrupo($idMateria,$idGrupo);
    }
    
    public function agregarPrematricula(){
        $this->prematriculaImpl->agregrarPrematricula();
        return $this->prematriculaImpl;
    }

}
