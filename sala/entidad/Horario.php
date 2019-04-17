<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\entidad;

defined('_EXEC') or die;

use \Sala\lib\Factory;

/**
 * Description of Horario
 *
 * @author Andres
 */
class Horario implements \Sala\interfaces\Entidad {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idhorario;
    private $idgrupo;
    private $codigodia;
    private $horainicial;
    private $horafinal;
    private $codigotiposalon;
    private $codigosalon;
    private $codigoestado;

    public function __construct() {
        
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function getIdhorario() {
        return $this->idhorario;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function getCodigodia() {
        return $this->codigodia;
    }

    public function getHorainicial() {
        return $this->horainicial;
    }

    public function getHorafinal() {
        return $this->horafinal;
    }

    public function getCodigotiposalon() {
        return $this->codigotiposalon;
    }

    public function getCodigosalon() {
        return $this->codigosalon;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setIdhorario($idhorario) {
        $this->idhorario = $idhorario;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function setCodigodia($codigodia) {
        $this->codigodia = $codigodia;
    }

    public function setHorainicial($horainicial) {
        $this->horainicial = $horainicial;
    }

    public function setHorafinal($horafinal) {
        $this->horafinal = $horafinal;
    }

    public function setCodigotiposalon($codigotiposalon) {
        $this->codigotiposalon = $codigotiposalon;
    }

    public function setCodigosalon($codigosalon) {
        $this->codigosalon = $codigosalon;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getById() {
        if (!empty($this->idcorte)) {
            $query = "SELECT * FROM horario "
                    . " WHERE idhorario = " . $this->db->qstr($this->idhorario);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->setIdhorario($d['idhorario']);
                $this->setIdgrupo($d['idgrupo']);
                $this->setCodigodia($d['codigodia']);
                $this->setHorainicial($d['horainicial']);
                $this->setHorafinal($d['horafinal']);
                $this->setCodigotiposalon($d['codigotiposalon']);
                $this->setCodigosalon($d['codigosalon']);
                $this->setCodigoestado($d['codigoestado']);
            }
        }
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM horario "
                . " WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);

        while ($d = $datos->FetchRow()) {
            $Horario = new Horario();
            $Horario->setIdhorario($d['idhorario']);
            $Horario->setIdgrupo($d['idgrupo']);
            $Horario->setCodigodia($d['codigodia']);
            $Horario->setHorainicial($d['horainicial']);
            $Horario->setHorafinal($d['horafinal']);
            $Horario->setCodigotiposalon($d['codigotiposalon']);
            $Horario->setCodigosalon($d['codigosalon']);
            $Horario->setCodigoestado($d['codigoestado']);
            $return[] = $Horario;
            unset($Horario);
        }
        return $return;
    }

}