<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/system/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_permiso extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_permiso";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "id_permiso";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Permisos del sistema";
		
		$spec['campos'][0]['etiqueta']     = 'Identificador del permiso';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['campo_nombre'] = 'id_permiso';
		$spec['campos'][0]['editable']     = false;
		
		$spec['campos'][1]['etiqueta']     = 'M&oacute;dulo';
		$spec['campos'][1]['tipo']         = 'texto';
		$spec['campos'][1]['longitud']     = 64;
		$spec['campos'][1]['campo_nombre'] = 'modulo';

		$spec['campos'][2]['etiqueta']     = 'Controlador';
		$spec['campos'][2]['tipo']         = 'texto';
		$spec['campos'][2]['longitud']     = 64;
		$spec['campos'][2]['campo_nombre'] = 'controlador';

		$spec['campos'][3]['etiqueta']     = 'Acci&oacute;n';
		$spec['campos'][3]['tipo']         = 'texto';
		$spec['campos'][3]['longitud']     = 64;
		$spec['campos'][3]['campo_nombre'] = 'accion';

		$spec['campos'][4]['etiqueta']     = 'Descripci&oacute;n';
		$spec['campos'][4]['tipo']         = 'texto';
		$spec['campos'][4]['largo']        = 100;
		$spec['campos'][4]['longitud']     = 250;
		$spec['campos'][4]['campo_nombre'] = 'descripcion';

		$spec['campos'][5]['etiqueta']     = 'Informaci&oacute;n adicional';
		$spec['campos'][5]['tipo']         = 'texto';
		$spec['campos'][5]['largo']        = 100;
		$spec['campos'][5]['longitud']     = 128;
		$spec['campos'][5]['campo_nombre'] = 'informacion_adicional';

		$spec['campos'][6]['etiqueta']     = 'Fecha de creaci&oacute;n';
		$spec['campos'][6]['tipo']         = 'fecha';
		$spec['campos'][6]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][6]['formato_tiempo'] = '12';
		$spec['campos'][6]['mostrar_hora'] = true;
		$spec['campos'][6]['editable']     = false;
		$spec['campos'][6]['campo_nombre'] = 'fecha_creacion';

		$spec['campos'][7]['etiqueta']     = 'Fecha de actualizaci&oacute;n';
		$spec['campos'][7]['tipo']         = 'fecha';
		$spec['campos'][7]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][7]['formato_tiempo'] = '12';
		$spec['campos'][7]['mostrar_hora'] = true;
		$spec['campos'][7]['editable']     = false;
		$spec['campos'][7]['campo_nombre'] = 'fecha_actualizacion';

		$spec['campos'][8]['etiqueta']     = 'Acceso directo';
		$spec['campos'][8]['tipo']         = 'arreglo';
		$spec['campos'][8]['opciones']     = array('s' => 'Si', 'n' => 'No');
		$spec['campos'][8]['campo_nombre'] = 'acceso_directo';

		return $spec;
	}
}

?>