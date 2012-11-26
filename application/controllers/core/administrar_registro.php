<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_registro extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_registro";
		$spec['pk']                        = array(0, 1, 2, 3, 4, 5);
		$spec['campo_orden']               = "momento desc";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Registro de eventos";
		
		$spec['campos'][0]['etiqueta']     = 'Momento';
		$spec['campos'][0]['tipo']         = 'fecha';
		$spec['campos'][0]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][0]['formato_tiempo'] = '12';
		$spec['campos'][0]['mostrar_hora'] = true;
		$spec['campos'][0]['editable']     = false;
		$spec['campos'][0]['campo_nombre'] = 'momento';
		
		$spec['campos'][1]['etiqueta']      = 'Usuario';
		$spec['campos'][1]['tipo']          = 'consulta';
		$spec['campos'][1]['origen_tabla']  = 'core_usuario';
		$spec['campos'][1]['origen_codigo'] = 'id_usuario';
		$spec['campos'][1]['origen_valor']  = '_username';
		$spec['campos'][1]['campo_nombre']  = 'id_usuario';

		$spec['campos'][2]['etiqueta']     = 'M&oacute;dulo';
		$spec['campos'][2]['tipo']         = 'texto';
		$spec['campos'][2]['longitud']     = 64;
		$spec['campos'][2]['campo_nombre'] = 'modulo';

		$spec['campos'][3]['etiqueta']     = 'Controlador';
		$spec['campos'][3]['tipo']         = 'texto';
		$spec['campos'][3]['longitud']     = 64;
		$spec['campos'][3]['campo_nombre'] = 'controlador';

		$spec['campos'][4]['etiqueta']     = 'Acci&oacute;n';
		$spec['campos'][4]['tipo']         = 'texto';
		$spec['campos'][4]['longitud']     = 64;
		$spec['campos'][4]['campo_nombre'] = 'accion';

		$spec['campos'][5]['etiqueta']     = 'Tipo';
		$spec['campos'][5]['tipo']         = 'texto';
		$spec['campos'][5]['longitud']     = 32;
		$spec['campos'][5]['campo_nombre'] = 'tipo';

		$spec['campos'][6]['etiqueta']     = 'Informaci&oacute;n adicional';
		$spec['campos'][6]['tipo']         = 'texto';
		$spec['campos'][6]['longitud']     = 128;
		$spec['campos'][6]['largo']        = 64;
		$spec['campos'][6]['campo_nombre'] = 'informacion_adicional';
		
		$spec['campos'][7]['etiqueta']     = 'Direcci&oacute;n IP';
		$spec['campos'][7]['tipo']         = 'texto';
		$spec['campos'][7]['longitud']     = 15;
		$spec['campos'][7]['campo_nombre'] = 'ip';
		
		return $spec;
	}
}

?>