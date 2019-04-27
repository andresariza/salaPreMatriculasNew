<?php
namespace Sala\lib\GestorDePrematriculas\impl; 
defined('_EXEC') or die;
/**
 * Description of EstudianteImpl
 *
 * @author Andres
 */
class EstudianteImpl  implements \Sala\lib\GestorDePrematriculas\interfaces\IEstudiante {
    private $estudianteDTO; 
    
    function __construct($id, $codigo, $estado, $nombres, $apellidos) {
        $this->estudianteDTO = new \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO($id, $codigo, $estado, 
                $nombres, $apellidos);
    }

    
    //put your code here
    public function consultarCreditosDisponibles() {
        
    }

    public function validarEstado() {
        $return = false;
        if($this->estudianteDTO->getEstado() == 301){
            $return = true;
        }
        return $return;
    }

    public function validarInformacionEstudiante() {
        return true;
    }
    
    public function getEstudianteDTO(){
        return $this->estudianteDTO;
    }

}
