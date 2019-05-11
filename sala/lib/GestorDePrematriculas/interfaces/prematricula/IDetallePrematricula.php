<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces\prematicula;
defined('_EXEC') or die;

/**
 *
 * @author Andres
 */
interface IDetallePrematricula {
    public function agregrarGrupo();
    public function eliminarGrupo();
}
