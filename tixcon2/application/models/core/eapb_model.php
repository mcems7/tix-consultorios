<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Eapb_model extends CI_Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::__construct();
		
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
	function obtenerTercero($id_tercero)
	{
		 $this-> db -> select('core_tipo_documentos.tipo_documento,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.id_tercero,
  core_tercero.primer_nombre,
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
		//----------------------------------------------------
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
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_entidad',$d['id_entidad']);
		$r = $this -> db -> update('core_eapb',$update);
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}