<?php
namespace Sala\config;
/**
 * Archivo de configuracion global
 * 
 * Este archivo contiene un objeto singleton con los paramateros de configuracion
 * global necesarios para inicializar el sistema, la conexion a bases de datos
 * las rutas absolutas del sitio y la version para cachear la carga de scripts
 * en los navegadores
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package config
 */

class Configuration {
    /**
     * $config es una variable privada estatica, es la contenedora de la 
     * instancia singleton del objeto Configuration
     * 
     * @var Configuration Object
     * @access private static
     */
    private static $config;
    
    /**
     * $template es una variable privada, es la contenedora del nombre de
     * template con el que se redenderiza la capa de presentación
     * 
     * @var String
     * @access private
     */
    private $template;
    
    /**
     * $entorno es una variable privada, contiene el nombre del entorno donde se 
     * esta ejecutando el sistema (local, prebas, produccion), es utilizado
     * para mostrar o no errores y/o debug de variables
     * 
     * @var String
     * @access private
     */
    private $entorno;
    
    /**
     * $hostName es una variable privada, contiene el nombre del host donde se
     * encuentra la base de datos PRINCIPAL, es utilizada para setear la 
     * conexion a base de datos
     * 
     * @var String
     * @access private
     */
    private $hostName;
    
    /**
     * $dbName es una variable privada, contiene el nombre de la base de datos
     * PRINCIPAL, es utilizada para setear la conexion a base de datos
     * 
     * @var String
     * @access private
     */
    private $dbName;
    
    /**
     * $dbUserName es una variable privada, contiene el user de la base de datos
     * PRINCIPAL, es utilizada para setear la conexion a base de datos
     * 
     * @var String
     * @access private
     */
    private $dbUserName;
    
    /**
     * $dbUserPasswd es una variable privada, contiene el passwd del usuario
     * de la base de datos PRINCIPAL, es utilizada para setear la conexion a 
     * base de datos
     * 
     * @var String
     * @access private
     */
    private $dbUserPasswd;
    
    /**
     * $hostNameAndover es una variable privada, contiene el nombre del host 
     * donde se encuentra la base de datos del ANDOVER, es utilizada para setear 
     * la conexion a base de datos para consultas de andover
     * 
     * @var String
     * @access private
     */
    private $hostNameAndover;
    
    /**
     * $dbNameAndover es una variable privada, contiene el nombre de la base de 
     * datos ANDOVER, es utilizada para setear la conexion a base de datos
     * 
     * @var String
     * @access private
     */
    private $dbNameAndover;
    
    /**
     * $dbUserNameAndover es una variable privada,contiene el passwd del usuario
     * de la base de datos ANDOVER, es utilizada para setear la conexion a 
     * base de datos
     * 
     * @var String
     * @access private
     */
    private $dbUserNameAndover;
    
    /**
     * $dbUserPasswdAndover es una variable privada, contiene el passwd del 
     * usuario de la base de datos ANDOVER, es utilizada para setear la conexion
     * a base de datos
     * 
     * @var String
     * @access private
     */
    private $dbUserPasswdAndover;
    
    /**
     * $versionSistema es una variable privada, contiene un string con el dato 
     * de version del sistema, para entornos de desarrollo este valor es el
     * hash de git, para entornos de pruebas y produccion es el unixtime de la
     * ultima modificacion a un archivo en el PATH_SITE
     * 
     * @var String
     * @access private
     */
    private $versionSistema;
    
    /**
     * $SESSION_LIVE es una variable privada, contiene el tiempo de vida de
     * session en segundos, se setea como variable constante global en el 
     * constructor
     * 
     * @var int
     * @access private
     */
    private $SESSION_LIVE = 14400; //30 minutos * 60 segundos;
    
    /**
     * $HTTP_SITE es una variable privada, contiene la url completa del site
     * donde se encuentra sala en el ambiente en que este corriendo, se setea 
     * como variable constante global en el constructor
     * 
     * @var String
     * @access private
     */
    private $HTTP_SITE;
    
