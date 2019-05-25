<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces\daoFacade;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
/**
 *
 * @author Andres
 */
interface IDAOFacade {
    public function consultarEstudiante($codigo,$idEstudiante);
    public function buscarPlanEstudio(PeriodoDTO $periodo, EstudianteDTO $EstudianteDTO);
    public function consultarCarrera();
    public function reservarCupo(EstudianteDTO $estudianteDTO, $grupoid);
    public function borrarReserva(EstudianteDTO $estudianteDTO, $grupoid);
    public function consultarReservasEstudiante(EstudianteDTO $estudianteDTO);
    public function consultarReservasGrupo($idGrupo);
}
