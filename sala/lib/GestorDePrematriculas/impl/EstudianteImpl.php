<?php
namespace Sala\lib\GestorDePrematriculas\impl; 
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\IEstudiante;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
/**
 * Description of EstudianteImpl
 *
 * @author Andres
 */
class EstudianteImpl  implements IEstudiante {
    private $estudianteDTO; 
    
    function __construct($id, $codigo, $estado, $nombres, $apellidos, $semestreMatricula) {
        $this->estudianteDTO = new EstudianteDTO($id, $codigo, $estado, 
                $nombres, $apellidos, $semestreMatricula);
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
