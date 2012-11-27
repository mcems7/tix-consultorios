<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class PermisoEntidad extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();

		$this -> load -> model('core/permiso');
		$this -> load -> model('core/usuariogrupo');
		$this -> load -> model('core/tiempo');
	}
	
	public function obtenerPermisosDeUsuario($id_usuario)
	{
		$this->db->where('id_entidad', $id_usuario);
		$this->db->where('tipo_entidad', 'usuario');
		$result = $this->db->get('core_permiso_entidad');
		
		return $result -> result_array();
	}

	public function validarPermisoDeUsuario($id_usuario, $id_permiso)
	{
		$this->db->where('id_entidad', $id_usuario);
		$this->db->where('tipo_entidad', 'usuario');
		$this->db->where('id_permiso', $id_permiso);
		$result = $this->db->get('core_permiso_entidad');

		if ($result == null || $result -> num_rows() == 0)
			return null;
			
		$permiso = $result -> row_array();
		
		if ($permiso['tipo_permiso'] == 'permitir')
			return true;
		
		return false;
	}

	public function obtenerPermisosDeGrupo($id_grupo)
	{
		$this->db->where('id_entidad', $id_grupo);
		$this->db->where('tipo_entidad', 'grupo');
		$result = $this->db->get('core_permiso_entidad');
		
		return $result -> result_array();
	}

	public function validarPermisoDeGrupo($id_grupo, $id_permiso)
	{
		$this->db->where('id_entidad', $id_grupo);
		$this->db->where('tipo_entidad', 'grupo');
		$this->db->where('id_permiso', $id_permiso);
		$result = $this->db->get('core_permiso_entidad');

		if ($result == null || $result -> num_rows() == 0)
			return null;
			
		$permiso = $result -> row_array();
		
		if ($permiso['tipo_permiso'] == 'permitir')
			return true;
		
		return false;
	}

	public function validarPermisoConsolidadoDeUsuario($id_usuario, $id_permiso)
	{
		// Verificar permisos asignados directamente al usuario,
		// predominan sobre los permisos asignados al grupo
		
		$permiso_usuario = $this -> validarPermisoDeUsuario($id_usuario, $id_permiso);
		
		if($permiso_usuario === true)			// Existe el permiso de usuario permitiendo
			return true;
			
		if ($permiso_usuario === false)			// Existe el permiso de usuario negando
			return false;

		// No existe un permiso de usuario explícito
		
	 	// Verificar permisos asignados a los grupos a los cuales
		// pertenece el usuario.  Si sucede un conflicto de permisos 
		// entre grupos, predomina el permiso de negación

		$grupos_con_permiso = 0;
		
		$grupos_usuario = $this -> usuariogrupo -> obtenerGruposDeUsuario($id_usuario);

		foreach($grupos_usuario as $grupo)
		{
			$revision_permiso_grupo = $this -> validarPermisoDeGrupo($grupo['id_grupo'], $id_permiso);
			
			if($revision_permiso_grupo != null)
			{
				$grupos_con_permiso ++;

				if($revision_permiso_grupo === true){
					return true;
				}else{ return false;}
			}
		}
		
		if ($grupos_con_permiso > 0)
			return false;
		
		return null;				// No existe permiso de usuario ni de grupo
	}

	public function validarPermisodeUsuarioSegunSeccion($id_usuario, $modulo, $controlador, $accion)
	{		
		// Determinar las opciones de verificaci�n en orden de prioridad.
		//
		//		1. Acceso genérico a todo el módulo: todos los controladores con todas sus acciones.
		//		2. Acceso genérico a las acciones de un módulo/controlador específico.
		//		3. Acceso específico al módulo/controlador/acción.
	
		$opciones = array(
						array('modulo' => $modulo, 'controlador' => '*',          'accion' => '*'),
						array('modulo' => $modulo, 'controlador' => $controlador, 'accion' => '*'),
						array('modulo' => $modulo, 'controlador' => $controlador, 'accion' => $accion)
					);

		$cantidad_permisos_encontrados = 0;

		foreach ($opciones as $seccion)
		{
			$permiso = $this -> permiso -> obtenerSegunSeccion($seccion['modulo'], 
	                                                           $seccion['controlador'], 
															   $seccion['accion']);

			// Si el permiso existe, verificar si lo tiene el usuario a validarse (en permitir).

			if ($permiso != null)
			{
				$cantidad_permisos_encontrados ++;
		
				$id_permiso = $permiso['id_permiso'];
				
				// Si el usuario tiene el permiso a verificarse se informa retornando 'true'.
				// En caso contrario se debe seguir verificando con la siguiente opci�n.
				
				$ctrl = $this -> validarPermisoConsolidadoDeUsuario($id_usuario, $id_permiso);

				if ($ctrl)
					return true;
			}
		}

		// Si se encontraron permisos sobre el recurso y no se tuvo éxito con ninguna de las 
		// opciones el usuario no tiene el permiso a validarse y se retorna 'false'.

		if($cantidad_permisos_encontrados > 0)
			return false;	
			
		return null;
	}
	
	function removerTodosPermisos($entidad, $tipo_entidad)
	{
		if($tipo_entidad != 'usuario' && $tipo_entidad != 'grupo')
			return null;
			
		$this->db->where('id_entidad', $entidad);
		$this->db->where('tipo_entidad', $tipo_entidad);
		
		return $this->db->delete('core_permiso_entidad'); 
	}
	
	function agregarPermisoEntidad($entidad, $tipo_entidad, $permiso)
	{
		$this->db->set('id_entidad',            $entidad);
		$this->db->set('tipo_entidad',          $tipo_entidad);
		$this->db->set('id_permiso',            $permiso);
		$this->db->set('tipo_permiso',          'permitir');
		$this->db->set('informacion_adicional', null);
		$this->db->set('fecha_creacion',        $this -> tiempo -> obtenerDateTimeActual());
		$this->db->set('fecha_actualizacion',   $this -> tiempo -> obtenerDateTimeActual());

		return $this->db->insert('core_permiso_entidad'); 
	}
	
	function permisosDenegadosGrupo($id_grupo,$modulo,$controlador,$accion)
	{
		$this->db->SELECT(' 
  core_permiso_entidad.id_entidad,
  core_permiso_entidad.tipo_permiso,
  core_permiso_entidad.tipo_entidad,
  core_permiso.modulo,
  core_permiso.controlador,
  core_permiso.accion,
  core_permiso.descripcion,
  core_permiso_entidad.tipo_permiso');
$this->db->FROM('core_permiso');
$this->db->JOIN('core_permiso_entidad','core_permiso.id_permiso = core_permiso_entidad.id_permiso');
$this->db->WHERE('core_permiso_entidad.id_entidad',$id_grupo); 
$this->db->WHERE('core_permiso.modulo',$modulo);
$this->db->WHERE('core_permiso.controlador',$controlador);
$this->db->WHERE('core_permiso.accion',$accion);
$this->db->WHERE('core_permiso_entidad.tipo_permiso','denegar');
$result = $this->db->get();
return $result->num_rows();

	}
	
	function gruposPermisoDenegado($id_usuario,$modulo,$controlador,$accion)
	{
		$grupos_usuario = $this -> usuariogrupo -> obtenerGruposDeUsuario($id_usuario);
		
		foreach($grupos_usuario as $d)
		{
			$res = $this -> permisosDenegadosGrupo($d['id_grupo'],$modulo,$controlador,$accion);
		}
		return $res;
	}
}

?>
