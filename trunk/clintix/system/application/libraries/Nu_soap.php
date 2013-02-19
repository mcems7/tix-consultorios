<?php
/*********************************************************************************
 * @AUTOR:            ULTIMINIO RAMOS GALAN.
 * @SISTEMA:          CI_training.
 * @FECHA:            17/07/2010, 11:46:15 PM.
 * @ARCHIVO:          Nu_soap.php
 * @DESCRIPCION:      Libreria propia.
 * @Encoding file:    UTF-8
 * Notas:             Convenciones de nombres de archivos, clases, metodos,
 *                    variables, estructuras de control {}, manejo de operadores,
 *                    etc, son adoptadas segun la guia de referencia de
 *                    CodeIgniter.
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No se permite el acceso directo a las p&aacute;ginas de este sitio.');

class Nu_soap {

   function  __construct() {
      // Por si se ejecuta en un servidor Windows
      // require_once(str_replace("\\", "/", APPPATH).'libraries/NuSOAP/lib/nusoap'.EXT);
      require_once('NuSOAP/lib/nusoap'.EXT);
   } // end Constructor

   function index($no_cache) {
   }  // end function

} // end Class

/* End of file Nu_soap.php */