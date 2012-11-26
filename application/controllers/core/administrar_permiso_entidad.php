<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Administrar_permiso_entidad extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this -> load -> model('core/modulo');
		$this -> load -> model('core/permiso');
		$this -> load -> model('core/grupo');
		$this -> load -> model('core/usuario');
		$this -> load -> model('core/permisoentidad');
		$this -> load -> helper('form');
	}
	
	public function index()
	{
		$datos = array();
		
		$datos['permisos'] = $this -> permiso -> obtenerTodos();
		
		$dat['titulo'] = "Administrar permisos entidad";
		$this->load->view('core/core_inicio',$dat);
		$this -> load -> view("core/administrar_permiso_entidad", $datos);
		$this->load->view('core/core_fin');
	}
	
	public function listar_entidades()
	{
		$entidades = array();

		if($this -> input -> post('tipo') == 'usuario')
			$entidades = $this -> usuario -> obtenerTodos();
		else
			$entidades = $this -> grupo -> obtenerTodos();;

		echo "<select id='id_entidad' name='id_entidad'>";

		echo "<option value=''>-- " . utf8_encode('Seleccione una opci&oacute;n') . " --</option>\n";

		foreach($entidades as $e)
		{
			$code  = '';
			$value = '';
			
			if($this -> input -> post('tipo') == 'usuario')
			{
				$code  = utf8_encode($e['id_usuario']);
				$value = utf8_encode($e['_username']);
			}
			
			if($this -> input -> post('tipo') == 'grupo')
			{
				$code  = utf8_encode($e['id_grupo']);
				$value = utf8_encode($e['nombre'] . ' - ' . $e['descripcion']);
				
				$value = (strlen($value) > 70) ? substr($value, 0, 70) . "..." : $value;
			}
			
			echo "<option value='{$code}'>{$value}</option>\n";
		}
		
		echo "</select>";
	}
	
	public function listar_permisos()
	{
		$request = file_get_contents('php://input');
		$data = str_replace('json=', '', urldecode($request));
		 
		$json = json_decode($data);

		///////////////////////////////////////////////////////////

		$entidad = $json -> id_entidad;
		$tipo    = null;
		
		if($json -> tipo_usuario)
			$tipo = 'usuario';
		else
			if($json -> tipo_grupo)
				$tipo = 'grupo';
			else
				$tipo = 'desconocido';
		
		///////////////////////////////////////////////////////////

		$ps = array();
		
		if($tipo == 'usuario')
			$ps = $this -> permisoentidad -> obtenerPermisosDeUsuario($entidad);
		if($tipo == 'grupo')
			$ps = $this -> permisoentidad -> obtenerPermisosDeGrupo($entidad);

		///////////////////////////////////////////////////////////

		$permisos = array();
		
		foreach($ps as $p)
		{
			$permisos[] = $p['id_permiso'];
		}
		
		// header('Content-type: application/json');
		//print_r($permisos);
		$json = json_encode($permisos);
		echo $json;
	}
	
	function actualizar_permisos()
	{
		$tipo     = $this -> input -> post('tipo');
		$entidad  = $this -> input -> post('id_entidad');
		$permisos = array_keys($this -> input -> post('permisos'));
		
		print_r($permisos);
		
		// Remover todos los permisos de la entidad
		
		$this -> permisoentidad -> removerTodosPermisos($entidad, $tipo);
		
		// Agregar los nuevos permisos elegidos
		
		foreach($permisos as $permiso)
		{
			$this -> permisoentidad -> agregarPermisoEntidad($entidad, $tipo, $permiso);
		}
	}
}

?>
