<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\dao;
defined('_EXEC') or die;
use \Sala\entidad\Estudiante;
use \Sala\entidad\EstudianteGeneral;
use \Sala\lib\GestorDePrematriculas\interfaces\dao\IEstudianteDAO;
use \Sala\lib\GestorDePrematriculas\impl\estudiante\EstudianteImpl;

/**
 * Description of EstudianteDAO
 *
 * @author Andres
 */
class EstudianteDAO  implements IEstudianteDAO {
    private $EstudianteImpl;
    
    public function __construct() {
        
    }
    
    public function consultarEstudiante($codigo, $idEstudianteGeneral){
        $eEstudiante = new Estudiante();
        $eEstudiante->setCodigoEstudiante($codigo);
        $eEstudiante->getById();
        
        $eEstudianteGeneral = new EstudianteGeneral();
        $eEstudianteGeneral->setIdestudiantegeneral($idEstudianteGeneral);
        $eEstudianteGeneral->getById();
        
        $this->EstudianteImpl = new EstudianteImpl($eEstudiante->getCodigoesEstudiante(), 
                $eEstudiante->getCodigoesEstudiante(), $eEstudiante->getCodigosituacioncarreraestudiante(),
                $eEstudianteGeneral->getNombresestudiantegeneral(), $eEstudianteGeneral->getApellidosestudiantegeneral(),
                $eEstudiante->getSemestre());
        return $this->EstudianteImpl;
    }
}
