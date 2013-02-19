<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/system/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_cama extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_cama";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "id_cama";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Administraci&oacute;n de camas";
		
		$spec['campos'][0]['etiqueta']     = 'ID Cama';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['editable']     = false;
		$spec['campos'][0]['campo_nombre'] = 'id_cama';
		
		$spec['campos'][1]['etiqueta']      = 'Servicio';
		$spec['campos'][1]['tipo']          = 'consulta';
		$spec['campos'][1]['origen_tabla']  = 'core_servicios_hosp';
		$spec['campos'][1]['origen_codigo'] = 'id_servicio';
		$spec['campos'][1]['origen_valor']  = 'nombre_servicio';
		$spec['campos'][1]['campo_nombre']  = 'id_servicio';		

		$spec['campos'][2]['etiqueta']      = 'N&uacute;mero de la cama';
		$spec['campos'][2]['tipo']          = 'texto';
		$spec['campos'][2]['longitud']      = 64;
		$spec['campos'][2]['campo_nombre'] = 'numero_cama';
		
		$spec['campos'][3]['etiqueta']      = 'Estado';
		$spec['campos'][3]['tipo']          = 'consulta';
		$spec['campos'][3]['origen_tabla']  = 'core_estados_camas';
		$spec['campos'][3]['origen_codigo'] = 'id_estado';
		$spec['campos'][3]['origen_valor']  = 'estado';
		$spec['campos'][3]['campo_nombre']  = 'id_estado';		
		
		$spec['campos'][4]['etiqueta']      = 'Observaciones';
		$spec['campos'][4]['tipo']          = 'areatexto';
		$spec['campos'][4]['campo_nombre'] = 'observacion';	


		return $spec;
	}
}

?>