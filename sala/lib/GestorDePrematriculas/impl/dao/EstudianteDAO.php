<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\dao;
defined('_EXEC') or die;
use \Sala\lib\Servicios;
use \Sala\entidad\Estudiante;
use \Sala\entidad\EstudianteGeneral;
use \Sala\entidad\Prematricula;
use \Sala\lib\GestorDePrematriculas\interfaces\dao\IEstudianteDAO;
use \Sala\lib\GestorDePrematriculas\impl\estudiante\EstudianteImpl;

/**
 * Description of EstudianteDAO
 *
 * @author Andres
 */
class EstudianteDAO  implements IEstudianteDAO {
    private $EstudianteDTO;
    
    public function __construct() {
        
    }
    
    public function consultarEstudiante($codigo, $idEstudianteGeneral){
        $eEstudiante = new Estudiante();
        $eEstudiante->setCodigoEstudiante($codigo);
        $eEstudiante->getById();
        
        $eEstudianteGeneral = new EstudianteGeneral();
        $eEstudianteGeneral->setIdestudiantegeneral($idEstudianteGeneral);
        $eEstudianteGeneral->getById();
        
        $periodoVigente = Servicios::getPeriodoVigente(); 
        $ePrematricula = Prematricula::getPrematriculaEstudiante($eEstudiante->getCodigoesEstudiante(), $periodoVigente->getCodigoperiodo());
        
        
        $this->EstudianteDTO = new \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO($eEstudiante->getCodigoesEstudiante(), 
                $eEstudiante->getCodigoesEstudiante(), $eEstudiante->getCodigosituacioncarreraestudiante(),
                $eEstudianteGeneral->getNombresestudiantegeneral(), $eEstudianteGeneral->getApellidosestudiantegeneral(),
                $eEstudiante->getSemestre(), $ePrematricula);
        
        return $this->EstudianteDTO;
    }
}
