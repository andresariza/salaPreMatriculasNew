<?php
namespace Sala\control;
defined('_EXEC') or die;

/**
 * Se incluye la libreria Factory para tener acceso a todas sus metodos estaticos
 */
use Sala\lib\Factory;        
use Sala\modelo\Defecto;

/**
 * Clase ControlEjecucionTareas para orquestacion de la carga de templates, 
 * componentes y modulos, y tambien de la ejecucion de sus task y actions
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
class ControlEjecucionTareas{
    /**
     * $db es una variable privada, es la contenedora de la instancia singleton 
     * del objeto adodb de conexion a base de datos de sala
     * 
     * @var adodb Object
     * @access protected static
     */
    private $db;
    
    /**
     * $variables es una variable privada, contenedora de el objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var stdObject
     * @access private
     */
    private $variables; 
    
    /**
     * $Configuracion es una variable privada, es la contenedora de la 
     * instancia singleton del objeto Configuration
     * 
     * @var Configuration 
     * @access private static
     */
    private $Configuracion;

    /**
     * Constructor de la clase ControlEjecucionTareas,
     * @param stdClass $variables
     * @param Configuration $Configuracion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */  
    function __construct($variables, $Configuracion) {        
        $this->db = Factory::createDbo();
        $this->variables = $variables;
        $this->Configuracion = $Configuracion;
    }

    /**
     * Ejecuta cualquier tarea solicitada por request a traves de la variable
     * action, si viene acompañada de una solicitud de option esta accion se 
     * ejecuta en el controlador de componente option, de lo contrario busca
     * ejecutarla en la clase ControlEjecucionTareas
     * @param String $action
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public
     * @return void
     */ 
    public function execute($action){
        if(!empty($action)){
            $option = @$this->variables->option;
            //ddd($option);
            if(!empty($option)){
                $controlClass = "Control".ucfirst($option);
                //d(PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php');
                if(!empty($action) && is_file(PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php')){
                    eval("\$Control = new \\Sala\\components\\".$option."\\control\\".$controlClass."();");
                    $Control->setVariables($this->variables);
                    $Control->$action();
                }elseif(!empty($action)){
                    $this->$action();
                }
            }elseif(!empty($action)){
                $this->$action();
            }
            exit();
        }
    }

    /**
     * Metodo encargado de la renderizacion del templayte y componentes solicitados
     * por request
     * @param String $option
     * @param String $layout
     * @param String $task
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public
     * @return void
     */ 
    public function go($option, $layout, $task){
        $return = false;
        if(empty($layout)){
            $layout = 'default';
        }
        $path = null;
        if(!empty($this->variables->json)){
            $this->variables->tmpl = "json";
            $return = true;            
        }
        //d($this->variables);
        if((empty($this->variables->tmpl) || $this->variables->tmpl!="json") && $this->variables->option=="dashBoard"){
            Factory::inicializarPeridos();
        }
        
        $ModeloDefault = new \Sala\modelo\Defecto($this->db);
        
        $arrayTemplate = array();
        $arrayTemplate['tituloSeccion'] = $ModeloDefault->getTituloSeccion($option);
        
        $arrayTemplate['breadCrumb'] = Factory::getBreadCrumbs($option,$this->variables);
        
        $array = array();
        //d(224);
        $array = $ModeloDefault->getVariables($this->variables);
        //d(225);
        $array['task'] = $task;
        $array['option'] = $option;
        $array['variables'] = $this->variables; 
        
        $arrayTemplate = array_merge($arrayTemplate,$array);
        
        $arrayTemplate['component'] = null;
        
        if(!empty($option)){
            $modeloClass = ucfirst($option);
            if(!is_file(PATH_SITE.'/components/'.$option.'/modelo/'.$modeloClass.'.php')){
                $modeloClass = "Defecto";
            }
            
            eval("\$Modelo = new \\Sala\\components\\".$option."\\modelo\\".$modeloClass."();");
            
            /**
             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
             * Se agrega la siguiente validacion para verificar que los clases Modelo implementen la interface Model
             * @since mayo 5, 2018
             */
            if (!($Modelo instanceof \Sala\interfaces\Model)) {
                throw new \Exception('El modelo '.$modeloClass.' no implementa la interface Model');
            }
        
            $array = array();
            $array['task'] = $task;
            $array['variables'] = $this->variables;
            
            $variablesModelo = $Modelo->getVariables($this->variables);
            
            $array = array_merge($array,$variablesModelo); 
            
            $controlClass = "Control".ucfirst($option);
            if(is_file(PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php')){

                if(!empty($task)){
                    eval("\$Control = new \\Sala\\components\\".$option."\\control\\".$controlClass."();");
                    $Control->setVariables($this->variables);
                    $Control->$task();
                }
            }
            if(!empty($this->variables->layout) && $layout!=$this->variables->layout){
                $layout = $this->variables->layout;
            }
            //d($layout);
            $componentRender = Factory::getRenderInstance();
            $arrayTemplate['component'] = $componentRender->render($layout,"/components/".$option,$array, true);
            
        }
        
        $template = $this->Configuracion->getTemplate();
        if(empty($this->variables->tmpl)){
            $layout = "default";
        }else{
            $layout = $this->variables->tmpl;
        }
        $controlRender = Factory::getRenderInstance();
        $template = $controlRender->render($template."/".$layout,$path,$arrayTemplate, $return);
        if(!empty($this->variables->json)){
            echo json_encode(array('s'=>true,'msj'=>$template));
            exit(); 
        }
    }
    
    public function validarNombreCarrera(){
        
        $response = array("s"=>false);
        $idCarrera = Factory::getSessionVar('codigofacultad'); 
        if(@$this->variables->idCarrera != $idCarrera){
            $Carrera = new \Sala\entidad\Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($idCarrera);
            $Carrera->getByCodigo();
            
            $response["s"] = true;
            $response["idCarrera"] = $Carrera->getCodigocarrera();
            $response["nombreCarrera"] = $Carrera->getNombrecarrera();            
        }
        echo json_encode($response);
    }
     
}