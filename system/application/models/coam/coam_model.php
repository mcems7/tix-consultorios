<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Coam_model
 *Tipo: modelo
 *Descripcion: Acceso a datos modulo de consulta ambulatoria
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 06 de abril de 2012
*/
class Coam_model extends Model 
{
////////////////////////////////////////////////////////////
function __construct()
{        
	parent::Model();
	$this->load->database();
}
////////////////////////////////////////////////////////////
/*
* Crea la atencion del paciente mediante su admision
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120301
* @version		20120301
* @return		array[object]
*/
function crearAdmisionDb($d)
{
	$insert = array(
	'id_paciente' => $d['id_paciente'],
	'fecha_ingreso' => date('Y-m-d H:i:s'),
	'fecha_egreso' => '0000-00-00 00:00:00',
	'id_consultorio' => $d['id_consultorio'],
	'id_entidad' => $d['id_entidad'],
	'consulta' => 'NO',
	'admision' => 'NO',
	'id_entidad_pago' => $d['id_entidad_pago'],
	'id_origen' => $d['id_origen'],
	'poliza_soat' => $d['poliza_soat'],
	'id_estado' => '1',
	'id_contrato' => $d['id_contrato'],
	'observaciones_adm' => $d['observaciones_adm'],
	'activo'		=> 'SI',
	'fecha_modificacion' =>	date('Y-m-d H:i:s'),
	'id_usuario_admision' => $this->session->userdata('id_usuario'));
	$this->db->insert('coam_atencion',$insert);
	//----------------------------------------------------
	$id_atencion = $this->db->insert_id();
	//----------------------------------------------------
	return $id_atencion;
}
////////////////////////////////////////////////////////////
function obtenerOrigenesAtencion()
{
	$result = $this->db->get('urg_origen_atencion');
	return $result->result_array();
}
////////////////////////////////////////////////////////////
function obtenerConsultorios()
{
	$this->db->order_by('consultorio','asc');
	$result = $this->db->get('coam_consultorios');
	return $result->result_array();
}
///////////////////////////////////////////////////////////
function obtPacConsultorio($id_consultorio)
{
	$this->db->select('coam_atencion.id_atencion,
	coam_atencion.fecha_ingreso,
	coam_atencion.id_medico_consulta,
	coam_atencion.consulta,
	coam_atencion.id_consultorio,
	core_paciente.genero,
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	core_tercero.numero_documento,
	core_tipo_documentos.tipo_documento,
	coam_estados_atencion.estado,
	core_tercero.fecha_nacimiento,
	coam_atencion.id_estado');
	$this->db->from('coam_atencion');
	$this->db->join('core_paciente','coam_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->join('coam_estados_atencion','coam_atencion.id_estado = coam_estados_atencion.id_estado');
	$this->db->where('coam_atencion.id_consultorio',$id_consultorio);
	$this->db->where('coam_atencion.activo','SI');
	$this->db->order_by('fecha_ingreso','desc');   	
	$result = $this->db->get();
	return $result->result_array();
}
///////////////////////////////////////////////////////////
function obtenerAtencion($id_atencion)
{
	$this->db->select('coam_estados_atencion.estado,
	coam_atencion.id_atencion,
	coam_atencion.id_consultorio,
	coam_atencion.id_paciente,
	coam_atencion.fecha_ingreso,
	coam_atencion.fecha_egreso,
	coam_consultorios.consultorio,
	coam_atencion.consulta,
	coam_atencion.id_entidad,
	coam_atencion.id_medico_consulta,
	coam_atencion.id_entidad_pago,
	coam_atencion.admision,
	coam_atencion.observaciones_adm,
	coam_atencion.id_estado,
	coam_atencion.id_origen,
	coam_atencion.id_contrato,
	coam_atencion.id_causa_externa,
	coam_atencion.activo,
	core_causa_externa.causa_externa');
	$this->db->from('coam_atencion');
	$this->db->join('coam_estados_atencion','coam_atencion.id_estado = coam_estados_atencion.id_estado');
	$this->db->join('urg_origen_atencion','coam_atencion.id_origen = urg_origen_atencion.id_origen','LEFT');
  $this->db->join('core_causa_externa','coam_atencion.id_causa_externa = core_causa_externa.id_causa_externa','LEFT');
  $this->db->join('coam_consultorios','coam_atencion.id_consultorio = coam_consultorios.id_consultorio','LEFT');
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db->get();
	return $result->row_array();
}
///////////////////////////////////////////////////////////
function obtenerListaCausaExterna()
{
	$result = $this->db->get('core_causa_externa');
	return $res = $result -> result_array();
}
///////////////////////////////////////////////////////////
function consulta_ambulatoriaDb($d)
{
	$dat = array();
	$dat['error'] =	$error = false;
	$insert = array(
	'motivo_consulta' => $d['motivo_consulta'],
	'enfermedad_actual' => $d['enfermedad_actual'],
	'revicion_sistemas' => $d['revicion_sistemas'],
	'condiciones_generales' => $d['condiciones_generales'],
	'talla' => $d['talla'],
	'peso' => $d['peso'],
	'frecuencia_cardiaca' => $d['frecuencia_cardiaca'],
	'frecuencia_respiratoria' => $d['frecuencia_respiratoria'],
	'ten_arterial_s' => $d['ten_arterial_s'],
	'ten_arterial_d' => $d['ten_arterial_d'],
	'temperatura' => $d['temperatura'],
	'spo2' => $d['spo2'],
	'analisis' => $d['analisis'],
	'conducta' => $d['conducta'],
	'fecha_ini_consulta' => $d['fecha_ini_consulta'],
	'fecha_fin_consulta' => date('Y-m-d H:i:s'),
	'id_medico' => $d['id_medico'],
	'id_atencion' => $d['id_atencion'],
	'id_usuario' => $this->session->userdata('id_usuario'));
	$r = $this->db->insert('coam_nota_inicial',$insert);
	if($r != 1){
	$error = true;
	return $dat['error'] = $error;}
	$id_consulta = $this->db->insert_id();
	//----------------------------------------------------
	$insertAnt = array(
	'ant_patologicos' => $d['ant_patologicos'],
	'ant_famacologicos' => $d['ant_famacologicos'],
	'ant_toxicoalergicos' => $d['ant_toxicoalergicos'],
	'ant_quirurgicos' => $d['ant_quirurgicos'],
	'ant_familiares' => $d['ant_familiares'],
	'ant_ginecologicos' => $d['ant_ginecologicos'],
	'ant_otros' => $d['ant_otros'],
	'id_consulta' => $id_consulta);
	$this->db->insert('coam_nota_inicial_ant',$insertAnt);
	//----------------------------------------------------
	$insertExa = array(
	'exa_cabeza' => $d['exa_cabeza'],
	'exa_ojos' => $d['exa_ojos'],
	'exa_oral' => $d['exa_oral'],
	'exa_cuello' => $d['exa_cuello'],
	'exa_dorso' => $d['exa_dorso'],
	'exa_torax' => $d['exa_torax'],
	'exa_abdomen' => $d['exa_abdomen'],
	'exa_genito_urinario' => $d['exa_genito_urinario'],
	'exa_extremidades' => $d['exa_extremidades'],
	'exa_neurologico' => $d['exa_neurologico'],
	'exa_piel' => $d['exa_piel'],
	'exa_mental' => $d['exa_mental'],
	'id_consulta' => $id_consulta);
	$r = $this->db->insert('coam_nota_inicial_exa',$insertExa);
	//----------------------------------------------------
	if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
	{
		for($i=0;$i<count($d['dx']);$i++)
		{
			$insert = array(
				'id_diag' 		=> $d['dx'][$i],
				'tipo_dx' 		=> $d['tipo_dx'][$i],
				'id_consulta' 	=> $id_consulta );
			$this->db->insert('coam_nota_inicial_diag', $insert); 
		}
	}
	//----------------------------------------------------	
	$update = array('consulta' => 'SI',
	'id_medico_consulta' => $d['id_medico'],
	'id_estado' => '3',
	'id_causa_externa' => $d['id_causa_externa']);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('coam_atencion ',$update);
	//----------------------------------------------------
	return $dat;
}
////////////////////////////////////////////////////////////
function obtenerNotaInicial($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db ->get('coam_nota_inicial');
	return $result->row_array();
}
////////////////////////////////////////////////////////////
function obtenerNotaInicial_ant($id_consulta)
{
	$this -> db -> where('id_consulta',$id_consulta);
	$result = $this -> db ->get('coam_nota_inicial_ant');
	return $result -> row_array();
}
////////////////////////////////////////////////////////////	
function obtenerNotaInicial_exa($id_consulta)
{
	$this -> db -> where('id_consulta',$id_consulta);
	$result = $this -> db ->get('coam_nota_inicial_exa');
	return $result -> row_array();
}
////////////////////////////////////////////////////////////
function obtenerDxConsulta($id_consulta)
{
	$this->db->select('coam_nota_inicial_diag.id_diag,
	coam_nota_inicial_diag.tipo_dx,
	core_diag_item.diagnostico,
	coam_nota_inicial_diag.id_consulta');
	$this->db->from('coam_nota_inicial_diag');
	$this->db->join('core_diag_item','coam_nota_inicial_diag.id_diag = core_diag_item.id_diag');
	$this->db->where('id_consulta',$id_consulta);
	$result = $this->db->get();
	return  $result->result_array();
}
///////////////////////////////////////////////////////////
function cambiar_estado($id_atencion,$id_estado)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->update('coam_atencion',array('id_estado' => $id_estado));	
}
///////////////////////////////////////////////////////////
function obtenerOrdenes($id_atencion)
{
	$this->db->select('core_tipo_medico.descripcion As tipo,
		core_especialidad.descripcion As esp,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		coam_ordenamiento.id_orden,
		coam_ordenamiento.fecha_creacion,
		coam_ordenamiento.id_atencion,
		coam_ordenamiento.id_medico');
	$this->db->from('coam_ordenamiento');
	$this->db->join('core_medico','coam_ordenamiento.id_medico = core_medico.id_medico');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('coam_ordenamiento.id_atencion',$id_atencion);
	$this->db->order_by('coam_ordenamiento.fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
///////////////////////////////////////////////////////////
function crearOrdenDb($d)
{
	$dat = array();
	$dat['error'] =	$error = false;
	$insert = array(
	'fecha_ini_ord' => $d['fecha_ini_ord'],
	'fecha_creacion' => date('Y-m-d H:i:s'),
	'fecha_modificacion' => date('Y-m-d H:i:s'),
	'id_usuario' => $this -> session -> userdata('id_usuario'),
	'id_medico' => $d['id_medico'],
	'id_atencion' => $d['id_atencion']);
	$r = $this->db->insert('coam_ordenamiento',$insert);
	$dat['id_orden'] = $this->db->insert_id();
	if($r != 1){
		$error = true;
		return $dat['error'] = $error;}
	//----------------------------------------------------------
	if(count($d['atc']) > 0 && strlen($d['atc'][0]) > 0)
	{
		for($i=0;$i<count($d['atc']);$i++)
		{
			$insert = array(
				'atc' 		=> $d['atc'][$i],
				'dosis' 	=> $d['dosis'][$i],
				'id_unidad' => $d['id_unidad'][$i],
				'frecuencia'=> $d['frecuencia'][$i],
				'id_frecuencia'=> $d['id_frecuencia'][$i],
				'id_via'=> $d['id_via'][$i],
				'pos'	=> $d['pos'][$i],
				'observacionesMed'=> $d['observacionesMed'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('coam_orde_medicamentos', $insert);
		}
	}
	//----------------------------------------------------------
	if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
	{
		for($i=0;$i<count($d['cups']);$i++)
		{ 
			$insert = array(
				'cups' 		=> $d['cups'][$i],
				'observacionesCups' => $d['observacionesCups'][$i],
				'cantidadCups' => $d['cantidadCups'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('coam_orde_cups', $insert); 
		}
	}
	//----------------------------------------------------------
	return $dat;
}
///////////////////////////////////////////////////////////
function obtenerOrden($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('coam_ordenamiento');
	return $result->row_array();
}
///////////////////////////////////////////////////////////
function obtenerCupsOrden($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('coam_orde_cups');
	return $result->result_array();	
}
///////////////////////////////////////////////////////////
function obtenerMediOrden($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('coam_orde_medicamentos');
	return $result->result_array();	
}
///////////////////////////////////////////////////////////
function remisionDb($d)
{
	$insert = array(
		'id_atencion' => $d['id_atencion'],
		'id_medico' => $d['id_medico'],
		'id_especialidad' => $d['id_especialidad'],
		'motivo_remision' => $d['motivo_remision'],
		'observacion' => $d['observacion'],
		'fecha_remision' => date('Y-m-d H:i:s')
	);
	$this->db->insert('coam_remision',$insert);
	return $this->db->insert_id();
}
///////////////////////////////////////////////////////////
function obtenerRemision($id_remision)
{
	$this->db->select('*');
	$this->db->from('coam_remision');
	$this->db->join('core_especialidad','coam_remision.id_especialidad = core_especialidad.id_especialidad');
	$this->db->where('id_remision',$id_remision);
	$res = $this->db->get();
	return $res->row_array();
}
///////////////////////////////////////////////////////////
function obtenerRemisiones($id_atencion)
{
		$this->db->select('*');
	$this->db->from('coam_remision');
	$this->db->join('core_especialidad','coam_remision.id_especialidad = core_especialidad.id_especialidad');
	$this->db->order_by('fecha_remision','DESC');
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}	
}
///////////////////////////////////////////////////////////
function incapacidadDb($d)
{
	$insert = array(
		'id_atencion' => $d['id_atencion'],
		'id_medico' => $d['id_medico'],
		'fecha_inicio' => $d['fecha_inicio'],
		'duracion' => $d['duracion'],
		'observacion' => $d['observacion'],
		'fecha_incapacidad' => date('Y-m-d H:i:s')
	);
	$this->db->insert('coam_incapacidad',$insert);
	return $this->db->insert_id();
}
///////////////////////////////////////////////////////////
function obtenerIncapacidad($id_incapacidad)
{
	$this->db->where('id_incapacidad',$id_incapacidad);
	$res = $this->db->get('coam_incapacidad');
	return $res->row_array();
}
///////////////////////////////////////////////////////////
function obtenerIncapacidades($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_incapacidad','DESC');
	$result = $this->db->get('coam_incapacidad');
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}	
}
///////////////////////////////////////////////////////////
function finalizar_atencionDb($id_atencion)
{
	$update = array(
		'fecha_egreso' => date('Y-m-d H:i:s'),
		'id_estado' => '5',
		'activo' => 'NO',
		'fecha_modificacion' => date('Y-m-d H:i:s'));
	$this->db->where('id_atencion',$id_atencion);
	$this->db->update('coam_atencion',$update);	
}
///////////////////////////////////////////////////////////
function listadoTotalAtenciones()
{
	$this->db->select('coam_atencion.id_atencion,
	coam_atencion.fecha_ingreso,
	coam_atencion.id_medico_consulta,
	coam_atencion.consulta,
	coam_atencion.id_consultorio,
	core_paciente.genero,
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	core_tercero.numero_documento,
	core_tipo_documentos.tipo_documento,
	coam_estados_atencion.estado,
	core_tercero.fecha_nacimiento,
	coam_atencion.id_estado,
	coam_consultorios.consultorio');
	$this->db->from('coam_atencion');
	$this->db->join('core_paciente','coam_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->join('coam_estados_atencion','coam_atencion.id_estado = coam_estados_atencion.id_estado');
	$this->db->join('coam_consultorios','coam_atencion.id_consultorio = coam_consultorios.id_consultorio');
	$this->db->where('coam_atencion.activo','SI');
	$this->db->order_by('fecha_ingreso','desc');   	
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}	
}
///////////////////////////////////////////////////////////
function editar_admisionDb($d)
{
	$update = array(
	'id_consultorio' => $d['id_consultorio'],
	'id_entidad' => $d['id_entidad'],
	'id_entidad_pago' => $d['id_entidad_pago'],
	'id_origen' => $d['id_origen'],
	'poliza_soat' => $d['poliza_soat'],
	'id_contrato' => $d['id_contrato'],
	'observaciones_adm' => $d['observaciones_adm'],
	'fecha_modificacion' =>	date('Y-m-d H:i:s'));
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('coam_atencion',$update);
	//----------------------------------------------------
}
///////////////////////////////////////////////////////////
function retiroVoluntario($d)
{
	$insert = array(
		'id_atencion'	=> $d['id_atencion'], 
		'id_medico'		=> $d['id_medico'],
		'fecha_retiro'	=> date('Y-m-d H:i:s'),
		'id_usuario'	=> $this -> session -> userdata('id_usuario')
	);
	$this->db->insert('coam_retiro_voluntario',$insert);
	
	$update = array(
		'fecha_modificacion'=> date('Y-m-d H:i:s'),
		'id_estado'			=> '4',
		'activo'			=> 'NO',
		'fecha_egreso'		=> date('Y-m-d H:i:s')
		);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('coam_atencion',$update);
		
}
///////////////////////////////////////////////////////////
function no_respondeDB($id_atencion)
{	
	$update = array(
		'fecha_modificacion'=> date('Y-m-d H:i:s'),
		'id_estado'			=> '6',
		'activo'			=> 'NO',
		'fecha_egreso'		=> date('Y-m-d H:i:s')
		);
	$this->db->where('id_atencion',$id_atencion);
	$this->db->update('coam_atencion',$update);
		
}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
}