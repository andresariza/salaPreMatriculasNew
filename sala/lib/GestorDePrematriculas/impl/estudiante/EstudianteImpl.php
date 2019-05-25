<?php
namespace Sala\lib\GestorDePrematriculas\impl\estudiante; 
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\estudiante\IEstudiante;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
/**
 * Description of EstudianteImpl
 *
 * @author Andres
 */
class EstudianteImpl  implements IEstudiante {
    private $estudianteDTO; 
    
    function __construct(EstudianteDTO $estudianteDTO) {
        $this->estudianteDTO = $estudianteDTO;
    }

    public function validarEstado() {
        $return = false;
        if($this->estudianteDTO->getEstado() == 301){
            $return = true;
        }
        return $return;
    }
    
    public function getEstudianteDTO(){
        return $this->estudianteDTO;
    }

}
