<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;
defined('_EXEC') or die;

/**
 * Description of HorarioDTO
 *
 * @author Andres
 */
class HorarioDTO {
    private $codigodia;
    private $dia;
    private $horainicial;
    private $horafinal;
    
    public function __construct($codigodia, $dia, $horainicial, $horafinal) {
        $this->codigodia = $codigodia;
        $this->dia = $dia;
        $this->horainicial = $horainicial;
        $this->horafinal = $horafinal;
    }
    
    public function getCodigodia() {
        return $this->codigodia;
    }

    public function getDia() {
        return $this->dia;
    }

    public function getHorainicial() {
        return $this->horainicial;
    }

    public function getHorafinal() {
        return $this->horafinal;
    }
}