    /**
     * $HTTP_ROOT es una variable privada, contiene la url completa del root
     * donde se encuentra sala en el ambiente en que este corriendo, se setea 
     * como variable constante global en el constructor
     * 
     * @var String
     * @access private
     */
    private $HTTP_ROOT;
    
    /**
     * $PATH_ROOT es una variable privada, contiene la ruta fisica completa del 
     * root donde se encuentra sala en el ambiente en que este corriendo, se 
     * setea como variable constante global en el constructor
     * 
     * @var String
     * @access private
     */
    private $PATH_ROOT; 
    
    /**
     * $PATH_SITE es una variable privada, contiene la ruta fisica completa del 
     * site donde se encuentra sala en el ambiente en que este corriendo, se 
     * setea como variable constante global en el constructor
     * 
     * @var String
     * @access private
     */
    private $PATH_SITE; 

    /**
     * Constructor de la clase Configuration, de caracter privado al tratarse
     * de un singleton, setea {@link $template , @link $entorno , 
     * @link $hostName , @link $dbName , @link $dbUserName , 
     * @link $dbUserPasswd , @link $hostNameAndover , @link $dbNameAndover , 
     * @link $dbUserNameAndover , @link $dbUserPasswdAndover , 
     * @link $versionSistema , @link $SESSION_LIVE , @link $HTTP_SITE , 
     * @link $HTTP_ROOT , @link $PATH_ROOT , @link $PATH_SITE}
     */   
    private function __construct() {
        /**
         * _EXEC se define como constante de seguridad, se utiliza en todos los
         * archivos php del sisteman, si no esta definida no permite acceso al
         * archivo, de modo que todos los archivos deben ser cargados a traves
         * del ducto general del site, previene utilizacion sin permiso de las
         * clases
         * 
         * @global integer _EXEC 
         * @name _EXEC
         */ 
        if (!defined('_EXEC')){
            define('_EXEC', 1);
        }
        $this->template = "default"; 
        if(strcmp($_SERVER['SERVER_NAME'], "localhost")==0){
            $versionGit = self::getGitVersion();
            $this->versionSistema = $versionGit['number'];
            $this->entorno = "local";
            $this->hostName = "172.16.36.8";//desarrollo 
            $this->dbName = "sala2";
            $this->dbUserName = "appadmin";
            $this->dbUserPasswd = "*4pp4dm1n2013*";
            
            $this->HTTP_SITE = "http://localhost/proyecto/sala";
            $this->HTTP_ROOT = "http://localhost/proyecto";
            $this->PATH_SITE = "/var/www/html/proyecto/sala";            
            $this->PATH_ROOT = "/var/www/html/proyecto";            
        }elseif(strcmp($_SERVER["SERVER_ADDR"], "172.16.36.120")==0){
            $versionGit = self::getGitVersion();
            $this->entorno = "pruebas"; 
            $this->hostName = "172.16.36.8";//desarrollo 
            $this->dbName = "sala2";
            $this->dbUserName = "appadmin";
            $this->dbUserPasswd = "*4pp4dm1n2013*";
            $this->HTTP_SITE = "http://172.16.36.120/proyecto/sala";
            $this->HTTP_ROOT = "http://172.16.36.120/proyecto";
            $this->PATH_SITE = "/var/www/html/proyecto/sala";
            $this->PATH_ROOT = "/var/www/html/proyecto";
        }elseif(strcmp($_SERVER["SERVER_ADDR"], "172.16.36.5")==0){
            $this->entorno = "pruebas";
            $this->hostName = "172.16.36.9";//Preproducion
            $this->dbName = "sala";
            $this->dbUserName = "appadmin";
            $this->dbUserPasswd = "*4pp4dm1n2013*";
            $this->HTTP_SITE = "https://artemisa365.unbosque.edu.co/sala";
            $this->HTTP_ROOT = "https://artemisa365.unbosque.edu.co";
            $this->PATH_SITE = "/usr/local/apache2/htdocs/html/sala";
            $this->PATH_ROOT = "/usr/local/apache2/htdocs/html";
            $this->versionSistema = self::getDateLastFileModified($this->PATH_SITE);
        }elseif(strcmp($_SERVER["SERVER_ADDR"], "172.16.36.10")==0){
            //$this->entorno = "preproduccion";
            $this->entorno = "pruebas";
            $this->hostName = "172.16.36.8";//desarrollo 
            $this->dbName = "sala2";
            $this->dbUserName = "appadmin";
            $this->dbUserPasswd = "*4pp4dm1n2013*";
            $this->HTTP_SITE = "http://172.16.36.10/sala";
            $this->HTTP_ROOT = "http://172.16.36.10";
            $this->PATH_SITE = "/usr/local/apache2/htdocs/html/sala";
            $this->PATH_ROOT = "/usr/local/apache2/htdocs/html";
            $this->versionSistema = self::getDateLastFileModified($this->PATH_SITE);
        }

        /*
         * En el $hostanme_sql= "Molinetes" se define asi por que esa es la conexion que realizamos en vez de la IP 
         * ya que lo definimos en la configuracion del Freetds
         */
        $this->hostNameAndover = "Molinetes";
        $this->dbNameAndover = "ContinuumDB";
        $this->dbUserNameAndover = "dba";
        $this->dbUserPasswdAndover = "Ubosque2012";
        
        /**#@+
         * Constants
         */
        /**
         * HTTP_ROOT se define como constante para acceso global inmediato a la
         * url absoluta del root del sistema
         * 
         * @global String HTTP_ROOT 
         * @name HTTP_ROOT
         */ 
        if(!defined("HTTP_ROOT")){
            define("HTTP_ROOT", $this->getHTTP_ROOT());
        }
        
        /**
         * HTTP_SITE se define como constante para acceso global inmediato a la
         * url absoluta del site del sistema
         * 
         * @global String HTTP_SITE 
         * @name HTTP_SITE
         */ 
        if(!defined("HTTP_SITE")){
            define("HTTP_SITE", $this->getHTTP_SITE());
        }
        
        /**
         * PATH_SITE se define como constante para acceso global inmediato a la
         * path fisico absoluto del site del sistema en el servidor
         * 
         * @global String PATH_SITE 
         * @name PATH_SITE
         */ 
        if(!defined("PATH_SITE")){ 
            define("PATH_SITE", $this->getPATH_SITE());
        }
        
        /**
         * PATH_ROOT se define como constante para acceso global inmediato a la
         * path fisico absoluto del root del sistema en el servidor
         * 
         * @global String PATH_ROOT 
         * @name PATH_ROOT
         */ 
        if(!defined("PATH_ROOT")){ 
            define("PATH_ROOT", $this->getPATH_ROOT());
        }
        
        /**
         * SESSION_LIVE se define como constante para acceso global inmediato al
         * tiempo de vida de la session
         * 
         * @global String SESSION_LIVE 
         * @name SESSION_LIVE
         */ 
        if(!defined("SESSION_LIVE")){ 
            define("SESSION_LIVE", $this->getSESSION_LIVE());
        }
    }
    
