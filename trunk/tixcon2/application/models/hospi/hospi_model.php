<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_model
 *Tipo: modelo
 *Descripcion: Acceso a datos modulo hospitalización
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 01 de marzo de 2012
*/
class Hospi_model extends CI_Model 
{
////////////////////////////////////////////////////////////
function __construct()
{        
	parent::__construct();
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
	'id_servicio' => $d['id_servicio'],
	'id_entidad' => $d['id_entidad'],
	'consulta' => 'NO',
	'admision' => 'SI',
	'remitido' => $d['remitido'],
	'codigo_entidad' => $d['codigo_entidad'],
	'id_entidad_pago' => $d['id_entidad_pago'],
	'id_origen' => $d['id_origen'],
	'poliza_soat' => $d['poliza_soat'],
	'id_estado' => '1',
	'id_contrato' => $d['id_contrato'],
	'ingreso' => $d['ingreso'],
	'observaciones_adm' => $d['observaciones_adm'],
	'activo'		=> 'SI',
	'fecha_modificacion' =>	date('Y-m-d H:i:s'),
	'id_usuario_admision' => $this->session->userdata('id_usuario'));
	$this->db->insert('hospi_atencion',$insert);
	//----------------------------------------------------
	$id_atencion = $this->db->insert_id();
	//----------------------------------------------------
	return $id_atencion;
}
////////////////////////////////////////////////////////////
function obtPacPendientesCamaServicio($id_servicio)
{
	$this->db->select(' 
	  core_tercero.primer_apellido,
	  core_tercero.segundo_apellido,
	  core_tercero.primer_nombre,
	  core_tercero.segundo_nombre,
	  core_tercero.fecha_nacimiento,
	  core_tercero.numero_documento,
	  core_tipo_documentos.tipo_documento,
	  core_cama.id_cama,
	  core_cama.numero_cama,
	  hospi_atencion.id_atencion,
	  hospi_atencion.fecha_ingreso,
	  hospi_atencion.id_cama,
	  hospi_atencion.cama,
	  hospi_atencion.id_servicio');
		$this->db->from('hospi_atencion');
  $this->db->join('core_paciente','hospi_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->join('core_cama','hospi_atencion.id_cama = core_cama.id_cama','left');
  $this->db->where('hospi_atencion.activo','SI');
  $this->db->where('hospi_atencion.cama','NO');
  $this->db->where('hospi_atencion.id_servicio',$id_servicio);
  $result = $this->db->get();
  return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerCamasServicio($id_servicio,$id_estado)
{
	if($id_estado != 0)
	{
		$this->db->where('core_cama.id_estado',$id_estado);	
	}
	$this->db->SELECT('core_cama.id_cama,
	core_cama.id_servicio,
	core_cama.id_estado,
	core_cama.numero_cama,
	core_estados_camas.estado,
	core_estados_camas.icono');
	$this->db->FROM('core_cama');
	$this->db->JOIN('core_estados_camas','core_cama.id_estado = core_estados_camas.id_estado');
	$this->db->where('core_cama.id_servicio',$id_servicio);
	$this->db->order_by('core_cama.numero_cama','ASC');
	$result = $this->db->get();
	return $result->result_array();
}
////////////////////////////////////////////////////////////
function obtenerCamasDispoServicio($id_servicio)
{
	$this->db->where('id_estado','5');
	$this->db->where('id_servicio',$id_servicio);
	$result = $this->db->get('core_cama');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function ingresoServicioDd($id_atencion,$id_cama)
{
	$update = array('id_cama' => $id_cama, 'cama' => 'SI');

	$this->db->where('id_atencion',$id_atencion);
	$this->db->update('hospi_atencion',$update);
	
	$update = array('id_estado' =>'2');
	$this->db->where('id_cama',$id_cama);
	$this->db->update('core_cama',$update);
}
////////////////////////////////////////////////////////////
function obtenerOrigenesAtencion()
{
	$result = $this->db->get('urg_origen_atencion');
	return $result->result_array();
}
////////////////////////////////////////////////////////////
function obtenerServicios()
{
	$this->db->order_by('nombre_servicio','asc');
	$result = $this->db->get('core_servicios_hosp');
	return $result->result_array();
}
////////////////////////////////////////////////////////////
function obtenerEntidadesRemision()
{
	$this-> db->order_by('nombre','asc');
	$result = $this->db->get('core_entidad_remision');
	return $result->result_array();
}
////////////////////////////////////////////////////////////
function obtenerEstadosCamas()
{
	$this->db->where('id_estado <>',1);
	$result = $this->db->get('core_estados_camas');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function activarCamaServicio($id_cama)
{
	$update = array('id_estado' =>'5');
	$this->db->where('id_cama',$id_cama);
	$this->db->update('core_cama',$update);
}
////////////////////////////////////////////////////////////
function detalleCama($id_cama)
{
	$this->db->where('id_cama',$id_cama);
	$result = $this->db->get('core_cama');
	return $result->row_array();
}
////////////////////////////////////////////////////////////
function obtenerAtencionCama($id_cama)
{
	$this->db->select('
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	core_tercero.fecha_nacimiento,
	hospi_atencion.id_atencion,
	core_tercero1.razon_social,
	hospi_atencion.activo,
	hospi_atencion.consulta,
	hospi_atencion.id_cama,
	core_paciente.id_paciente,
	core_causa_externa.causa_externa,
	core_tipo_documentos.tipo_documento');
	$this->db->from('hospi_atencion');
	$this->db->JOIN('core_paciente','hospi_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->JOIN('core_causa_externa','hospi_atencion.id_causa_externa = core_causa_externa.id_causa_externa','LEFT');
	$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->JOIN('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
	$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
	$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->where('hospi_atencion.activo','SI');
	$this->db->where('hospi_atencion.id_cama',$id_cama);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->row_array();
	}	
}
////////////////////////////////////////////////////////////
function obtenerAtencion($id_atencion)
{
	$this->db->select('hospi_estados_atencion.estado,
	hospi_atencion.id_atencion,
	hospi_atencion.id_contrato,
	hospi_atencion.id_servicio,
	hospi_atencion.id_paciente,
	hospi_atencion.fecha_ingreso,
	hospi_atencion.fecha_egreso,
	core_servicios_hosp.nombre_servicio,
	hospi_atencion.consulta,
	hospi_atencion.id_entidad,
	hospi_atencion.id_medico_consulta,
	hospi_atencion.id_entidad_pago,
	hospi_atencion.admision,
	hospi_atencion.observaciones_adm,
	hospi_atencion.remitido,
	hospi_atencion.codigo_entidad,
	hospi_atencion.id_estado,
	hospi_atencion.id_destino,
	hospi_atencion.id_origen,
	hospi_atencion.id_causa_externa,
	hospi_atencion.id_cama,
	hospi_atencion.ingreso,
	hospi_atencion.activo,
	core_causa_externa.causa_externa,
	core_cama.numero_cama,');
	$this->db->from('hospi_atencion');
	$this->db->join('hospi_estados_atencion','hospi_atencion.id_estado = hospi_estados_atencion.id_estado');
	$this->db->join('urg_origen_atencion','hospi_atencion.id_origen = urg_origen_atencion.id_origen','LEFT');
  $this->db->join('core_causa_externa','hospi_atencion.id_causa_externa = core_causa_externa.id_causa_externa','LEFT');
  $this->db->join('core_servicios_hosp','hospi_atencion.id_servicio = core_servicios_hosp .id_servicio','LEFT');
   $this->db->join('core_cama','hospi_atencion.id_cama = core_cama.id_cama','left');
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db->get();
	return $result->row_array();
}
////////////////////////////////////////////////////////////
function notaInicialDb($d)
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
	$r = $this->db->insert('hospi_nota_inicial',$insert);
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
	$this->db->insert('hospi_nota_inicial_ant',$insertAnt);
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
	$r = $this->db->insert('hospi_nota_inicial_exa',$insertExa);
	//----------------------------------------------------
	if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
	{
		for($i=0;$i<count($d['dx']);$i++)
		{
			$insert = array(
				'id_diag' 		=> $d['dx'][$i],
				'tipo_dx' 		=> $d['tipo_dx'][$i],
				'id_consulta' 	=> $id_consulta );
			$this->db->insert('hospi_nota_inicial_diag', $insert); 
		}
	}
	//----------------------------------------------------	
	$update = array('consulta' => 'SI',
	'id_medico_consulta' => $d['id_medico'],
	'id_causa_externa' => $d['id_causa_externa']);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('hospi_atencion ',$update);
	//----------------------------------------------------
	return $dat;
}
////////////////////////////////////////////////////////////
function obtenerNotaInicial($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db ->get('hospi_nota_inicial');
	return $result->row_array();
}
////////////////////////////////////////////////////////////
function obtenerNotaInicial_ant($id_consulta)
{
	$this -> db -> where('id_consulta',$id_consulta);
	$result = $this -> db ->get('hospi_nota_inicial_ant');
	return $result -> row_array();
}
////////////////////////////////////////////////////////////	
function obtenerNotaInicial_exa($id_consulta)
{
	$this -> db -> where('id_consulta',$id_consulta);
	$result = $this -> db ->get('hospi_nota_inicial_exa');
	return $result -> row_array();
}
////////////////////////////////////////////////////////////
function obtenerDxConsulta($id_consulta)
{
	$this->db->select('hospi_nota_inicial_diag.id_diag,
	hospi_nota_inicial_diag.tipo_dx,
	core_diag_item.diagnostico,
	hospi_nota_inicial_diag.id_consulta');
	$this->db->from('hospi_nota_inicial_diag');
	$this->db->join('core_diag_item','hospi_nota_inicial_diag.id_diag = core_diag_item.id_diag');
	$this->db->where('id_consulta',$id_consulta);
	$result = $this->db->get();
	return  $result->result_array();
}
////////////////////////////////////////////////////////////
function obtenerDxEvoluciones($id_atencion)
{
	$this->db->SELECT('
	hospi_atencion.id_atencion,
	hospi_evoluciones.id_evolucion,
	hospi_evolucion_diag.id_diag,
	hospi_evolucion_diag.tipo_dx,
	core_diag_item.diagnostico');
	$this->db->FROM('hospi_atencion');
	$this->db->JOIN('hospi_evoluciones','hospi_atencion.id_atencion = hospi_evoluciones.id_atencion');
	$this->db->JOIN('hospi_evolucion_diag','hospi_evoluciones.id_evolucion = hospi_evolucion_diag.id_evolucion');
	$this->db->JOIN('core_diag_item','hospi_evolucion_diag.id_diag = core_diag_item.id_diag');
	$this->db->where('hospi_atencion.id_atencion',$id_atencion);
	$this->db->GROUP_BY('hospi_evolucion_diag.id_diag');
	$result = $this->db->get();
	return $result->result_array();
}
////////////////////////////////////////////////////////////
function liberarCama($id_cama)
{
	$update = array('id_estado' => '3');
	$this->db->where('id_cama',$id_cama);
	$this->db->update('core_cama',$update);			
}
////////////////////////////////////////////////////////////
function cambiarCamaHospiDb($id_atencion,$id_cama)
{
	$update = array(
		'id_cama' => $id_cama);
	$this->db->where('id_atencion',$id_atencion);
	$this->db->update('hospi_atencion',$update);
	
	$update = array('id_estado' =>'2');
	$this->db->where('id_cama',$id_cama);
	$this->db->update('core_cama',$update);
}
////////////////////////////////////////////////////////////
function obtenerEvoluciones($id_atencion)
{
	$this->db->select('core_especialidad.descripcion As esp,
	core_medico.id_medico,
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	hospi_evoluciones.id_evolucion,
	hospi_evoluciones.fecha_evolucion,
	hospi_evoluciones.id_atencion,
	core_evoluciones_tipo.tipo_evolucion');
	$this->db->from('hospi_evoluciones');
	$this->db->join('core_medico','hospi_evoluciones.id_medico = core_medico.id_medico');
	$this->db->join('core_evoluciones_tipo','hospi_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_evolucion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
////////////////////////////////////////////////////////////
function obtenerEvolucion($id_evolucion)
{
	$this->db->select('core_especialidad.descripcion As esp,
	core_medico.id_medico,
	core_medico.tarjeta_profesional,
	core_tipo_medico.descripcion,
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	hospi_evoluciones.id_evolucion,
	hospi_evoluciones.subjetivo,
	hospi_evoluciones.objetivo,
	hospi_evoluciones.analisis,
	hospi_evoluciones.conducta,
	hospi_evoluciones.fecha_evolucion,
	hospi_evoluciones.id_atencion,
	core_evoluciones_tipo.tipo_evolucion');
	$this->db->from('hospi_evoluciones');
	$this->db->join('core_medico','hospi_evoluciones.id_medico = core_medico.id_medico');
	$this->db->join('core_evoluciones_tipo','hospi_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_evolucion',$id_evolucion);
	$result = $this->db->get();
	return $result->row_array();
}
////////////////////////////////////////////////////////////
function obtenerDxEvolucion($id_evolucion)
{
	$this->db->select('hospi_evolucion_diag.id_diag,hospi_evolucion_diag.tipo_dx, core_diag_item.diagnostico,hospi_evolucion_diag.id_evolucion');
	$this->db->from('hospi_evolucion_diag');
	$this->db->join('core_diag_item','hospi_evolucion_diag.id_diag = core_diag_item.id_diag');
	$this->db->where('id_evolucion',$id_evolucion);
	$result = $this->db->get();
	return  $result->result_array();
}
////////////////////////////////////////////////////////////
function crearEvolucionDb($d)
{
	$insert = array(
		'id_tipo_evolucion' => $d['id_tipo_evolucion'],
		'subjetivo' => $d['subjetivo'],
		'objetivo' => $d['objetivo'],
		'analisis' => $d['analisis'],
		'conducta' => $d['conducta'],
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion'],
		'fecha_evolucion' => date('Y-m-d H:i:s'));
	$this->db->insert('hospi_evoluciones',$insert);
	$id_evolucion = $this->db->insert_id();
	//----------------------------------------------------
	if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
	{
		for($i=0;$i<count($d['dx']);$i++)
		{
			$insert = array(
				'tipo_dx' 		=> $d['tipo_dx'][$i],
				'id_diag' 		=> $d['dx'][$i],
				'id_evolucion' 	=> $id_evolucion );
			$this->db->insert('hospi_evolucion_diag', $insert); 
		}
	}
	//----------------------------------------------------
	return $id_evolucion;
}
////////////////////////////////////////////////////////////
function obtenerUltEvolucion($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_evolucion','DESC');
	$result = $this->db->get('hospi_evoluciones');
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->first_row('array');
	}	
}
////////////////////////////////////////////////////////////
function obtenerOrdenes($id_atencion)
{
	$this->db->select('core_tipo_medico.descripcion As tipo,
		core_especialidad.descripcion As esp,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		hospi_ordenamiento.id_orden,
		hospi_ordenamiento.id_servicio,
		hospi_ordenamiento.fecha_creacion,
		hospi_ordenamiento.id_atencion,
		hospi_ordenamiento.insumos_despacho,
		hospi_ordenamiento.id_medico,
		hospi_ordenamiento.insumos');
	$this->db->from('hospi_ordenamiento');
	$this->db->join('core_medico','hospi_ordenamiento.id_medico = core_medico.id_medico');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->where('hospi_ordenamiento.id_atencion',$id_atencion);
	$this->db->order_by('hospi_ordenamiento.fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
////////////////////////////////////////////////////////////
function crearOrdenDb($d)
{
	$dat = array();
	$dat['error'] =	$error = false;
	$insert = array(
	'cama_cabeza' => $d['cama_cabeza'],
	'cama_pie' => $d['cama_pie'],
	'oxigeno' => $d['oxigeno'],
	'id_tipo_oxigeno' => $d['id_oxigeno'],
	'id_oxigeno_valor' => $d['id_oxigeno_valor'],
	'liquidos' => $d['liquidos'],
	'cuidados_generales' => $d['cuidados_generales'],
	'fecha_ini_ord' => $d['fecha_ini_ord'],
	'fecha_creacion' => date('Y-m-d H:i:s'),
	'fecha_modificacion' => date('Y-m-d H:i:s'),
	'id_servicio' => $d['id_servicio'],
	'id_usuario' => $this -> session -> userdata('id_usuario'),
	'id_medico' => $d['id_medico'],
	'id_atencion' => $d['id_atencion']);
	$r = $this->db->insert('hospi_ordenamiento',$insert);
	$dat['id_orden'] = $this->db->insert_id();
	if($r != 1){
		$error = true;
		return $dat['error'] = $error;}
	//----------------------------------------------------------
	if(count($d['id_dieta']) > 0 && strlen($d['id_dieta'][0]) > 0)
	{
		for($i=0;$i<count($d['id_dieta']);$i++)
		{
			$insert = array(
				'id_dieta' 		=> $d['id_dieta'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('hospi_orde_dietas', $insert); 
		}
	}
	//----------------------------------------------------------
	if(count($d['id_cuidado']) > 0 && strlen($d['id_cuidado'][0]) > 0)
	{
		for($i=0;$i<count($d['id_cuidado']);$i++)
		{
			$insert = array(
				'id_cuidado' => $d['id_cuidado'][$i],
				'frecuencia_cuidado' => $d['frecuencia_cuidado'][$i],
				'id_frecuencia_cuidado' => $d['id_frecuencia_cuidado'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('hospi_orde_cuidados', $insert); 
		}
	}
	//----------------------------------------------------------
	if(count($d['atc']) > 0 && strlen($d['atc'][0]) > 0)
	{
		for($i=0;$i<count($d['atc']);$i++)
		{
			//No se guardan los medicamentos modificados
			if($d['bandera'][$i] != "Quitar"){
			$insert = array(
				'atc' 		=> $d['atc'][$i],
				'dosis' 	=> $d['dosis'][$i],
				'id_unidad' => $d['id_unidad'][$i],
				'frecuencia'=> $d['frecuencia'][$i],
				'id_frecuencia'=> $d['id_frecuencia'][$i],
				'id_via'=> $d['id_via'][$i],
				'pos'	=> $d['pos'][$i],
				'observacionesMed'=> $d['observacionesMed'][$i],
				'estado'=> $d['bandera'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('hospi_orde_medicamentos', $insert);
			}
		}
	}
	//----------------------------------------------------------
	if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
	{
		for($i=0;$i<count($d['cups']);$i++)
		{ 
			if(substr($d['cups'][$i], 0, -6) == '90.')
			{
			$insert = array(
				'cups' 		=> $d['cups'][$i],
				'observacionesCups' => $d['observacionesCups'][$i],
				'cantidadCups' => $d['cantidadCups'][$i],
				'id_orden' 		=> $dat['id_orden']);
								
			$this->db->insert('hospi_orde_laboratorios', $insert);
		
			}	
			
			elseif ((substr($d['cups'][$i], 0, -6) == '87.') || (substr($d['cups'][$i], 0, -6) == '88.'))
			{
			$insert = array(
				'cups' 		=> $d['cups'][$i],
				'observacionesCups' => $d['observacionesCups'][$i],
				'cantidadCups' => $d['cantidadCups'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('hospi_orde_imagenes', $insert); 
			}
			
			else
			{
			$insert = array(
				'cups' 		=> $d['cups'][$i],
				'observacionesCups' => $d['observacionesCups'][$i],
				'cantidadCups' => $d['cantidadCups'][$i],
				'id_orden' 		=> $dat['id_orden'] );
			$this->db->insert('hospi_orde_cups', $insert); 
			}
		}
	}
	//----------------------------------------------------------
	return $dat;
}
////////////////////////////////////////////////////////////
function obtenerUltOrden($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_creacion','DESC');
	$result = $this->db->get('hospi_ordenamiento');
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->first_row('array');
	}	
}
////////////////////////////////////////////////////////////
function obtenerDietasOrden($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_dietas');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerCuidadosOrden($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_cuidados');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerMediOrdenNueva($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$this->db->where('estado <>','Suspendido');
	$result = $this->db->get('hospi_orde_medicamentos');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerCupsOrden($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_cups');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerCupsLaboratorios($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_laboratorios');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerCupsImagenes($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_imagenes');
	return $result->result_array();	
}
////////////////////////////////////////////////////////////
function obtenerMediOrdenModiId($id_orden,$id)
{
	$this->db->where('id_orden',$id_orden);
	$this->db->where('id',$id);
	$res = $this->db->get('hospi_orde_medicamentos ');
	return $res->row_array();
}
////////////////////////////////////////////////////////////
function obtenerOrden($id_orden)
{
	$this->db->select('');
	$this->db->from('hospi_ordenamiento');
	$this->db->join('core_oxigeno','hospi_ordenamiento.id_tipo_oxigeno = core_oxigeno.id_oxigeno','left');
	$this->db->join('core_oxigeno_tipo','hospi_ordenamiento.id_oxigeno_valor = core_oxigeno_tipo.id_oxigeno_valor','left');
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get();
	return $result->row_array();
}
////////////////////////////////////////////////////////////
function obtenerContratosEntidad($id_entidad)
{
	$this->db->where('id_entidad',$id_entidad);
	$res = $this->db->get('core_contrato');
	return $res->result_array();
}
///////////////////////////////////////////////////////////
function obtenerMediOrdenInsu($id_orden)
{
	$this->db->where('id_orden',$id_orden);
	$this->db->where('estado <>','Continua');
	$result = $this->db->get('hospi_orde_medicamentos');
	return $result->result_array();	
}
///////////////////////////////////////////////////////////
function crearOrdenInsumosDb($d)
{
	$dat = array();
	$dat['error'] = $error = false;
	$insert = array(
	'id_usuario' => $this -> session -> userdata('id_usuario'),
	'id_medico' => $d['id_medico'],
	'fecha_creacion' => date('Y-m-d H:i:s'),
	'id_servicio' => $d['id_servicio'],
	'id_orden' => $d['id_orden']);
	$r = $this->db->insert('hospi_orde_insumos',$insert);
	$dat['id_orden'] = $this->db->insert_id();
	if($r != 1){
	  $error = true;
	  return $dat['error'] = $error;}
	//----------------------------------------------------------
	$update = array('insumos' => 'SI');
	$this->db->where('id_orden',$d['id_orden']);
	$this->db->update('hospi_ordenamiento',$update);
	//----------------------------------------------------------
	if(count($d['codigo_insumo']) > 0 && strlen($d['codigo_insumo'][0]) > 0)
	{
	  for($i=0;$i<count($d['codigo_insumo']);$i++)
	  {
		$insert = array(
		  'id_insumo'    => $d['codigo_insumo'][$i],
		  'cantidad'    => $d['cantidad'][$i],
		  'observaciones'    => $d['observaciones'][$i],
		   'pagador'    => $d['pagador'][$i],
		  'id_orden_insumos'    => $dat['id_orden'] );
		$this->db->insert('hospi_orde_insumos_detalle', $insert); 
	  }
	}
	//----------------------------------------------------------
	return $dat;  
}
///////////////////////////////////////////////////////////
function obtenerOrdenInsumos($id_orden)
{
	$this->db->select(' 
	hospi_orde_insumos_detalle.id_insumo,
	core_insumos.insumo,
	core_insumos.codigo_interno,
	hospi_orde_insumos_detalle.cantidad,
	hospi_orde_insumos_detalle.observaciones');
	$this->db->from('core_insumos');
	$this->db->join('hospi_orde_insumos_detalle','core_insumos.id_insumo = hospi_orde_insumos_detalle.id_insumo');
	$this->db->join('hospi_orde_insumos','hospi_orde_insumos.id_orden_insumos = hospi_orde_insumos_detalle.id_orden_insumos');
	$this->db->where('hospi_orde_insumos.id_orden',$id_orden);
	$result = $this->db->get();
	return $res = $result -> result_array();
}
///////////////////////////////////////////////////////////
function obtenerListaCausaExterna()
{
	$result = $this->db->get('core_causa_externa');
	return $res = $result -> result_array();
}
///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMediAtencion($id_atencion)
	{
		$this->db->SELECT(' 
   hospi_atencion.id_atencion,
  hospi_orde_medicamentos.observacionesMed,
  hospi_orde_medicamentos.id_via,
  hospi_orde_medicamentos.frecuencia,
  hospi_orde_medicamentos.dosis,
  hospi_orde_medicamentos.atc,
  hospi_orde_medicamentos.id_frecuencia,
  hospi_orde_medicamentos.id_unidad');
$this->db->FROM('hospi_atencion');
$this->db->JOIN('hospi_ordenamiento','hospi_atencion.id_atencion = hospi_ordenamiento.id_atencion');
$this->db->JOIN('hospi_orde_medicamentos','hospi_ordenamiento.id_orden = hospi_orde_medicamentos.id_orden');
$this->db->WHERE('hospi_atencion.id_atencion',$id_atencion);
$this->db->group_by('hospi_orde_medicamentos.atc');	
$result = $this->db->get();
return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerDestinos()
{
	$result = $this->db->get('hospi_destino_egreso');
	return $result->result_array();	
}	
///////////////////////////////////////////////////////////
function epicrisisDb($d)
{
	$dat = array();
	
	$insert = array(
	'id_atencion' 		=> $d['id_atencion'],
	'id_medico' 		=> $d['id_medico'],
	'fecha_egreso' 		=> $d['fecha_egreso'],
	'id_servicio' 		=> $d['id_servicio'],
	'estado_salida' 	=> $d['estado_salida'],
	'tiempo_muerto' 	=> $d['tiempo_muerto'],
	'incapacidad' 		=> $d['incapacidad'],
	'incapacidad_dias' 	=> $d['incapacidad_dias'],
	'examenes_auxiliares'=> $d['examenes_auxiliares'],
	'traslado' 			=> $d['traslado'],
	'nivel_traslado' 	=> $d['nivel_traslado'],
	'lugar_traslado' 	=> $d['lugar_traslado'],
	'cita_con_ext' 		=> $d['cita_con_ext'],
	'id_especialidad' 	=> $d['id_especialidad'],
	'cita_conext' 		=> $d['cita_conext'],
	'cita_hosp_local' 	=> $d['cita_hosp_local'],
	'municipio_cita' 	=> $d['municipio_cita'],
	'cita_hopslocal' 	=> $d['cita_hopslocal'],
	'id_destino' 		=> $d['id_destino'],
	'id_usuario' 		=> $this -> session -> userdata('id_usuario'),
	'fecha_modificacion'=> date('Y-m-d H:i:s'));
	$this -> db -> insert('hospi_epicrisis',$insert);
	$dat['id_epicrisis'] = $this->db->insert_id();
	
	//----------------------------------------------------
	if(count($d['dxI']) > 0 && strlen($d['dxI'][0]) > 0)
	{
		for($i=0;$i<count($d['dxI']);$i++)
		{
			$insert = array(
				'id_diag' 		=> $d['dxI'][$i],
				'tipo_dx'		=> 'ingreso',
				'id_epicrisis' 	=> $dat['id_epicrisis'] );
			$this->db->insert('hospi_epicrisis_dx', $insert); 
		}
	}
	//----------------------------------------------------
	if(count($d['dxE']) > 0 && strlen($d['dxE'][0]) > 0)
	{
		for($i=0;$i<count($d['dxE']);$i++)
		{
			$insert = array(
				'id_diag' 		=> $d['dxE'][$i],
				'tipo_dx'		=> 'egreso',
				'id_epicrisis' 	=> $dat['id_epicrisis'] );
			$this->db->insert('hospi_epicrisis_dx', $insert); 
		}
	}
	//----------------------------------------------------	
	if(count($d['evos']) > 0 && strlen($d['evos'][0]) > 0)
	{
		for($i=0;$i<count($d['evos']);$i++)
		{
			$insert = array(
				'id_evolucion' 	=> $d['evos'][$i],
				'id_epicrisis' 	=> $dat['id_epicrisis'] );
			$this->db->insert('hospi_epicrisis_evo', $insert); 
		}
	}
	//----------------------------------------------------		
	if($d['estado_salida'] == 'Muerto'){
		$estado = 4;	
	}else{
		$estado = $this->obtenerestadoDestino($d['id_destino']);
	}
	$update = array(
	'fecha_egreso' =>  $d['fecha_egreso'],
	'id_estado' => $estado,
	'activo' => 'NO',
	'id_destino' => $d['id_destino'],
	'id_usuario_egreso' => $this -> session -> userdata('id_usuario'),);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('hospi_atencion',$update);
}
///////////////////////////////////////////////////////////
function obtenerestadoDestino($id_destino)
{
	$this -> db -> where('id_destino',$id_destino);
	$result = $this -> db -> get('hospi_destino_egreso');
	$d = $result->row_array();
	return $d['id_estado'];
}
///////////////////////////////////////////////////////////
function obtenerEpicrisis($id_atencion)
{
	
	$this->db->FROM('hospi_epicrisis');
	$this->db->JOIN('core_especialidad','hospi_epicrisis.id_especialidad = core_especialidad.id_especialidad','left');
	$this->db->JOIN('hospi_destino_egreso','hospi_epicrisis.id_destino = hospi_destino_egreso.id_destino');
	
	$this->db->WHERE('id_atencion',$id_atencion);
	$result = $this->db->get();

	return $result->row_array();
}
///////////////////////////////////////////////////////////
function obtenerEvosEpicrisis($id_epicrisis)
{
	$this->db->SELECT('
  hospi_epicrisis_evo.id_epicrisis,
  hospi_evoluciones.id_evolucion, 
  hospi_evoluciones.subjetivo,
  hospi_evoluciones.objetivo,
  hospi_evoluciones.analisis,
  hospi_evoluciones.conducta,
  hospi_evoluciones.fecha_evolucion,
  core_evoluciones_tipo.tipo_evolucion,
  core_especialidad.descripcion As esp,
  core_medico.tarjeta_profesional,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre');
$this->db->FROM('hospi_epicrisis_evo');
$this->db->JOIN('hospi_evoluciones','hospi_epicrisis_evo.id_evolucion = hospi_evoluciones.id_evolucion');
$this->db->JOIN('core_evoluciones_tipo','hospi_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
$this->db->JOIN('core_medico','hospi_evoluciones.id_medico = core_medico.id_medico');
$this->db->JOIN('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->where('hospi_epicrisis_evo.id_epicrisis',$id_epicrisis);
$res = $this->db->get();
return $res->result_array();
}
///////////////////////////////////////////////////////////
function obtenerDxEpiI($id_epicrisis)
{
	$this->db->SELECT(' 
	core_diag_item.diagnostico,
	hospi_epicrisis_dx.id_diag,
	hospi_epicrisis_dx.id_epicrisis,
	hospi_epicrisis_dx.tipo_dx');
	$this->db->FROM('core_diag_item');
	$this->db->JOIN('hospi_epicrisis_dx','core_diag_item.id_diag = hospi_epicrisis_dx.id_diag');
	$this->db->where('hospi_epicrisis_dx.tipo_dx','ingreso');
	$this->db->where('hospi_epicrisis_dx.id_epicrisis',$id_epicrisis);
	$res = $this->db->get();
	return $res->result_array();
}
///////////////////////////////////////////////////////////
function obtenerDxEpiE($id_epicrisis)
{
	$this->db->SELECT(' 
	core_diag_item.diagnostico,
	 hospi_epicrisis_dx.id_diag,
	hospi_epicrisis_dx.id_epicrisis,
	hospi_epicrisis_dx.tipo_dx');
	$this->db->FROM('core_diag_item');
	$this->db->JOIN('hospi_epicrisis_dx','core_diag_item.id_diag = hospi_epicrisis_dx.id_diag');
	$this->db->where('hospi_epicrisis_dx.tipo_dx','egreso');
	$this->db->where('hospi_epicrisis_dx.id_epicrisis',$id_epicrisis);
	$res = $this->db->get();
	return $res->result_array();
}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
}