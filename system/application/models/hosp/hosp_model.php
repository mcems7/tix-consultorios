<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hops_model
 *Tipo: modelo
 *Descripcion: Gestión de pacientes hospitalizados
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 08 de febrero de 2011
*/
class Hosp_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();	
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function registrarAtencioDb($d)
	{
		$insert = array(
		'id_paciente' => $d['id_paciente'],
		'fecha_ingreso' => $d['fecha_ingreso'],
		'id_servicio' => $d['id_servicio'],
		'cama' => $d['cama'],
		'consulta' => 'NO',
		'admision' => 'SI',
		'id_entidad_pago' => $d['id_entidad_pago'],
		'id_entidad' => $d['id_entidad'],
		'id_estado' => '1',
		'id_origen' => $d['id_origen'],
		'numero_ingreso' => $d['numero_ingreso'],		
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('hosp_atencion',$insert);
		//----------------------------------------------------
		$id_atencion = $this->db->insert_id();
		//----------------------------------------------------
		$insert = array('id_estado' => '1',
						'id_usuario' => $this -> session -> userdata('id_usuario'),
						'id_atencion' => $id_atencion,
						'id_servicio' => $d['id_servicio'],
						'id_origen' => $d['id_origen'],
						'id_entidad' => $d['id_entidad'],
						'numero_ingreso' => $d['numero_ingreso'],
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('hosp_atencion_detalle',$insert);
		//----------------------------------------------------
		if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
		{
			for($i=0;$i<count($d['dx']);$i++)
			{
				$insert = array(
					'id_diag' 		=> $d['dx'][$i],
					'id_atencion' 	=> $id_atencion);
				$this->db->insert('hosp_atencion_diag', $insert); 
			}
		}
		//----------------------------------------------------
		return $id_atencion;
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarAtencionHosp($numero_documento)
	{
		$this->db->select('
		core_tercero.numero_documento,
		hosp_atencion.fecha_ingreso,
		hosp_atencion.id_estado,
		core_servicios_hosp.nombre_servicio,
		hosp_atencion.id_atencion');
		$this->db->from('core_tercero');
		$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  	$this->db->join('hosp_atencion','core_paciente.id_paciente = hosp_atencion.id_paciente');
	$this -> db ->JOIN('core_servicios_hosp','hosp_atencion.id_servicio = core_servicios_hosp.id_servicio');
		$this->db->where('core_tercero.numero_documento',$numero_documento);
		$this->db->where('hosp_atencion.activo','SI');
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAtencion($id_atencion)
	{
		$this->db->select('hosp_estados_atencion.estado,
  hosp_atencion.id_atencion,
  hosp_atencion.id_servicio,
  hosp_atencion.id_paciente,
  hosp_atencion.cama,
  hosp_atencion.activo,
  hosp_atencion.fecha_ingreso,
  hosp_atencion.fecha_egreso,
  hosp_atencion.consulta,
  hosp_atencion.id_medico_consulta,
  hosp_atencion.admision,
  hosp_atencion.id_estado,
  hosp_atencion.id_entidad,
  hosp_atencion.id_entidad_pago,
  hosp_atencion.id_destino,
  hosp_atencion.id_origen,
  hosp_atencion.numero_ingreso,
  core_servicios_hosp.nombre_servicio,
  urg_origen_atencion.origen');
  $this->db->from('hosp_atencion');
  $this->db->join('hosp_estados_atencion','hosp_atencion.id_estado = hosp_estados_atencion.id_estado');
  $this->db->join('core_servicios_hosp','hosp_atencion.id_servicio = core_servicios_hosp.id_servicio');
  $this->db->join('urg_origen_atencion','hosp_atencion.id_origen = urg_origen_atencion.id_origen','LEFT');
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db->get();
	return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDxAtencion($id_atencion)
	{
		$this->db->select('hosp_atencion_diag.id_diag,core_diag_item.diagnostico,hosp_atencion_diag.id_atencion');
		$this->db->from('hosp_atencion_diag');
  		$this->db->join('core_diag_item','hosp_atencion_diag.id_diag = core_diag_item.id_diag');
		$this->db->where('id_atencion',$id_atencion);
		$result = $this->db->get();
		return  $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function verificarAtencionHopsGes($d)
	{
		$this->db->select('
		core_tercero.numero_documento,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		hosp_atencion.fecha_ingreso,
		hosp_atencion.id_servicio,
		hosp_atencion.id_estado,
		core_servicios_hosp.nombre_servicio,
		hosp_atencion.id_atencion');
		$this->db->from('core_tercero');
		$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  	$this->db->join('hosp_atencion','core_paciente.id_paciente = hosp_atencion.id_paciente');
	$this -> db ->JOIN('core_servicios_hosp','hosp_atencion.id_servicio = core_servicios_hosp.id_servicio');
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
		
	    $this->db->where('hosp_atencion.activo','SI');	
		
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function egresoHospDb($d)
{
	$update = array(
	'fecha_egreso' 	=>  date('Y-m-d H:i:s'),
	'id_estado' 	=> '2',
	'activo'		=> 'NO',
	'id_usuario' 	=> $this -> session -> userdata('id_usuario'),);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('hosp_atencion',$update);
	
	$insert = array('id_estado' 	=> '2',
					'id_usuario' 	=> $this -> session -> userdata('id_usuario'),
					'id_atencion' 	=> $d['id_atencion'],
					'fecha_modificacion' => date('Y-m-d H:i:s'));
	$this->db->insert('hosp_atencion_detalle',$insert);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function registrarAtencionEditDb($d)
{
$update = array(
	'fecha_ingreso' => $d['fecha_ingreso'],
	'id_servicio' => $d['id_servicio'],
	'cama' => $d['cama'],
	'id_entidad_pago' => $d['id_entidad_pago'],
	'id_entidad' => $d['id_entidad'],
	'id_origen' => $d['id_origen'],
	'numero_ingreso' => $d['numero_ingreso'],		
	'fecha_modificacion' =>	date('Y-m-d H:i:s'),
	'id_usuario' => $this -> session -> userdata('id_usuario'));
$this -> db -> where('id_atencion',$d['id_atencion']);	
$this -> db -> update('hosp_atencion',$update);
//----------------------------------------------------
$insert = array('id_estado' => '1',
				'id_usuario' => $this -> session -> userdata('id_usuario'),
				'id_atencion' => $d['id_atencion'],
				'id_servicio' => $d['id_servicio'],
				'id_origen' => $d['id_origen'],
				'id_entidad' => $d['id_entidad'],
				'numero_ingreso' => $d['numero_ingreso'],
				'fecha_modificacion' => date('Y-m-d H:i:s'));
$this->db->insert('hosp_atencion_detalle',$insert);
//----------------------------------------------------
$this->db->trans_start();
$this->db->where('id_atencion',$d['id_atencion']);
$this->db->delete('hosp_atencion_diag');
if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
{
	for($i=0;$i<count($d['dx']);$i++)
	{
		$insert = array(
			'id_diag' 		=> $d['dx'][$i],
			'id_atencion' 	=> $d['id_atencion']);
		$this->db->insert('hosp_atencion_diag', $insert); 
	}
}
$this->db->trans_complete();
//----------------------------------------------------
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerAnexos3Atencion($id_atencion)
{

$this->db->SELECT(' 
  auto_anexo3_estados.estado_anexo,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tipo_documentos.tipo_documento,
  core_tercero.numero_documento,
  core_tercero1.razon_social,
  auto_anexo3.fecha_anexo,
  auto_anexo3.numero_envio,
  auto_anexo3.anexo4,
  auto_anexo3.fecha_ultimo_envio,
  auto_anexo3.hora_anexo,
  auto_anexo3.numero_informe,
  auto_anexo3.id_anexo3,
  auto_anexo3.id_estado_anexo,
  core_servicios_hosp.nombre_servicio');
$this->db->FROM('auto_anexo3');
$this->db->JOIN('auto_anexo3_estados','auto_anexo3.id_estado_anexo = auto_anexo3_estados.id_estado_anexo');
$this->db->JOIN('core_paciente','auto_anexo3.id_paciente = core_paciente.id_paciente');
$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->JOIN('core_eapb','auto_anexo3.id_entidad = core_eapb.id_entidad');
$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
$this->db->JOIN('core_servicios_hosp','auto_anexo3.servicio = core_servicios_hosp.id_servicio');
$this->db->order_by('auto_anexo3.fecha','DESC');
$this->db->where('id_atencion',$id_atencion);

$result = $this->db->get();
$num = $result -> num_rows();
if($num == 0){
return $num;}
$res = $result -> result_array();
return  $res;		
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}