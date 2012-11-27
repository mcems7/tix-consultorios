<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Funcionario_model extends CI_Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::__construct();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarFuncionario($id_tercero)
	{
		$this -> db -> select('id_funcionario');
		$this -> db -> where('id_tercero',$id_tercero);
		$result = $this->db->get('core_funcionario');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_funcionario'];
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
	function listaDependencias()
	{
		$result = $this -> db ->get('core_dependencia');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearFuncionarioDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'id_dependencia' => $d['id_dependencia'],
		'cargo' => $d['cargo'], 	
		'estado' => $d['estado'], 	
		'fecha_inicio' => $d['fecha_inicio'], 
		'fecha_fin' => $d['fecha_fin'], 	
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' =>	$d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_funcionario',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$dat['id_funcionario'] = $this->db->insert_id();
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
		
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerFuncionarioConsulta($id_funcionario)
	{
		$this-> db -> select('core_dependencia.nombre_dependencia,
		  core_funcionario.id_funcionario,
		  core_funcionario.id_dependencia,
		  core_funcionario.cargo,
		  core_funcionario.estado,
		  core_funcionario.fecha_inicio,
		  core_funcionario.fecha_fin,
		  core_funcionario.observaciones,
		  core_funcionario.id_tercero');
		$this-> db -> from('core_funcionario');
		$this-> db->join('core_dependencia','core_funcionario.id_dependencia = core_dependencia.id_dependencia');
		$this-> db -> where('id_funcionario',$id_funcionario);
		$result = $this->db->get();
		return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function editarFuncionarioDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$update = array(
		'id_dependencia' => $d['id_dependencia'],
		'cargo' => $d['cargo'], 	
		'estado' => $d['estado'], 	
		'fecha_inicio' => $d['fecha_inicio'], 
		'fecha_fin' => $d['fecha_fin'], 	
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_funcionario',$d['id_funcionario']);
		$r = $this -> db -> update('core_funcionario',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaFuncionarios($number_items,$offset)
	{
		$this -> db -> select(' 
		  core_funcionario.id_funcionario,
		  core_funcionario.cargo,
		  core_funcionario.estado,
		  core_dependencia.nombre_dependencia,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento');
$this->db->from('core_funcionario');
$this->db->join('core_dependencia','core_funcionario.id_dependencia = core_dependencia.id_dependencia');
$this->db->join('core_tercero','core_funcionario.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->limit($number_items,$offset);
$result = $this->db->get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerNumListaFuncionarios()
	{
		return $this->db->count_all('core_funcionario');	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaFuncionariosCon($d,$number_items,$offset)
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
		
		if($d['id_dependencia'] != 0){
		$this-> db -> where('core_funcionario.id_dependencia',$d['id_dependencia']); }
		
		$this -> db -> select(' 
		  core_funcionario.id_funcionario,
		  core_funcionario.id_dependencia,
		  core_funcionario.cargo,
		  core_funcionario.estado,
		  core_dependencia.nombre_dependencia,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento');
$this->db->from('core_funcionario');
$this->db->join('core_dependencia','core_funcionario.id_dependencia = core_dependencia.id_dependencia');
$this->db->join('core_tercero','core_funcionario.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->limit($number_items,$offset);
$result = $this->db->get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaFuncionariosCon($d)
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
		
		if($d['id_dependencia'] != 0){
		$this-> db -> where('core_funcionario.id_dependencia',$d['id_dependencia']); }
		
		$this -> db -> select(' 
		  core_funcionario.id_funcionario,
		  core_funcionario.id_dependencia,
		  core_funcionario.cargo,
		  core_funcionario.estado,
		  core_dependencia.nombre_dependencia,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento');
$this->db->from('core_funcionario');
$this->db->join('core_dependencia','core_funcionario.id_dependencia = core_dependencia.id_dependencia');
$this->db->join('core_tercero','core_funcionario.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$result = $this->db->get();
$n = $result -> num_rows();
		return $n;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}
