<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_mensaje extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_mensaje";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "id_mensaje";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Mensajes del sistema";
		
		$spec['campos'][0]['etiqueta']     = 'Identificador de mensaje';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['campo_nombre'] = 'id_mensaje';
		$spec['campos'][0]['editable']     = false;
		
		$spec['campos'][1]['etiqueta']     = 'Tipo';
		$spec['campos'][1]['tipo']         = 'arreglo';
		$spec['campos'][1]['opciones']     = array('informacion'   => 'Información',
												   'advertencia'   => 'Advertencia',
												   'error'         => 'Error',
												   'error critico' => 'Error Crítico');
		$spec['campos'][1]['campo_nombre'] = 'tipo';

		$spec['campos'][2]['etiqueta']     = 'Nombre';
		$spec['campos'][2]['tipo']         = 'texto';
		$spec['campos'][2]['longitud']     = 250;
		$spec['campos'][2]['largo']        = 100;
		$spec['campos'][2]['campo_nombre'] = 'nombre';

		$spec['campos'][3]['etiqueta']     = 'Descripción';
		$spec['campos'][3]['tipo']         = 'texto';
		$spec['campos'][3]['longitud']     = 250;
		$spec['campos'][3]['largo']        = 100;
		$spec['campos'][3]['campo_nombre'] = 'descripcion';

		$spec['campos'][4]['etiqueta']     = 'Fecha de creación';
		$spec['campos'][4]['tipo']         = 'fecha';
		$spec['campos'][4]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][4]['formato_tiempo'] = '12';
		$spec['campos'][4]['mostrar_hora'] = true;
		$spec['campos'][4]['editable']     = false;
		$spec['campos'][4]['campo_nombre'] = 'fecha_creacion';

		return $spec;
	}
}

?>