<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Urgencias_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 26 de agosto de 2010
*/
class Urgencias_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarAtencionUrg($d)
	{
		$this->db->select('
		core_tercero.numero_documento,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		urg_atencion.fecha_ingreso,
		urg_atencion.id_servicio,
		urg_atencion.id_estado,
		core_servicios_hosp.nombre_servicio,
		urg_atencion.id_atencion');
		$this->db->from('core_tercero');
		$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  	$this->db->join('urg_atencion','core_paciente.id_paciente = urg_atencion.id_paciente');
	$this -> db ->JOIN('core_servicios_hosp','urg_atencion.id_servicio = core_servicios_hosp.id_servicio');
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
		
		
	    $this->db->where('urg_atencion.activo','SI');
		$this->db->where('urg_atencion.id_estado <>','1');
		$this->db->where('urg_atencion.id_estado <>','2');
		$this->db->where('urg_atencion.id_estado <>','7');
		$this->db->where('urg_atencion.id_estado <>','8');
		$this->db->where('urg_atencion.id_estado <>','9');
			
			
			
		
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene la información de un tercero
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100830
* @version		20100830
* @return		array[object]
*/
	function obtenerTercero($id_tercero)
	{
		$this -> db -> select('core_tipo_documentos.tipo_documento,
			  core_tercero.id_tercero,
			  core_tercero.primer_apellido,
			  core_tercero.segundo_apellido,
			  core_tercero.primer_nombre,
			  core_tercero.segundo_nombre,
			  core_tercero.numero_documento,
			  core_tercero.fecha_nacimiento');
		$this -> db -> from('core_tercero');
		$this -> db -> join('core_tipo_documentos',
		'core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento',
		'left');
		$this-> db -> where('id_tercero',$id_tercero);
		$this->db->limit(1);
		$result = $this -> db -> get();
		return $result -> row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
/*
* Almacena en la base de datos la información del tercero
*
*La información es almacenada en la tabla principal de terceros, una copia es 
*almacenada en una tabla que guarda el historial de las modificaciones realizadas al tercero
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100830
* @version		20100830
* @return		array[object]
*/	
	function editarTerceroDb($d)
	{
		$update = array(
		'primer_apellido' => $d['primer_apellido'],
		'segundo_apellido' => $d['segundo_apellido'], 	
		'primer_nombre' => $d['primer_nombre'], 	
		'segundo_nombre' => $d['segundo_nombre'], 	
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'],
		'fecha_nacimiento' => $d['fecha_nacimiento'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_tercero',$d['id_tercero']);
		$this -> db -> update('core_tercero',$update);
		//----------------------------------------------------	
		$insert = array(
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' => $d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('core_tercero_detalle',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function editarPacienteDb($d)
	{
		$update = array(
		'genero' => $d['genero'], 	
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> where('id_paciente',$d['id_paciente']);
		$this -> db -> update('core_paciente',$update);
		//----------------------------------------------------
		$insert = array(	
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_paciente' =>	$d['id_paciente'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('core_paciente_detalle',$insert);
		//----------------------------------------------------	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearTerceroUrg($d)
	{
		$insert = array(
		'primer_apellido' => $d['primer_apellido'],
		'segundo_apellido' => $d['segundo_apellido'], 	
		'primer_nombre' => $d['primer_nombre'], 	
		'segundo_nombre' => $d['segundo_nombre'], 	
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'],
		'fecha_nacimiento' => $d['fecha_nacimiento'],
		'pais' => '52',
		'departamento' => '63',
		'municipio' => '63001',
		'email'=> 'correo@dominio.com',
		'fecha_creacion' => date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario') );
		$this -> db -> insert('core_tercero',$insert);
		//----------------------------------------------------
		$id_tercero = $this->db->insert_id();
		//----------------------------------------------------
		$insert = array(
		'id_tipo_documento' => $d['id_tipo_documento'], 	
		'numero_documento' => $d['numero_documento'], 	
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' => $id_tercero,
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('core_tercero_detalle',$insert);
		//----------------------------------------------------
		return $id_tercero;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function crearPacienteUrg($d)
	{
		$insert = array(
		'genero' => $d['genero'],
		'fecha_creacion' =>	date('Y-m-d H:i:s'),
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_tercero' =>	$d['id_tercero'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('core_paciente',$insert);
		//----------------------------------------------------
		$id_paciente = $this->db->insert_id();
		//----------------------------------------------------
		$insert = array(	
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_paciente' =>	$id_paciente,
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('core_paciente_detalle',$insert);
		//----------------------------------------------------
		return $id_paciente;	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function crearAtencionDb($d)
	{
		if($d['clasificacion'] == '4'){
			$fecha_egreso = date('Y-m-d H:i:s');
		}else{
			$fecha_egreso = '0000-00-00 00:00:00';
		}
		
		$insert = array(
		'id_paciente' => $d['id_paciente'],
		'reingreso' => $d['reingreso'],
		'ingreso' => $d['ingreso'],
		'clasificacion' => $d['clasificacion'],
		'remitido' => $d['remitido'],
		'codigo_entidad' => $d['codigo_entidad'],
		'fecha_ingreso' => date('Y-m-d H:i:s'),
		'fecha_egreso' => $fecha_egreso,
		'id_estado' => $d['estado'],
		'embarazo' => $d['embarazo'],
		'id_servicio' => $d['id_servicio'],
		'activo'		=> $d['activo'],
		'fecha_modificacion' =>	date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('urg_atencion',$insert);
		//----------------------------------------------------
		$id_atencion = $this->db->insert_id();
		//----------------------------------------------------
		$insert = array('id_estado' => $d['estado'],
						'id_usuario' => $this -> session -> userdata('id_usuario'),
						'id_atencion' => $id_atencion,
						'id_servicio' => $d['id_servicio'],
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_atencion_detalle',$insert);
		
		return $id_atencion;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function crearTriageDb($d)
	{
		$dat = array();
		$dat['error'] =	$error = false;
		$insert = array(
		'motivo_consulta' => $d['motivo_consulta'],
		'antecedentes' => $d['antecedentes'],
		'frecuencia_cardiaca' => $d['frecuencia_cardiaca'],
		'frecuencia_respiratoria' => $d['frecuencia_respiratoria'],
		'ten_arterial_s' => $d['ten_arterial_s'],
		'ten_arterial_d' => $d['ten_arterial_d'],
		'temperatura' => $d['temperatura'],
		'spo2' => $d['spo2'],
		'resp_ocular' => $d['resp_ocular'],
		'resp_verbal' => $d['resp_verbal'],
		'resp_motora' => $d['resp_motora'],
		'clasificacion' => $d['clasificacion'],
		'just_blanco' => $d['just_blanco'],
		'recomendaciones' => $d['recomendaciones'],
		'fecha_ini_triage' => $d['fecha_ini_triage'],
		'fecha_fin_triage' => date('Y-m-d H:i:s'),
		'id_medico' => $d['id_medico'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_atencion' => $d['id_atencion']);
		$r = $this -> db -> insert('urg_triage',$insert);
		$dat['id_triage'] = $this->db->insert_id();
		if($r != 1){
			$error = true;
			return $dat['error'] = $error;}
		//----------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerIdMedico($id_usuario)
	{
		$this->db->select('core_medico.id_medico,core_usuario.id_usuario');
		$this->db->from('core_tercero');
		$this->db->join('core_medico','core_tercero.id_tercero = core_medico.id_tercero');
		$this->db->join('core_usuario','core_tercero.numero_documento = core_usuario.numero_documento');
		$this->db->where('core_usuario.id_usuario',$id_usuario);
		$this->db->limit(1);
		$result = $this ->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> row_array();
		return  $res['id_medico'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
$this->db->where('urg_atencion.id_estado <>',5);
$this->db->where('urg_atencion.id_estado <>',1);
$this->db->where('urg_atencion.id_estado <>',6);
$this->db->where('urg_atencion.id_estado <>',7); 
$this->db->where('urg_atencion.id_estado <>',8);
$this->db->where('urg_atencion.id_estado <>',10);
$this->db->order_by('urg_triage.clasificacion', 'asc'); 
$this->db->order_by('fecha_ingreso','desc');   	
$result = $this->db->get();
return $result->result_array();
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAtencion($id_atencion)
	{
		$this->db->select('urg_estados_atencion.estado,
  urg_atencion.id_atencion,
  urg_atencion.id_servicio,
  urg_atencion.id_paciente,
  urg_atencion.fecha_ingreso,
  urg_atencion.cama,
  urg_atencion.fecha_egreso,
 core_servicios_hosp.nombre_servicio,
  urg_atencion.clasificacion,
  urg_atencion.consulta,
  urg_atencion.id_entidad,
  urg_atencion.id_entidad_pago,
  urg_atencion.id_medico_consulta,
  urg_atencion.admision,
  urg_atencion.reingreso,
  urg_atencion.observaciones_adm,
  urg_atencion.remitido,
  urg_atencion.codigo_entidad,
  urg_atencion.id_estado,
  urg_atencion.id_destino,
  urg_atencion.id_origen,
  urg_atencion.ingreso,
  urg_atencion.activo,
  urg_atencion.id_usuario,
  urg_atencion.anexo2,
  urg_origen_atencion.origen');
  $this->db->from('urg_atencion');
  $this->db->join('urg_estados_atencion','urg_atencion.id_estado = urg_estados_atencion.id_estado');
  $this->db->join('urg_origen_atencion','urg_atencion.id_origen = urg_origen_atencion.id_origen','LEFT');
  $this->db->join('core_servicios_hosp','urg_atencion.id_servicio = core_servicios_hosp .id_servicio','LEFT');
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('urg_atencion.id_atencion','DESC');
	$this->db->limit(1);
	$result = $this->db->get();
	return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEntidad($id_entidad)
	{
		$this->db->select('core_tercero.razon_social,
  core_tercero.id_tipo_documento,
  core_tercero.numero_documento,
  core_eapb.id_entidad,
  core_eapb.codigo_eapb,
  core_tercero.id_tercero');
		$this->db->from('core_eapb');
  		$this->db->join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
		$this->db->where('core_eapb.id_entidad',$id_entidad);
	$this->db->limit(1);
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTriage($id_atencion)
	{
		$this->db->select('urg_triage.fecha_fin_triage,
  urg_triage.fecha_ini_triage,
  urg_triage.id_triage,
  urg_triage.clasificacion,
  urg_triage.resp_verbal,
  urg_triage.resp_motora,
  urg_triage.spo2,
  urg_triage.resp_ocular,
  urg_triage.temperatura,
  urg_triage.ten_arterial_d,
  urg_triage.ten_arterial_s,
  urg_triage.frecuencia_respiratoria,
  urg_triage.frecuencia_cardiaca,
  urg_triage.antecedentes,
  urg_triage.motivo_consulta,
  urg_triage.just_blanco,
  urg_triage.recomendaciones,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_medico.tarjeta_profesional,
  urg_triage.id_atencion');
  		$this->db->from('urg_triage');
		$this->db->join('core_medico','urg_triage.id_medico = core_medico.id_medico');
		$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('urg_triage.id_atencion','DESC');
	$this->db->limit(1);
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDxCap()
	{
		$result = $this->db->get('core_diag_capitulo');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerDxNivel1($cap)
	{
		$this -> db -> where('id_capitulo',$cap);
		$result = $this->db->get('core_diag_nivel1');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerDxNivel2($nivel1)
	{
		$this -> db -> where('id_nivel1',$nivel1);
		$result = $this->db->get('core_diag_nivel2');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerDx($nivel2)
	{
		$this -> db -> where('id_nivel2',$nivel2);
		$result = $this->db->get('core_diag_item');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerOrigenesAtencion()
	{
		$result = $this->db->get('urg_origen_atencion');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerMedico($id_medico)
	{
		$this -> db -> select(' 
		  core_medico.id_medico,
		  core_medico.tarjeta_profesional,
		  core_especialidad.descripcion As especialidad,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento,
		  core_tipo_medico.id_tipo_medico,
		  core_tipo_medico.descripcion As tipo_medico');
		$this->db->from('core_medico');
  	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
  $this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
  $this->db->where('id_medico',$id_medico);
	$this->db->limit(1);
  $result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarMedicoConsulta($d)
	{
		
		$this->db->select('core_medico.id_medico,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_medico.tarjeta_profesional,
		  core_usuario.numero_documento,
		  core_tipo_documentos.tipo_documento,
		  core_usuario._username,
		  core_usuario._password');
		$this->db->from('core_usuario');
  $this->db->join('core_tercero','core_usuario.numero_documento = core_tercero.numero_documento');
  $this->db->join('core_medico','core_tercero.id_tercero = core_medico.id_tercero');
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
		$this->db->where('core_usuario._username',$d['_username']);
		$this->db->where('core_usuario._password',$d['_password']);
		$this->db->where('core_medico.id_tipo_medico <>','1');
		$this->db->where('core_medico.id_tipo_medico <>','4');
		$this->db->limit(1);
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		return $res = $result -> row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function consultaInicialDb($d)
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
		'verificado' => $d['verificado'],
		'id_medico_verifica' => $d['id_medico_verifica'],
		'fecha_verificado' => date('Y-m-d H:i:s'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion'],
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$r = $this -> db -> insert('urg_consulta',$insert);
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
		$this -> db -> insert('urg_consulta_ant',$insertAnt);
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
		$r = $this -> db -> insert('urg_consulta_exa',$insertExa);
		//----------------------------------------------------
		if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
		{
			for($i=0;$i<count($d['dx']);$i++)
			{
				$insert = array(
					'id_diag' 		=> $d['dx'][$i],
					'orden_dx' 		=> $i,
					'tipo_dx' 		=> $d['tipo_dx'][$i],
					'id_consulta' 	=> $id_consulta );
				$this->db->insert('urg_consulta_diag', $insert); 
			}
		}
		//----------------------------------------------------	
		$update = array('consulta' => 'SI',
			'id_medico_consulta' => $d['id_medico']);
		$this->db->where('id_atencion',$d['id_atencion']);
		$this->db->update('urg_atencion ',$update);
		//----------------------------------------------------
		$insert = array('id_usuario' => $this -> session -> userdata('id_usuario'),
						'id_atencion' => $d['id_atencion'],
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_atencion_detalle',$insert);
		//----------------------------------------------------
		return $dat;
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function editarConsultaInicialDb_($d)
  {
    $dat = array();
    $dat['error'] = $error = false;
    $update = array(
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
    'id_medico' => $d['id_medico_verifica'],
    'verificado' => $d['verificado'],
    'id_medico_verifica' => $d['id_medico_verifica'],
    'fecha_verificado' => date('Y-m-d H:i:s'));
    $this->db->where('id_consulta',$d['id_consulta']);
    $r = $this -> db -> update('urg_consulta',$update);
        if($r != 1){
      $error = true;
      return $dat['error'] = $error;}
    //----------------------------------------------------
    $updateAnt = array(
    'ant_patologicos' => $d['ant_patologicos'],
    'ant_famacologicos' => $d['ant_famacologicos'],
    'ant_toxicoalergicos' => $d['ant_toxicoalergicos'],
    'ant_quirurgicos' => $d['ant_quirurgicos'],
    'ant_familiares' => $d['ant_familiares'],
    'ant_ginecologicos' => $d['ant_ginecologicos'],
    'ant_otros' => $d['ant_otros']);
    $this->db->where('id_consulta',$d['id_consulta']);
    $this -> db -> update('urg_consulta_ant',$updateAnt);
    //----------------------------------------------------
    $updateExa = array(
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
    'exa_mental' => $d['exa_mental']);
    $this->db->where('id_consulta',$d['id_consulta']);
    $r = $this -> db -> update('urg_consulta_exa',$updateExa);
    //----------------------------------------------------
    $this->db->trans_start();
    $this->db->where('id_consulta',$d['id_consulta']);
    $this->db->delete('urg_consulta_diag');
    
    if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
    {
      for($i=0;$i<count($d['dx']);$i++)
      {
        $insert = array(
         'id_diag' 		=> $d['dx'][$i],
		 'orden_dx' 		=> $i,
		 'tipo_dx' 		=> $d['tipo_dx'][$i],
         'id_consulta'   => $d['id_consulta'] );
        $this->db->insert('urg_consulta_diag', $insert); 
      }
    }
    $this->db->trans_complete();
    //----------------------------------------------------  
    $update = array('consulta' => 'SI',
      'id_medico_consulta' => $d['id_medico']);
    $this->db->where('id_atencion',$d['id_atencion']);
    $this->db->update('urg_atencion ',$update);
    //----------------------------------------------------
    $insert = array('id_usuario' => $this -> session -> userdata('id_usuario'),
            'id_atencion' => $d['id_atencion'],
            'fecha_modificacion' => date('Y-m-d H:i:s'));
    $this->db->insert('urg_atencion_detalle',$insert);
    //----------------------------------------------------
    return $dat;
    
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function actualizarEstado($id_atencion,$estado)
	{
		$update = array('id_estado' => $estado,'fecha_modificacion'=>date('Y-m-d H:i:s'));
		$this->db->where('id_atencion',$id_atencion);
		$this->db->update('urg_atencion ',$update);
		
		$insert = array('id_estado' => $estado,
						'id_usuario' => $this -> session -> userdata('id_usuario'),
						'id_atencion' => $id_atencion,
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_atencion_detalle',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	

	function actualizarEstadoInsumos($id_orden,$estado)
  {
    $update = array('insumos' => $estado);
    $this->db->where('id_orden',$id_orden);
    $this->db->update('urg_ordenamiento',$update);
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////  


	function obtenerPacientesUrgencias($d)
	{
		$this->db->select('urg_atencion.id_atencion,
  urg_atencion.fecha_ingreso,
  urg_atencion.admision,
  urg_atencion.clasificacion,
  urg_atencion.id_medico_consulta,
  urg_atencion.consulta,
  urg_atencion.id_servicio,
  urg_atencion.id_estado,
  core_paciente.genero,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  urg_triage.clasificacion,
  urg_triage.motivo_consulta,
  core_servicios_hosp.nombre_servicio,
  core_servicios_hosp.id_servicio,
  urg_estados_atencion.estado,
  core_tercero.fecha_nacimiento');

$this->db->from('urg_atencion');
$this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->join('core_servicios_hosp','urg_atencion.id_servicio = core_servicios_hosp.id_servicio');
$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->join('urg_triage','urg_atencion.id_atencion = urg_triage.id_atencion');
$this->db->join('urg_estados_atencion','urg_atencion.id_estado = urg_estados_atencion.id_estado');
$this->db->where('urg_atencion.admision',$d['admision']);
$this->db->where('urg_atencion.id_estado <>',1);
$this->db->where('urg_atencion.id_estado <>',6); 
$this->db->where('urg_atencion.id_estado <>',7); 
$this->db->where('urg_atencion.id_estado <>',8);
$this->db->where('urg_atencion.id_estado <>',9);  
$this->db->order_by('fecha_ingreso','desc');   	
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function listadoEstados()
	{
		$result = $this->db->get('urg_estados_atencion');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearAdmisionDb($d)
	{
		$update = array('admision' 	=> 'SI',
						'id_origen' => $d['id_origen'],
						'ingreso'	=> $d['ingreso'],
						'observaciones_adm' => $d['observaciones_adm'],
						'id_entidad'=> $d['id_entidad'],
						'id_entidad_pago' => $d['id_entidad_pago'],
						'id_usuario_admision' => $this -> session -> userdata('id_usuario'),
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->where('id_atencion',$d['id_atencion']);
		$this->db->update('urg_atencion',$update);
		
		$insert = array('id_origen' => $d['id_origen'],
						'ingreso'	=> $d['ingreso'],
						'observaciones_adm' => $d['observaciones_adm'],
						'id_entidad'=> $d['id_entidad'],
						'id_usuario' => $this -> session -> userdata('id_usuario'),
						'id_atencion' => $d['id_atencion'],
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_atencion_detalle',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarAtencionLista($id_atencion)
	{
		$this -> db -> select('admision');
		$this -> db -> where('id_atencion',$id_atencion);
		$this->db->limit(1);
		$result = $this -> db ->get('urg_atencion');
		$dat = $result -> row_array();
		return $dat['admision'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerConsulta($id_atencion)
	{
		$this -> db -> where('id_atencion',$id_atencion);
		$this->db->limit(1);
		$result = $this -> db ->get('urg_consulta');
		return $result -> row_array();
	}
	
	function obtenerConsulta_ant($id_consulta)
	{
		$this -> db -> where('id_consulta',$id_consulta);
		$this->db->limit(1);
		$result = $this -> db ->get('urg_consulta_ant');
		return $result -> row_array();
	}
	
	function obtenerConsulta_exa($id_consulta)
	{
		$this -> db -> where('id_consulta',$id_consulta);
		$this->db->limit(1);
		$result = $this -> db ->get('urg_consulta_exa');
		return $result -> row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEvoluciones($id_atencion)
	{
		$this->db->select('core_especialidad.descripcion As esp,
		  core_medico.id_medico,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  urg_evoluciones.id_evolucion,
		  urg_evoluciones.verificado,
		  urg_evoluciones.fecha_evolucion,
		  urg_evoluciones.id_atencion,
		  urg_evoluciones.verificado,
		  core_evoluciones_tipo.tipo_evolucion');
	$this->db->from('core_medico');
	$this->db->join('urg_evoluciones','core_medico.id_medico = urg_evoluciones.id_medico');
	$this->db->join('core_evoluciones_tipo','urg_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
  urg_evoluciones.id_evolucion,
  urg_evoluciones.subjetivo,
  urg_evoluciones.objetivo,
  urg_evoluciones.analisis,
  urg_evoluciones.conducta,
  urg_evoluciones.fecha_evolucion,
  urg_evoluciones.id_atencion,
  core_evoluciones_tipo.tipo_evolucion');
	$this->db->from('core_medico');
	$this->db->join('urg_evoluciones','core_medico.id_medico = urg_evoluciones.id_medico');
	$this->db->join('core_evoluciones_tipo','urg_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
	$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
	$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
		$this->db->where('id_evolucion',$id_evolucion);
		$this->db->limit(1);
		$this->db->order_by('urg_evoluciones.id_evolucion','DESC');
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDxCon($id_dx)
	{
		$this->db->where('id_diag',$id_dx);
		$this->db->limit(1);
		$result = $this->db->get('core_diag_item');
		$diag = $result->row_array();
		$cadena = "<strong>".$diag['id_diag']."</strong>"." ".$diag['diagnostico'];
		return $cadena;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerUltEvolucion($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('fecha_evolucion','DESC');
		$result = $this->db->get('urg_evoluciones');
		$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->first_row('array');
		}	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearEvolucionDb($d)
	{
		$insert = array(
			'id_tipo_evolucion' => $d['id_tipo_evolucion'],
			'subjetivo' => $d['subjetivo'],
			'objetivo' => $d['objetivo'],
			'analisis' => $d['analisis'],
			'conducta' => $d['conducta'],
			'verificado' => $d['verificado'],
			'id_servicio' => $d['id_servicio'],
			'id_medico_verifica' => $d['id_medico_verifica'],
			'fecha_verificado' => date('Y-m-d H:i:s'),
			'id_usuario' => $this -> session -> userdata('id_usuario'),
			'id_medico' => $d['id_medico'],
			'id_atencion' => $d['id_atencion'],
			'fecha_evolucion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_evoluciones',$insert);
		$id_evolucion = $this->db->insert_id();
		//----------------------------------------------------
		if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
		{
			for($i=0;$i<count($d['dx']);$i++)
			{
				$insert = array(
					'id_diag' 		=> $d['dx'][$i],
					'id_evolucion' 	=> $id_evolucion );
				$this->db->insert('urg_evolucion_diag', $insert); 
			}
		}
		//----------------------------------------------------
		return $id_evolucion;
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Verifica la evolucion
*

* @author William Alberto Ospina <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100830
* @version		20100830
* @return		array[object]
*/

	function verificarEvolucionDb($d)
  {
    $update = array(
      'id_tipo_evolucion' => $d['id_tipo_evolucion'],
      'subjetivo' => $d['subjetivo'],
      'objetivo' => $d['objetivo'],
      'analisis' => $d['analisis'],
      'conducta' => $d['conducta'],
      'verificado' => $d['verificado'],
      'id_servicio' => $d['id_servicio'],
      'id_medico_verifica' => $d['id_medico_verifica'],
      'fecha_verificado' => date('Y-m-d H:i:s'),
      'id_usuario' => $this -> session -> userdata('id_usuario'),
      'id_medico' => $d['id_medico'],
      'id_atencion' => $d['id_atencion'],
      'fecha_evolucion' => date('Y-m-d H:i:s'));
    $this->db->where ('id_evolucion',$d['id_evolucion']);
    $this->db->update('urg_evoluciones',$update);
    
    //----------------------------------------------------
       
    $this->db->trans_start();
    $this->db->where('id_evolucion',$d['id_evolucion']);
    $this->db->delete('urg_evolucion_diag');
    
    if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
    {
      for($i=0;$i<count($d['dx']);$i++)
      {
        $insert = array(
          'id_diag'     => $d['dx'][$i],
          'id_evolucion'  => $d['id_evolucion'] );
        $this->db->insert('urg_evolucion_diag', $insert); 
      }
    }
    
    $this->db->trans_complete();
         
        
    //----------------------------------------------------
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		
	function obtenerOrdenes($id_atencion)
	{
		$this->db->select('core_tipo_medico.descripcion As tipo,
		  core_especialidad.descripcion As esp,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  urg_ordenamiento.id_orden,
		  urg_ordenamiento.id_servicio,
		  urg_ordenamiento.fecha_creacion,
		  urg_ordenamiento.id_atencion,
		  urg_ordenamiento.verificado,
		  urg_ordenamiento.verificado,
		  urg_ordenamiento.insumos,
		urg_ordenamiento.insumos_despacho,
		  urg_ordenamiento.id_medico,
		  urg_ordenamiento.insumos');
$this->db->from('core_medico');
$this->db->join('urg_ordenamiento','core_medico.id_medico = urg_ordenamiento.id_medico');
$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->where('urg_ordenamiento.id_atencion',$id_atencion);
$this->db->order_by('urg_ordenamiento.fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerUltOrden($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('fecha_creacion','DESC');
		$result = $this->db->get('urg_ordenamiento');
		$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->first_row('array');
		}	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDietas()
	{
		$this->db->order_by('dieta','ASC');
		$result = $this->db->get('core_dietas');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerDieta($id_dieta)
	{
		$this->db->where('id_dieta',$id_dieta);
		$this->db->limit(1);
		$result = $this->db->get('core_dietas');
		$cad = $result->row_array();
		return $cad['dieta'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerOxigeno()
	{
		$result = $this->db->get('core_oxigeno');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTipoOxigeno($id_o2)
	{
		$this->db->where('id_oxigeno',$id_o2);
		$result = $this->db->get('core_oxigeno_tipo');
		$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
		return $result->result_array();
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerVarMedi($tipo)
	{
		$this->db->where('tipo',$tipo);
		$this->db->order_by('descripcion','ASC');
		$result = $this->db->get('core_medicamento_var');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerValorVarMedi($id)
	{
		$this->db->where('id',$id);
		$this->db->limit(1);
		$result = $this->db->get('core_medicamento_var');
		$row = $result->row_array();
		return $row['descripcion'];	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNomMedicamento($atc)
	{
		$this->db->where('atc_full',$atc);
		$this->db->limit(1);
		$result = $this->db->get('core_medicamento');
		$row = $result->row_array();
		return $row['principio_activo']." ".$row['descripcion'];	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMedicamentoPos($atc)
	{
		$this->db->where('atc_full',$atc);
		$result = $this->db->get('core_medicamento');
		return $result->row_array();
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerCupsSec()
	{
		$result = $this->db->get('core_cups_seccion');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsCap($sec)
	{
		$this->db->where('id_seccion',$sec);
		$result = $this->db->get('core_cups_capitulo');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////

	function obtenerCupsGrup($cap)
	{
		$this->db->where('id_capitulo',$cap);
		$result = $this->db->get('core_cups_grupo');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsSubGrup($gru)
	{
		$this->db->where('id_grupo',$gru);
		$result = $this->db->get('core_cups_subgrupo');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsCategorias($sgru)



	{
		$this->db->where('id_subgrupo',$sgru);
		$result = $this->db->get('core_cups_categoria ');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsSubCate($cate)

	{
		$this->db->where('id_categoria',$cate);
		$result = $this->db->get('core_cups_subcategoria');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNomCubs($cups)
	{
		$this->db->where('id_subcategoria',$cups);
		$this->db->limit(1);
		$result = $this->db->get('core_cups_subcategoria');
		$row = $result->row_array();
		return $row['desc_subcategoria'];	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerNomfrecuencia($frecuencia)
	{
		$this->db->where('id',$frecuencia);
		$this->db->limit(1);
		$result = $this->db->get('core_medicamento_var');
		$row = $result->row_array();
		return $row['descripcion'];	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////




function obtenerNomInsumo($id_insumo)
  {
    $this->db->where('id_insumo',$id_insumo);
	$this->db->limit(1);
    $result = $this->db->get('core_insumos');
    $row = $result->row_array();
    return $row['insumo']; 
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////

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
		'verificado' => $d['verificado'],
		'id_medico_verifica' => $d['id_medico_verifica'],
		'fecha_verificado' => $d['fecha_verificado'],
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		
		'id_atencion' => $d['id_atencion']);
		$r = $this->db->insert('urg_ordenamiento',$insert);
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
				$this->db->insert('urg_orde_dietas', $insert); 
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
				$this->db->insert('urg_orde_cuidados', $insert); 
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
				$this->db->insert('urg_orde_medicamentos', $insert);
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
									
				$this->db->insert('urg_orde_laboratorios', $insert);
			
				}	
				
				elseif ((substr($d['cups'][$i], 0, -6) == '87.') || (substr($d['cups'][$i], 0, -6) == '88.'))
				{
				$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_orden' 		=> $dat['id_orden'] );
				$this->db->insert('urg_orde_imagenes', $insert); 
				}
				
				else
				{
				$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_orden' 		=> $dat['id_orden'] );
				$this->db->insert('urg_orde_cups', $insert); 
				}
			}
		}
		//----------------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////


function verificarOrdenDb($d)
  {
	$this->db->trans_start();  
    $dat = array();
    $dat['error'] = $error = false;
    $update = array(
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
    'verificado' => $d['verificado'],
    'id_medico_verifica' => $d['id_medico_verifica'],
    'fecha_verificado' => $d['fecha_verificado'],
    'id_servicio' => $d['id_servicio'],
    'id_usuario' => $this -> session -> userdata('id_usuario'),
    'id_medico' => $d['id_medico'],
    'id_atencion' => $d['id_atencion']);
    
    $this->db->where('id_orden',$d['id_orden']);
    $r = $this->db->update('urg_ordenamiento',$update);
    
    if($r != 1){
      $error = true;
      return $dat['error'] = $error;}
    //----------------------------------------------------------
    //$this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_dietas');
    
    if(count($d['id_dieta']) > 0 && strlen($d['id_dieta'][0]) > 0)
    {
      for($i=0;$i<count($d['id_dieta']);$i++)
      {
        $insert = array(
          'id_dieta'    => $d['id_dieta'][$i],
          'id_orden'    => $d['id_orden'] );
        $this->db->insert('urg_orde_dietas', $insert); 
      }
    }
    //$this->db->trans_complete();
    //----------------------------------------------------------
    //$this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_cuidados');
    
    if(count($d['id_cuidado']) > 0 && strlen($d['id_cuidado'][0]) > 0)
    {
      for($i=0;$i<count($d['id_cuidado']);$i++)
      {
        $insert = array(
          'id_cuidado' => $d['id_cuidado'][$i],
          'frecuencia_cuidado' => $d['frecuencia_cuidado'][$i],
          'id_frecuencia_cuidado' => $d['id_frecuencia_cuidado'][$i],
          'id_orden'    => $d['id_orden'] );
        $this->db->insert('urg_orde_cuidados', $insert); 
      }
    }
    //$this->db->trans_complete();
    //----------------------------------------------------------
    //$this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_medicamentos');
    
    if(count($d['atc']) > 0 && strlen($d['atc'][0]) > 0)
    {
      for($i=0;$i<count($d['atc']);$i++)
      {
        $insert = array(
          'atc'     => $d['atc'][$i],
          'dosis'   => $d['dosis'][$i],
          'id_unidad' => $d['id_unidad'][$i],
          'frecuencia'=> $d['frecuencia'][$i],
          'id_frecuencia'=> $d['id_frecuencia'][$i],
          'id_via'  => $d['id_via'][$i],
          'observacionesMed'=> $d['observacionesMed'][$i],
          'id_orden'    => $d['id_orden'] );
        $this->db->insert('urg_orde_medicamentos', $insert); 
      }
    }
    //$this->db->trans_complete();
    //----------------------------------------------------------
    //$this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_cups');
          
    if((count($d['cups']) > 0 && strlen($d['cups'][0]) > 0))
    {
      for($i=0;$i<count($d['cups']);$i++)
      {
		if ((substr($d['cups'][$i], 0, -6) != '90.') && ((substr($d['cups'][$i], 0, -6) != '87.') && (substr($d['cups'][$i], 0, -6) != '88.')))
        {
		$insert = array(
          'cups'    => $d['cups'][$i],
          'observacionesCups' => $d['observacionesCups'][$i],
		  'cantidadCups' => $d['cantidadCups'][$i],
          'id_orden'    => $d['id_orden'] );
        $this->db->insert('urg_orde_cups', $insert); 
		}
      }
    }
    //$this->db->trans_complete();
    //----------------------------------------------------------
    //$this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_laboratorios');
    
    if((count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)) 
				{
	   for($i=0;$i<count($d['cups']);$i++)
          {
		   if ((substr($d['cups'][$i], 0, -6) == '90.'))
              {
				$insert = array(
				'cups' 		=> $d['cups'][$i],
				'observacionesCups' => $d['observacionesCups'][$i],
				'cantidadCups' => $d['cantidadCups'][$i],
				'id_orden' 		=> $d['id_orden'] );
				$this->db->insert('urg_orde_laboratorios', $insert);
				}
			  }	
			}	
    //$this->db->trans_complete();
    //----------------------------------------------------------
    //$this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_imagenes');
    
    if((count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)) 
				{
			for($i=0;$i<count($d['cups']);$i++)
				{
				if ((substr($d['cups'][$i], 0, -6) == '87.') || (substr($d['cups'][$i], 0, -6) == '88.'))
					{		
					$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_orden' 		=> $d['id_orden'] );
				    $this->db->insert('urg_orde_imagenes', $insert);
					}
				   }	
				}
    $this->db->trans_complete();
    //----------------------------------------------------------
    return $dat;
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    $r = $this->db->insert('urg_orde_insumos',$insert);
    $dat['id_orden'] = $this->db->insert_id();
    if($r != 1){
      $error = true;
      return $dat['error'] = $error;}
	//----------------------------------------------------------
	$update = array('insumos' => 'SI');
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->update('urg_ordenamiento',$update);
    //----------------------------------------------------------
    if(count($d['codigo_insumo']) > 0 && strlen($d['codigo_insumo'][0]) > 0)
    {
      for($i=0;$i<count($d['codigo_insumo']);$i++)
      {
        $insert = array(
          'id_insumo'    => $d['codigo_insumo'][$i],
          'cantidad'    => $d['cantidad'][$i],
          'observaciones'    => $d['observaciones'][$i],
          'id_orden_insumos'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_insumos_detalle', $insert); 
      }
    }
    //----------------------------------------------------------
    return $dat;  
      }
//////////////////////////////////////////////////////////////////////////////////////////////////////////

	function obtenerDietasOrden($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get('urg_orde_dietas');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCuidadosOrden($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get('urg_orde_cuidados');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMediOrden($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get('urg_orde_medicamentos');
		return $result->result_array();	
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMediOrdenNueva($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$this->db->where('estado <>','Suspendido');
		$result = $this->db->get('urg_orde_medicamentos');
		return $result->result_array();	
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMediOrdenInsu($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$this->db->where('estado <>','Continua');
		$result = $this->db->get('urg_orde_medicamentos');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerMediOrdenNoPos($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$this->db->where('pos','NO');
		$result = $this->db->get('urg_orde_medicamentos');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsOrden($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get('urg_orde_cups');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerCupsLaboratorios($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get('urg_orde_laboratorios');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerCupsImagenes($id_orden)
	{
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get('urg_orde_imagenes');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////


	function obtenerOrden($id_orden)
	{
		$this->db->select('*');
 	$this->db->from('urg_ordenamiento');
  	$this->db->join('core_oxigeno','urg_ordenamiento.id_tipo_oxigeno = core_oxigeno.id_oxigeno','left');
  	$this->db->join('core_oxigeno_tipo','urg_ordenamiento.id_oxigeno_valor = core_oxigeno_tipo.id_oxigeno_valor','left');
	$this->db->where('id_orden',$id_orden);
	$this->db->limit(1);
	$this->db->order_by('id_orden','DESC');
	$result = $this->db->get();
	return $result->row_array();
  }
  
  function obtenerOrdenRepetir($id_orden)
	{
		$this->db->select('*');
 	$this->db->from('urg_ordenamiento');
	$this->db->where('id_orden',$id_orden);
	$this->db->limit(1);
	$this->db->order_by('id_orden','DESC');
	$result = $this->db->get();
	return $result->row_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
 	
 	
 	function obtenerOrdenInsumos($id_orden)
  {
    $this->db->select(' 
  urg_orde_insumos_detalle.id_insumo,
  core_insumos.insumo,
  core_insumos.codigo_interno,
  urg_orde_insumos_detalle.cantidad,
  urg_orde_insumos_detalle.observaciones');
  $this->db->from('core_insumos');
  $this->db->join('urg_orde_insumos_detalle','core_insumos.id_insumo = urg_orde_insumos_detalle.id_insumo');
  $this->db->join('urg_orde_insumos','urg_orde_insumos.id_orden_insumos = urg_orde_insumos_detalle.id_orden_insumos');
  $this->db->where('urg_orde_insumos.id_orden',$id_orden);
  $result = $this->db->get();
  return $res = $result -> result_array();
  
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  
 	
 	
 	
 	function obtenerDestinos()
 	{
	 	$result = $this->db->get('urg_egreDestinos');
		return $result->result_array();	
 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCuidadosE()
	{
		$result = $this->db->get('core_cuidados_enfermeria');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCuidadoDetalle($id_cuidado)
	{
		$this->db->where('id_cuidado',$id_cuidado);
		$this->db->limit(1);
		$result = $this->db->get('core_cuidados_enfermeria');
		$row = $result->row_array();
		return $row['cuidado'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDxConsulta($id_consulta)
	{
		$this->db->select('*');
		$this->db->from('urg_consulta_diag');
  		$this->db->join('core_diag_item','urg_consulta_diag.id_diag = core_diag_item.id_diag');
		$this->db->where('id_consulta',$id_consulta);
		$result = $this->db->get();
		return  $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDxEvolucion($id_evolucion)
	{
		$this->db->select('urg_evolucion_diag.id_diag,core_diag_item.diagnostico,urg_evolucion_diag.id_evolucion');
		$this->db->from('urg_evolucion_diag');
  		$this->db->join('core_diag_item','urg_evolucion_diag.id_diag = core_diag_item.id_diag');
		$this->db->where('id_evolucion',$id_evolucion);
		$result = $this->db->get();
		return  $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearPlanManejoDb($d)
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
		'verificado' => $d['verificado'],
		'id_medico_verifica' => $d['id_medico_verifica'],
		'fecha_verificado' => date('Y-m-d H:i:s'),
		'id_servicio' => $d['id_servicio'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_medico' => $d['id_medico'],
		'id_atencion' => $d['id_atencion']);
		$r = $this->db->insert('urg_ordenamiento',$insert);
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
				$this->db->insert('urg_orde_dietas', $insert); 
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
				$this->db->insert('urg_orde_cuidados', $insert); 
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
				$this->db->insert('urg_orde_medicamentos', $insert);
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
					'id_orden' 		=> $dat['id_orden'] );
				$this->db->insert('urg_orde_laboratorios', $insert);
				}	
				
				elseif ((substr($d['cups'][$i], 0, -6) == '87.') || (substr($d['cups'][$i], 0, -6) == '88.'))
				{
				$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_orden' 		=> $dat['id_orden'] );
				$this->db->insert('urg_orde_imagenes', $insert); 
				}
				
				else
				{
				$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_orden' 		=> $dat['id_orden'] );
				$this->db->insert('urg_orde_cups', $insert); 
				}
			}
		}
		//----------------------------------------------------------
		return $dat;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function remitirObservacion($d)
	{
		$insert = array(
			'fecha_remicion' => date('Y-m-d H:i:s'),
			'id_medico_remite' => $d['id_medico'],
			'id_servicio' => $d['id_servicio'],
			'id_atencion' => $d['id_atencion']);
		$this->db->insert('urg_observacion',$insert);
		
		$update = array('id_servicio' => $d['id_servicio']);
		$this->db->where('id_atencion',$d['id_atencion']);
		$this->db->update('urg_atencion',$update);
		
		$insert = array(
		'id_servicio' => $d['id_servicio'],
		'fecha_modificacion ' => date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'),
		'id_atencion' => $d['id_atencion']);
		$this->db->insert('urg_atencion_detalle',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerPacientesObservacionUrg($id_servicio)
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
  urg_observacion.id_observacion,
  urg_observacion.fecha_ingreso,
  urg_observacion.id_cama,
  urg_observacion.fecha_remicion,
  urg_observacion.id_medico_remite,
  urg_observacion.ingreso_sala,
  urg_observacion.id_servicio,
  urg_observacion.id_atencion');
		$this->db->from('urg_observacion');
  $this->db->join('urg_atencion','urg_observacion.id_atencion = urg_atencion.id_atencion');
  $this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->join('core_cama','urg_observacion.id_cama = core_cama.id_cama','left');
  $this->db->where('urg_observacion.estado','activo');
  $this->db->where('urg_observacion.ingreso_sala','NO');
  $this->db->where('urg_observacion.id_servicio',$id_servicio);
  $result = $this->db->get();
  return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerInfoServicio($id_servicio)
	{
		$this->db->where('id_servicio',$id_servicio);
		$this->db->limit(1);
		$result = $this->db->get('core_servicios_hosp');
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerServicios()
	{
		$this->db->order_by('nombre_servicio','asc');
		$result = $this->db->get('core_servicios_hosp');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function numeroEvolucionesObservacion($id_atencion,$id_servicio)
	{
		$this->db->where('id_servicio',$id_servicio);
		$this->db->where('id_atencion',$id_atencion);
		$result = $this->db->get('urg_evoluciones');
		return $result->num_rows();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCamasDispoServicio($id_servicio)
	{
		$this->db->where('id_estado','5');
		$this->db->where('id_servicio',$id_servicio);
		$result = $this->db->get('core_cama');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerObservacion($id_observacion)
	{
		
		$this->db->where('id_observacion',$id_observacion);
		$this->db->limit(1);
		$this->db->order_by('id_observacion','DESC');
		$result = $this->db->get('urg_observacion');
		return $result->row_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function ingresoObservacionDb($id_observacion,$id_cama)
	{
		$this->db->where('id_observacion',$id_observacion);
		$this->db->limit(1);
		$this->db->order_by('id_observacion','DESC');
		$res = $this->db->get('urg_observacion');
		$obs = $res->row_array();
		
		if($obs['fecha_ingreso'] == '0000-00-00 00:00:00'){
			$update = array(
			'fecha_ingreso' => date('Y-m-d H:i:s'),
			'id_cama' => $id_cama,
			'ingreso_sala' => 'SI');
		}else{
			$update = array(
			'id_cama' => $id_cama,
			'ingreso_sala' => 'SI');
		}
		
		$this->db->where('id_observacion',$id_observacion);
		$this->db->update('urg_observacion',$update);
		
		$update = array('id_estado' =>'2');
		$this->db->where('id_cama',$id_cama);
		$this->db->update('core_cama',$update);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function detalleCama($id_cama)
	{
		$this->db->where('id_cama',$id_cama);
		$this->db->limit(1);
		$result = $this->db->get('core_cama');
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
  $result =	 $this->db->get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerPacienteAtencion($id_atencion)
	{
	$this->db->SELECT('urg_atencion.id_atencion, 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tipo_documentos.tipo_documento,
  core_tercero1.razon_social');
  $this->db->FROM('urg_atencion');
  $this->db->JOIN('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->JOIN('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad','LEFT');
  $this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero','LEFT');	
  $this->db->where('urg_atencion.id_atencion',$id_atencion);
  $this->db->where('urg_atencion.id_estado','5');
  $this->db->limit(1);
	$this->db->order_by('urg_atencion.id_atencion','DESC');
  $result =	 $this->db->get();
	return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEstadosCamas()
	{
		$this->db->where('id_estado <>',1);
		$result = $this->db->get('core_estados_camas');
		return $result->result_array();	
	}

  
  function obtenerUltimaEvolucion($id_atencion)
  {
    $this->db->where('id_atencion',$id_atencion);
    $this->db->order_by('fecha_evolucion', 'desc');
	$this->db->limit(1);
    $result = $this->db->get('urg_evoluciones');
    $num = $result -> num_rows();
    if($num == 0){
    return $num;}
    $res = $result -> row_array();
    return  $res['verificado'];
     
  }  
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerObservacionAtencion($id_atencion)
	{
		$this->db->SELECT(' 
  core_cama.numero_cama,
  urg_observacion.id_observacion,
   urg_observacion.id_cama,
  urg_observacion.fecha_remicion,
  urg_observacion.fecha_ingreso,
  urg_observacion.estado,
  core_servicios_hosp.nombre_servicio,
  urg_observacion.id_medico_remite');
		$this->db->FROM('urg_observacion');
  $this->db->JOIN('core_cama','urg_observacion.id_cama = core_cama.id_cama');
 $this->db->JOIN('core_servicios_hosp','urg_observacion.id_servicio = core_servicios_hosp.id_servicio');
		$this->db->where('urg_observacion.id_atencion',$id_atencion);
		$this->db->limit(1);
		$this->db->order_by('urg_observacion.id_atencion','DESC');
		$result = $this->db->get();
		return $result->row_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTiposEvolucion()
	{
		$result = $this->db->get('core_evoluciones_tipo');
		return $result->result_array();
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function solicitudInterconsulta($d)
	{
		$insert = array(
			'id_evolucion' => $d['id_evolucion'],
			'id_especialidad' => $d['id_especialidad'],
			'id_medico' => $d['id_medico_verifica'],
			'id_servicio' => $d['id_servicio'],
			'fecha_solicitud' => date('Y-m-d H:i:s'));
		$this->db->insert('inter_interconsulta',$insert);	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEntidadesRemision()
	{
		$this-> db -> order_by('nombre','asc');
		$result = $this->db->get('core_entidad_remision');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEntidadRemision($id_entidad)
	{
		$this->db->where('codigo_entidad',$id_entidad);
		$this->db->limit(1);
		$result = $this->db->get('core_entidad_remision');
		return $result->row_array();		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerDxEvoluciones($id_atencion)
	{
		$this->db->SELECT('
  urg_atencion.id_atencion,
  urg_evoluciones.id_evolucion,
  urg_evolucion_diag.id_diag,core_diag_item.diagnostico');
$this->db->FROM('urg_atencion');
  $this->db->JOIN('urg_evoluciones','urg_atencion.id_atencion = urg_evoluciones.id_atencion');
  $this->db->JOIN('urg_evolucion_diag','urg_evoluciones.id_evolucion = urg_evolucion_diag.id_evolucion');
  $this->db->JOIN('core_diag_item','urg_evolucion_diag.id_diag = core_diag_item.id_diag');
$this->db->where('urg_atencion.id_atencion',$id_atencion);
$this->db->GROUP_BY('urg_evolucion_diag.id_diag');
$result = $this->db->get();
return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMediAtencion($id_atencion)
	{
		$this->db->SELECT(' 
   urg_atencion.id_atencion,
  urg_orde_medicamentos.observacionesMed,
  urg_orde_medicamentos.id_via,
  urg_orde_medicamentos.frecuencia,
  urg_orde_medicamentos.dosis,
  urg_orde_medicamentos.atc,
  urg_orde_medicamentos.id_frecuencia,
  urg_orde_medicamentos.id_unidad');
$this->db->FROM('urg_atencion');
$this->db->JOIN('urg_ordenamiento','urg_atencion.id_atencion = urg_ordenamiento.id_atencion');
$this->db->JOIN('urg_orde_medicamentos','urg_ordenamiento.id_orden = urg_orde_medicamentos.id_orden');
$this->db->WHERE('urg_atencion.id_atencion',$id_atencion);
$this->db->group_by('urg_orde_medicamentos.atc');	
$result = $this->db->get();
return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerOrigenAtencion($id_origen)
	{
		$this->db->WHERE('id_origen',$id_origen);
		$this->db->limit(1);
		$result = $this->db->get('urg_origen_atencion');
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		$this -> db -> insert('urg_epicrisis',$insert);
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
				$this->db->insert('urg_epicrisis_dx', $insert); 
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
				$this->db->insert('urg_epicrisis_dx', $insert); 
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
				$this->db->insert('urg_epicrisis_evo', $insert); 
			}
		}
		//----------------------------------------------------		
		
		$estado = $this->obtenerestadoDestino($d['id_destino']);
		
		$update = array(
		'fecha_egreso' =>  $d['fecha_egreso'],
		'id_estado' => $estado,
		'activo' => 'NO',
		'id_destino' => $d['id_destino'],
		'id_usuario' => $this -> session -> userdata('id_usuario'),);
		$this->db->where('id_atencion',$d['id_atencion']);
		$this->db->update('urg_atencion',$update);
		
		$insert = array('id_estado' => $estado,
						'id_usuario' => $this -> session -> userdata('id_usuario'),
						'id_atencion' => $d['id_atencion'],
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_atencion_detalle',$insert);
		
		$update = array(
			'fecha_salida' => $d['fecha_egreso'],
			'estado' => 'inactivo'
		);
		$this->db->where('id_atencion',$d['id_atencion']);
		$this->db->update('urg_observacion',$update);
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerestadoDestino($id_destino)
	{
		$this -> db -> where('id_destino',$id_destino);
		$this->db->limit(1);
		$result = $this -> db -> get('urg_egreDestinos');
		$d = $result->row_array();
		return $d['id_estado'];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function liberarCama($id_cama)
	{
		$update = array('id_estado' => '3');
		$this->db->where('id_cama',$id_cama);
		$this->db->update('core_cama',$update);			
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerSustitutosPos($atc_nopos)
	{
		$this -> db -> where('atc_nopos',$atc_nopos);
		$this -> db -> from('core_medicamentos_sustitutos_pos');
		$this -> db -> join('core_medicamento','core_medicamentos_sustitutos_pos.atc_pos = core_medicamento.atc_full');
		$result = $this -> db -> get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function formatoNoPosDb($d)
	{
		if(count($d['atcNoPos']) > 0 && strlen($d['atcNoPos'][0]) > 0)
		{
			for($i=0;$i<count($d['atcNoPos']);$i++)
			{
				$insert = array(
				'atcNoPos' => $d['atcNoPos'][$i], 
				'resumen_historia' => $d['resumen_historia'],   
				'dias_tratamiento' => $d['dias_tratamiento'][$i],
				'dosis_diaria' => $d['dosis_diaria'][$i],
				'cantidad_mes' => $d['cantidad_mes'][$i], 
				'ventajas' => $d['ventajas'][$i],
				'id_usuario' => $this -> session -> userdata('id_usuario'),
				'fecha' => date('Y-m-d H:i:s'),
				'id_orden' => $d['id_orden'],
				); 
				$this -> db -> insert('urg_orde_med_no_pos',$insert);
			}
		}
				
		if(count($d['atc_pos']) > 0 && strlen($d['atc_pos'][0]) > 0)
		{
			for($i=0;$i<count($d['atc_pos']);$i++)
			{		
				$insert = array(
				'atc_pos' => $d['atc_pos'][$i], 
				'atcNoPosSus' => $d['atcNoPosSus'][$i],   
				'dias_tratamientoPos' => $d['dias_tratamientoPos'][$i],
				'dosis_diariaPos' => $d['dosis_diariaPos'][$i],
				'cantidad_mesPos' => $d['cantidad_mesPos'][$i], 
				'resp_clinica' => $d['resp_clinica'][$i],
				'resp_clinica_cual' => $d['resp_clinica_cual'][$i],
				'contraindicacion' => $d['contraindicacion'][$i],
				'contraindicacion_cual' => $d['contraindicacion_cual'][$i],
				'id_orden' => $d['id_orden'],
				); 
				$this -> db -> insert('urg_orde_med_sustitutos',$insert);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAtencionCama($id_cama)
	{
$this->db->select('
core_tercero.primer_apellido,
core_tercero.segundo_apellido,
core_tercero.primer_nombre,
core_tercero.segundo_nombre,
core_tercero.fecha_nacimiento,
urg_observacion.id_atencion,
core_tercero1.razon_social,
urg_observacion.estado,
urg_observacion.id_cama,
core_paciente.id_paciente,
core_tipo_documentos.tipo_documento');
$this->db->from('urg_observacion');
$this->db->JOIN('urg_atencion','urg_observacion.id_atencion = urg_atencion.id_atencion');
$this->db->JOIN('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->JOIN('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->where('urg_observacion.estado','activo');
$this->db->where('urg_observacion.id_cama',$id_cama);
$this->db->order_by('urg_observacion.id_atencion','DESC');
$this->db->limit(1);
$result = $this->db->get();
$num = $result->num_rows();
if($num == 0){
	return $num;
}else{
return $result->row_array();
}	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarAtencionTriage($numero_documento)
	{
		$this->db->select('
		core_tercero.numero_documento,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		urg_atencion.fecha_egreso,
		urg_estados_atencion.estado,
		urg_atencion.fecha_ingreso,
		urg_atencion.id_estado,
		core_servicios_hosp.nombre_servicio,
		urg_atencion.id_atencion');
		$this->db->from('core_tercero');
		$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  	$this->db->join('urg_atencion','core_paciente.id_paciente = urg_atencion.id_paciente');
  	$this->db->join('urg_estados_atencion','urg_atencion.id_estado = urg_estados_atencion.id_estado');
	$this -> db ->JOIN('core_servicios_hosp','urg_atencion.id_servicio = core_servicios_hosp.id_servicio');
		$this->db->where('core_tercero.numero_documento',$numero_documento);
		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function reingresoPacienteDb($id_atencion)
	{
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEpicrisis($id_atencion)
	{
		
		$this->db->FROM('urg_epicrisis');
		$this->db->JOIN('core_especialidad','urg_epicrisis.id_especialidad = core_especialidad.id_especialidad','left');
		$this->db->JOIN('urg_egreDestinos','urg_epicrisis.id_destino = urg_egreDestinos.id_destino');
		$this->db->limit(1);
		$this->db->order_by('id_atencion','DESC');
		$this->db->WHERE('id_atencion',$id_atencion);
		$result = $this->db->get();

		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function activarCamaObservacion($id_cama)
	{
		$update = array('id_estado' =>'5');
		$this->db->where('id_cama',$id_cama);
		$this->db->update('core_cama',$update);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTiposCupsUrg()
	{
		$this->db->order_by('nombre_tipo','ASC');
		$this->db->where('id_tipo <>','7');
		$this->db->where('id_tipo <>','8');
		$this->db->where('id_tipo <>','9');
		$res = $this->db->get('urg_cups_comunes_tipo');
		return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerTiposCupsUrgGine()
	{
		$this->db->order_by('nombre_tipo','ASC');
		$this->db->where('id_tipo','7');
		$this->db->or_where('id_tipo','8');
		$this->db->or_where('id_tipo','9');
		$res = $this->db->get('urg_cups_comunes_tipo');
		return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsUrg($id_tipo)
	{
		$this->db->order_by('descripcion','ASC');
		$this->db->where('id_tipo',$id_tipo);
		$res = $this->db->get('urg_cups_comunes');
		return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function egresoUrgenciasDb($d)
	{
		$estado = $this->obtenerestadoDestino($d['id_destino']);
		
		$update = array(
		'estado_salida' =>  $d['estado_salida'],
		'fecha_egreso' 	=>  date('Y-m-d H:i:s'),
		'id_estado' 	=> $estado,
		'id_destino' 	=> $d['id_destino'],
		'obser_destino' => $d['obser_destino'],
		'activo'		=> 'NO',
		'id_usuario' 	=> $this -> session -> userdata('id_usuario'),);
		$this->db->where('id_atencion',$d['id_atencion']);
		$this->db->update('urg_atencion',$update);
		
		$insert = array('id_estado' 	=> $estado,
						'id_usuario' 	=> $this -> session -> userdata('id_usuario'),
						'id_atencion' 	=> $d['id_atencion'],
						'fecha_modificacion' => date('Y-m-d H:i:s'));
		$this->db->insert('urg_atencion_detalle',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene las evoluciones seleccionadas en la epicrisis
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110408
* @version		20110408
* @return		array[object]
*/	
	function obtenerEvosEpicrisis($id_epicrisis)
	{
		$this->db->SELECT('
  urg_epicrisis_evo.id_epicrisis,
  urg_evoluciones.id_evolucion, 
  urg_evoluciones.subjetivo,
  urg_evoluciones.objetivo,
  urg_evoluciones.analisis,
  urg_evoluciones.conducta,
  urg_evoluciones.fecha_evolucion,
  core_evoluciones_tipo.tipo_evolucion,
  core_especialidad.descripcion As esp,
  core_medico.tarjeta_profesional,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre');
$this->db->FROM('urg_epicrisis_evo');
$this->db->JOIN('urg_evoluciones','urg_epicrisis_evo.id_evolucion = urg_evoluciones.id_evolucion');
$this->db->JOIN('core_evoluciones_tipo','urg_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
$this->db->JOIN('core_medico','urg_evoluciones.id_medico = core_medico.id_medico');
$this->db->JOIN('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->where('urg_epicrisis_evo.id_epicrisis',$id_epicrisis);
$res = $this->db->get();
return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene los diagnosticos de ingreso seleccionados en la epicrisis
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110408
* @version		20110408
* @return		array[object]
*/	
	function obtenerDxEpiI($id_epicrisis)
	{
$this->db->SELECT(' 
core_diag_item.diagnostico,
urg_epicrisis_dx.id_diag,
urg_epicrisis_dx.id_epicrisis,
urg_epicrisis_dx.tipo_dx');
$this->db->FROM('core_diag_item');
$this->db->JOIN('urg_epicrisis_dx','core_diag_item.id_diag = urg_epicrisis_dx.id_diag');
$this->db->where('urg_epicrisis_dx.tipo_dx','ingreso');
$this->db->where('urg_epicrisis_dx.id_epicrisis',$id_epicrisis);
$res = $this->db->get();
return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene los diagnosticos de ingreso seleccionados en la epicrisis
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110408
* @version		20110408
* @return		array[object]
*/	
	function obtenerDxEpiE($id_epicrisis)
	{
$this->db->SELECT(' 
core_diag_item.diagnostico,
 urg_epicrisis_dx.id_diag,
urg_epicrisis_dx.id_epicrisis,
urg_epicrisis_dx.tipo_dx');
$this->db->FROM('core_diag_item');
$this->db->JOIN('urg_epicrisis_dx','core_diag_item.id_diag = urg_epicrisis_dx.id_diag');
$this->db->where('urg_epicrisis_dx.tipo_dx','egreso');
$this->db->where('urg_epicrisis_dx.id_epicrisis',$id_epicrisis);
$res = $this->db->get();
return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerOrdenesInsumos($id_atencion)
	{
		$this->db->select('
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  urg_orde_insumos.fecha_creacion,
		  urg_orde_insumos.id_orden_insumos');
$this->db->from('urg_orde_insumos');
$this->db->join('urg_ordenamiento','urg_orde_insumos.id_orden = urg_ordenamiento.id_orden');
$this->db->join('core_medico','urg_orde_insumos.id_medico = core_medico.id_medico');
$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->where('urg_ordenamiento.id_atencion',$id_atencion);
$this->db->order_by('urg_orde_insumos.fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerOrdenInsumosDetalle($id_orden_insumos)
	{
		$this->db->where('id_orden_insumos',$id_orden);
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function crearOrdenInsumosIndepeDb($d)
	{
		$dat = array();
    $dat['error'] = $error = false;
    $insert = array(
    'id_usuario' => $this -> session -> userdata('id_usuario'),
    'id_medico' => $d['id_medico'],
    'fecha_creacion' => date('Y-m-d H:i:s'),
    'id_servicio' => $d['id_servicio'],
    'id_orden' => $d['id_orden']);
    $r = $this->db->insert('urg_orde_insumos',$insert);
    $dat['id_orden'] = $this->db->insert_id();
    if($r != 1){
      $error = true;
      return $dat['error'] = $error;}
    //----------------------------------------------------------
    if(count($d['codigo_insumo']) > 0 && strlen($d['codigo_insumo'][0]) > 0)
    {
      for($i=0;$i<count($d['codigo_insumo']);$i++)
      {
        $insert = array(
          'id_insumo'    => $d['codigo_insumo'][$i],
          'cantidad'    => $d['cantidad'][$i],
          'observaciones'    => $d['observaciones'][$i],
          'id_orden_insumos'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_insumos_detalle', $insert); 
      }
    }
    //----------------------------------------------------------
    return $dat;  
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function cambiarObservacionDb($id_observacion,$id_cama)
	{
		$update = array(
			'id_cama' => $id_cama);
		$this->db->where('id_observacion',$id_observacion);
		$this->db->update('urg_observacion',$update);
		
		$update = array('id_estado' =>'2');
		$this->db->where('id_cama',$id_cama);
		$this->db->update('core_cama',$update);
	}
/////////////////////////////////////////////////////////////////////////////////////
function retiroVoluntario($d)
{
	$insert = array(
		'id_atencion'	=> $d['id_atencion'], 
		'id_medico'		=> $d['id_medico'],
		'fecha_retiro'	=> date('Y-m-d H:i:s'),
		'id_usuario'	=> $this -> session -> userdata('id_usuario')
	);
	$this->db->insert('urg_retiro_voluntario',$insert);
	
	$update = array(
		'fecha_modificacion'=> date('Y-m-d H:i:s'),
		'id_estado'			=> '10',
		'activo'			=> 'NO',
		'fecha_egreso'		=> date('Y-m-d H:i:s'),
		'id_usuario'		=> $this -> session -> userdata('id_usuario')
		);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('urg_atencion',$update);
		
}
/////////////////////////////////////////////////////////////////////////////////////
function comprobarPassword($d)
{
	$this->db->where('id_usuario',$this->session->userdata('id_usuario'));
	$result = $this->db->get('core_usuario');
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			$res = $result->row_array();
			if(md5($d['password']) == $res['_password'])
			{
				return true;
			}else{
				return false;
			}
		}
}
/////////////////////////////////////////////////////////////////////////////////////
function obtenerInfoRetiro($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->limit(1);
	$res = $this->db->get('urg_retiro_voluntario');
	return $res->row_array();
}
/////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene un medicamento de una orden
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110726
* @version		20110726
* @return		array[object]
*/
function obtenerMediOrdenModi($id_orden,$atc)
{
	$this->db->where('id_orden',$id_orden);
	$this->db->where('atc',$atc);
	$this->db->limit(1);
	$res = $this->db->get('urg_orde_medicamentos ');
	return $res->row_array();
}
/*
* Obtiene un medicamento de una orden por Id
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110726
* @version		20110726
* @return		array[object]
*/
function obtenerMediOrdenModiId($id_orden,$id)
{
	$this->db->where('id_orden',$id_orden);
	$this->db->where('id',$id);
	$this->db->limit(1);
	$res = $this->db->get('urg_orde_medicamentos ');
	return $res->row_array();
}
/////////////////////////////////////////////////////////////////////////////////////
/*
* Abre la atención ya finalizada de un pasiente y la reestablece
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20111012
* @version		20111012
*/
function abrirAtencionDb($d){
$this->db->trans_start();
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$update = array(
	'activo' => 'SI',
	'id_estado' => $d['id_estado']
);
$this->db->where('id_atencion',$d['id_atencion']);
$this->db->update('urg_atencion',$update);
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$update = array(
	'fecha_salida' => '0000-00-00 00:00:00',
	'estado' => 'activo',
	'id_cama' => '0',
	'ingreso_sala' => 'NO'
);
$this->db->where('id_atencion',$d['id_atencion']);
$this->db->update('urg_observacion',$update);
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$this->db->where('id_atencion',$d['id_atencion']);
$this->db->delete('urg_epicrisis');
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$insert = array(
	'id_atencion' 		=> $d['id_atencion'],
	'fecha_egreso'		=> $d['fecha_egreso'],
	'fecha_apertura'	=> date('Y-m-d H:i:s'),
	'id_usuario'		=> $this -> session -> userdata('id_usuario'),
	'motivo'			=> $d['motivo'],
	'id_medico'			=> $d['id_medico']
);
$this->db->insert('urg_apertura_atencion',$insert);
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$this->db->trans_complete();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function trasladar_atencionDb($d)
{
$this->db->trans_start();
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$update = array('id_paciente' => $d['id_paciente_destino']);
$this->db->where('id_atencion',$d['id_atencion']);
$this->db->update('urg_atencion',$update);
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
$insert = array(
	'id_atencion' => $d['id_atencion'],
	'id_paciente_origen' => $d['id_paciente_origen'],
	'id_paciente_destino' => $d['id_paciente_destino'],
	'justificacion' => $d['justificacion'],
	'operacion' => $d['operacion'],
	'fecha' => date('Y-m-d H:i:s'),
	'id_usuario' => $this -> session -> userdata('id_usuario')
);
$this->db->insert('urg_traslado_atenciones',$insert);
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
$this->db->trans_complete();
//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function borrarPacienteSinAtenciones($id_paciente)
{
	$this->db->where('id_paciente',$id_paciente);
	$result = $this->db->get('urg_atencion');
	$num = $result->num_rows();
	if($num == 0){
		$this->db->where('id_paciente',$id_paciente);
		$this->db->limit(1);
		$res = $this->db->get('core_paciente');
		$r = $res->row_array();
		$this->db->where('id_tercero',$r['id_tercero']);
		$this->db->delete('core_tercero');
		return true;
	}else{
		return false;	
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/* function obtenerNotaEnfermeria($id_nota)
	{
		$this -> db -> where('id_nota',$id_nota);
		$result = $this -> db ->get('urg_notas_enfermeria');
		return $result -> row_array();
	}
	*/
	
/////////////////////////////////////////////////////////////////////////////////////
/*
* guarda la remision generada despues de la epicrisis
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

*/		

	function remisionDb($d)
	{
		$dat = array();
		
		$insert = array(
		'id_atencion' 		=> $d['id_atencion'],
		'id_medico' 		=> $d['id_medico'],
		'fecha_egreso' 		=> $d['fecha_egreso'],
		'id_servicio' 		=> $d['id_servicio'],
		'estado_salida' 	=> $d['estado_salida'],
		'complicaciones' 	=> $d['complicaciones'],
		'resumen_anamnesis' 	=> $d['resumen_anamnesis'],
		'examenes_auxiliares'=> $d['examenes_auxiliares'],
		'motivo_remision' => $d['motivo_remision'],
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
		$this -> db -> insert('urg_remision',$insert);
		$dat['id_remision'] = $this->db->insert_id();
	
		//----------------------------------------------------
		if(count($d['dxI']) > 0 && strlen($d['dxI'][0]) > 0)
		{
			for($i=0;$i<count($d['dxI']);$i++)
			{
				$insert = array(
					'id_diag' 		=> $d['dxI'][$i],
					'tipo_dx'		=> 'ingreso',
					'id_remision' 	=> $dat['id_remision'] );
				$this->db->insert('urg_remision_dx', $insert); 
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
					'id_remision' 	=> $dat['id_remision'] );
				$this->db->insert('urg_remision_dx', $insert); 
			}
		}
		//----------------------------------------------------	
		if(count($d['evos']) > 0 && strlen($d['evos'][0]) > 0)
		{
			for($i=0;$i<count($d['evos']);$i++)
			{
				$insert = array(
					'id_evolucion' 	=> $d['evos'][$i],
					'id_remision' 	=> $dat['id_remision'] );
				$this->db->insert('urg_remision_evo', $insert); 
			}
		}
		//----------------------------------------------------		
		
	}
	
	/*
* muestra la remision generada despues de la epicrisis
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

*/	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerRemision($id_atencion)
	{
		
		$this->db->FROM('urg_remision');
		$this->db->JOIN('core_especialidad','urg_remision.id_especialidad = core_especialidad.id_especialidad','left');
		
		$this->db->limit(1);
		$this->db->WHERE('id_atencion',$id_atencion);
		$result = $this->db->get();

		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
* Obtiene las evoluciones seleccionadas en la epicrisis
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @return		array[object]
*/	
	function obtenerEvosRemision($id_remision)
	{
		$this->db->SELECT('
  urg_remision_evo.id_remision,
  urg_evoluciones.id_evolucion, 
  urg_evoluciones.subjetivo,
  urg_evoluciones.objetivo,
  urg_evoluciones.analisis,
  urg_evoluciones.conducta,
  urg_evoluciones.fecha_evolucion,
  core_evoluciones_tipo.tipo_evolucion,
  core_especialidad.descripcion As esp,
  core_medico.tarjeta_profesional,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre');
$this->db->FROM('urg_remision_evo');
$this->db->JOIN('urg_evoluciones','urg_remision_evo.id_evolucion = urg_evoluciones.id_evolucion');
$this->db->JOIN('core_evoluciones_tipo','urg_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
$this->db->JOIN('core_medico','urg_evoluciones.id_medico = core_medico.id_medico');
$this->db->JOIN('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->where('urg_remision_evo.id_remision',$id_remision);
$res = $this->db->get();
return $res->result_array();
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene los diagnosticos de ingreso seleccionados en la remision
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function obtenerDxRemI($id_remision)
	{
$this->db->SELECT(' 
core_diag_item.diagnostico,
urg_remision_dx.id_diag,
urg_remision_dx.id_remision,
urg_remision_dx.tipo_dx');
$this->db->FROM('core_diag_item');
$this->db->JOIN('urg_remision_dx','core_diag_item.id_diag = urg_remision_dx.id_diag');
$this->db->where('urg_remision_dx.tipo_dx','ingreso');
$this->db->where('urg_remision_dx.id_remision',$id_remision);
$res = $this->db->get();
return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene los diagnosticos de ingreso seleccionados en la remision
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]

*/	
	function obtenerDxRemE($id_remision)
	{
$this->db->SELECT(' 
core_diag_item.diagnostico,
 urg_remision_dx.id_diag,
urg_remision_dx.id_remision,
urg_remision_dx.tipo_dx');
$this->db->FROM('core_diag_item');
$this->db->JOIN('urg_remision_dx','core_diag_item.id_diag = urg_remision_dx.id_diag');
$this->db->where('urg_remision_dx.tipo_dx','egreso');
$this->db->where('urg_remision_dx.id_remision',$id_remision);
$res = $this->db->get();
return $res->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* verifica si existe una remision previa
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]

*/	
	function existe_remision($id_atencion)
	{
$this->db->SELECT(' 
urg_remision.id_atencion,
urg_remision.id_remision,
');
$this->db->FROM('urg_remision');
$this->db->where('urg_remision.id_atencion',$id_atencion);
$res = $this->db->get();
return $res->result_array();
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Elimina una remision
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]

*/		
	
function cancelar_remision($id_atencion)
	{
$this->db->where('id_atencion',$id_atencion);
$this->db->delete('urg_remision');
	}	

function obtenerPacientesEntregaTurno($id_servicio)
{
	$this->db->select(' 
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tipo_documentos.tipo_documento,
  core_tercero.numero_documento,
  core_tercero.fecha_nacimiento,
  core_cama.numero_cama,
  urg_atencion.id_servicio,
  urg_atencion.id_atencion');
	$this->db->from('urg_atencion');
	$this->db->join('urg_observacion','urg_atencion.id_atencion = urg_observacion.id_atencion');
	$this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->join('core_cama','urg_observacion.id_cama = core_cama.id_cama');
	$this->db->where('urg_observacion.estado','ACTIVO');
	$this->db->where('urg_observacion.ingreso_sala','SI');
	$this->db->where('urg_observacion.id_servicio',$id_servicio);
	$this->db->order_by('core_cama.numero_cama','ASC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
	
function obtenerPacienteEntregaTurno($id_atencion)
{
	$this->db->select(' 
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tipo_documentos.tipo_documento,
  core_tercero.numero_documento,
  core_tercero.fecha_nacimiento,
  core_cama.numero_cama,
  urg_atencion.id_servicio,
  urg_atencion.id_atencion');
	$this->db->from('urg_atencion');
	$this->db->join('urg_observacion','urg_atencion.id_atencion = urg_observacion.id_atencion');
	$this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->join('core_cama','urg_observacion.id_cama = core_cama.id_cama');
	$this->db->where('urg_atencion.id_atencion',$id_atencion);
	$result = $this->db->get();
	return $result->row_array();
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerMedicosHospitalarios()
	{
		$this -> db -> select(' 
		  core_medico.id_medico,
		  core_medico.tarjeta_profesional,
		  core_especialidad.descripcion As especialidad,
		  core_tercero.primer_apellido,
		  core_tercero.segundo_apellido,
		  core_tercero.primer_nombre,
		  core_tercero.segundo_nombre,
		  core_tercero.numero_documento,
		  core_tipo_documentos.tipo_documento,
		  core_tipo_medico.id_tipo_medico,
		  core_tipo_medico.descripcion As tipo_medico');
		$this->db->from('core_medico');
  	$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
  $this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
  $this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
  $this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
  $this->db->where('core_tipo_medico.id_tipo_medico','2');
  $this->db->order_by('core_tercero.primer_apellido','ASC');
  $result = $this->db->get();
		return $result->result_array();
	}
////////////////////////////////////////////////////////////////////////////////////
function pacientes_seleccionadosDB($d)
{
	$insert = array(
	'id_medico_entrega'	=> $d['id_medico_entrega'],
	'id_medico_recibe'	=> $d['id_medico_recibe'],
	'fecha_hora_entrega' => $d['fecha_hora_entrega'],
	'id_servicio' => $d['id_servicio']);
	$this->db->insert('urg_entrega_turno',$insert);
	$id_entrega = $this->db->insert_id();
	//----------------------------------------------------
	if(count($d['id_atencion']) > 0 && strlen($d['id_atencion'][0]) > 0)
	{
		for($i=0;$i<count($d['id_atencion']);$i++)
		{
			$insert = array(
			'id_atencion' 		=> $d['id_atencion'][$i],
			'id_especialidad' 	=> $d['id_especialidad'][$i],
			'pendiente' 		=> $d['pendiente'][$i],
			'observaciones' 	=> $d['observaciones'][$i],
			'id_entrega'		=> $id_entrega );
			$this->db->insert('urg_entrega_turno_detalle', $insert); 
		}
	}
	return $id_entrega;	
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerEntregaTurno($id_entrega)
{
	$this->db->SELECT("
	CONCAT(core_tercero.primer_apellido,' ' ,
	core_tercero.segundo_apellido,' ',
	core_tercero.primer_nombre,' ',
	core_tercero.segundo_nombre) AS medico_entrega,
	CONCAT(core_tercero1.primer_apellido,' ',
	core_tercero1.segundo_apellido, ' ',
	core_tercero1.primer_nombre, ' ',
	core_tercero1.segundo_nombre) AS medico_recibe,
	urg_entrega_turno.fecha_hora_entrega,
	urg_entrega_turno.id_servicio,
	urg_entrega_turno.id_entrega,
	core_servicios_hosp.nombre_servicio",FALSE);
	$this->db->from('urg_entrega_turno');
	$this->db->JOIN('core_medico','urg_entrega_turno.id_medico_entrega = core_medico.id_medico');
	$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->JOIN('core_medico core_medico1','urg_entrega_turno.id_medico_recibe = core_medico1.id_medico');
	$this->db->JOIN('core_tercero core_tercero1','core_medico1.id_tercero = core_tercero1.id_tercero');
	$this->db->JOIN('core_servicios_hosp','urg_entrega_turno.id_servicio = core_servicios_hosp.id_servicio');
	$this->db->where('urg_entrega_turno.id_entrega',$id_entrega);
	$this->db->limit(1);
	$result = $this -> db -> get();
	return $result -> row_array();
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerEntregaTurnoDetalle($id_entrega)
{
	$this->db->SELECT("
	CONCAT(core_tercero.primer_nombre,' ',
	core_tercero.segundo_nombre,' ',
	core_tercero.primer_apellido,' ',
	core_tercero.segundo_apellido) AS paciente,
	core_tercero.numero_documento,
	core_especialidad.descripcion AS espe,
	urg_entrega_turno_detalle.id_atencion,
	core_tipo_documentos.tipo_documento,
	urg_entrega_turno_detalle.pendiente,
	core_cama.numero_cama,
	urg_entrega_turno_detalle.observaciones",FALSE);
	$this->db->FROM('urg_entrega_turno_detalle');
	$this->db->JOIN('core_especialidad','urg_entrega_turno_detalle.id_especialidad = core_especialidad.id_especialidad');
	$this->db->JOIN('urg_atencion','urg_entrega_turno_detalle.id_atencion = urg_atencion.id_atencion');
	$this->db->JOIN('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->JOIN('urg_observacion','urg_atencion.id_atencion = urg_observacion.id_atencion');
  	$this->db->JOIN('core_cama','urg_observacion.id_cama = core_cama.id_cama');
	$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->where('urg_entrega_turno_detalle.id_entrega',$id_entrega);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}
}
////////////////////////////////////////////////////////////////////////////////////
function verificaPacienteEntregaTurno($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('id_entrega_detalle','DESC');
	$result = $this->db->get('urg_entrega_turno_detalle');	
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->first_row('array');
	}
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerTiempoEstancia($id_atencion,$fa)
{
	$this->db->SELECT('TIMESTAMPDIFF(HOUR, urg_observacion.fecha_ingreso, "'.$fa.'") AS N',false);
	$this->db->FROM('urg_observacion');
	$this->db->WHERE('urg_observacion.id_atencion',$id_atencion);
	$result = $this->db->get();
	$r = $result->row_array();
	return $r['N'];
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerListaEntregaTurno($d)
{
	$this->db->SELECT("
	core_servicios_hosp.nombre_servicio,
	CONCAT(core_tercero.primer_nombre,' ',
	core_tercero.segundo_nombre,' ',
	core_tercero.primer_apellido,' ',
	core_tercero.segundo_apellido) AS medico_entrega,
	CONCAT(core_tercero1.primer_nombre,' ',
	core_tercero1.segundo_nombre,' ',
	core_tercero1.primer_apellido,' ',
	core_tercero1.segundo_apellido) AS medico_recibe,
	urg_entrega_turno.id_entrega,
	urg_entrega_turno.fecha_hora_entrega",FALSE);
	$this->db->FROM('urg_entrega_turno');
	$this->db->JOIN(' core_servicios_hosp','urg_entrega_turno.id_servicio = core_servicios_hosp.id_servicio');
	$this->db->JOIN('core_medico','urg_entrega_turno.id_medico_entrega = core_medico.id_medico');
	$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	$this->db->JOIN('core_medico core_medico1','urg_entrega_turno.id_medico_recibe = core_medico1.id_medico');
	$this->db->JOIN('core_tercero core_tercero1','core_medico1.id_tercero = core_tercero1.id_tercero');
	if($d['id_servicio'] != 0)
		$this->db->where('urg_entrega_turno.id_servicio',$d['id_servicio']);
	$this->db->where('urg_entrega_turno.fecha_hora_entrega >=', $d['fecha_inicio']);
	$this->db->where('urg_entrega_turno.fecha_hora_entrega <=', $d['fecha_fin']);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}	
}
////////////////////////////////////////////////////////////////////////////////////
function segu_riesgo_caidasDb($d){
	$insert = array(
	'limitacion_fisica' => $d['limitacion_fisica'],
	'estado_mental' => $d['estado_mental'],
	'tratamiento_farmacologico' => $d['tratamiento_farmacologico'],
	'problemas_de_idioma' => $d['problemas_de_idioma'],
	'incontinencia_urinaria' => $d['incontinencia_urinaria'],
	'deficit_sensorial' => $d['deficit_sensorial'],
	'desarrollo_psicomotriz' => $d['desarrollo_psicomotriz'],
	'pacientes_sin_facores' => $d['pacientes_sin_facores'],
	'fecha_creacion' => date('Y-m-d H:i:s'),
	'id_usuario' => $this->session->userdata('id_usuario'),
	'id_atencion' => $d['id_atencion'],
	'id_medico' => $d['id_medico'],
	);
	$this->db->insert('urg_riesgo_caidas',$insert);
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerValoracionPuntajeRiesgo($id_atencion)
{
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_creacion','DESC');
	$result = $this->db->get('urg_riesgo_caidas');
	$num = $result->num_rows();
	if($num == 0)
		return 20;
	
	
	$row = $result->first_row('array');
	$puntaje = 0;
	$puntaje = $row['limitacion_fisica']+$row['estado_mental']+$row['tratamiento_farmacologico']+$row['problemas_de_idioma']+$row['incontinencia_urinaria']+$row['deficit_sensorial']+$row['desarrollo_psicomotriz']+$row['pacientes_sin_facores'];
	return $puntaje;
}
////////////////////////////////////////////////////////////////////////////////////
function obtenerListaValoracionRiesgo($id_atencion)
{
	$this->db->SELECT("
  	CONCAT(core_tercero.primer_nombre,' ',
  core_tercero.segundo_nombre,' ',
  core_tercero.primer_apellido,' ',
  core_tercero.segundo_apellido) AS medico,
  urg_riesgo_caidas.id,
  urg_riesgo_caidas.limitacion_fisica,
  urg_riesgo_caidas.estado_mental,
  urg_riesgo_caidas.tratamiento_farmacologico,
  urg_riesgo_caidas.problemas_de_idioma,
  urg_riesgo_caidas.incontinencia_urinaria,
  urg_riesgo_caidas.deficit_sensorial,
  urg_riesgo_caidas.desarrollo_psicomotriz,
  urg_riesgo_caidas.pacientes_sin_facores,
  urg_riesgo_caidas.fecha_creacion",FALSE);
$this->db->FROM('urg_riesgo_caidas');
$this->db->JOIN('core_medico','urg_riesgo_caidas.id_medico = core_medico.id_medico');
$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
	
	$this->db->where('id_atencion',$id_atencion);
	$this->db->order_by('fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}	
}

function obtenerValoracionRiesgo($id)
{
	$this->db->SELECT("
  	CONCAT(core_tercero.primer_nombre,' ',
  core_tercero.segundo_nombre,' ',
  core_tercero.primer_apellido,' ',
  core_tercero.segundo_apellido) AS medico,
  urg_riesgo_caidas.id,
  urg_riesgo_caidas.limitacion_fisica,
  urg_riesgo_caidas.estado_mental,
  urg_riesgo_caidas.tratamiento_farmacologico,
  urg_riesgo_caidas.problemas_de_idioma,
  urg_riesgo_caidas.incontinencia_urinaria,
  urg_riesgo_caidas.deficit_sensorial,
  urg_riesgo_caidas.desarrollo_psicomotriz,
  urg_riesgo_caidas.pacientes_sin_facores,
  urg_riesgo_caidas.fecha_creacion",FALSE);
$this->db->FROM('urg_riesgo_caidas');
$this->db->JOIN('core_medico','urg_riesgo_caidas.id_medico = core_medico.id_medico');
$this->db->JOIN('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
$this->db->where('id',$id);
$result = $this->db->get();
return $result->row_array();	
}
////////////////////////////////////////////////////////////////////////////////////
function ingresar_paciente_pre_triage($nd)
{
	$insert = array(
	'numero_documento' => $nd,
	'fecha_ingreso' => date('Y-m-d H:i:s'),
	'activo' => 'SI',
	'id_usuario' => $this->session->userdata('id_usuario'),
	);
	
	$this->db->insert('urg_pre_triage',$insert);	
}
///////////////////////////////Fin//////////////////////////////////////////////////	
}