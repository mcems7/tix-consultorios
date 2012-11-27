<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Paciente_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerNumListaPac()
	{
		return $this->db->count_all('core_paciente');	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaPac($number_items,$offset)
	{
		$this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_paciente.id_paciente,
  core_tercero1.razon_social,
  core_cobertura_salud.cobertura');
$this-> db -> from('core_paciente');
$this-> db -> join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this-> db -> join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this-> db -> join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
$this-> db -> join('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
$this-> db -> join('core_cobertura_salud','core_paciente.id_cobertura = core_cobertura_salud.id_cobertura','left');
		$this->db->limit($number_items,$offset);
		$result = $this->db->get();
		return $result -> result_array();   	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaPacCon($d)
	{
		if(strlen($d['primer_apellido']) > 0){
		$this-> db -> like('core_tercero.primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 0){
		$this-> db -> like('core_tercero.primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 0){
		$this-> db -> like('core_tercero.segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 0){
		$this-> db -> like('core_tercero.segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('core_tercero.numero_documento',$d['numero_documento']); }
		
		if($d['id_cobertura'] > 0){
		$this-> db -> where('core_paciente.id_cobertura',$d['id_cobertura']); }
		
		$this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_paciente.id_paciente,
  core_paciente.id_cobertura,
  core_tercero1.razon_social,
  core_cobertura_salud.cobertura');
$this-> db -> from('core_paciente');
$this-> db -> join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this-> db -> join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento','left');
$this-> db -> join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad','left');
$this-> db -> join('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero','left');
$this-> db -> join('core_cobertura_salud','core_paciente.id_cobertura = core_cobertura_salud.id_cobertura','left');
		$result = $this->db->get();
		return $result -> num_rows();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaPacCon($d,$number_items,$offset)
	{
		if(strlen($d['primer_apellido']) > 0){
		$this-> db -> like('core_tercero.primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 0){
		$this-> db -> like('core_tercero.primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 0){
		$this-> db -> like('core_tercero.segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 0){
		$this-> db -> like('core_tercero.segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('core_tercero.numero_documento',$d['numero_documento']); }
		
		if($d['id_cobertura'] > 0){
		$this-> db -> where('core_paciente.id_cobertura',$d['id_cobertura']); }
		
		$this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_paciente.id_paciente,
  core_tercero1.razon_social,
  core_paciente.id_cobertura,
  core_cobertura_salud.cobertura');
$this-> db -> from('core_paciente');
$this-> db -> join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this-> db -> join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento','left');
$this-> db -> join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad','left');
$this-> db -> join('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero','left');
$this-> db -> join('core_cobertura_salud','core_paciente.id_cobertura = core_cobertura_salud.id_cobertura','left');
		$this->db->limit($number_items,$offset);
		$this-> db-> order_by("primer_apellido", "asc");
		$this-> db-> order_by("segundo_apellido", "asc");
		$result = $this->db->get();
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarPaciente($id_tercero)
	{
		$this -> db -> select('id_paciente');
		$this -> db -> where('id_tercero',$id_tercero);
		$result = $this->db->get('core_paciente');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_paciente'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function tipos_usuario()
	{
		$result = $this -> db ->get('core_cobertura_salud');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEntidades()
	{
		$this -> db -> select('core_eapb.id_entidad,core_tercero.razon_social');
		$this -> db -> from('core_eapb');
		$this -> db -> join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
		$this -> db -> order_by('razon_social','ASC');
		$result = $this -> db -> get();
		return $result -> result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTercero($id_tercero)
	{
	$this-> db -> select('core_tipo_documentos.tipo_documento,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.id_tercero,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
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
	$this-> db->join('core_tercero','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento','left');
	$this-> db->join('core_municipio','core_tercero.municipio = core_municipio.id_municipio','left');
	$this-> db->join('core_departamento','core_municipio.id_departamento = core_departamento.id_departamento','left');
	$this-> db->join('core_pais ','core_departamento.PAI_PK = core_pais.PAI_PK','left');
	$this-> db -> where('id_tercero',$id_tercero);
	$result = $this->db->get();
	return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerPacienteConsulta($id_paciente)
	{
		$this-> db -> select('core_cobertura_salud.cobertura,
  core_tercero.razon_social,
  core_paciente.genero,
  core_paciente.id_paciente,
  core_paciente.estado_civil,
  core_paciente.id_entidad,
  core_paciente.tipo_afiliado,
  core_paciente.nivel_categoria,
  core_paciente.desplazado,
  core_paciente.observaciones,
   core_paciente.id_cobertura,
  core_paciente.id_tercero');
		$this-> db -> from('core_paciente');
$this-> db -> join('core_cobertura_salud','core_paciente.id_cobertura = core_cobertura_salud.id_cobertura','left');
$this-> db -> join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad','left');
$this-> db -> join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero','left');
		$this-> db -> where('id_paciente',$id_paciente);
		$result = $this->db->get();
		return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearPacienteDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'genero' => $d['genero'],
		'estado_civil' => $d['estado_civil'], 	
		'id_entidad' => $d['id_entidad'], 
		'id_cobertura' => $d['id_cobertura'], 	
		'tipo_afiliado' => $d['tipo_afiliado'],
		'nivel_categoria' => $d['nivel_categoria'],
		'desplazado' =>	$d['desplazado'],
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' =>	$d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_paciente',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$dat['id_paciente'] = $this->db->insert_id();
		//----------------------------------------------------
		$insert = array(	
		'id_entidad' => $d['id_entidad'], 
		'id_cobertura' => $d['id_cobertura'], 	
		'tipo_afiliado' => $d['tipo_afiliado'],
		'nivel_categoria' => $d['nivel_categoria'],
		'desplazado' =>	$d['desplazado'],
		'observaciones' =>	$d['observaciones'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_paciente' =>	$dat['id_paciente'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_paciente_detalle',$insert);
			if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerPaciente($id_tercero)
	{
		$this->db->where('id_tercero',$id_tercero);
		$result = $this->db->get('core_paciente');
		return $result -> row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function editarPacienteDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$update = array(
		'genero' => $d['genero'], 	
		'estado_civil' => $d['estado_civil'], 	
		'id_entidad' => $d['id_entidad'], 
		'id_cobertura' => $d['id_cobertura'], 	
		'tipo_afiliado' => $d['tipo_afiliado'],
		'nivel_categoria' => $d['nivel_categoria'],
		'desplazado' =>	$d['desplazado'],
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_paciente',$d['id_paciente']);
		$r = $this -> db -> update('core_paciente',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$insert = array( 		
		'id_entidad' => $d['id_entidad'], 
		'id_cobertura' => $d['id_cobertura'], 	
		'tipo_afiliado' => $d['tipo_afiliado'],
		'nivel_categoria' => $d['nivel_categoria'],
		'desplazado' =>	$d['desplazado'],
		'observaciones' =>	$d['observaciones'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_paciente' =>	$d['id_paciente'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_paciente_detalle',$insert);
			if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function comprobarTercero($d)
	{
		if(strlen($d['primer_apellido']) > 2){
		$this-> db -> like('primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 2){
		$this-> db -> like('primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 2){
		$this-> db -> like('segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 2){
		$this-> db -> like('segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['fecha_nacimiento']) > 2){
		$this-> db -> like('fecha_nacimiento',$d['fecha_nacimiento']); }
		
		$this-> db-> order_by("primer_apellido", "asc");
		$this-> db-> order_by("segundo_apellido", "asc");
		
		$this-> db -> from('core_tipo_documentos');
		$this-> db->join('core_tercero', 'core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
		$result = $this -> db -> get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		return $result -> result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}
