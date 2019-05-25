<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl\validaAcceso;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\validaAcceso\IPazYSalvo;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;

/**
 * Description of PazYSalvoImpl
 *
 * @author Andres
 */
class PazYSalvoImpl implements IPazYSalvo {
    private $Estudiante;
    
    function __construct(EstudianteDTO $Estudiante) {
        $this->Estudiante = $Estudiante;
    }
    
    public function validarPazYSalvoEstudiante(EstudianteDTO $Estudiante, PeriodoDTO $PeriodoDTO) {
        
        $servicio="http://localhost/peoplesoft/pazysalvo/PazYSalvo.wsdl?wsdl";
        $parametros=array(); //parametros de la llamada
        $parametros['idEstudiante'] = $Estudiante->getCodigo();
        $parametros['codigoPeriodo'] = $PeriodoDTO->getCodigoPeriodo(); 
        
        $client = new \SoapClient($servicio, $parametros);
        $pazYSalvo = $client->getPazYSalvo($parametros);
        
        return $pazYSalvo;
    }

}

