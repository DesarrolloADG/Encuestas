<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\models\General AS GeneralDao;
use \Core\Controller;

//echo dirname(__DIR__);

require_once dirname(__DIR__).'/../public/librerias/mpdf/mpdf.php';
require_once dirname(__DIR__).'/../public/librerias/phpexcel/Classes/PHPExcel.php';

//require_once '/home/granja/backend/public/librerias/mpdf/mpdf.php';
//require_once '/home/granja/backend/public/librerias/phpexcel/Classes/PHPExcel.php';

class Contenedor extends Controller{


    function __construct(){
      parent::__construct();
      //echo "Este esl usuario: {$this->__usuario}+++++";
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function header($extra = ''){
        $usuario = $this->__usuario;

     $header =<<<html
        <!DOCTYPE html>
        <html lang="en">
          <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!-- Meta, title, CSS, favicons, etc. -->
            <meta charset="utf-8">

            <title>SAIRRHH - ADG</title>
            <link rel="shortcut icon" href="/img/iconlogogranja.png">
            <link href="/css/nprogress.css" rel="stylesheet">
            <link rel="stylesheet" href="/css/tabla/sb-admin-2.css">
            <link rel="stylesheet" href="/css/bootstrap/datatables.bootstrap.css">
            <link rel="stylesheet" href="/css/bootstrap/bootstrap.css">
            <link rel="stylesheet" href="/css/bootstrap/bootstrap-switch.css">
            <link rel="stylesheet" href="/css/validate/screen.css">
            <link rel="stylesheet" href="/css/extra.css" />
            <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />

            <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
          	<link href="/css/font-awesome.min.css" rel="stylesheet">
            <link href="/css/menu/menu5custom.min.css" rel="stylesheet">
            <link href="/css/green.css" rel="stylesheet">
            <link href="/css/custom.min.css" rel="stylesheet">

            <link href="/librerias/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="/librerias/vintage_flip_clock/jquery.flipcountdown.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            
           <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
                    
                    </head>
html;
$menu =<<<html
<body class="container body">
  <div class="container body">
      <div class="top_nav">
      
        <div class="nav_menu">
        
            <ul class="nav navbar-nav navbar-right">
          
              <li>
              <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="/img/usr/user.png" alt="">{$usuario}
                     <span class="fa fa-angle-down"></span>
                  </a>
              
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="/Usuario/"> Perfil</a></li>
                  <!--li>
                    <a href="">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Configuración</span>
                      </a>
                  </li>
                  <li><a href="">Ayuda</a></li-->
                  <li><a href="/Login/cerrarSession"><i class="fa fa-sign-out pull-right"></i>Cerrar Sesión</a></li>
                </ul>
              </li>
               <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">4</span>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                
                  </ul>
                </li>
            </ul>
             <h2>&#160;&#160;&#160;&#160;&#160;&#160; <i class="fa fa-users" aria-hidden="true"></i>
                Mi Sitio Encuentas y Evaluaciones RH</h2>
        </div>
      </div>
    

html;

    return $header.$extra.$menu;
    }

    public function footer($extra = ''){
        $footer =<<<html
            
            </div>
            <footer>
            </footer>
            <!-- /footer content -->
          
        <script src="/js/moment/moment.min.js"></script>
        <script src="/js/datepicker/scriptdatepicker.js"></script>
        <script src="/js/datepicker/datepicker2.js"></script>

        <!-- jQuery -->
        <script src="/js/jquery.min.js"></script>
        
        <!-- Bootstrap -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/bootstrap/bootstrap-switch.js"></script>
        <script src="/js/nprogress.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="/js/custom.min.js"></script>

        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <script src="/js/login.js"></script>

        <script src="/js/tabla/jquery.dataTables.min.js"></script>
        <script src="/js/tabla/dataTables.editor.min.js"></script>
        <script src="/js/tabla/dataTables.bootstrap.min.js"></script>
        <script src="/js/tabla/jquery.tablesorter.js"></script>

        <!-- EXTENCIONES DE DATATABLE() PARA EXPORTAR  -->
        <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" ></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" ></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" ></script>
        <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js" ></script>

        <script src="/librerias/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script type="text/javascript" src="/librerias/vintage_flip_clock/jquery.flipcountdown.js"></script>


  </body>
</html>
html;

    return $footer.$extra;
    }

}
