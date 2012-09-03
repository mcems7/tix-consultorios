<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Entidades_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();	
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarEapb($id_tercero)
	{
		$this -> db -> select('id_entidad');
		$this -> db -> where('id_tercero',$id_tercero);
		$result = $this->db->get('core_eapb');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_entidad'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaEapb()
	{
		return $this->db->count_all('core_eapb');		
	}
	
	function obtenerListaEapb($number_items,$offset)
	{
$this->db->select(' 
  core_tercero.razon_social,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_eapb.estado,
  core_eapb.id_entidad,
  core_eapb.id_tercero,
  core_eapb.codigo_eapb');
$this->db->from('core_eapb');
$this->db->join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');	$this->db->limit($number_items,$offset);
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNumListaEapbCon($d)
	{
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('numero_documento',$d['numero_documento']); }
		
		if(strlen($d['razon_social']) > 0){
		$this-> db -> like('razon_social',$d['razon_social']); }
		
		$this->db->select(' 
  core_tercero.razon_social,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_eapb.estado,
  core_eapb.id_entidad,
  core_eapb.id_tercero,
  core_eapb.codigo_eapb');
$this->db->from('core_eapb');
$this->db->join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$result = $this->db->get();
$n = $result -> num_rows();
		return $n;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListaEapbCon($d,$number_items,$offset)
	{
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('numero_documento',$d['numero_documento']); }
		
		if(strlen($d['razon_social']) > 0){
		$this-> db -> like('razon_social',$d['razon_social']); }
		
		$this->db->select(' 
  core_tercero.razon_social,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_eapb.estado,
  core_eapb.id_entidad,
  core_eapb.id_tercero,
  core_eapb.codigo_eapb');
$this->db->from('core_eapb');
$this->db->join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');	$this->db->limit($number_items,$offset);
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearEapbDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'codigo_eapb' => $d['codigo_eapb'],
		'estado' => $d['estado'], 	
		'observaciones' =>	$d['observaciones'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' =>	$d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('core_eapb',$insert);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		$dat['id_entidad'] = $this->db->insert_id();
		//----------------------------------------------------------
		if(count($d['correo_entidad']) > 0 && strlen($d['correo_entidad'][0]) > 0)
		{
			for($i=0;$i<count($d['correo_entidad']);$i++)
			{
				$insert = array(
					'correo_entidad'=> $d['correo_entidad'][$i],
					'id_entidad'	=> $dat['id_entidad']);
				$this->db->insert('auto_correo_entidad', $insert); 
			}
		}
		//----------------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEapbConsulta($id_entidad)
	{
		$this-> db -> where('id_entidad',$id_entidad);
		$result = $this->db->get('core_eapb');
		return $result -> row_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function editarEapbDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$update = array(
		'codigo_eapb' => $d['codigo_eapb'],
		'estado' => $d['estado'], 	
		'observaciones' =>	$d['observaciones'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_entidad',$d['id_entidad']);
		$r = $this -> db -> update('core_eapb',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------------
		$this->db->trans_start();
    	$this->db->where('id_entidad',$d['id_entidad']);
   		$this->db->delete('auto_correo_entidad');
		if(count($d['correo_entidad']) > 0 && strlen($d['correo_entidad'][0]) > 0)
		{
			for($i=0;$i<count($d['correo_entidad']);$i++)
			{
				$insert = array(
					'correo_entidad'=> $d['correo_entidad'][$i],
					'id_entidad'	=> $d['id_entidad']);
				$this->db->insert('auto_correo_entidad', $insert); 
			}
		}
		 $this->db->trans_complete();
		//----------------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCorreosEapb($id_entidad)
	{
		$this-> db -> where('id_entidad',$id_entidad);
		$result = $this->db->get('auto_correo_entidad');
		return $result -> result_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}