<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_grupo extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_grupo";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "id_grupo";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Grupos de usuarios del sistema";
		
		$spec['campos'][0]['etiqueta']     = 'Identificador de grupo';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['campo_nombre'] = 'id_grupo';
		$spec['campos'][0]['editable']     = false;
		
		$spec['campos'][1]['etiqueta']     = 'Estado';
		$spec['campos'][1]['tipo']         = 'arreglo';
		$spec['campos'][1]['opciones']     = array('activo'   => 'Activo',
												   'inactivo' => 'Inactivo');
		$spec['campos'][1]['campo_nombre'] = 'estado';

		$spec['campos'][2]['etiqueta']      = 'Coordinador';
		$spec['campos'][2]['tipo']          = 'consulta';
		$spec['campos'][2]['origen_tabla']  = 'core_usuario';
		$spec['campos'][2]['origen_codigo'] = 'id_usuario';
		$spec['campos'][2]['origen_valor']  = '_username';
		$spec['campos'][2]['campo_nombre']  = 'coordinador';

		$spec['campos'][3]['etiqueta']     = 'Nombre';
		$spec['campos'][3]['tipo']         = 'texto';
		$spec['campos'][3]['longitud']     = 50;
		$spec['campos'][3]['campo_nombre'] = 'nombre';

		$spec['campos'][4]['etiqueta']     = 'Descripci&oacute;n';
		$spec['campos'][4]['tipo']         = 'texto';
		$spec['campos'][4]['longitud']     = 250;
		$spec['campos'][4]['largo']        = 64;
		$spec['campos'][4]['campo_nombre'] = 'descripcion';

		$spec['campos'][5]['etiqueta']     = 'Fecha de creaci&oacute;n';
		$spec['campos'][5]['tipo']         = 'fecha';
		$spec['campos'][5]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][5]['formato_tiempo'] = '12';
		$spec['campos'][5]['mostrar_hora'] = true;
		$spec['campos'][5]['campo_nombre'] = 'fecha_creacion';
		$spec['campos'][5]['editable']     = false;
		
		$spec['campos'][6]['etiqueta']     = 'Fecha de actualizaci&oacute;n';
		$spec['campos'][6]['tipo']         = 'fecha';
		$spec['campos'][6]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][6]['formato_tiempo'] = '12';
		$spec['campos'][6]['mostrar_hora'] = true;
		$spec['campos'][6]['campo_nombre'] = 'fecha_actualizacion';
		$spec['campos'][6]['editable']     = false;

		return $spec;
	}
}

?>