<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Medico_model extends CI_Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::__construct();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarMedico($id_tercero)
	{
		$this -> db -> select('id_medico');
		$this -> db -> where('id_tercero',$id_tercero);
		$result = $this->db->get('core_medico');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_medico'];
	}
	
	function verificarDisponibilidad($username)
	{
		$this -> db -> where('_username',$username);
		$result = $this->db->get('core_usuario');
		$num = $result -> num_rows();
		if($num == 0){
		return true;
		}else{
		return false;	
			}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTercero($id_tercero)
	{
		 $this-> db -> select('core_tipo_documentos.tipo_documento,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.id_tercero,
  core_tercero.primer_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.segundo_nombre,
  core_tercero.id_tipo_documento,
  core_tercero.numero_documento,
  core_tercero.pais,
  core_tercero.departamento,
  core_tercero.municipio,
  core_municipio.nombre,
  core_departamento.nombre AS depa,
  core_pais.PAI_NOMBRE,
  core_tercero.vereda,
  core_tercero.zona,
  core_tercero.direccion,
  core_tercero.telefono,
  core_tercero.celular,
  core_tercero.fax,
  core_tercero.email,
  core_tercero.observaciones');
		$this-> db -> from('core_tipo_documentos');
		$this-> db->join('core_tercero','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
		$this-> db->join('core_municipio','core_tercero.municipio = core_municipio.id_municipio','left');
		$this-> db->join('core_departamento','core_municipio.id_departamento = core_departamento.id_departamento','left');
		$this-> db->join('core_pais ','core_departamento.PAI_PK = core_pais.PAI_PK','left');
		$this-> db -> where('id_tercero',$id_tercero);
		$result = $this->db->get();
		return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function tipos_especialidades()
	{
		$result = $this -> db ->get('core_especialidad');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function tipos_medico()
	{
		$result = $this -> db ->get('core_tipo_medico');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearMedicoDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'id_especialidad' => $d['id_especialidad'],
		'tarjeta_profesional' => $d['tarjeta_profesional'], 	
		'estado' => $d['estado'], 	
		'fecha_inicio' => $d['fecha_inicio'], 
		'fecha_fin' => $d['fecha_fin'], 	
		'id_tipo_medico' => $d['id_tipo_medico'],
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' =>	$d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_medico',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$dat['id_medico'] = $this->db->insert_id();
		//----------------------------------------------------
		
		$insert = array(
		'estado' => 'activo',
		'_username' => $d['_username'],
		'_password' => md5($d['_password']),
		'numero_documento' => $d['numero_documento'],
		'fecha_creacion' => date('Y-m-d H:i:s'),
		'fecha_actualizacion' => date('Y-m-d H:i:s')
		);
		$this -> db -> insert('core_usuario',$insert);
		$id_usuario = $this->db->insert_id();
		
		switch ($d['id_tipo_medico']) {
			case 1;
			$grupo = 2;
			break;
			
			case 2;
			$grupo = 5;
			break;
			
			case 3;
			$grupo = 9;
			break;
			
			case 4;
			$grupo = 6;
			break;
			
			case 5;
			$grupo = 10;
			break;
		}
		
		$insertG = array(
			'id_usuario' 	=> $id_usuario,
			'id_grupo'		=> $grupo,
			'fecha_creacion'=> date('Y-m-d H:i:s')
		);
		$this->db->insert('core_usuario_grupo',$insertG);
		
		
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMedicoConsulta($id_medico)
	{
		$this-> db -> select('core_especialidad.descripcion As esp,
		  core_tipo_medico.descripcion As tipo,
		  core_medico.id_medico,
		  core_medico.id_especialidad,
		  core_medico.tarjeta_profesional,
		  core_medico.estado,
		  core_medico.fecha_inicio,
		  core_medico.fecha_fin,
		  core_medico.id_tipo_medico,
		  core_medico.observaciones,
		  core_medico.id_tercero');
		$this-> db -> from('core_medico');
		$this-> db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
		$this-> db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
		$this-> db -> where('id_medico',$id_medico);
		$result = $this->db->get();
		return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function editarMedicoDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$update = array(
		'id_especialidad' => $d['id_especialidad'],
		'tarjeta_profesional' => $d['tarjeta_profesional'], 	
		'estado' => $d['estado'], 	
		'fecha_inicio' => $d['fecha_inicio'], 
		'fecha_fin' => $d['fecha_fin'], 	
		'id_tipo_medico' => $d['id_tipo_medico'],
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_medico',$d['id_medico']);
		$r = $this -> db -> update('core_medico',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaMedicos($number_items,$offset)
	{
		$this -> db -> select(' 
		  core_medico.id_medico,
		  core_medico.tarjeta_profesional,
		  core_medico.estado,
		  core_especialidad.descripcion As especialidad,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento,
		  core_tipo_medico.id_tipo_medico,
		  core_tipo_medico.descripcion As tipo_medico');
$this->db->from('core_medico');
$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
$this->db->limit($number_items,$offset);
$result = $this->db->get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerNumListaMedicos()
	{
		return $this->db->count_all('core_medico');	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaMedicosCon($d,$number_items,$offset)
	{
		if(strlen($d['primer_apellido']) > 0){
		$this-> db -> like('primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 0){
		$this-> db -> like('primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 0){
		$this-> db -> like('segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 0){
		$this-> db -> like('segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> like('numero_documento',$d['numero_documento']); }
		
		if($d['id_especialidad'] != 0){
		$this-> db -> where('core_medico.id_especialidad',$d['id_especialidad']); }
		
		if($d['id_tipo_medico'] != 0){
		$this-> db -> where('core_medico.id_tipo_medico',$d['id_tipo_medico']); }
		
		$this -> db -> select(' 
		  core_medico.id_medico,
		  core_medico.id_especialidad,
		  core_medico.tarjeta_profesional,
		  core_medico.estado,
		  core_medico.id_tipo_medico,
		  core_especialidad.descripcion As especialidad,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento,
		  core_tipo_medico.descripcion As tipo_medico');
$this->db->from('core_medico');
$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
$this->db->limit($number_items,$offset);
$result = $this->db->get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaMedicosCon($d)
	{
		if(strlen($d['primer_apellido']) > 0){
		$this-> db -> like('primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 0){
		$this-> db -> like('primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 0){
		$this-> db -> like('segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 0){
		$this-> db -> like('segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> like('numero_documento',$d['numero_documento']); }
		
		if($d['id_especialidad'] != 0){
		$this-> db -> where('core_medico.id_especialidad',$d['id_especialidad']); }
		
		if($d['id_tipo_medico'] != 0){
		$this-> db -> where('core_medico.id_tipo_medico',$d['id_tipo_medico']); }
		
		$this -> db -> select(' 
		  core_medico.id_medico,
		  core_medico.id_especialidad,
		  core_medico.tarjeta_profesional,
		  core_medico.estado,
		  core_medico.id_tipo_medico,
		  core_especialidad.descripcion As especialidad,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento,
		  core_tipo_medico.descripcion As tipo_medico');
$this->db->from('core_medico');
$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
$result = $this->db->get();
$n = $result -> num_rows();
		return $n;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}