    /**
     * Retorna la instancia creada del objeto configuracion, importante recordar
     * que el objeto configuracion se concibe como un singleton
     * @access public static
     * @return Configuration Object
     */
    public static function getInstance(){        
        if (empty(self::$config)){
            self::$config = new Configuration(); 
        }
        return self::$config;        
    }
    
    /**
     * Retorna el nombre de template seteado para el site {@link $template}
     * @return String $template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Setea el nombre de template para el site, en caso de que en tiempo de 
     * ejecucion sea modificado  {@link $template}
     * @param String $template
     * @return void
     */
    public function setTemplate($template) {
        $this->template = $template;
    }
    
    /**
     * Retorna el hostName seteado para el site {@link $hostName}
     * @return String $hostName
     */
    public function getHostName() {
        return $this->hostName;
    }

    /**
     * Retorna el dbName seteado para el site {@link $dbName}
     * @return String $dbName
     */
    public function getDbName() {
        return $this->dbName;
    }

    /**
     * Retorna el dbUserName seteado para el site {@link $dbUserName}
     * @return String $dbUserName
     */
    public function getDbUserName() {
        return $this->dbUserName;
    }

    /**
     * Retorna el dbUserPasswd seteado para el site {@link $dbUserPasswd}
     * @return String $dbUserPasswd
     */
    public function getDbUserPasswd() {
        return $this->dbUserPasswd;
    }
    
