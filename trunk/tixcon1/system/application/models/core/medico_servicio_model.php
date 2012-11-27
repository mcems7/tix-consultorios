<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Medico_servicio_model extends Model 
{
/////////////////////////////////////////////////////////////////////////////
function __construct()
{        
	parent::Model();
	
	$this->load->database();
}
/////////////////////////////////////////////////////////////////////////////
function obtenerDatosMedico($d)
{
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
$this-> db -> where('core_tercero.numero_documento',$d['numero_documento']);
$result = $this->db->get();
$num = $result -> num_rows();
if($num == 0){
return $num;}
$res = $result -> row_array();
return  $res;
}
/////////////////////////////////////////////////////////////////////////////
function obtenerServiciosHospitalizacion()
{
	$this->db->where('estado','Activo');
	$this->db->where('tipo_servicio','Hospitalización');
	$this->db->order_by('nombre_servicio','ASC');
	$res = $this->db->get('core_servicios_hosp');
	return $res->result_array();
}
/////////////////////////////////////////////////////////////////////////////
function obtenerServiciosMedico($id_medico)
{
	$this->db->from('core_personal_servicio');
	$this->db->join('core_servicios_hosp','core_personal_servicio.id_servicio = core_servicios_hosp.id_servicio');
	$this->db->where('core_personal_servicio.estado','Activo');
	$result = $this->db->get();
	$num = $result -> num_rows();
	if($num == 0){
	return $num;}
	$res = $result -> result_array();
	return  $res;
}
/////////////////////////////////////////////////////////////////////////////
function agregar_medico_servicio($d)
{
	$insert = array(
		'id_medico'		=> $d['id_medico'],
		'id_servicio'	=> $d['id_servicio'],
		'fecha_asignacion' => date('Y-m-d H:i:s'),
		'id_usuario'	=> $this->session->userdata('id_usuario')  
	);
	$this -> db -> insert('core_personal_servicio',$insert);
}
/////////////////////////////////////////////////////////////////////////////
}
