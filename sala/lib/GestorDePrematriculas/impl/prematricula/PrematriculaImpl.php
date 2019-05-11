<?php

namespace Sala\lib\GestorDePrematriculas\impl\prematricula;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\prematricula\IPrematricula;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrematriculaImpl
 *
 * @author Andres
 */
class PrematriculaImpl implements IPrematricula{
    private $estudianteDTO;
    private $periodoDTO;
    public function __construct(EstudianteDTO $estudianteDTO, PeriodoDTO $periodoDTO) {
        $this->estudianteDTO = $estudianteDTO;
        $this->periodoDTO = $periodoDTO;
    }

    public function agregrarPrematricula() {
        
    }

    public function eliminarPrematricula() {
        
    }

}
