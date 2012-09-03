<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Interconsulta_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 04 de noviembre de 2010
*/
class Interconsulta_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();	
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene el listado de interconsultas 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100830
* @version		20100830
* @return		array[object]
*/
	function obtenerInterconsultas($estado)
	{
		$this -> db -> select('
		inter_interconsulta.id_interconsulta,
  inter_interconsulta.estado,
  inter_interconsulta.fecha_solicitud,
  core_servicios_hosp.nombre_servicio');
  $this -> db -> from('inter_interconsulta');
  $this -> db -> join('core_servicios_hosp','inter_interconsulta.id_servicio = core_servicios_hosp.id_servicio');
  if($estado == 'Abierta'){
  $this -> db -> or_where('estado','Sin consultar');
  $this -> db -> or_where('estado','Consultada');
  }else{
	$this -> db -> where('estado',$estado);  
  }
		$this -> db -> order_by('fecha_solicitud','DESC');
		$result = $this -> db -> get();
		return $result -> result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function ontenerInterconsulta($id_interconsulta)
	{
		$this -> db ->SELECT(' 
  core_servicios_hosp.nombre_servicio,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  inter_interconsulta.estado,
  inter_interconsulta.nombres,
  inter_interconsulta.documento,
  inter_interconsulta.fecha_notificacion,
  inter_interconsulta.id_interconsulta,
  inter_interconsulta.id_medico,
  inter_interconsulta.id_evolucion,
  core_especialidad.descripcion,
  inter_interconsulta.fecha_solicitud');
$this -> db ->FROM('inter_interconsulta');
$this -> db ->JOIN('core_servicios_hosp','inter_interconsulta.id_servicio = core_servicios_hosp.id_servicio');
$this -> db ->JOIN('core_medico','inter_interconsulta.id_medico = core_medico.id_medico');
$this -> db ->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this -> db ->JOIN('core_especialidad','inter_interconsulta.id_especialidad = core_especialidad.id_especialidad');
$this -> db -> where('id_interconsulta',$id_interconsulta);
$result = $this -> db -> get();
return $result -> row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function actualizarEstadoInterconsulta($id_interconsulta,$estado)
	{
		$update = array('estado' => $estado, 'fecha_consulta' => date('Y-m-d H:i:s'));
		$this->db->where('id_interconsulta',$id_interconsulta);
		$this->db->update('inter_interconsulta',$update);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function notificarInterconsultaDb($d)
	{
		$update = array(
		'estado' => 'Notificada',
		'nombres' => $d['nombres'],
		'documento' => $d['documento'],
		'fecha_notificacion' => date('Y-m-d H:i:s'));
		$this->db->where('id_interconsulta',$d['id_interconsulta']);
		$this->db->update('inter_interconsulta',$update);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerInterconsultasAtencion($id_atencion)
	{
		$this->db->SELECT(' 
  urg_atencion.id_atencion,
  core_especialidad.descripcion,
  inter_interconsulta.fecha_solicitud,
  inter_interconsulta.fecha_consulta,
  inter_interconsulta.fecha_notificacion,
  inter_interconsulta.fecha_atencion,
  inter_interconsulta.estado,
  inter_interconsulta.id_interconsulta');
$this->db->FROM('urg_evoluciones');
$this->db->JOIN('urg_atencion','urg_evoluciones.id_atencion = urg_atencion.id_atencion');
$this->db->JOIN('inter_interconsulta','urg_evoluciones.id_evolucion = inter_interconsulta.id_evolucion');
$this->db->JOIN('core_especialidad','inter_interconsulta.id_especialidad = core_especialidad.id_especialidad');
$this->db->WHERE('inter_interconsulta.estado','Notificada');
$this->db->WHERE('urg_atencion.id_atencion',$id_atencion);
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function cerrarInterconsulta($d)
	{
		$update = array(
			'fecha_atencion' => date('Y-m-d H:i:s'),
			'estado' => 'Cerrada',
			'id_evo_cierra' => $d['id_evolucion']
		);
		$this->db->where('id_interconsulta',$d['id_interconsulta']);
		$this->db->update('inter_interconsulta',$update);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene el listado de observaciones de una interconsulta 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110419
* @version		20110419
* @return		array[object]
*/
	function obtenerObsInterconsulta($id_interconsulta)
	{
		$this->db->where('id_interconsulta',$id_interconsulta);
		$res = $this->db->get('inter_interconsulta_obs');
		return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Agregar una observación a una interconsulta 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110419
* @version		20110419
*/
	function agregarObsInterconsultaDb($d)
	{
		$insert = array(
			'id_interconsulta' 	=> $d['id_interconsulta'],
			'observacion'		=> $d['observacion'],
			'fecha'				=> date('Y-m-d H:i:s'),
			'id_usuario'		=> $this -> session -> userdata('id_usuario')
		);
		$this->db->insert('inter_interconsulta_obs',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}