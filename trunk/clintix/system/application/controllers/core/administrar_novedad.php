<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/system/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_novedad extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_novedades";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "id_novedad";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Novedades del sistema";
		
		$spec['campos'][0]['etiqueta']     = 'ID';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['campo_nombre'] = 'id_novedad';
		$spec['campos'][0]['editable']     = false;
		
		$spec['campos'][1]['etiqueta']     = 'Titulo';
		$spec['campos'][1]['tipo']         = 'texto';
		$spec['campos'][1]['longitud']     = 64;
		$spec['campos'][1]['campo_nombre'] = 'titulo';
		
		$spec['campos'][2]['etiqueta']     = 'Novedad';
		$spec['campos'][2]['tipo']         = 'areatexto';
		$spec['campos'][2]['campo_nombre'] = 'texto';
		
		$spec['campos'][3]['etiqueta']     = 'Fecha de publicaci&oacute;n';
		$spec['campos'][3]['tipo']         = 'fecha';
		$spec['campos'][3]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][3]['formato_tiempo'] = '12';
		$spec['campos'][3]['mostrar_hora'] = true;
		$spec['campos'][3]['editable']     = false;
		$spec['campos'][3]['campo_nombre'] = 'fecha_publicacion';

		$spec['campos'][4]['etiqueta']     = 'Fecha de actualizaci&oacute;n';
		$spec['campos'][4]['tipo']         = 'fecha';
		$spec['campos'][4]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][4]['formato_tiempo'] = '12';
		$spec['campos'][4]['mostrar_hora'] = true;
		$spec['campos'][4]['editable']     = false;
		$spec['campos'][4]['campo_nombre'] = 'fecha_modificacion';
		
		return $spec;
	}
}

?>