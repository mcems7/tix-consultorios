<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
///////////////////////////////////////////////////////////////////////////////////////////////
include_once(getcwd()."/application/controllers/core/administrar_entidad_generica.php");
///////////////////////////////////////////////////////////////////////////////////////////////

class Administrar_usuario_empresa extends Administrar_entidad_generica
{
	function __construct()
	{
		parent::__construct();
	}
	
	protected function _obtenerEspecificacion()
	{
		$spec = array();
			
		$spec['tabla']                     = "core_usuario_empresa";
		$spec['pk']                        = array(0, 1);
		$spec['campo_orden']               = "id_usuario, id_empresa";
		$spec['regresar_a']                = site_url("core/home/index");
		$spec['descripcion']               = "Pertenencia de usuario a empresas";
		
		$spec['campos'][0]['etiqueta']      = 'Usuario';
		$spec['campos'][0]['tipo']          = 'consulta';
		$spec['campos'][0]['origen_tabla']  = 'usuarios';
		$spec['campos'][0]['origen_codigo'] = 'id_usuario';
		$spec['campos'][0]['origen_valor']  = 'user';
		$spec['campos'][0]['campo_nombre']  = 'id_usuario';		

		$spec['campos'][1]['etiqueta']      = 'Empresa';
		$spec['campos'][1]['tipo']          = 'consulta';
		$spec['campos'][1]['origen_tabla']  = 'com_empresas';
		$spec['campos'][1]['origen_codigo'] = 'id_empresa';
		$spec['campos'][1]['origen_valor']  = 'nombre';
		$spec['campos'][1]['campo_nombre']  = 'id_empresa';		


		return $spec;
	}
}

?>