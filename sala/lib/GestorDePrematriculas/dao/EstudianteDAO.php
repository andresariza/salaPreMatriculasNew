<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dao;
defined('_EXEC') or die;
use \Sala\entidad\Estudiante;
use \Sala\entidad\EstudianteGeneral;
use \Sala\lib\GestorDePrematriculas\interfaces\IEstudianteDAO;
use \Sala\lib\GestorDePrematriculas\impl\EstudianteImpl;

/**
 * Description of EstudianteDAO
 *
 * @author Andres
 */
class EstudianteDAO  implements IEstudianteDAO {
    private $EstudianteImpl;
    
    public function __construct() {
        
    }
    
    public function getEstudiante($codigo, $idEstudianteGeneral){
        $eEstudiante = new Estudiante();
        $eEstudiante->setCodigoEstudiante($codigo);
        $eEstudiante->getById();
        //d($eEstudiante);
        
        $eEstudianteGeneral = new EstudianteGeneral();
        $eEstudianteGeneral->setIdestudiantegeneral($idEstudianteGeneral);
        $eEstudianteGeneral->getById();
        //d($eEstudianteGeneral);
        
        $this->EstudianteImpl = new EstudianteImpl($eEstudiante->getCodigoesEstudiante(), 
                $eEstudiante->getCodigoesEstudiante(), $eEstudiante->getCodigosituacioncarreraestudiante(),
                $eEstudianteGeneral->getNombresestudiantegeneral(), $eEstudianteGeneral->getApellidosestudiantegeneral());
        return $this->EstudianteImpl;
    }
}
