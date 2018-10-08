<?php
namespace Sala\components\asideContainer\modelo;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\lib\Servicios;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class AsideContainer implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public function getVariables($variables){
        //d($_SESSION);//43359
        $Usuario = new \Sala\entidad\Usuario();
        $Usuario->setIdusuario(Factory::getSessionVar('idusuario'));
        $Usuario->getUsuarioByIdUsuario();
        //d($Usuario);
        $this->Usuario = $Usuario;
               
        $array = array();
        $array['Usuario'] = $Usuario;
        
        $linkimagen = Servicios::getUserImage($Usuario);
        
        $array['imgUsuario'] = $linkimagen;
        
        $codigofacultad = Factory::getSessionVar('codigofacultad');
        $idCarrera = Factory::getSessionVar('codigofacultad');
        
        $rol = Factory::getSessionVar('rol');
        
        if((empty($codigofacultad) && $rol==1) || ($codigofacultad==1 && !empty($idCarrera))){
            $idCarrera = Factory::getSessionVar('idCarrera');
        }
        if(empty($idCarrera)){
            $idCarrera = $codigofacultad;
        }
        //ddd($_SESSION );
        $Carrera = new \Sala\entidad\Carrera();
        $Carrera->setDb();
        $Carrera->setCodigocarrera($idCarrera);
        $Carrera->getByCodigo();
        
        $carreraSession = unserialize(Factory::getSessionVar("carreraEstudiante"));
        if(empty($carreraSession) || ($carreraSession->getCodigocarrera() != $Carrera->getCodigocarrera()) ){
            Factory::setSessionVar('carreraEstudiante', serialize($Carrera));
        }
            
        $array['Carrera'] = $Carrera;
        
        $curRol = Factory::getSessionVar('idPerfil'); 
        
        if(!empty($curRol)){ 
            
            $array['selectPerfil'] = $this->getPerfilName($curRol);
            $array['personalInfo'] = $this->getPersonalInfo($curRol, $Usuario);
        }
        
