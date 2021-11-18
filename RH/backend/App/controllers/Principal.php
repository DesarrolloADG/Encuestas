<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Principal AS PrincipalDao;


class Principal extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }
    public function getColaborador(){
        return $a = $this->__id_colaborador;
    }

    public function index() {

        $usuario = $this->__usuario;

        $obtener_colaborador = PrincipalDao::getObtenerColaborador($usuario);
        $id = $obtener_colaborador['id_colaborador'];
        $colaboradores = PrincipalDao::getLista($id);
        $tabla= '';
        foreach ($colaboradores as $key => $value) {
            if($value['id_cuestionario'] == 1)
                {
                    $tabla.=<<<html
                    <div class="list-group center-block">
                        <a href="/Encuestas/Ingreso/{$value['id_cuestionario_colaborador']}" class="list-group-item">{$value['nombre']}</a>
                    </div>
html;
                }
            if($value['id_cuestionario'] == 2)
            {
                $tabla.=<<<html
                    <div class="list-group center-block">
                        <a href="/Encuestas/ComunicacionOrganizacional/$id" class="list-group-item">{$value['nombre']}</a>
                    </div>
html;
            }
            if($value['id_cuestionario'] == 3)
            {
                $tabla.=<<<html
                    <div class="list-group center-block">
                        <a href="/Encuestas/Comunicacion/$id" class="list-group-item">{$value['nombre']}</a>
                    </div>
html;
            }
            if($value['id_cuestionario'] == 4)
            {
                $tabla.=<<<html
                    <div class="list-group center-block">
                        <a href="/Encuestas/ClimaLaboral/$id" class="list-group-item">{$value['nombre']}</a>
                    </div>
html;
            }
            if($value['id_cuestionario'] == 5)
            {
                $tabla.=<<<html
                    <div class="list-group center-block">
                        <a href="/Encuestas/Salida/$id" class="list-group-item">{$value['nombre']}</a>
                    </div>
html;
            }

}



        View::set('tabla',$tabla);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("principal_all");
    }

}
