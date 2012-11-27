<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_dependencia extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_dependencia";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "nombre_dependencia";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Administraci&oacute;n dependencias";
		
		$spec['campos'][0]['etiqueta']     = 'ID';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['editable']     = false;
		$spec['campos'][0]['campo_nombre'] = 'id_dependencia';

		$spec['campos'][1]['etiqueta']     = 'Nombre dependencia';
		$spec['campos'][1]['tipo']         = 'texto';
		$spec['campos'][1]['longitud']     = 40;
		$spec['campos'][1]['campo_nombre'] = 'nombre_dependencia';
		
		$spec['campos'][2]['etiqueta']     = 'Indicativo';
		$spec['campos'][2]['tipo']         = 'texto';
		$spec['campos'][2]['longitud']     = 2;
		$spec['campos'][2]['campo_nombre'] = 'indicativo';
		
		$spec['campos'][3]['etiqueta']     = 'Tel&eacute;fono';
		$spec['campos'][3]['tipo']         = 'texto';
		$spec['campos'][3]['longitud']     = 15;
		$spec['campos'][3]['campo_nombre'] = 'telefono';
		
		$spec['campos'][4]['etiqueta']     = 'Extension';
		$spec['campos'][4]['tipo']         = 'texto';
		$spec['campos'][4]['longitud']     = 4;
		$spec['campos'][4]['campo_nombre'] = 'extencion';
		
		return $spec;
	}
}

?>
