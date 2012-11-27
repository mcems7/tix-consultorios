<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: hospi_Enfermeria_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades de enfermeria en el modulo de Urgencias
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 12 de marzo de 2012
 
*/


class Hospi_enfermeria_model extends CI_Model 
{
////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::__construct();
		
		$this->load->database();
    }
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerPacientesSala($id_servicio)
	{
		
	$this->db->select('hospi_atencion.id_atencion,
	  hospi_atencion.fecha_ingreso,
	  hospi_atencion.clasificacion,
	  hospi_atencion.id_medico_consulta,
	  hospi_atencion.consulta,
	  hospi_atencion.id_servicio,
	  core_paciente.genero,
	  core_tercero.primer_apellido,
	  core_tercero.segundo_apellido,
	  core_tercero.primer_nombre,
	  core_tercero.segundo_nombre,
	  core_tercero.numero_documento,
	  core_tipo_documentos.tipo_documento,
	  hospi_triage.clasificacion,
	  hospi_triage.motivo_consulta,
	  hospi_estados_atencion.estado,
	  core_tercero.fecha_nacimiento,
	  hospi_atencion.id_estado');
	$this->db->from('hospi_atencion');
	$this->db->join('core_paciente','hospi_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->join('hospi_triage','hospi_atencion.id_atencion = hospi_triage.id_atencion');
	$this->db->join('hospi_estados_atencion','hospi_atencion.id_estado = hospi_estados_atencion.id_estado');
	$this->db->where('hospi_atencion.id_servicio',$id_servicio);
	$this->db->where('hospi_atencion.id_estado <>',2);
	$this->db->where('hospi_atencion.id_estado <>',3);
	$this->db->where('hospi_atencion.id_estado <>',5);
	$this->db->where('hospi_atencion.id_estado <>',1);
	$this->db->where('hospi_atencion.id_estado <>',6);
	$this->db->where('hospi_atencion.id_estado <>',7); 
	$this->db->where('hospi_atencion.id_estado <>',8);
	$this->db->where('hospi_atencion.id_estado <>',10);
	$this->db->order_by('fecha_ingreso','desc');   	
	$result = $this->db->get();
	
	return $result->result_array();
	}
	
////////////////////////////////////////////////////////////////////////////////////////

function obtenerNotas($id_atencion)
	{
	$this->db->from('hospi_notas_enfermeria');
	$this->db->join('core_medico','hospi_notas_enfermeria.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_nota','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerUltimaNota($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('fecha_nota','desc');
		$result = $this->db->get('hospi_notas_enfermeria');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res;
	}  
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNota($id_nota)
	{
		$this->db->from('hospi_notas_enfermeria');
		$this->db->join('core_medico','hospi_notas_enfermeria.id_medico = core_medico.id_medico');
		$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
		$this->db->where('id_nota',$id_nota);
		$result = $this->db->get();
		return $result->row_array();
	}
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerUltNota($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('fecha_nota','DESC');
		$result = $this->db->get('hospi_notas_enfermeria');
		$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->first_row('array');
		}	
	}
////////////////////////////////////////////////////////////////////////////////////////
	function crearNotaDb($d)
	{
		$insert = array(
			'subjetivo' => $d['subjetivo'],
			'objetivo' => $d['objetivo'],
			'actividades' => $d['actividades'],
			'pendientes' => $d['pendientes'],
			'id_servicio' => $d['id_servicio'],
			'id_usuario' => $this -> session -> userdata('id_usuario'),
			'id_medico' => $d['id_medico'],
			'id_atencion' => $d['id_atencion'],
			'fecha_nota' => date('Y-m-d H:i:s'));
		$this->db->insert('hospi_notas_enfermeria',$insert);
		$id_nota = $this->db->insert_id();
		//----------------------------------------------------
		return $id_nota;
	}
	
/*
* crea los datos de los signos vitales
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120312
* @version		20120312
* @return		array[object]
*/	

	function crearSvNotaDb($d)
	{

		$insert = array(
			'pulso' => $d['pulso'],
			'frecuencia_respiratoria'  => $d['frecuencia_respiratoria'],
			'ten_arterial_s' => $d['ten_arterial_s'],
			'ten_arterial_d'  => $d['ten_arterial_d'],
			'temperatura'  => $d['temperatura'],
			'spo2'  => $d['spo2'],
			'peso' => $d['peso'],
			'id_servicio' => $d['id_servicio'],
			'id_usuario' => $this -> session -> userdata('id_usuario'),
			'id_medico' => $d['id_medico'],
			'id_atencion' => $d['id_atencion'],
			'fecha_nota' => date('Y-m-d H:i'));
		$this->db->insert('hospi_signos_enfermeria',$insert);
		$id_nota = $this->db->insert_id();
		//----------------------------------------------------
		return $id_nota;
	}	
////////////////////////////////////////////////////////////////////////////////////////
/*
* obtiene los datos de los signos vitales
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120312
* @version		20120312
* @return		array[object]
*/
function obtenerSvNotaConsulta($id)
	{
	$this->db->from('hospi_signos_enfermeria');
	$this->db->join('core_medico','hospi_signos_enfermeria.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id',$id);
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}



////////////////////////////////////////////////////////////////////////////////////////
function obtenerSvNotas($id_atencion,$id_servicio)
	{
	$this->db->from('hospi_signos_enfermeria');
	$this->db->join('core_medico','hospi_signos_enfermeria.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('id_servicio',$id_servicio);
	$this->db->order_by('fecha_nota','ASC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////
function obtenerBlNotasEli($id_atencion)
	{
	$this->db->from('hospi_bl_eliminados_enfermeria');
	$this->db->join('core_medico','hospi_bl_eliminados_enfermeria.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_nota','ASC');
	$this->db->group_by('fecha_nota');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
////////////////////////////////////////////////////////////////////////////////////////
function obtenerBlNotasAdm($id_atencion)
	{
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->join('core_medico','hospi_bl_administrados_enfermeria.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_nota','ASC');
	$this->db->group_by('fecha_nota');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
	
function obtenerBlEliminados($id_atencion,$id_servicio)
	{
	
	$this->db->select_sum('orina');
	$this->db->select_sum('vomito');
	$this->db->select_sum('drend');
	$this->db->select_sum('drene');
	$this->db->select_sum('storaxe');
	$this->db->select_sum('storaxd');
	$this->db->select_sum('deposicion');
	$this->db->select_sum('otros');
	$this->db->select_sum('sng');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_eliminados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('id_servicio',$id_servicio);
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
	
	function obtenerBlAdministrados($id_atencion,$id_servicio)
	{
	
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('id_servicio',$id_servicio);
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	
	
 function crearBl_admi($d)
 {
	 $hoy= date("Y-m-d");
	 $hora =date('H:i:s');
	 
	 
	 if ($hora > '00:00' && $hora < 07)
	 {
		  $insert = array(	
		'l_administrado' => $d['l_administrado'],
		'via_oral'  =>$d['via_oral'],
		'sng'  => $d['sng'],
		'liv'  =>$d['liv'],
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion'],
		'fecha_real' => date('Y-m-d'),
		'fecha_nota' => date('Y-m-d', strtotime("$hoy - 1 day")),
		'hora_nota' => date('H:i:s'));
	 }else{
		  $insert = array(	
		'l_administrado' => $d['l_administrado'],
		'via_oral'  =>$d['via_oral'],
		'sng'  => $d['sng'],
		'liv'  =>$d['liv'],
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion'],
		'fecha_nota' => date('Y-m-d'),
		'fecha_real' => date('Y-m-d'),
		'hora_nota' => date('H:i:s'));
		   }
	
		$this->db->insert('hospi_bl_administrados_enfermeria',$insert);
		$id_nota = $this->db->insert_id();
		//----------------------------------------------------
		return $id_nota;
	 
	 
 }
 
 ////////////////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////
 
 	function crearBl_elimi($d)
	{
		$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
	if ($hora > '00:00' && $hora < 07)
	 {
		$insert = array(	
		'orina' => $d['orina'],
		'vomito'  =>$d['vomito'],
		'sng'  => $d['sng'],
		'otros'  =>$d['otros'],
		'drend'  =>$d['drend'],
		'drene'  =>$d['drene'],
		'storaxe'  =>$d['storaxe'],
		'storaxd'  =>$d['storaxd'],
		'deposicion'  =>$d['deposicion'],
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion'],
		'fecha_nota' => date('Y-m-d', strtotime("$hoy - 1 day")),
		'fecha_real' => date('Y-m-d'),
		'hora_nota' => date('H:i:s'));
	 }else{
		 	$insert = array(
		'orina' => $d['orina'],
		'vomito'  =>$d['vomito'],
		'sng'  => $d['sng'],
		'otros'  =>$d['otros'],
		'drend'  =>$d['drend'],
		'drene'  =>$d['drene'],
		'storaxe'  =>$d['storaxe'],
		'storaxd'  =>$d['storaxd'],
		'deposicion'  =>$d['deposicion'],
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion'],
		'fecha_nota' => date('Y-m-d'),
		'fecha_real' => date('Y-m-d'),
		'hora_nota' => date('H:i:s'));
		 
	}
		
		$this->db->insert('hospi_bl_eliminados_enfermeria',$insert);
		$id_nota = $this->db->insert_id();
		//----------------------------------------------------
		return $id_nota;
		
	}	
	
	/////////////////diego carvajal///////////////////
	
	//se obtiene los datos de balance de liquidos por fecha y en el horario de la manana.
	
function obtenerBlAdmFecha7_12($id_atencion,$fecha_nota)
	{
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	$this->db->where('hora_nota >','07:00');
	$this->db->where('hora_nota <','13:00');
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
	//se obtiene los datos de balance de liquidos por fecha y en el horario de la tarde.
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	
function obtenerBlAdmFecha13_18($id_atencion,$fecha_nota)
	{
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	$this->db->where('hora_nota >','13:01');
	$this->db->where('hora_nota <','19:00');
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	
//se obtiene los datos de balance de liquidos por fecha y en el horario de la tarde.
function obtenerBlAdmFecha19_6($id_atencion,$fecha_nota)
	{
	
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	//$this->db->where('fecha_nota',$fecha_nota);
	$where = "fecha_nota = '$fecha_nota' AND (hora_nota < '7:00' OR hora_nota > '19:00')
";
	$this->db->where($where);
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			
			return $num;
		}else{
			return $result->result_array();
			
		}
	}	
	
/////balance eliminados por fehca y hora////////
//se obtiene los datos de balance de liquidos eliminados por fecha y en el horario de la manana.

function obtenerBlEliFecha7_12($id_atencion,$fecha_nota)
	{
	
	$this->db->select_sum('orina');
	$this->db->select_sum('vomito');
	$this->db->select_sum('sng');
	$this->db->select_sum('otros');
	$this->db->select_sum('drend');
	$this->db->select_sum('drene');
	$this->db->select_sum('storaxe');
	$this->db->select_sum('storaxd');
	$this->db->select_sum('deposicion');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_eliminados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	$this->db->where('hora_nota >','07:00');
	$this->db->where('hora_nota <','13:00');
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
	//se obtiene los datos de balance de liquidos por fecha y en el horario de la tarde.
	////////////////////////////////////////////////////////////////////////////////////////
	
function obtenerBlEliFecha13_18($id_atencion,$fecha_nota)
	{
	$this->db->select_sum('orina');
	$this->db->select_sum('vomito');
	$this->db->select_sum('sng');
	$this->db->select_sum('otros');
	$this->db->select_sum('drend');
	$this->db->select_sum('drene');
	$this->db->select_sum('storaxe');
	$this->db->select_sum('storaxd');
	$this->db->select_sum('deposicion');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_eliminados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	$this->db->where('hora_nota >','13:01');
	$this->db->where('hora_nota <','19:00');
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	
//se obtiene los datos de balance de liquidos por fecha y en el horario de la tarde.
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function obtenerBlEliFecha19_6($id_atencion,$fecha_nota)
	{
	
	$this->db->select_sum('orina');
	$this->db->select_sum('vomito');
	$this->db->select_sum('sng');
	$this->db->select_sum('otros');
	$this->db->select_sum('drend');
	$this->db->select_sum('drene');
	$this->db->select_sum('storaxe');
	$this->db->select_sum('storaxd');
	$this->db->select_sum('deposicion');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_eliminados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$where = "fecha_nota = '$fecha_nota' AND (hora_nota < '7:00' OR hora_nota > '19:00')
";
	$this->db->where($where);
  
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	
	//se obtiene los datos de balance de liquidos durante las 24 horas del dia,
function obtenerBlEliFecha24($id_atencion,$fecha_nota)
	{
	
	$this->db->select_sum('orina');
	$this->db->select_sum('vomito');
	$this->db->select_sum('sng');
	$this->db->select_sum('otros');
	$this->db->select_sum('drend');
	$this->db->select_sum('drene');
	$this->db->select_sum('storaxe');
	$this->db->select_sum('storaxd');
	$this->db->select_sum('deposicion');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_eliminados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	//se obtiene los datos de balance de liquidos administrados en las 24 horas.
function obtenerBlAdmFecha24($id_atencion,$fecha_nota)
	{
	
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	
	$this->db->group_by('fecha_nota');
	$this->db->order_by('fecha_nota','ASC');
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	
	///////////carga datos de la nota de enfermeria/////////////
	
	function obtenerNotaEnfermeria($id_nota)
	{
	$this->db->select('core_especialidad.descripcion As esp,
		  core_medico.id_medico,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  hospi_notas_enfermeria.id_nota,
		  hospi_notas_enfermeria.id_atencion,
		  hospi_notas_enfermeria.id_medico,
		  hospi_notas_enfermeria.id_usuario,
		  hospi_notas_enfermeria.id_servicio,
		  hospi_notas_enfermeria.pendientes,
		  hospi_notas_enfermeria.actividades,
		  hospi_notas_enfermeria.objetivo,
		  hospi_notas_enfermeria.subjetivo,
		  hospi_notas_enfermeria.fecha_nota');
	$this->db->from('hospi_notas_enfermeria');
	$this->db->join('core_medico','core_medico.id_medico = hospi_notas_enfermeria.id_medico');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_nota',$id_nota);
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
	
	
//////////////////////////////////////////////////////////////////////////////////	
///////////carga datos del balance de liquidos de enfermeria/////////////
	
	
	function obtenerDatoBalanceEnfermeria($id_atencion,$fecha_nota)
	{
	$this->db->select('core_especialidad.descripcion As esp,
		  core_medico.id_medico,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,		
		  hospi_bl_administrados_enfermeria.id_atencion,
		  hospi_bl_administrados_enfermeria.id_medico,
		  hospi_bl_administrados_enfermeria.id_usuario,
		  hospi_bl_administrados_enfermeria.id_servicio,
		  hospi_bl_administrados_enfermeria.fecha_nota');
	$this->db->from('hospi_bl_administrados_enfermeria');
	$this->db->join('core_medico','core_medico.id_medico = hospi_bl_administrados_enfermeria.id_medico');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_nota',$fecha_nota);
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
	
/////////////////////////////fin///////////////////////////////////////////////





	
}


