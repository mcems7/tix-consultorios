<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_usuario extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_usuario";
		$spec['pk']                        = array(0);
		$spec['campo_orden']               = "_username";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Usuarios del sistema";
		
		$spec['campos'][0]['etiqueta']     = 'Identificador de usuario';
		$spec['campos'][0]['tipo']         = 'autonumerico';
		$spec['campos'][0]['editable']     = false;
		$spec['campos'][0]['campo_nombre'] = 'id_usuario';
		
		$spec['campos'][1]['etiqueta']     = 'Estado';
		$spec['campos'][1]['tipo']         = 'arreglo';
		$spec['campos'][1]['opciones']     = array('activo'   => 'Activo',
							   'inactivo' => 'Inactivo');
		$spec['campos'][1]['campo_nombre'] = 'estado';

		$spec['campos'][2]['etiqueta']     = 'Nombre de usuario';
		$spec['campos'][2]['tipo']         = 'texto';
		$spec['campos'][2]['longitud']     = 20;
		$spec['campos'][2]['campo_nombre'] = '_username';

		$spec['campos'][3]['etiqueta']     = 'Contrase&ntilde;a';
		$spec['campos'][3]['tipo']         = 'texto';
		$spec['campos'][3]['longitud']     = 20;
		$spec['campos'][3]['funcion']      = 'md5';
		$spec['campos'][3]['campo_nombre'] = '_password';
		
		$spec['campos'][4]['etiqueta']     = 'Documento del tercero';
		$spec['campos'][4]['tipo']         = 'texto';
		$spec['campos'][4]['longitud']     = 20;
		$spec['campos'][4]['campo_nombre'] = 'numero_documento';

		$spec['campos'][5]['etiqueta']     = 'Fecha de creaci&oacute;n';
		$spec['campos'][5]['tipo']         = 'fecha';
		$spec['campos'][5]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][5]['formato_tiempo'] = '12';
		$spec['campos'][5]['mostrar_hora'] = true;
		$spec['campos'][5]['editable']     = false;
		$spec['campos'][5]['campo_nombre'] = 'fecha_creacion';
		
		$spec['campos'][6]['etiqueta']     = 'Fecha de actualizaci&oacute;n';
		$spec['campos'][6]['tipo']         = 'fecha';
		$spec['campos'][6]['formato']      = '%d/%m/%Y %H:%M:%S';
		$spec['campos'][6]['formato_tiempo'] = '12';
		$spec['campos'][6]['mostrar_hora'] = true;
		$spec['campos'][6]['editable']     = false;
		$spec['campos'][6]['campo_nombre'] = 'fecha_actualizacion';
		
		return $spec;
	}
}

?>
