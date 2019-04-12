<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dao;

/**
 * Description of EstudianteDAO
 *
 * @author Andres
 */
class EstudianteDAO {
    private $Estudiante;
    
    public function __construct($codigo, $idEstudianteGeneral) {
        $eEstudiante = new \Sala\entidad\Estudiante();
        $eEstudiante->setCodigoEstudiante($codigo);
        $eEstudiante->setDb();
        $eEstudiante->getById();
        //d($eEstudiante);
        
        $eEstudianteGeneral = new \Sala\entidad\EstudianteGeneral();
        $eEstudianteGeneral->setIdestudiantegeneral($idEstudianteGeneral);
        $eEstudianteGeneral->setDb();
        $eEstudianteGeneral->getById();
        //d($eEstudianteGeneral);
        
        $this->Estudiante = new \Sala\lib\GestorDePrematriculas\impl\EstudianteImpl($eEstudiante->getCodigoesEstudiante(), 
                $eEstudiante->getCodigoesEstudiante(), $eEstudiante->getCodigosituacioncarreraestudiante(),
                $eEstudianteGeneral->getNombresestudiantegeneral(), $eEstudianteGeneral->getApellidosestudiantegeneral());
        
    }
    
    public function getEstudiante(){
        return $this->Estudiante;
    }
    
    public function getEstudianteDTO(){
        return $this->Estudiante->getEstudianteDTO();
    }
    //put your code here
}
