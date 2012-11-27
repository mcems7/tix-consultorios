<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_especialidad extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_especialidad";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "descripcion";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Especialidades m&eacute;dicas";
		
		$spec['campos'][0]['etiqueta']     = 'C&oacute;digo especialidad';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['campo_nombre'] = 'id_especialidad';
		$spec['campos'][0]['editable']     = false;
		
		$spec['campos'][1]['etiqueta']     = 'Descripci&oacute;n especialidad';
		$spec['campos'][1]['tipo']         = 'texto';
		$spec['campos'][1]['longitud']     = 100;
		$spec['campos'][1]['largo']        = 50;
		$spec['campos'][1]['campo_nombre'] = 'descripcion';

		return $spec;
	}
}

?>