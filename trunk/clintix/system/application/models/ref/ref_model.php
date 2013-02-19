<?php
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Ref_model
 *Tipo: modelo
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 03 de junio de 2012
*/
class Ref_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{        
	parent::Model();	
	$this->load->database();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function crear_trasladoDB($d)
{
	$insert = array(
	'id_paciente' => $d['id_paciente'],
	'id_atencion' => $d['id_atencion'], 
	'fecha_solicitud' => $d['fecha_solicitud'], 
	'tramite' => $d['tramite'],
	'tipo_traslado' => $d['tipo_traslado'],
	'prioridad' => $d['prioridad'],
	'fecha_orden' => $d['fecha_orden'],
	'procedimiento' => $d['procedimiento'],
	'medico_remite' => $d['medico_remite'],
	'activo' => 'SI',
	'fecha_creacion ' => date('Y-m-d H:i:s'),
	'id_usuario' => $this->session->userdata('id_usuario'));
	$this->db->insert('ref_traslados',$insert);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtener_traslados_activos($tipo,$estado)
{
	$this->db->SELECT("CONCAT(
	  core_tercero.primer_nombre,' ',
	  core_tercero.segundo_nombre,' ',
	  core_tercero.primer_apellido,' ',
	  core_tercero.segundo_apellido) AS nombres,
	  ref_traslados.fecha_creacion,
	  ref_traslados.id_traslado,
	  ref_traslados.tipo_traslado,
	  ref_traslados.prioridad,
	   ref_traslados.autorizacion,
	  ref_traslados.tramite,
	  ref_traslados.activo",FALSE);
	$this->db->FROM('ref_traslados');
	$this->db->JOIN('core_paciente','ref_traslados.id_paciente = core_paciente.id_paciente');
	$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->where('ref_traslados.activo',$estado);
	if($tipo != 0){
		$this->db->where('ref_traslados.tipo_traslado',$tipo);
	}
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtener_traslado($id_traslado)
{
	$this->db->where('id_traslado',$id_traslado);
	$this->db->limit(1);
	$result=$this->db->get('ref_traslados');
	return $result->row_array();	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtener_traslado_fin($id_traslado)
{
	$this->db->where('id_traslado',$id_traslado);
	$this->db->limit(1);
	$result=$this->db->get('ref_traslados_finalizar');
	return $result->row_array();	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerUsuario($id_usuario)
{
	$this->db->SELECT("CONCAT(
  core_tercero.primer_apellido,' ',
  core_tercero.segundo_apellido,' ',
  core_tercero.primer_nombre,' ',
  core_tercero.segundo_nombre) as usuario,
  core_usuario.id_usuario",FALSE);
	$this->db->FROM('core_usuario');
	$this->db->JOIN('core_tercero','core_usuario.numero_documento = core_tercero.numero_documento');
	$this->db->where('core_usuario.id_usuario',$id_usuario);
	$this->db->limit(1);
	$result=$this->db->get();
	return $result->row_array();	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function agregar_notaDB($d)
{
	$insert = array(
		'tipo_nota' => $d['tipo_nota'],
		'nota' => $d['nota'],
		'id_traslado' => $d['id_traslado'],
		'fecha_nota' => date('Y-m-d H:i:s'),
		'id_usuario' => $this->session->userdata('id_usuario'));
		$this->db->insert('ref_traslados_notas',$insert);
		return $this->db->insert_id();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtener_nota($id_nota)
{
	$this->db->where('id_nota',$id_nota);
	$this->db->limit(1);
	$result=$this->db->get('ref_traslados_notas');
	return $result->row_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtener_notas($id_traslado)
{
	$this->db->where('id_traslado',$id_traslado);
	$this->db->order_by('fecha_nota','DESC');
	$result=$this->db->get('ref_traslados_notas');
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function agregar_autorizacionDB($d)
{
	$insert = array(
		'id_traslado' => $d['id_traslado'],
		'autorizacion' => $d['autorizacion'],
		'fecha_autorizacion' => $d['fecha_autorizacion'],
		'obs_autorizacion' => $d['obs_autorizacion'],
		'fecha_creacion' => date('Y-m-d H:i:s'),
		'id_usuario' => $this->session->userdata('id_usuario'));
	$this->db->insert('ref_traslados_autorizacion',$insert);
	
	$update = array(
		'autorizacion' => 'SI',
	);
	$this->db->where('id_traslado',$d['id_traslado']);
	$this->db->update('ref_traslados',$update);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtener_autorizacion($id_traslado)
{
	$this->db->where('id_traslado',$id_traslado);
	$this->db->limit(1);
	$result=$this->db->get('ref_traslados_autorizacion');
	return $result->row_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function finalizar_trasladoDB($d)
{
	$insert = array(
		'id_traslado' => $d['id_traslado'],
		'traslado_realizado' => $d['traslado_realizado'],
		'muere_traslado' => $d['muere_traslado'],
		'motivo_no_traslado' => $d['motivo_no_traslado'],
		'movil' => $d['movil'],
		'fecha_traslado' => $d['fecha_traslado'],
		'conductor' => $d['conductor'],
		'paramedico' => $d['paramedico'],
		'medico' => $d['medico'],
		'observacion' => $d['observacion'],
		'fecha_creacion' => date('Y-m-d H:i:s'),
		'id_usuario' => $this->session->userdata('id_usuario'));
	$this->db->insert('ref_traslados_finalizar',$insert);
	
	$update = array(
		'activo' => 'NO',
	);
	$this->db->where('id_traslado',$d['id_traslado']);
	$this->db->update('ref_traslados',$update);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}