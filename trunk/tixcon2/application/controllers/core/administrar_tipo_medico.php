<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_tipo_afiliado extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_tipo_afiliado ";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "id_tipo_afiliado";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Tipo de afiliados al sistema de seguridad social";
		
		$spec['campos'][0]['etiqueta']     = 'Identificador';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['campo_nombre'] = 'id_tipo_afiliado';
		$spec['campos'][0]['editable']     = false;
		
		$spec['campos'][1]['etiqueta']     = 'Descripci&oacute;';
		$spec['campos'][1]['tipo']         = 'texto';
		$spec['campos'][1]['longitud']     = 100;
		$spec['campos'][1]['largo']        = 50;
		$spec['campos'][1]['campo_nombre'] = 'descripcion';

		return $spec;
	}
}

?>