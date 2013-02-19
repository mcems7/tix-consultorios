<?php
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Autorizaciones_model
 *Tipo: modelo
 *Descripcion: Gestión de la central de autorizaciones
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 01 de diciembre de 2010
*/
class Autorizaciones_model extends Model 
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
		$this->db->join('core_servicios_hosp','urg_atencion.id_servicio = core_servicios_hosp.id_servicio');
		$this->db->where('core_tercero.numero_documento',$d['numero_documento']);
	    $this->db->where('urg_atencion.activo','SI');


		$result = $this->db->get();
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerReporta($anexo)
	{
		$this -> db -> where('anexo',$anexo);
		$result = $this->db->get('auto_reporta_anexo');
		return $result->row_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	function obtenerConsecutivo($anexo)
	{
		$fecha = date('Y');
		$conse = 0;
		
		$this->db->where('id','1');
		$result = $this->db->get('auto_consecutivo');
		$res = $result->row_array();
		
		if($fecha != $res['fecha']){
			$update = array('fecha' => $fecha,'anexo1' => '0','anexo2' => '0','anexo3' => '0');
			$this->db->where('id','1');
			$this->db->update('auto_consecutivo',$update);	
			$conse = 1;
			if($anexo == 1){
				$this->db->where('id','1');
				$this->db->update('auto_consecutivo',array('anexo1' => $conse)); 
			}else if($anexo == 2){
				$this->db->where('id','1');
				$this->db->update('auto_consecutivo',array('anexo2' => $conse));
			}else if($anexo == 3){
				$this->db->where('id','1');
				$this->db->update('auto_consecutivo',array('anexo3' => $conse));
			}
		}else{
			if($anexo == 1){
				$conse = $res['anexo1'] + 1;
				$this->db->where('id','1');
				$this->db->update('auto_consecutivo',array('anexo1' => $conse)); 
			}else if($anexo == 2){
				$conse = $res['anexo2'] + 1;	
				$this->db->where('id','1');
				$this->db->update('auto_consecutivo',array('anexo2' => $conse));
			}else if($anexo == 3){
				$conse = $res['anexo3'] + 1;	
				$this->db->where('id','1');
				$this->db->update('auto_consecutivo',array('anexo3' => $conse));
			}
			
		}
		return $conse;
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEmpresa($id_empresa)
	{
		
		$this->db->SELECT(' 
  core_empresa.id_empresa,
  core_departamento.nombre As depa,
  core_municipio.nombre As muni,
  core_empresa.telefono1,
  core_empresa.id_municipio,
  core_empresa.indicativo,
  core_empresa.direccion,
  core_empresa.codigo,
  core_empresa.nit_dv,
  core_empresa.nit,
  core_empresa.razon_social');
$this->db->FROM('core_departamento');
$this->db->JOIN('core_empresa','core_departamento.id_departamento = core_empresa.id_departamento');
$this->db->JOIN('core_municipio','core_empresa.id_municipio = core_municipio.id_municipio');
	$this->db->where('id_empresa',$id_empresa);
	$result = $this->db->get();
	return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCobertura()
	{
		$result = $this->db->get('core_cobertura_salud ');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function anexo1Db($d)
	{
		$insert = array(
		'id_paciente' => $d['id_paciente'],
		'id_atencion' => $d['id_atencion'],
		'fecha_anexo' => $d['fecha_anexo'],
		'hora_anexo' => $d['hora_anexo'],
		'cod_depa_empresa' => $d['cod_depa_empresa'],
		'cod_muni_empresa' => $d['cod_muni_empresa'],
		'numero_informe' => $d['numero_informe'],
		'id_empresa' => $d['id_empresa'],
		'id_entidad' => $d['id_entidad'],
		'tipo_inconsistencia' => $d['tipo_inconsistencia'],
		'primer_apellido' => $d['primer_apellido'],
		'segundo_apellido' => $d['segundo_apellido'],
		'primer_nombre' => $d['primer_nombre'],
		'segundo_nombre' => $d['segundo_nombre'],
		'id_tipo_documento' => $d['id_tipo_documento'],
		'numero_documento' => $d['numero_documento'],
		'fecha_nacimiento' => $d['fecha_nacimiento'],
		'direccion' => $d['direccion'],
		'telefono' => $d['telefono'],
		'departamento' => $d['departamento'],
		'municipio' => $d['municipio'],
		'cobertura' => $d['cobertura'],
		'primer_apellido_caja' => $d['primer_apellido_caja'],
		'segundo_apellido_caja' => $d['segundo_apellido_caja'],
		'primer_nombre_caja' => $d['primer_nombre_caja'],
		'segundo_nombre_caja' => $d['segundo_nombre_caja'],
		'tipo_documento_caja' => $d['tipo_documento_caja'],
		'numero_documento_caja' => $d['numero_documento_caja'],
		'fecha_nacimiento_caja' => $d['fecha_nacimiento_caja'],
		'primer_apellido_doc' => $d['primer_apellido_doc'],
		'segundo_apellido_doc' => $d['segundo_apellido_doc'],
		'primer_nombre_doc' => $d['primer_nombre_doc'],
		'segundo_nombre_doc' => $d['segundo_nombre_doc'],
		'tipo_documento_doc' => $d['tipo_documento_doc'],
		'numero_documento_doc' => $d['numero_documento_doc'],
		'fecha_nacimiento_doc' => $d['fecha_nacimiento_doc'],
		'observaciones' => $d['observaciones'],
		'nombre_reporta' => $d['nombre_reporta'],
		'indicativo_reporta' => $d['indicativo_reporta'],
		'telefono_reporta' => $d['telefono_reporta'],
		'ext_reporta' => $d['ext_reporta'],
		'cargo_reporta' => $d['cargo_reporta'],
		'celular_reporta' => $d['celular_reporta'],
		'fecha' => date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('auto_anexo1',$insert);
		//----------------------------------------------------
		$id_anexo = $this->db->insert_id();
		//----------------------------------------------------
		return $id_anexo;

	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAnexo1($id_anexo)
	{
$this->db->SELECT('
  auto_anexo1.id_usuario,
  auto_anexo1.fecha,
  auto_anexo1.observaciones,
  auto_anexo1.fecha_nacimiento_doc,
  auto_anexo1.numero_documento_doc,
  auto_anexo1.tipo_documento_doc,
  auto_anexo1.segundo_nombre_doc,
  auto_anexo1.primer_nombre_doc,
  auto_anexo1.segundo_apellido_doc,
  auto_anexo1.primer_apellido_doc,
  auto_anexo1.fecha_nacimiento_caja,
  auto_anexo1.numero_documento_caja,
  auto_anexo1.tipo_documento_caja,
  auto_anexo1.segundo_nombre_caja,
  auto_anexo1.primer_nombre_caja,
  auto_anexo1.segundo_apellido_caja,
  auto_anexo1.primer_apellido_caja,
  auto_anexo1.cobertura,
  core_municipio.nombre As muni,
  auto_anexo1.municipio,
  core_departamento.nombre As depa,
  auto_anexo1.departamento,
  auto_anexo1.telefono,
  auto_anexo1.direccion,
  auto_anexo1.fecha_nacimiento,
  auto_anexo1.numero_documento,
  auto_anexo1.segundo_nombre,
  auto_anexo1.id_tipo_documento,
  auto_anexo1.primer_nombre,
  auto_anexo1.segundo_apellido,
  auto_anexo1.primer_apellido,
  auto_anexo1.tipo_inconsistencia,
  auto_anexo1.id_entidad,
  auto_anexo1.id_empresa,
  auto_anexo1.numero_informe,
  auto_anexo1.hora_anexo,
  auto_anexo1.fecha_anexo,
  auto_anexo1.id_paciente,
  auto_anexo1.id_atencion,
  auto_anexo1.id_anexo1,
  auto_anexo1.cod_depa_empresa,
  auto_anexo1.cod_muni_empresa,
  auto_anexo1.nombre_reporta,
  auto_anexo1.indicativo_reporta,
  auto_anexo1.telefono_reporta,
  auto_anexo1.ext_reporta,
  auto_anexo1.cargo_reporta,
  auto_anexo1.celular_reporta
');
$this->db->FROM('auto_anexo1');
$this->db->JOIN('core_municipio','auto_anexo1.municipio = core_municipio.id_municipio');
$this->db->JOIN('core_departamento','auto_anexo1.departamento = core_departamento.id_departamento');
$result = $this->db->get();
return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function anexo2Db($d)
	{
		$insert = array(
		'id_paciente' => $d['id_paciente'],
		'id_atencion' => $d['id_atencion'],
		'fecha_anexo' => $d['fecha_anexo'],
		'hora_anexo' => $d['hora_anexo'],
		'cod_depa_empresa' => $d['cod_depa_empresa'],
		'cod_muni_empresa' => $d['cod_muni_empresa'],
		'numero_informe' => $d['numero_informe'],
		'id_empresa' => $d['id_empresa'],
		'id_entidad' => $d['id_entidad'],
		'cobertura' => $d['cobertura'],
		'fecha' => date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('auto_anexo2',$insert);
		//----------------------------------------------------
		$id_anexo = $this->db->insert_id();
		//----------------------------------------------------
		return $id_anexo;

	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAnexo2($id_anexo)
	{
		$this->db->where('id_anexo2',$id_anexo);
		$result = $this->db->get('auto_anexo2');
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEntidadRemite($codigo_entidad)
	{
		$this->db->SELECT('
  core_municipio.nombre AS muni,
  core_departamento.nombre AS depa,
  core_entidad_remision.codigo_entidad,
  core_entidad_remision.id_entidad_remision,
  core_entidad_remision.nombre,
  core_entidad_remision.nit,
  core_entidad_remision.dv,
    core_entidad_remision.Cod_dpto,
  core_entidad_remision.Cod_mpio');
$this->db->FROM('core_entidad_remision');
  $this->db->JOIN('core_municipio','core_entidad_remision.Cod_mpio = core_municipio.id_municipio');
  $this->db->JOIN('core_departamento','core_entidad_remision.Cod_dpto = core_departamento.id_departamento');
		
		$this->db->where('core_entidad_remision.codigo_entidad',$codigo_entidad);
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function anexo3Db($d)
	{
		$insert = array(
		'id_paciente' => $d['id_paciente'],
		'id_atencion' => $d['id_atencion'],
		'fecha_anexo' => $d['fecha_anexo'],
		'id_estado_anexo' => '1',
		'hora_anexo' => $d['hora_anexo'],
		'cod_depa_empresa' => $d['cod_depa_empresa'],
		'cod_muni_empresa' => $d['cod_muni_empresa'],
		'numero_informe' => $d['numero_informe'],
		'id_empresa' => $d['id_empresa'],
		'id_entidad' => $d['id_entidad'],
		'id_origen' => $d['id_origen'],
		'tipo' => $d['tipo'],
		'cobertura' => $d['cobertura'],
		'serv_soli' => $d['serv_soli'],
		'prioridad' => $d['prioridad'],
		'ubicacion_paciente' => $d['ubicacion_paciente'],
		'servicio' => $d['servicio'],
		'cama' => $d['cama'],
		'guia_manejo' => $d['guia_manejo'],
		'justificacion_clinica' => $d['justificacion_clinica'],
		'nombre_reporta' => $d['nombre_reporta'],
		'indicativo_reporta' => $d['indicativo_reporta'],
		'telefono_reporta' => $d['telefono_reporta'],
		'ext_reporta' => $d['ext_reporta'],
		'cargo_reporta' => $d['cargo_reporta'],
		'celular_reporta' => $d['celular_reporta'],
		'numero_envio' => '0',
		'nombre_pdf' => $d['nombre_pdf'],
		'fecha' => date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('auto_anexo3',$insert);
		//----------------------------------------------------------
		$id_anexo = $this->db->insert_id();
		//----------------------------------------------------------
		if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
		{
			for($i=0;$i<count($d['cups']);$i++)
			{
				$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_anexo3' 		=> $id_anexo );
				$this->db->insert('auto_anexo3_cups', $insert); 
			}
		}
		//----------------------------------------------------------
		return $id_anexo;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAnexo3($id_anexo)
	{
		$this->db->where('id_anexo3',$id_anexo);
		$this->db->from('auto_anexo3');
		$this->db->join('core_servicios_hosp','auto_anexo3.servicio = core_servicios_hosp.id_servicio');
		$this->db->join('auto_anexo3_estados','auto_anexo3.id_estado_anexo = auto_anexo3_estados.id_estado_anexo');
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsAnexo3($id_anexo)
	{
		$this->db->where('id_anexo3',$id_anexo);
		$result = $this->db->get('auto_anexo3_cups');
		$num = $result -> num_rows();
		if($num == 0){
		return $num;}
		$res = $result -> result_array();
		return  $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEstadosAnexo3()
	{
		$this -> db -> order_by('estado_anexo','ASC');
		$result = $this->db->get('auto_anexo3_estados');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListadoAnexo3($d)
	{
if($d['id_estado_anexo'] != '0'){		
$this->db->where('auto_anexo3.id_estado_anexo',$d['id_estado_anexo']);
}

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
$result = $this->db->get();
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function contarEnvioAnexo3($id_anexo,$numero_envio)
	{
		if(!($numero_envio > 3)){
			$estado = 2;	
		}else{
			$estado = 5;
		}
		
		$update = array	(
		'numero_envio' => $numero_envio, 
		'id_estado_anexo' => '2' ,
		'fecha_ultimo_envio' => date('Y-m-d H:i:s'));
		$this -> db -> where('id_anexo3',$id_anexo);
		$this -> db -> update('auto_anexo3',$update);
		
		$insert = array(
		'id_anexo3' => $id_anexo,
		'numero_envio' => $numero_envio,
		'fecha' => date('Y-m-d H:i:s'));
		$this -> db -> insert('auto_anexo3_envios',$insert);
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerEnviosAnexo3($id_anexo)
	{
		$this -> db -> where('id_anexo3',$id_anexo);
		$result = $this->db->get('auto_anexo3_envios');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsAnexo($id_anexo3)
	{
		$this -> db -> where('id_anexo3',$id_anexo3);
		$result = $this->db->get('auto_anexo3_cups');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function anexo4Db($d)
	{
		$insert = array(
		'id_anexo3' => $d['id_anexo3'],
		'numero_informe' => $d['numero_informe'],
		'fecha_anexo' => $d['fecha_anexo'],
		'hora_anexo' => $d['hora_anexo'],
		'estado_anexo' => $d['estado_anexo'],
		'porcentaje_pagar' => $d['porcentaje_pagar'],
		'semanas_afiliacion' => $d['semanas_afiliacion'],
		'bono_pago' => $d['bono_pago'], 
		'cuota_moderadora' => $d['cuota_moderadora'],
		'valor_moderadora' => $d['valor_moderadora'],
		'porcentaje_moderadora' => $d['porcentaje_moderadora'], 
		'tope_moderadora' => $d['tope_moderadora'], 
		'copago' => $d['copago'],
		'valor_copago' => $d['valor_copago'],
		'porcentaje_copago' => $d['porcentaje_copago'], 
		'tope_copago' => $d['tope_copago'], 
		'cuota_recuperacion' => $d['cuota_recuperacion'],
		'valor_recuperacion' => $d['valor_recuperacion'], 
		'porcentaje_recuperacion' => $d['porcentaje_recuperacion'], 
		'tope_recuperacion' => $d['tope_recuperacion'],
		'otro' => $d['otro'],
		'valor_otro' => $d['valor_otro'], 
		'porcentaje_otro' => $d['porcentaje_otro'],
		'tope_otro' => $d['tope_otro'],
		'fecha' => date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('auto_anexo4',$insert);
		//----------------------------------------------------------
		$id_anexo = $this->db->insert_id();
		//----------------------------------------------------------
		if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
		{
			for($i=0;$i<count($d['cups']);$i++)
			{
				$insert = array(
					'cups' 		=> $d['cups'][$i],
					'observacionesCups' => $d['observacionesCups'][$i],
					'cantidadCups' => $d['cantidadCups'][$i],
					'id_anexo4' 		=> $id_anexo );
				$this->db->insert('auto_anexo4_cups', $insert); 
			}
		}
		//----------------------------------------------------------
		$update = array	(
		'anexo4' => 'SI',
		'id_estado_anexo' => $d['estado_anexo'],);
		$this -> db -> where('id_anexo3',$d['id_anexo3']);
		$this -> db -> update('auto_anexo3',$update);
		//----------------------------------------------------------
		return $id_anexo;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListadoAnexo4($id_anexo3)
	{	
		$this -> db -> where('id_anexo3',$id_anexo3);
		$result = $this->db->get('auto_anexo4');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function agregarAdjuntoAnexo3($d)
	{
		$insert = array(
		'id_anexo3' => $d['id_anexo3'],
		'titulo' => $d['titulo'],
		'descripcion' => $d['descripcion'],
		'archivo' => $d['archivo'],
		'ext' => $d['ext'],
		'fecha' => date('Y-m-d H:i:s'),
		'id_usuario' => $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('auto_anexo3_adjuntos',$insert);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function obtenerAdjuntosAnexo3($id_anexo3)
	{	
		$this -> db -> where('id_anexo3',$id_anexo3);
		$result = $this->db->get('auto_anexo3_adjuntos');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerAnexo4($id_anexo)
	{
		$this->db->where('id_anexo4',$id_anexo);
		$this->db->from('auto_anexo4');
		$this->db->join('auto_anexo3_estados','auto_anexo4.estado_anexo = auto_anexo3_estados.id_estado_anexo');
		$result = $this->db->get();
		return $result->row_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsAnexo4($id_anexo)
	{
		$this -> db -> where('id_anexo4',$id_anexo);
		$result = $this->db->get('auto_anexo4_cups');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCorreosEntidad($id_entidad)
	{
		$this -> db -> where('id_entidad',$id_entidad);
		$result = $this->db->get('auto_correo_entidad');
		return $result->result_array();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerListadoAnexo2($d)
	{
if($d['enviado'] != 'Todos'){		
$this->db->where('auto_anexo2.enviado',$d['enviado']);
$this->db->where('auto_anexo2.verificado',"NO");
}
$this->db->SELECT(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tipo_documentos.tipo_documento,
  core_tercero.numero_documento,
  core_tercero1.razon_social,
  auto_anexo2.fecha_anexo,
  auto_anexo2.hora_anexo,
  auto_anexo2.numero_informe,
  auto_anexo2.id_anexo2,
  auto_anexo2.enviado');
$this->db->FROM('auto_anexo2');
$this->db->JOIN('core_paciente','auto_anexo2.id_paciente = core_paciente.id_paciente');
$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->JOIN('core_eapb','auto_anexo2.id_entidad = core_eapb.id_entidad');
$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
$this->db->order_by('auto_anexo2.fecha','DESC');
$result = $this->db->get();
		return $result->result_array();		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function envioAnexo2($id_anexo,$envio)
	{
		$update = array('enviado' => $envio);
		$this->db->where('id_anexo2',$id_anexo);
		$this->db->update('auto_anexo2',$update);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function enviarAnexo2Mail($id_anexo)
	{
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo2($id_anexo);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['anexo']['id_atencion']);
		if($d['atencion']['remitido'] == 'SI'){
			$d['entidad_remite'] = $this ->autorizaciones_model -> obtenerEntidadRemite($d['atencion']['codigo_entidad']);
		}	
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		//----------------------------------------------------------
		$d['empresa'] = $this -> autorizaciones_model -> obtenerEmpresa(1);
		//----------------------------------------------------------
		$d['reporta'] = $this -> autorizaciones_model -> obtenerReporta(2);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($d['anexo']['id_atencion']);
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		
		$d['tipo'] = 'email';
		$html_email = $this->load->view('auto/anexo2',$d,true);
		
		//----------------------------------------------------------------------------------------
		$d['tipo'] = 'pdf';
		$html_pdf = $this->load->view('auto/anexo2',$d,true);
		//----------------------------------------------------------	
		$this ->load->plugin('to_pdf');
		$nombre_pdf ='Anexo2';
		$nombre_pdf .= $d['anexo']['fecha_anexo'];
		$nombre_pdf .= $d['anexo']['numero_informe'];
		$nombre_pdf .= $d['tercero']['numero_documento'];	
		
		
		// Envio de correo electronico-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
		$correos = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['anexo']['id_entidad']);
    	
    	$this->load->library('email');
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
		
		$asunto ='Anexo2 ';
		$asunto .= $d['anexo']['numero_informe']." ";
		$asunto .= $d['anexo']['fecha_anexo']." ";
		$asunto .= $d['tercero']['numero_documento']." ";
		$asunto .= $d['tercero']['primer_apellido']." ";
		$asunto .= $d['tercero']['segundo_apellido']." ";
		$asunto .= $d['tercero']['primer_nombre']." ";
		$asunto .= $d['tercero']['segundo_nombre']." ";	
		$lista = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['anexo']['id_entidad']);
		
		$email = array();
		foreach($lista as $email_temp)
		{
			$email[] = $email_temp['correo_entidad'];
		}
		
		if(count($email) == 0)
		{
			$envio = 'NO';
		}else{
		
			//pdf_create ($html_pdf,$nombre_pdf,false);
				
			$this->email->from('cerca@hospitalquindio.gov.co','Hospital Departamental Universitario del Quindío San Juan de Dios');
			
			$this->email->to($email);
			//	Correo de almacenamiento de anexos enviados
			$this->email->cc('bodegacerca@opuslibertati.org'); 
			$this->email->subject($asunto);
			$this->email->message($html_email);
			//	Adjuntar el anexo en PDF para ser enviado en el correo electronico
			//$this->email->attach('./files/auto/anexo3/'.$nombre_pdf.'.pdf');
			if (!$this->email->send())
			{
				$envio = 'NO';
			}else{
				$envio = 'SI';
				
					$update = array('anexo2' => 'SI');
					$this->db->where('id_atencion',$d['anexo']['id_atencion']);
					$this->db->update('urg_atencion',$update);
			}
		}
		$this->autorizaciones_model->envioAnexo2($id_anexo,$envio);
		//echo $this->email->print_debugger();
	}	
	
	public function verificado($dato)
	{
          
            $uid = $this -> session -> userdata('id_usuario');
           $date = date('Y-m-d H:i:s');
                    
                   
	$data = array(
               'verificado_por'=> $uid,
               'verificado' => "SI",
               'verificado_fecha' => $date
            );	
           
            
            $this->db->where('id_anexo2',$dato);

            $this->db->update('auto_anexo2', $data); 
            
            redirect('/auto/anexo2/index', 'refresh');
            
                    			
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerEntes()
{
		$this -> db -> select('core_eapb.id_entidad,core_tercero.razon_social');
		$this -> db -> from('core_eapb');
		$this -> db -> join('core_tercero','core_eapb.id_tercero = core_tercero.id_tercero');
		$this -> db -> order_by('razon_social','ASC');
		$this -> db -> where('id_tipo','2');
		$result = $this -> db -> get();
		return $result -> result_array();	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerPacientesAnexo3($id_paciente)
{
	$this->db->SELECT("
		auto_anexo3.id_paciente,
		auto_anexo3.id_anexo3,
		core_tipo_documentos.tipo_documento,
		core_tercero.numero_documento,
		CONCAT(core_tercero.primer_nombre,' ', core_tercero.segundo_nombre,' ', core_tercero.primer_apellido,' ', core_tercero.segundo_apellido) AS paciente,
		auto_anexo3.fecha_anexo,
		core_tercero1.razon_social,
		core_servicios_hosp.nombre_servicio",FALSE);
	$this->db->FROM('core_paciente');
	$this->db->JOIN('auto_anexo3','core_paciente.id_paciente = auto_anexo3.id_paciente');
	$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->JOIN('core_eapb','auto_anexo3.id_entidad = core_eapb.id_entidad');
	$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
	$this->db->JOIN('core_servicios_hosp','auto_anexo3.servicio = core_servicios_hosp.id_servicio');
	$this->db->ORDER_BY('auto_anexo3.fecha_anexo','DESC');
	$this->db->where('auto_anexo3.id_paciente',$id_paciente);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->result_array();
	}	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerPaciente($numero_documento)
{
	$this->db->SELECT('core_paciente.id_paciente,core_tercero.numero_documento');
	$this->db->FROM('core_tercero');
	$this->db->JOIN('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
	$this->db->where('core_tercero.numero_documento',$numero_documento);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
		return $result->row_array();
	}	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}
