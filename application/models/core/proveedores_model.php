<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Proveedores_model extends CI_Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::__construct();	
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarProveedor($id_tercero)
	{
		$this -> db -> select('id_proveedor');
		$this -> db -> where('id_tercero',$id_tercero);
		$result = $this->db->get('core_proveedores');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_proveedor'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaProveedores()
	{
		return $this->db->count_all('core_proveedores');		
	}
	
	function obtenerListaProveedores($number_items,$offset)
	{
$this->db->select(' 
  core_tercero.razon_social,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_proveedores.estado,
  core_proveedores.id_proveedor,
  core_proveedores.id_tercero');
$this->db->from('core_proveedores');
$this->db->join('core_tercero','core_proveedores.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');	$this->db->limit($number_items,$offset);
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaProveedoresCon($d)
	{
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('numero_documento',$d['numero_documento']); }
		
		if(strlen($d['razon_social']) > 0){
		$this-> db -> like('razon_social',$d['razon_social']); }
		
		$this->db->select(' 
  core_tercero.razon_social,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_proveedores.estado,
  core_proveedores.id_proveedor,
  core_proveedores.id_tercero');
$this->db->from('core_proveedores');
$this->db->join('core_tercero','core_proveedores.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$result = $this->db->get();
$n = $result -> num_rows();
		return $n;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaProveedoresCon($d,$number_items,$offset)
	{
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('numero_documento',$d['numero_documento']); }
		
		if(strlen($d['razon_social']) > 0){
		$this-> db -> like('razon_social',$d['razon_social']); }
		
		$this->db->select(' 
  core_tercero.razon_social,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_proveedores.estado,
  core_proveedores.id_proveedor,
  core_proveedores.id_tercero');
$this->db->from('core_proveedores');
$this->db->join('core_tercero','core_proveedores.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');	
$this->db->limit($number_items,$offset);
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearProveedorDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'representante_legal' => $d['representante_legal'], 
		'nombre_contacto' => $d['nombre_contacto'],
		'estado' => $d['estado'], 	
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' =>	$d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_proveedores',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$dat['id_proveedor'] = $this->db->insert_id();
		//----------------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerProveedorConsulta($id_proveedor)
	{
		$this-> db -> where('id_proveedor',$id_proveedor);
		$result = $this->db->get('core_proveedores');
		return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function editarProveedorDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$update = array(
		'representante_legal' => $d['representante_legal'], 
		'nombre_contacto' => $d['nombre_contacto'],
		'estado' => $d['estado'], 	
		'observaciones' =>	$d['observaciones'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_proveedor',$d['id_proveedor']);
		$r = $this -> db -> update('core_proveedores',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}