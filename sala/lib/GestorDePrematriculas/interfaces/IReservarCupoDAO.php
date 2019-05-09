<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;

/**
 *
 * @author Andres
 */
interface IReservarCupoDAO {
    public function reservarCupo(EstudianteDTO $estudianteDTO, $grupoid);
    public function borrarReserva(EstudianteDTO $estudianteDTO, $grupoid);
    public function consultarReservas(EstudianteDTO $estudianteDTO);
}