        //d($array);
        return $array;
    }
    
    private function getPerfilName($id){
        //d($id);
        $nameRolPerfil = '';
        $ico = "";
        switch($id){
            case '1':
                $nameRolPerfil = 'Estudiante';
                $ico = "fa-child";
                break;
            case '2':
                $nameRolPerfil = 'Docente';
                $ico = "fa-graduation-cap";
                break;
            case '3':
            //case '13':
                $nameRolPerfil = 'Administrativo';
                $ico = "fa-cogs";
                break;
            case '4':
                $nameRolPerfil = 'Padre';
                $ico = "fa-male";
                break;    
        }
        $return = '
                <i class="fa '.$ico.' lang-flag" aria-hidden="true"></i>
                <span class="lang-name">'.$nameRolPerfil.'</span>
                ';
        
        return $return;
    }
    
    private function getPersonalInfo($id, $Usuario){
        require_once(PATH_SITE."/entidad/Periodo.php");
        $return = array();
        //d($id);
        switch($id){
            case '1':
                $EstudianteGeneral = new \Sala\entidad\EstudianteGeneral();
                $EstudianteGeneral->setDb();
                $EstudianteGeneral->setIdestudiantegeneral(Factory::getSessionVar('sesion_idestudiantegeneral'));
                $EstudianteGeneral->getById();
                //d($EstudianteGeneral);
                $return["email"] = new \stdClass();
                $return["email"]->ico = "fa-at";
                $return["email"]->text = $EstudianteGeneral->getEmailestudiantegeneral()." - ".$EstudianteGeneral->getEmail2estudiantegeneral();
                $return["cel"] = new \stdClass();
                $return["cel"]->ico = "fa-mobile";
                $return["cel"]->text = $EstudianteGeneral->getCelularestudiantegeneral();
                $return["tel"] = new \stdClass();
                $return["tel"]->ico = "fa-phone";
                $return["tel"]->text = $EstudianteGeneral->getTelefonoresidenciaestudiantegeneral();
                $return["dir"] = new \stdClass();
                $return["dir"]->ico = "fa-address-book";
                $return["dir"]->text = $EstudianteGeneral->getDireccionresidenciaestudiantegeneral();
                break;
            case '2':
            case '3':
                
                $codigofacultad = Factory::getSessionVar('codigofacultad');
                $idCarrera = Factory::getSessionVar('codigofacultad');

                $rol = Factory::getSessionVar('rol');

                if((empty($codigofacultad) && $rol==1) || ($codigofacultad==1 && !empty($idCarrera))){
                    $idCarrera = Factory::getSessionVar('idCarrera');
                }
                if(empty($idCarrera)){
                    $idCarrera = $codigofacultad;
                }
                
                $carreraSession = unserialize(Factory::getSessionVar("carreraEstudiante"));
                //d($carreraSession);
                if(!empty($carreraSession) && ($carreraSession->getCodigocarrera()!=$idCarrera)){
                    $Carrera = $carreraSession;
                    $Carrera->setDb();
                    //d("entra1");
                }else{
                    //d("entra2");
                    $Carrera = new \Sala\entidad\Carrera();
                    $Carrera->setDb();
                    $Carrera->setCodigocarrera($idCarrera);
                    $Carrera->getByCodigo();
                    Factory::setSessionVar('carreraEstudiante', serialize($Carrera));
                }
                
                $AdministrativosDocentes = new \Sala\entidad\AdministrativosDocentes();
                $AdministrativosDocentes->setDb();
                $AdministrativosDocentes->setTipodocumento($Usuario->getTipodocumento());
                $AdministrativosDocentes->setNumerodocumento($Usuario->getNumerodocumento());
                $AdministrativosDocentes->getByDocumentoTipo();
                
                $esVirtual = Servicios::isVirtual($Carrera);
                if($esVirtual){
                    $PeriodoVirtualSession = Factory::getSessionVar("PeriodoVirtualSession");
                    if(!empty($PeriodoVirtualSession)){
                        $return["periodo"] = new \stdClass();
                        $return["periodo"]->ico = "fa-calendar-check-o";
                        $return["periodo"]->text = $PeriodoVirtualSession->getPeriodoVirtual()->getNombrePeriodo();
                        $return["periodo"]->id = "asideNombrePeriodo";
                    }
                }else{
                    $Periodo = new \Sala\entidad\Periodo();
                    $Periodo->setDb();
                    $Periodo->setCodigoperiodo(Factory::getSessionVar('codigoperiodosesion'));
                    $Periodo->getById();
                    $return["periodo"] = new \stdClass();
                    $return["periodo"]->ico = "fa-calendar-check-o";
                    $return["periodo"]->text = $Periodo->getNombreperiodo();
                    $return["periodo"]->id = "asideNombrePeriodo";
                }
                
                //d($AdministrativosDocentes);
                $return["cargo"] = new \stdClass();
                $return["cargo"]->text = $AdministrativosDocentes->getCargoadministrativosdocentes();
                $return["email"] = new \stdClass();
                $return["email"]->ico = "fa-at";
                $return["email"]->text = $AdministrativosDocentes->getEmailadministrativosdocentes();
                if(empty($return["email"]->text)){
                    unset($return["email"]);
                }
                $return["cel"] = new \stdClass();
                $return["cel"]->ico = "fa-mobile";
                $return["cel"]->text = $AdministrativosDocentes->getCelularadministrativosdocentes();
                if(empty($return["cel"]->text)){
                    unset($return["cel"]);
                }
                $return["tel"] = new \stdClass();
                $return["tel"]->ico = "fa-phone";
                $return["tel"]->text = $AdministrativosDocentes->getTelefonoadministrativosdocentes();
                if(empty($return["tel"]->text)){
                    unset($return["tel"]);
                }
                
                break;
            case '4':
                break;    
        }
        
        return $return;
    }
}
