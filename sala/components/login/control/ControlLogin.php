<?php
namespace Sala\components\login\control;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
class ControlLogin { 
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public function setVariables($variables){
        $this->variables = $variables; 
    }
    
    public function logout(){
        Factory::destroySession();
        echo json_encode(array("s"=>true));exit;
    }
    
    public function setSegClaveReq(){
        Factory::setSessionVar('2clavereq',$this->variables->autenticacion);
        Factory::setSessionVar('auth',false);
        echo json_encode(array("s"=>true));exit;
    }
    
    public function changeRol(){
        $idrol=$this->variables->rol;
        $rol = $this->variables->cambiorol;
        //d($this->variables);
        Factory::setSessionVar('idPerfil', $idrol); 
        $return = array("s"=>true,"action"=>"reload");
        
        $MM_Username = Factory::getSessionVar('MM_Username');
        $idusuario = Factory::getSessionVar('idusuario');
        //d($MM_Username);
        //si el usuario actual es estudiante se valida su idgeneral para identifcar el usuario
        if($MM_Username === 'estudiante'){
            //consulta el usuario que tiene asignado el idgeneral
            $sqlusuario = "SELECT u.usuario FROM usuario u inner join estudiantegeneral eg on u.numerodocumento = eg.numerodocumento where eg.idestudiantegeneral = '".Factory::getSessionVar('sesion_idestudiantegeneral')."' and u.codigorol = '1' AND u.codigoestadousuario=100";        
            $sql_buscarusuario = $this->db->query($sqlusuario);    
            $sql_buscarusuario = $sql_buscarusuario->fetchRow();
            //asigna el usuario consultado al username
            Factory::setSessionVar('MM_Username', $sql_buscarusuario['usuario']); 
        }
        //consulta de l usuario por su tipo de rol y diferente al usuario actual.
        $nombre_usuario = "select distinct u.usuario, u.idusuario from usuario u inner join UsuarioTipo t on t.UsuarioId = u.idusuario where u.numerodocumento = (select numerodocumento from usuario where idusuario ='".$idusuario."') and  u.usuario <> '".$MM_Username."' and t.codigoestado ='100' and t.CodigoTipoUsuario ='".$rol."' AND u.codigoestadousuario=t.CodigoEstado";
        //echo $nombre_usuario;exit;
        $sqlusuario = $this->db->query($nombre_usuario);    
        $row_usuario = $sqlusuario->fetchRow();
        
        //is el rol es 2 "Docente" ingresa la validacion para segunda contraseña
        if($idrol=='2'){
            Factory::setSessionVar('auth','SEGCLAVE');
            Factory::setSessionVar('2clavereq','SEGCLAVE');
            Factory::setSessionVar('MM_Username',$row_usuario['usuario']); 
            $return["action"]="gologin";
        }else{
            //si el rol es 1 "Estudiante" 
            if($idrol=='1' || $idrol=='4'){
                //ingresa para la validacion de datos que tiene el estudiante.
                $sqlidgeneral ="SELECT eg.idestudiantegeneral, eg.numerodocumento FROM estudiantegeneral eg inner join usuario u on u.numerodocumento = eg.numerodocumento where u.idusuario ='".$idusuario."' AND u.codigoestadousuario=100 ";
                $sqlid = $this->db->query($sqlidgeneral);    
                $row_idgeneral = $sqlid->fetchRow();
                //se crean las variables para usuario
                Factory::setSessionVar('sesion_idestudiantegeneral',$row_idgeneral['idestudiantegeneral']);            
                Factory::setSessionVar('codigo',$row_idgeneral['numerodocumento']);
                if($idrol == '4'){
                    Factory::setSessionVar('MM_Username','padre');
                }else{
                    Factory::setSessionVar('MM_Username','estudiante');
                }

                $usuario = Factory::getSessionVar('MM_Username');
            }else{
                $usuario = $row_usuario['usuario']; 
                Factory::setSessionVar('MM_Username', $usuario);
                Factory::setSessionVar('usuario', $usuario);
                Factory::setSessionVar('idCarrera', null);
            }//else 1
            //se asigna el rol
            $sqlRol= "SELECT rol.idrol
            FROM usuario u 
            INNER JOIN UsuarioTipo ut ON (ut.UsuarioId = u.idusuario)
            INNER JOIN usuariorol rol ON (rol.idusuariotipo = ut.UsuarioTipoId )
            WHERE u.idusuario = '".$row_usuario['idusuario']."'";
            //d($sqlRol);
            $datos = $this->db->query($sqlRol);    
            $d = $datos->fetchRow();
            //d($d);
            
            Factory::setSessionVar('rol', $d['idrol']); 
            Factory::setSessionVar('idusuario', $row_usuario['idusuario']); 
        }//else 2
        /**/
        echo json_encode($return);
        exit;
    }
    
