<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Enfermeria_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades de enfermeria en el modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 04 de marzo de 2011
 
*/
class Enfermeria_model extends Model 
{
////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerPacientesSala($id_servicio)
	{
		
		$this->db->select('urg_atencion.id_atencion,
  urg_atencion.fecha_ingreso,
  urg_atencion.clasificacion,
  urg_atencion.id_medico_consulta,
  urg_atencion.consulta,
  urg_atencion.id_servicio,
  core_paciente.genero,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  urg_triage.clasificacion,
  urg_triage.motivo_consulta,
  urg_estados_atencion.estado,
  core_tercero.fecha_nacimiento,
  urg_atencion.id_estado');
$this->db->from('urg_atencion');
$this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->join('urg_triage','urg_atencion.id_atencion = urg_triage.id_atencion');
$this->db->join('urg_estados_atencion','urg_atencion.id_estado = urg_estados_atencion.id_estado');
$this->db->where('urg_atencion.id_servicio',$id_servicio);
$this->db->where('urg_atencion.activo','SI');
$this->db->where('urg_atencion.id_estado <>',2);
$this->db->where('urg_atencion.id_estado <>',3);
$this->db->where('urg_atencion.id_estado <>',5);
$this->db->where('urg_atencion.id_estado <>',1);
$this->db->where('urg_atencion.id_estado <>',6);
$this->db->where('urg_atencion.id_estado <>',7); 
$this->db->where('urg_atencion.id_estado <>',8);
$this->db->where('urg_atencion.id_estado <>',10);
$this->db->order_by('fecha_ingreso','desc');   	
$result = $this->db->get();
return $result->result_array();
	}
////////////////////////////////////////////////////////////////////////////////////////
function obtenerNotas($id_atencion)
	{
	$this->db->from('urg_notas_enfermeria');
	$this->db->join('core_medico','urg_notas_enfermeria.id_medico = core_medico.id_medico');
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
		$this->db->limit(1);
		$result = $this->db->get('urg_notas_enfermeria');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res;
	}  
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNota($id_nota)
	{
		$this->db->from('urg_notas_enfermeria');
		$this->db->join('core_medico','urg_notas_enfermeria.id_medico = core_medico.id_medico');
		$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
		$this->db->where('id_nota',$id_nota);
		$this->db->limit(1);
		$this->db->order_by('id_nota','DESC');
		$result = $this->db->get();
		return $result->row_array();
	}
////////////////////////////////////////////////////////////////////////////////////////
	function obtenerUltNota($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('fecha_nota','DESC');
		$result = $this->db->get('urg_notas_enfermeria');
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
		$this->db->insert('urg_notas_enfermeria',$insert);
		$id_nota = $this->db->insert_id();
		//----------------------------------------------------
		return $id_nota;
	}
	
	/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA

 *Autor: Diego Ivan Carvajal Gil<dcarvajal@opuslibertati.org>
*/
	
///////////////////////////signos vitales/////////////////////////////////////////////////////////////
	function crearSvNotaDb($d,$existe)
	{
		
		$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
		 if ($hora > '00:00' && $hora < 07)
	 {
		 $fecha_turno = date('Y-m-d', strtotime("$hoy - 1 day"));
		 if($existe==0)
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
				'saturacion_oxigeno'=> $d['saturacion_oxigeno'],
				'tencion_arterial_m'=>$d['tencion_arterial_m'],
				'fecha_turno' =>  $fecha_turno,
				'hora'=> $d['hora'],
				'signos_ingresados'=> 'SI',
				'fecha_nota' => date('Y-m-d H:i'));
				$this->db->insert('urg_signos_enfermeria',$insert);
				$id_nota = $this->db->insert_id();
				//----------------------------------------------------
				return $id_nota;
		
		
		}else{
						
						$update = array(
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
						'saturacion_oxigeno'=> $d['saturacion_oxigeno'],
						'tencion_arterial_m'=>$d['tencion_arterial_m'],
						'signos_ingresados'=> 'SI',
						);
								
						$this -> db -> where('fecha_turno', $fecha_turno);
						$this -> db -> where('hora',$d['hora']);
						$this -> db -> where('id_atencion',$d['id_atencion']);
						$this -> db -> update('urg_signos_enfermeria',$update);
				}
		 
		//fin del if	
	 }else{
		if($existe==0)
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
				'saturacion_oxigeno'=> $d['saturacion_oxigeno'],
				'tencion_arterial_m'=>$d['tencion_arterial_m'],
				'fecha_turno' => date('Y-m-d'),
				'hora'=> $d['hora'],
				'signos_ingresados'=> 'SI',
				'fecha_nota' => date('Y-m-d H:i'));
				$this->db->insert('urg_signos_enfermeria',$insert);
				$id_nota = $this->db->insert_id();
				//----------------------------------------------------
				return $id_nota;
		
		
		}else{
						
				$update = array(
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
				'saturacion_oxigeno'=> $d['saturacion_oxigeno'],
				'tencion_arterial_m'=>$d['tencion_arterial_m'],
				'signos_ingresados'=> 'SI',
				);
								
						$this -> db -> where('fecha_turno',date('Y-m-d'));
						$this -> db -> where('hora',$d['hora']);
						$this -> db -> where('id_atencion',$d['id_atencion']);
						$this -> db -> update('urg_signos_enfermeria',$update);
					}
		
		
	 }
	 //////////
	}	
