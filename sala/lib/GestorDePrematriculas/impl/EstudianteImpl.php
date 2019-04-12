<?php
namespace Sala\lib\GestorDePrematriculas\impl; 
defined('_EXEC') or die;
/**
 * Description of EstudianteImpl
 *
 * @author Andres
 */
class EstudianteImpl  implements \Sala\lib\GestorDePrematriculas\interfaces\IEstudiante {
    private $id;
    private $codigo;
    private $estado;
    private $nombres;
    private $apellidos;
    
    function __construct($id, $codigo, $estado, $nombres, $apellidos) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->estado = $estado;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        //d(1);
    }

    
    //put your code here
    public function consultarCreditosDisponibles() {
        
    }

    public function validarEstado() {
        $return = false;
        if($this->estado == 301){
            $return = true;
        }
        return $return;
    }

    public function validarInformacionEstudiante() {
        return true;
    }
    
    public function getEstudianteDTO(){
        return new \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO($this->id, 
                $this->codigo, $this->estado, $this->nombres, $this->apellidos);
    }

}
