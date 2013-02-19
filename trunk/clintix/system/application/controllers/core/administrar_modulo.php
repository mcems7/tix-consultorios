<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/system/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_modulo extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_modulo";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "modulo, nombre";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "M&oacute;dulos de la plataforma";
		
		$spec['campos'][0]['etiqueta']     = 'C&oacute;digo';
		$spec['campos'][0]['tipo']         = 'texto';
		$spec['campos'][0]['longitud']     = 8;
		$spec['campos'][0]['campo_nombre'] = 'modulo';
		
		$spec['campos'][1]['etiqueta']     = 'Nombre';
		$spec['campos'][1]['tipo']         = 'texto';
		$spec['campos'][1]['longitud']     = 64;
		$spec['campos'][1]['campo_nombre'] = 'nombre';
		
		$spec['campos'][2]['etiqueta']     = 'Descripci&oacute;n';
		$spec['campos'][2]['tipo']         = 'areatexto';
		$spec['campos'][2]['campo_nombre'] = 'descripcion';
		
		return $spec;
	}
}

?>