<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hce_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 12 de mayo de 2011
*/
class Hce_model extends CI_Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::__construct();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAtencionesUrg($id_paciente)
	{
				$sql = "SELECT 
  core_tercero.numero_documento,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tipo_documentos.tipo_documento,
  core_servicios_hosp.nombre_servicio,
  urg_atencion.activo,
  urg_atencion.clasificacion,
  urg_atencion.fecha_ingreso,
  urg_atencion.fecha_egreso,
  urg_atencion.id_atencion,
  urg_estados_atencion.estado
FROM
  core_tercero
        
  JOIN core_tipo_documentos ON (core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento)
  JOIN core_paciente ON (core_tercero.id_tercero = core_paciente.id_tercero)
  JOIN urg_atencion ON (core_paciente.id_paciente = urg_atencion.id_paciente)
  JOIN urg_estados_atencion ON (urg_atencion.id_estado = urg_estados_atencion.id_estado)
  JOIN core_servicios_hosp ON (urg_atencion.id_servicio = core_servicios_hosp.id_servicio)
WHERE
  urg_atencion.id_paciente = '{$id_paciente}'
ORDER BY
  urg_atencion.fecha_ingreso";
		$result = $this->db->query($sql);
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}

function obtenerAtencionesHospi($id_paciente)
{
	$this->db->select('
	core_servicios_hosp.nombre_servicio,
	hospi_atencion.fecha_ingreso,
	hospi_atencion.fecha_egreso,
	hospi_atencion.id_atencion,
	hospi_estados_atencion.estado');
	$this->db->from('hospi_atencion');
	$this->db->join('hospi_estados_atencion','hospi_atencion.id_estado = hospi_estados_atencion.id_estado');
	$this->db->join('core_servicios_hosp','hospi_atencion.id_servicio = core_servicios_hosp.id_servicio');    
	$this->db->where('hospi_atencion.id_paciente',$id_paciente);
	$this->db->order_by('hospi_atencion.fecha_ingreso','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
	return $num;}
	$res = $result->result_array();
	return  $res;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerAtencionesUrgPacientes($d)
{
	$this->db->select('
		
  core_tercero.numero_documento,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tipo_documentos.tipo_documento,  
  core_servicios_hosp.nombre_servicio,
  urg_atencion.activo,
  urg_atencion.clasificacion,
  urg_atencion.fecha_ingreso,
  urg_atencion.fecha_egreso,
  urg_atencion.id_atencion,
  urg_atencion.id_paciente,
  urg_estados_atencion.estado');
 
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  	$this->db->join('urg_atencion','core_paciente.id_paciente = urg_atencion.id_paciente');
	$this->db->join('urg_estados_atencion','urg_atencion.id_estado = urg_estados_atencion.id_estado');
  	$this->db->join('core_servicios_hosp','urg_atencion.id_servicio = core_servicios_hosp.id_servicio');
			
			$this->db->from('core_tercero');
			
		if(strlen($d['primer_apellido']) > 0){
		$this-> db -> like('core_tercero.primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 0){
		$this-> db -> like('core_tercero.primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 0){
		$this-> db -> like('core_tercero.segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 0){
		$this-> db -> like('core_tercero.segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('core_tercero.numero_documento',$d['numero_documento']);
	
		}
		$this->db->group_by('numero_documento');
		$this->db->order_by('urg_atencion.fecha_ingreso', 'desc'); 
		
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function verificarPaciente($d){
	$this->db->select('
	core_tercero.numero_documento,
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	core_tercero.fecha_nacimiento,
	core_tipo_documentos.tipo_documento,
	core_paciente.id_paciente');
	$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
	$this->db->from('core_tercero');
			
	if(strlen($d['primer_apellido']) > 0){
	$this-> db -> like('core_tercero.primer_apellido',$d['primer_apellido']); }
	
	if(strlen($d['primer_nombre']) > 0){
	$this-> db -> like('core_tercero.primer_nombre',$d['primer_nombre']); }
	
	if(strlen($d['segundo_apellido']) > 0){
	$this-> db -> like('core_tercero.segundo_apellido',$d['segundo_apellido']); }
	
	if(strlen($d['segundo_nombre']) > 0){
	$this-> db -> like('core_tercero.segundo_nombre',$d['segundo_nombre']); }
	
	if(strlen($d['numero_documento']) > 0){
	$this-> db -> where('core_tercero.numero_documento',$d['numero_documento']);}
	
	$this->db->order_by('core_tercero.primer_nombre', 'ASC');
	$this->db->order_by('core_tercero.primer_apellido', 'ASC'); 	 
		
	$result = $this->db->get();
	$num = $result -> num_rows();
	if($num == 0){
	return $num;}
	$res = $result -> result_array();
	return  $res;
}
function obtenerAtencionesHospiPacientes($d)
{
	$this->db->select('
  core_tercero.numero_documento,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tipo_documentos.tipo_documento,  
  hospi_atencion.activo,
  hospi_atencion.fecha_ingreso,
  hospi_atencion.fecha_egreso,
  hospi_atencion.id_atencion,
  hospi_atencion.id_pacienteo');
 
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  $this->db->join('hospi_atencion','core_paciente.id_paciente = hospi_atencion.id_paciente');
			
			$this->db->from('core_tercero');
			
		if(strlen($d['primer_apellido']) > 0){
		$this-> db -> like('core_tercero.primer_apellido',$d['primer_apellido']); }
		
		if(strlen($d['primer_nombre']) > 0){
		$this-> db -> like('core_tercero.primer_nombre',$d['primer_nombre']); }
		
		if(strlen($d['segundo_apellido']) > 0){
		$this-> db -> like('core_tercero.segundo_apellido',$d['segundo_apellido']); }
		
		if(strlen($d['segundo_nombre']) > 0){
		$this-> db -> like('core_tercero.segundo_nombre',$d['segundo_nombre']); }
		
		if(strlen($d['numero_documento']) > 0){
		$this-> db -> where('core_tercero.numero_documento',$d['numero_documento']);
	
		}
		$this->db->group_by('numero_documento');
		$this->db->order_by('hospi_atencion.fecha_ingreso', 'desc'); 
		
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerObservacion($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$result = $this->db->get('urg_epicrisis');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerAnexo2Atencion($id_atencion)
{
$this->db->SELECT(' 
  core_tercero.razon_social,
  auto_anexo2.fecha_anexo,
  auto_anexo2.hora_anexo,
  auto_anexo2.numero_informe,
  auto_anexo2.id_anexo2,
  auto_anexo2.enviado');
$this->db->FROM('auto_anexo2');
$this->db->JOIN('core_paciente','auto_anexo2.id_paciente = core_paciente.id_paciente');
$this->db->JOIN('core_eapb','auto_anexo2.id_entidad = core_eapb.id_entidad');
$this->db->JOIN('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
$this->db->where('auto_anexo2.id_atencion',$id_atencion);
$this->db->order_by('auto_anexo2.fecha','DESC');
$result = $this->db->get();
return $result->result_array();		
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerAnexo3Atencion($id_atencion)
{
$this->db->SELECT(' 
  auto_anexo3_estados.estado_anexo,
  core_tercero1.razon_social,
  auto_anexo3.fecha_anexo,
  auto_anexo3.numero_envio,
  auto_anexo3.anexo4,
  auto_anexo3.fecha_ultimo_envio,
  auto_anexo3.hora_anexo,
  auto_anexo3.numero_informe,
  auto_anexo3.id_anexo3,
  auto_anexo3.id_estado_anexo');
$this->db->FROM('auto_anexo3');
$this->db->JOIN('auto_anexo3_estados','auto_anexo3.id_estado_anexo = auto_anexo3_estados.id_estado_anexo');
$this->db->JOIN('core_eapb','auto_anexo3.id_entidad = core_eapb.id_entidad');
$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
$this->db->order_by('auto_anexo3.fecha','DESC');
$this->db->where('auto_anexo3.id_atencion',$id_atencion);
$result = $this->db->get();
$num = $result -> num_rows();
if($num == 0){
return $num;}
$res = $result -> result_array();
return  $res;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////
/*
* Funcion que nos permite mirar si ya a sido creada una remision de una determinada atencion
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright

*/
	function obtenerRemision($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$result = $this->db->get('urg_remision');
		$num = $result -> num_rows();
		
		return $num;
	
     
	}
	 ////////////////////////////////Fin////////////////////////
	 }


