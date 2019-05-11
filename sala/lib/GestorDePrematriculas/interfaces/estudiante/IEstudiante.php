<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces\estudiante;
defined('_EXEC') or die;

/**
 *
 * @author arizaandres
 */
interface IEstudiante {
    public function validarEstado();
    public function validarInformacionEstudiante();
}