    /*
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * El tiempo de vida de la sesion es de 30 minutos 
     * @since Marzo 2, 2018
     */
    public function validarVidaSesion(){
        $curTime = mktime(); 
        $lastActivity = Factory::getSessionVar('lastActivity');
        //$lastActivity = 1527585164;
        //d(date('m/d/Y H:i:s', $lastActivity));
        
        $diferencia = $curTime - $lastActivity;
        //d($diferencia);
        if(empty($lastActivity) || $diferencia>=SESSION_LIVE){
            Factory::destroySession();
            echo json_encode(array("s"=>false));
        }else{
            echo json_encode(array("s"=>true));
        }
        exit;
    }
    
    /*
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * El tiempo de vida de la sesion es de 30 minutos 
     * @since Marzo 2, 2018
     */
    public function updateSessionActivity(){
        $curTime = mktime();
        Factory::setSessionVar("lastActivity",$curTime);
        echo json_encode(array("s"=>true));
        exit;
    }
    
    public function ingresar(){
        $response = array("aut"=>false, "mensaje"=>"Usuario o clave incorrectos");
        $user = new \Sala\entidad\Usuario();
        $user->setDb();
        $user->setUsuario($this->variables->login);
        
        $user->getUsuarioByUsuario();
        //d($user);
        $idUsuario = $user->getIdusuario(); 
        if(!empty($idUsuario)){
            $response['aut'] = "OK";
            $response['mensaje'] = "Bienvenido";
            $response['codigotipousuario'] = $user->getCodigotipousuario();
            
            Factory::setSessionVar('MM_Username', $user->getUsuario());
            Factory::setSessionVar('key', md5($user->getUsuario()." ".$user->getNombres()." ".$user->getApellidos()));
            Factory::setSessionVar('idusuario', $user->getIdusuario());
            Factory::setSessionVar('codigotipousuario',$user->getCodigotipousuario());
            $idPerfil = 0;
            switch ($user->getCodigotipousuario()){
                case '600':
                        $idPerfil = 1;
                        Factory::setSessionVar('MM_Username', "estudiante");
                    $query = " SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento = ".$this->db->qstr($user->getNumerodocumento());
                    $datos = $this->db->Execute($query);
                    if(!empty($datos)){
                        $d = $datos->FetchRow();
                        Factory::setSessionVar('sesion_idestudiantegeneral',$d['idestudiantegeneral']);
                    }
                    break;
                case '900':
                    $idPerfil = 4;
                    break;
                case '500':
                    $idPerfil = 2;
                    break;
                case '400':
                    $idPerfil = 3;
                    break;
            }
            
            Factory::setSessionVar('idPerfil',$idPerfil);
            Factory::setSessionVar('auth',true);
            Factory::setSessionVar('nuevoMenu',true);
            Factory::setSessionVar('path_live',PATH_ROOT);
            
            $query = "SELECT rol.idrol "
                    . " FROM usuario u "
                    . " INNER JOIN UsuarioTipo ut ON (ut.UsuarioId = u.idusuario) "
                    . " INNER JOIN usuariorol rol ON (rol.idusuariotipo = ut.UsuarioTipoId) "
                    . " WHERE u.usuario = ".$this->db->qstr($user->getUsuario());
            $datos = $this->db->Execute($query);
            //d($query);
            if(!empty($datos)){
                $d = $datos->FetchRow();
                Factory::setSessionVar('rol',$d['idrol']);
            }
            
            Factory::setSessionVar('codigoperiodosesion',20191);
            Factory::setSessionVar('codigoestadoperiodosesion',1);
            Factory::setSessionVar('usuario',$user->getUsuario());
            Factory::setSessionVar('codigo',$user->getCodigousuario());
            
            
        }
        echo json_encode($response);
    }
}