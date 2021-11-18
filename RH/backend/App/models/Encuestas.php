<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Encuestas implements Crud{

    public static function getLista($id){

        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT cc.id_cuestionario_colaborador, ca.id_cuestionario, c.nombre, cc.id_colaborador, ca.fecha_inicio, ca.fecha_fin, cc.estatus FROM cuestionario_colaborador AS cc
  INNER JOIN cuestionarios_activos ca ON cc.id_cuestionario_activo = ca.id_cuestionario_activo
  INNER JOIN cuestionario c ON ca.id_cuestionario = c.id_cuestionario WHERE cc.id_colaborador = $id
  
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * from cuestionarios_activos 
  
sql;
        return $mysqli->queryAll($query);
    }

    public static function insertIngreso($ingreso){
        $mysqli = Database::getInstance();
        $query=<<<sql
      INSERT INTO cuestionario_ingreso_adg
      VALUES (NULL, :id_cuestionario_colaborador, :uno, :dos, :tres, :cuatro, :cinco, :seis, :siete, :ocho, :nueve, :diez, :once, :nombre, :numero);
sql;
        $parametros = array(
            ':id_cuestionario_colaborador' => $ingreso->_id,
            ':uno' => $ingreso->_uno,
            ':dos' => $ingreso->_dos,
            ':tres' => $ingreso->_tres,
            ':cuatro' => $ingreso->_cuatro,
            ':cinco' => $ingreso->_cinco,
            ':seis' => $ingreso->_seis,
            ':siete' => $ingreso->_siete,
            ':ocho' => $ingreso->_ocho,
            ':nueve' => $ingreso->_nueve,
            ':diez' => $ingreso->_diez,
            ':once' => $ingreso->_once,
            ':nombre' => $ingreso->_nombre,
            ':numero' => $ingreso->_numero,
        );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        //UtileriasLog::addAccion($accion);
        return $id;
    }

    public static function insert($encuestas){
        $mysqli = Database::getInstance();
        $query=<<<sql
      INSERT INTO cuestionarios_activos
      VALUES (NULL, :id_cuestionario, :fecha_inicio, :fecha_fin, :fecha_activacion, :trimestre, :comentario, 1);
sql;
        $parametros = array(
            ':id_cuestionario' => $encuestas->_tipo_encuesta,
            ':fecha_inicio' => $encuestas->_fecha_inicio,
            ':fecha_fin' => $encuestas->_fecha_fin,
            ':fecha_activacion' => $encuestas->_fecha_activacion,
            ':trimestre' => $encuestas->_trimestre,
            ':comentario' => $encuestas->_comentario
        );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        UtileriasLog::addAccion($accion);
        return $id;
    }

    public static function update($cuestionario){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE cuestionario_colaborador SET
        estatus = 1
      WHERE id_cuestionario_colaborador = :id_cuestionario_colaborador
sql;
        $parametros = array(
            ':id_cuestionario_colaborador' => $cuestionario->_id
        );

      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $accidente->_id_accidente;
      UtileriasLog::addAccion($accion);
      return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      UPDATE catalogo_colaboradores set status = 2 WHERE catalogo_colaboradores_id = $id
sql;
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $id;
      UtileriasLog::addAccion($accion);
      return $mysqli->update($query);
    }

    public static function getById($id)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
    SELECT id_accidente,
  c.catalogo_colaboradores_id,
  CONCAT(c.nombre, " ", c.apellido_paterno, " ",c.apellido_materno) AS nombre,
  a.fecha_accidente,
  a.trimestre,
  a.id_lugar_accidente,
  cla.detalle AS accidente,
  a.detalle_accidente,
  a.causa,
  cl.id_clasificacion_accidente,
  cl.detalle AS clasificacion_accidente, 
  a.activo_incapacidad,
  a.acto_inseguro,
  a.condicion_insegura
  FROM accidentes AS a
  INNER JOIN catalogo_colaboradores c ON a.catalogo_colaboradores_id = c.catalogo_colaboradores_id
  INNER JOIN catalogo_clasificacion_accidente cl ON a.id_clasificacion_accidente = cl.id_clasificacion_accidente
  INNER JOIN catalogo_lugares_accidentes cla ON a.id_lugar_accidente = cla.id_lugar_accidente
WHERE id_accidente = $id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getColaboradorNombre($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
    SELECT ue.id_colaborador, CONCAT(ca.nombre," ",ca.apellido_materno," ", ca.apellido_paterno) AS nombre FROM usuarios_encuestas AS ue
  INNER JOIN catalogo_colaboradores ca ON ca.catalogo_colaboradores_id = ue.id_colaborador WHERE ue.usuario = '$id'
sql;
        return $mysqli->queryAll($query);
    }

    public static function getLugarAccidente(){
        $mysqli = Database::getInstance();
        $query=<<<sql
      SELECT * FROM catalogo_lugares_accidentes ORDER BY detalle ASC
sql;
        return $mysqli->queryAll($query);
    }

    public static function getClasificacionrAccidente(){
        $mysqli = Database::getInstance();
        $query=<<<sql
      SELECT * FROM catalogo_clasificacion_accidente ORDER BY detalle ASC
sql;
        return $mysqli->queryAll($query);
    }

    public static function verificarRelacion($id){
        $mysqli = Database::getInstance();
        $select = <<<sql
      SELECT cd.catalogo_departamento_id FROM catalogo_departamento cd JOIN catalogo_colaboradores c ON cd.catalogo_departamento_id = c.catalogo_departamento_id WHERE cd.catalogo_departamento_id = $id
sql;
        $sqlSelect = $mysqli->queryAll($select);
        if(count($sqlSelect) >= 1)
            return array('seccion'=>2, 'id'=>$id); // NO elimina
        else
            return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado

    }
}
