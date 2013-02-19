<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Tercero_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaTer()
	{
		return $this->db->count_all('core_tercero');	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaTer($number_items,$offset)
	{
		$this-> db -> from('core_tercero');
		$this-> db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
		$this->db->limit($number_items,$offset);
		$result = $this->db->get();
		return $result -> result_array();   	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerNumListaTerCon($d)
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
		
		if(strlen($d['razon_social']) > 0){
		$this-> db -> like('razon_social',$d['razon_social']); }
		
		$this-> db -> from('core_tercero');
		$this-> db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
		$result = $this->db->get();
		return $result -> num_rows();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerListaTerCon($d,$number_items,$offset)
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
		
		if(strlen($d['razon_social']) > 0){
		$this-> db -> like('razon_social',$d['razon_social']); }
		
		$this-> db -> from('core_tercero');
		$this-> db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
		$this->db->limit($number_items,$offset);
		$result = $this->db->get();
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificaTercero($numero_documento)
	{
		$this -> db -> select('id_tercero');
		$this -> db -> where('numero_documento',$numero_documento);
		$result = $this->db->get('core_tercero');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_tercero'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function tipos_documento()
	{
		$result = $this -> db ->get('core_tipo_documentos');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerPais()
	{
		$result = $this -> db ->get('core_pais');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDepartamento()
	{
		$this -> db -> order_by('nombre');
		$result = $this -> db ->get('core_departamento');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMunicipio($id_departamento)
	{
		$this -> db -> where('id_departamento',$id_departamento);
		$result = $this -> db ->get('core_municipio');
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearTerceroDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'primer_apellido' => $d['primer_apellido'],
		'segundo_apellido' => $d['segundo_apellido'], 	
		'primer_nombre' => $d['primer_nombre'], 	
		'segundo_nombre' => $d['segundo_nombre'], 	
		'razon_social' => $d['razon_social'], 
		'fecha_nacimiento' => $d['fecha_nacimiento'], 		
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'], 	
		'pais' => $d['pais'], 	
		'departamento' => $d['departamento'], 	
		'municipio' => $d['municipio'], 	
		'vereda' => $d['vereda'],
		'zona' => $d['zona'],	
		'direccion' => $d['direccion'], 	
		'telefono' => $d['telefono'], 	
		'celular' => $d['celular'], 
		'fax' => $d['fax'], 	
		'email' => $d['email'], 	
		'observaciones' => $d['observaciones'], 
		'fecha_creacion' => date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_tercero',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$dat['id_tercero'] = $this->db->insert_id();
		//----------------------------------------------------
		$insert = array(
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'], 	
		'pais' => $d['pais'], 	
		'departamento' => $d['departamento'], 	
		'municipio' => $d['municipio'], 	
		'vereda' => $d['vereda'],
		'zona' => $d['zona'],	
		'direccion' => $d['direccion'], 	
		'telefono' => $d['telefono'], 	
		'celular' => $d['celular'], 	
		'observaciones' => $d['observaciones'], 
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' => $dat['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_tercero_detalle',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTercero($id_tercero)
	{
		$this -> db -> where('id_tercero',$id_tercero);
		$result = $this -> db ->get('core_tercero');
		return $result -> row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function editarTerceroDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$update = array(
		'primer_apellido' => $d['primer_apellido'],
		'segundo_apellido' => $d['segundo_apellido'], 	
		'primer_nombre' => $d['primer_nombre'], 	
		'segundo_nombre' => $d['segundo_nombre'], 	
		'razon_social' => $d['razon_social'], 
		'fecha_nacimiento' => $d['fecha_nacimiento'], 		
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'], 	
		'pais' => $d['pais'], 	
		'departamento' => $d['departamento'], 	
		'municipio' => $d['municipio'], 	
		'vereda' => $d['vereda'],
		'zona' => $d['zona'],		
		'direccion' => $d['direccion'], 	
		'telefono' => $d['telefono'], 	
		'celular' => $d['celular'], 
		'fax' => $d['fax'], 	
		'email' => $d['email'], 	
		'observaciones' => $d['observaciones'], 
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_tercero',$d['id_tercero']);
		$r = $this -> db -> update('core_tercero',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$insert = array(
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'], 	
		'pais' => $d['pais'], 	
		'departamento' => $d['departamento'], 	
		'municipio' => $d['municipio'], 	
		'vereda' => $d['vereda'],
		'zona' => $d['zona'],	
		'direccion' => $d['direccion'], 	
		'telefono' => $d['telefono'], 	
		'celular' => $d['celular'], 	
		'observaciones' => $d['observaciones'], 
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' => $d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_tercero_detalle',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerNumeroConsulta($d)
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
		$this-> db -> from('core_tipo_documentos');
		$this-> db -> limit(30);
		$this-> db->join('core_tercero', 'core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
		
		$result = $this->db->get();
		
		$n = $result -> num_rows();
		return $n;   
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerListaTercerosBusca($d,$ini,$numero)
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
		$this-> db -> from('core_tipo_documentos');
		$this-> db->join('core_tercero', 'core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
		$this-> db-> order_by("primer_apellido", "asc");
		$this-> db-> order_by("segundo_apellido", "asc"); 
		$this-> db->limit($numero,$ini);
		$result = $this->db->get();
		return $result -> result_array();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
}