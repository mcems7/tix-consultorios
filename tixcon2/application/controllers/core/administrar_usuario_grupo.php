<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_usuario_grupo extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_usuario_grupo";
		$spec['pk']                        = array(0, 1);
		$spec['campo_orden']               = "id_usuario, id_grupo";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Pertenencia de usuario en grupos";
		
		$spec['campos'][0]['etiqueta']      = 'Usuario';
		$spec['campos'][0]['tipo']          = 'consulta';
		$spec['campos'][0]['origen_tabla']  = 'core_usuario';
		$spec['campos'][0]['origen_codigo'] = 'id_usuario';
		$spec['campos'][0]['origen_valor']  = '_username';
		$spec['campos'][0]['campo_nombre']  = 'id_usuario';		

		$spec['campos'][1]['etiqueta']      = 'Grupo';
		$spec['campos'][1]['tipo']          = 'consulta';
		$spec['campos'][1]['origen_tabla']  = 'core_grupo';
		$spec['campos'][1]['origen_codigo'] = 'id_grupo';
		$spec['campos'][1]['origen_valor']  = 'nombre';
		$spec['campos'][1]['campo_nombre']  = 'id_grupo';		

		$spec['campos'][2]['etiqueta']     = 'Fecha de creaci&oacute;n';
		$spec['campos'][2]['tipo']         = 'fecha';
		$spec['campos'][2]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][2]['formato_tiempo'] = '12';
		$spec['campos'][2]['mostrar_hora'] = true;
		$spec['campos'][2]['editable']     = false;
		$spec['campos'][2]['campo_nombre'] = 'fecha_creacion';

		return $spec;
	}
}

?>