    /**
     * Retorna el hostNameAndover seteado para el site {@link $hostNameAndover}
     * @return String $hostNameAndover
     */
    public function getHostNameAndover() {
        return $this->hostNameAndover;
    }

    /**
     * Retorna el dbNameAndover seteado para el site {@link $dbNameAndover}
     * @return String $dbNameAndover
     */
    public function getDbNameAndover() {
        return $this->dbNameAndover;
    }

    /**
     * Retorna el dbUserNameAndover seteado para el site {@link $dbUserNameAndover}
     * @return String $dbUserNameAndover
     */
    public function getDbUserNameAndover() {
        return $this->dbUserNameAndover;
    }

    /**
     * Retorna el dbUserPasswdAndover seteado para el site {@link $dbUserPasswdAndover}
     * @return String $dbUserPasswdAndover
     */
    public function getDbUserPasswdAndover() {
        return $this->dbUserPasswdAndover;
    }
    
    /**
     * Retorna el entorno seteado para el site {@link $entorno}
     * @return String $entorno
     */
    public function getEntorno() {
        return $this->entorno;
    }
    
    /**
     * Retorna el versionSistema seteado para el site en caso de fallar se 
     * autosetea como la primera unixtime de consulta a esta variable
     * {@link $versionSistema}
     * @return String $versionSistema
     */
    public function getVersionSistema() {
        if(empty($this->versionSistema)){
            $this->versionSistema = mktime(); 
        }
        return $this->versionSistema;
    }
    
    /**
     * Retorna el SESSION_LIVE seteado para el site {@link $SESSION_LIVE}
     * @return int $SESSION_LIVE
     */
    public function getSESSION_LIVE() {
        return $this->SESSION_LIVE;
    }
    
    /**
     * Retorna el HTTP_SITE seteado para el site {@link $HTTP_SITE}
     * @return String $HTTP_SITE
     */
    function getHTTP_SITE() {
        return $this->HTTP_SITE;
    }
    
    /**
     * Retorna el HTTP_ROOT seteado para el site {@link $HTTP_ROOT}
     * @return String $HTTP_ROOT
     */
    function getHTTP_ROOT() {
        return $this->HTTP_ROOT;
    }

    /**
     * Retorna el PATH_SITE seteado para el site {@link $PATH_SITE}
     * @return String $PATH_SITE
     */
    function getPATH_SITE() {
        return $this->PATH_SITE;
    }

    /**
     * Retorna el PATH_ROOT seteado para el site {@link $PATH_ROOT}
     * @return String $PATH_ROOT
     */
    function getPATH_ROOT() {
        return $this->PATH_ROOT;
    }
    
    /**
     * Retorna la version de Git sobre la cual esta corriendo el sistema
     * SOLO para ambientes locales
     * @return String
     */
    public static function getGitVersion() {
        exec('git describe --always',$version_mini_hash);
        exec('git rev-list HEAD | wc -l',$version_number);
        exec('git log -1',$line);
        $version['number'] = $version_number[0];
        $version['hash'] = $version_mini_hash[0];
        $version['short'] = "v1.".trim($version_number[0]).".".$version_mini_hash[0];
        $version['full'] = "v1.".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ','',$line[0]).")";
        return $version;
    }
    
    /**
     * Retorna la fecha unixtime de ultima modificacion de archivos en el path_site
     * @param String $path_site
     * @return String
     */
    public static function getDateLastFileModified($path_site){
        exec('find '.$path_site.' -type f -name "*.css" -o -name "*.js" -printf "%T@\n" | sort -nr | head -1',$last1);
        $t = explode(".",(string) $last1[0]);
        if(is_array($t)){
            $t = $t[0];
        }else{
            $t = $last1[0];
        }
        return ((string) $t);
    }

}