////////////////////////////////////////////////////////////////////////////////////////
function obtenerSvNotaConsulta($id)
	{
	$this->db->from('urg_signos_enfermeria');
	$this->db->join('core_medico','urg_signos_enfermeria.id_medico = core_medico.id_medico');
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
	$this->db->from('urg_signos_enfermeria');
	$this->db->join('core_medico','urg_signos_enfermeria.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('id_servicio',$id_servicio);
	$this->db->where('signos_ingresados','SI');
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
	$this->db->from('urg_bl_eliminados_enfermeria');
	$this->db->join('core_medico','urg_bl_eliminados_enfermeria.id_medico = core_medico.id_medico');
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
	$this->db->from('urg_bl_administrados_enfermeria');
	$this->db->join('core_medico','urg_bl_administrados_enfermeria.id_medico = core_medico.id_medico');
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
	$this->db->from('urg_bl_eliminados_enfermeria');
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
	
	function obtenerBlAdministrados($id_atencion,$id_servicio)
	{
	
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('urg_bl_administrados_enfermeria');
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
	
		$this->db->insert('urg_bl_administrados_enfermeria',$insert);
		$id_nota = $this->db->insert_id();
		//----------------------------------------------------
		return $id_nota;
	 
	 
 }
 
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
		
		$this->db->insert('urg_bl_eliminados_enfermeria',$insert);
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
	$this->db->from('urg_bl_administrados_enfermeria');
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
function obtenerBlAdmFecha13_18($id_atencion,$fecha_nota)
	{
	
	$this->db->select_sum('via_oral');
	$this->db->select_sum('sng');
	$this->db->select_sum('liv');
	$this->db->select('fecha_nota');
	$this->db->from('urg_bl_administrados_enfermeria');
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
	$this->db->from('urg_bl_administrados_enfermeria');
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
	$this->db->from('urg_bl_eliminados_enfermeria');
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
	$this->db->from('urg_bl_eliminados_enfermeria');
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
	$this->db->from('urg_bl_eliminados_enfermeria');
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
	$this->db->from('urg_bl_eliminados_enfermeria');
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
	$this->db->from('urg_bl_administrados_enfermeria');
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
		  urg_notas_enfermeria.id_nota,
		  urg_notas_enfermeria.id_atencion,
		  urg_notas_enfermeria.id_medico,
		  urg_notas_enfermeria.id_usuario,
		  urg_notas_enfermeria.id_servicio,
		  urg_notas_enfermeria.pendientes,
		  urg_notas_enfermeria.actividades,
		  urg_notas_enfermeria.objetivo,
		  urg_notas_enfermeria.subjetivo,
		  urg_notas_enfermeria.fecha_nota');
	$this->db->from('urg_notas_enfermeria');
	$this->db->join('core_medico','core_medico.id_medico = urg_notas_enfermeria.id_medico');
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
		  urg_bl_administrados_enfermeria.id_atencion,
		  urg_bl_administrados_enfermeria.id_medico,
		  urg_bl_administrados_enfermeria.id_usuario,
		  urg_bl_administrados_enfermeria.id_servicio,
		  urg_bl_administrados_enfermeria.fecha_nota');
	$this->db->from('urg_bl_administrados_enfermeria');
	$this->db->join('core_medico','core_medico.id_medico = urg_bl_administrados_enfermeria.id_medico');
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
	
	
	////////////////////////////////////////////////////////////////////////////////////////
	
	//permite ver las monitorias de los signos vitales y los agrupa por fechas.
function obtenerMonitoria($id_atencion)
	{
	$this->db->from('urg_signos_enfermeria');
	
	$this->db->where('id_atencion',$id_atencion);
	$this->db->where('fecha_turno <>','0000-00-00');
	$this->db->group_by('urg_signos_enfermeria.fecha_turno');
	$this->db->order_by('fecha_turno','ASC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
	
	
//permite ver el seguimiento del dia de los signos vitales.
function obtenerMonitoriaFecha($id_atencion,$fecha_turno)
	{
	$this->db->from('urg_signos_enfermeria');
	$this->db->where('urg_signos_enfermeria.id_atencion',$id_atencion);
	$this->db->where('urg_signos_enfermeria.fecha_turno',$fecha_turno);
	$this->db->order_by('urg_signos_enfermeria.hora','ASC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 * permite crear las notas de los gases arteriales de enfermeria.
 *Autor: Diego Ivan Carvajal Gil<dcarvajal@opuslibertati.org>
*/
	
	function crearSvNotaGasesDb($d,$existe)
	{
	$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
		 if ($hora > '00:00' && $hora < 07)
	 {
		 $fecha_turno = date('Y-m-d', strtotime("$hoy - 1 day"));
		 	if($existe == 0)
				{
						$insert = array(
						'ph' => $d['ph'],
						'paco2'  => $d['paco2'],
						'pao2' => $d['pao2'],
						'hco3'  => $d['hco3'],
						'sao2'  => $d['sao2'],						
						'BE' => $d['BE'],
						'observacion' => $d['observacion'],
						'id_servicio' => $d['id_servicio'],
						'id_usuario_gases' => $this -> session -> userdata('id_usuario'),
						'id_medico_gases' => $d['id_medico'],
						'id_atencion' => $d['id_atencion'],
						'fraccion_inspirada_oxigeno' => $d['fraccion_inspirada_oxigeno'],
						'pao2_fio2'=>$d['pao2_fio2'],
						'fecha_turno' => $fecha_turno,
						'hora'=> $d['hora'],
						'gases_ingresados'=>'SI',
						'fecha_nota' => date('Y-m-d H:i'));
						$this->db->insert('urg_signos_enfermeria',$insert);
						$id_nota = $this->db->insert_id();
						//----------------------------------------------------
						return $id_nota;
		
				}else{
						
						$update = array(
						'ph' => $d['ph'],
						'paco2'  => $d['paco2'],
						'pao2' => $d['pao2'],
						'hco3'  => $d['hco3'],
						'sao2'  => $d['sao2'],
						'BE' => $d['BE'],
						'observacion' => $d['observacion'],
						'id_servicio' => $d['id_servicio'],
						'id_usuario_gases' => $this -> session -> userdata('id_usuario'),
						'id_medico_gases' => $d['id_medico'],
						'id_atencion' => $d['id_atencion'],
						'fraccion_inspirada_oxigeno' => $d['fraccion_inspirada_oxigeno'],
						'pao2_fio2'=>$d['pao2_fio2'],
						'gases_ingresados'=>'SI');
								
						$this -> db -> where('fecha_turno',$fecha_turno);
						$this -> db -> where('hora',$d['hora']);
						$this -> db -> where('id_atencion',$d['id_atencion']);
						$this -> db -> update('urg_signos_enfermeria',$update);
					}
		 
		 
		 
		 
	 }else {
				if($existe == 0)
				{
						$insert = array(
						'ph' => $d['ph'],
						'paco2'  => $d['paco2'],
						'pao2' => $d['pao2'],
						'hco3'  => $d['hco3'],
						'sao2'  => $d['sao2'],
						'BE' => $d['BE'],
						'observacion' => $d['observacion'],
						'id_servicio' => $d['id_servicio'],
						'id_usuario_gases' => $this -> session -> userdata('id_usuario'),
						'id_medico_gases' => $d['id_medico'],
						'id_atencion' => $d['id_atencion'],
						'fraccion_inspirada_oxigeno' => $d['fraccion_inspirada_oxigeno'],
						'pao2_fio2'=>$d['pao2_fio2'],
						'fecha_turno' => date('Y-m-d'),
						'hora'=> $d['hora'],
						'gases_ingresados'=>'SI',
						'fecha_nota' => date('Y-m-d H:i'));
						$this->db->insert('urg_signos_enfermeria',$insert);
						$id_nota = $this->db->insert_id();
						//----------------------------------------------------
						return $id_nota;
		
				}else{
						$update = array(
						'ph' => $d['ph'],
						'paco2'  => $d['paco2'],
						'pao2' => $d['pao2'],
						'hco3'  => $d['hco3'],
						'sao2'  => $d['sao2'],
						'BE' => $d['BE'],
						'observacion' => $d['observacion'],
						'id_servicio' => $d['id_servicio'],
						'id_usuario_gases' => $this -> session -> userdata('id_usuario'),
						'id_medico_gases' => $d['id_medico'],
						'id_atencion' => $d['id_atencion'],
						'fraccion_inspirada_oxigeno' => $d['fraccion_inspirada_oxigeno'],
						'pao2_fio2'=>$d['pao2_fio2'],
						'gases_ingresados'=>'SI');
								
						$this -> db -> where('fecha_turno',date('Y-m-d'));
						$this -> db -> where('hora',$d['hora']);
						$this -> db -> where('id_atencion',$d['id_atencion']);
						$this -> db -> update('urg_signos_enfermeria',$update);
					}
			 }
		
	}	
	
	function crearSvNotaGlucometriaDb($d,$existe)
	{
	$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
		 if ($hora > '00:00' && $hora < 07)
	 {
		 $fecha_turno = date('Y-m-d', strtotime("$hoy - 1 day"));
		 	if($existe == 0)
				{
						$insert = array(
						'glucometria' => $d['glucometria'],
						'insulina'  => $d['insulina'],
						'via_administracion' => $d['via_administracion'],							
						'id_servicio' => $d['id_servicio'],
						'id_usuario_gluco' => $this -> session -> userdata('id_usuario'),
						'id_medico_gluco' => $d['id_medico'],
						'id_atencion' => $d['id_atencion'],					
						'fecha_turno' => $fecha_turno,
						'hora'=> $d['hora'],
						'glucometria_ingresada'=>'SI',
						'fecha_nota' => date('Y-m-d H:i'));
						$this->db->insert('urg_signos_enfermeria',$insert);
						$id_nota = $this->db->insert_id();
						//----------------------------------------------------
						return $id_nota;
		
				}else{
						
						$update = array(
						'glucometria' => $d['glucometria'],
						'insulina'  => $d['insulina'],
						'via_administracion' => $d['via_administracion'],
						'id_usuario_gluco' => $this -> session -> userdata('id_usuario'),
						'id_medico_gluco' => $d['id_medico'],
						'glucometria_ingresada'=>'SI');
								
						$this -> db -> where('fecha_turno',$fecha_turno);
						$this -> db -> where('hora',$d['hora']);
						$this -> db -> where('id_atencion',$d['id_atencion']);
						$this -> db -> update('urg_signos_enfermeria',$update);
					}
		 
		 
		 
		 
	 }else {
					if($existe == 0)
				{
						$insert = array(
						'glucometria' => $d['glucometria'],
						'insulina'  => $d['insulina'],
						'via_administracion' => $d['via_administracion'],							
						'id_servicio' => $d['id_servicio'],
						'id_usuario_gluco' => $this -> session -> userdata('id_usuario'),
						'id_medico_gluco' => $d['id_medico'],
						'id_atencion' => $d['id_atencion'],					
						'fecha_turno' => date('Y-m-d'),
						'hora'=> $d['hora'],
						'glucometria_ingresada'=>'SI',
						'fecha_nota' => date('Y-m-d H:i'));
						$this->db->insert('urg_signos_enfermeria',$insert);
						$id_nota = $this->db->insert_id();
						//----------------------------------------------------
						return $id_nota;
		
				}else{
						
						$update = array(
						'glucometria' => $d['glucometria'],
						'insulina'  => $d['insulina'],
						'via_administracion' => $d['via_administracion'],
						'id_usuario_gluco' => $this -> session -> userdata('id_usuario'),
						'id_medico_gluco' => $d['id_medico'],
						'glucometria_ingresada'=>'SI');
								
						$this -> db -> where('fecha_turno',date('Y-m-d'));
						$this -> db -> where('hora',$d['hora']);
						$this -> db -> where('id_atencion',$d['id_atencion']);
						$this -> db -> update('urg_signos_enfermeria',$update);
					}
			 }
		
	}		
	
	
		
	// se verifica si han sido ingresados gases arteriales o signos vitales anteriormente para el horario establecido
	function VerificarExistencia($id_atencion,$fecha_turno,$hora)
	{
	$this->db->select('gases_ingresados,signos_ingresados,glucometria_ingresada');	
	$this->db->from('urg_signos_enfermeria');
	$this->db->where('urg_signos_enfermeria.id_atencion',$id_atencion);
	$this->db->where('urg_signos_enfermeria.fecha_turno',$fecha_turno);
	$this->db->where('urg_signos_enfermeria.hora',$hora);
	$result = $this->db->get();
    $num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
		
	}
	
	
////////////////////////////////////////////
	/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA

 *Autor: Diego Ivan Carvajal Gil<dcarvajal@opuslibertati.org>
*/
	
///////////////////////////signos vitales/////////////////////////////////////////////////////////////
	function crearSvNotaDbMinute($d)
	{
		
		$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
		$minute = date('i');
		 if ($hora > '00:00' && $hora < 07)
	 {
		 $fecha_turno = date('Y-m-d', strtotime("$hoy - 1 day"));
		 
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
				'saturacion_oxigeno'=> $d['saturacion_oxigeno'],
				'tencion_arterial_m'=>$d['tencion_arterial_m'],
				'fecha_turno' =>  $fecha_turno,
				'hora'=> $d['hora'],
				'minuto' =>$minute,
				'signos_ingresados'=> 'SI',
				'fecha_nota' => date('Y-m-d H:i'));
				$this->db->insert('urg_signos_enfermeria',$insert);
				$id_nota = $this->db->insert_id();
				//----------------------------------------------------
				return $id_nota;
		
		
		
						
						
	 }else{
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
				'saturacion_oxigeno'=> $d['saturacion_oxigeno'],
				'tencion_arterial_m'=>$d['tencion_arterial_m'],
				'fecha_turno' => date('Y-m-d'),
				'hora'=> $d['hora'],
				'minuto' =>$minute,
				'signos_ingresados'=> 'SI',
				'fecha_nota' => date('Y-m-d H:i'));
				$this->db->insert('urg_signos_enfermeria',$insert);
				$id_nota = $this->db->insert_id();
				//----------------------------------------------------
				return $id_nota;
		
	 }
	 //////////
	}	
	
	
/////////////////////////////fin///////////////////////////////////////////////





	
}


