<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: laboratorio_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de laboratorio
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24de octubre de 2011
*/


class Laboratorio_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
    
    $this->load->database();
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerNombreEntidad($id_paciente)
  {
    $this->db->select('core_paciente.id_entidad, core_eapb.id_tercero, core_tercero.razon_social');
    $this->db->from('core_paciente');
    $this->db->join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
    $this->db->join('core_tercero','core_tercero.id_tercero = core_eapb.id_tercero');
    $this->db->where('core_paciente.id_paciente',$id_paciente);
    $result = $this->db->get();
    return $result->row_array();
     
  }

//////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerConsulta($id_atencion)
  {
    $this -> db -> where('id_atencion',$id_atencion);
    $result = $this -> db ->get('urg_consulta');
    return $result -> row_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
        /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerLaboraOrden($id_orden)
  {
  $this->db->select('
  urg_orde_laboratorios.id, 
  urg_orde_laboratorios.id_orden,
  urg_orde_laboratorios.cups,
  urg_orde_laboratorios.cantidadCups,
  urg_orde_laboratorios.observacionesCups,
  core_cups_subcategoria.desc_subcategoria');
  $this->db->from('urg_orde_laboratorios');
  $this->db->join('core_cups_subcategoria','urg_orde_laboratorios.cups = core_cups_subcategoria.id_subcategoria');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = urg_orde_laboratorios.id_orden');
  $this->db->where('urg_ordenamiento.verificado','SI');
  $this->db->where('urg_orde_laboratorios.id_orden',$id_orden);
  $this -> db -> order_by('urg_orde_laboratorios.cups','ASC');
  $result = $this->db->get();
  return $result->result_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
      /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerOrden($id_orden)
  {
  $this->db->select(' 
  urg_ordenamiento.cama_cabeza,
  urg_ordenamiento.cama_pie,
  core_oxigeno.oxigeno As tipoO2,
  core_oxigeno_tipo.tipo_oxigeno As valorO2,
  urg_ordenamiento.liquidos,
  urg_ordenamiento.cuidados_generales,
  urg_ordenamiento.id_orden,
  urg_ordenamiento.fecha_creacion,
  urg_ordenamiento.verificado,
  urg_ordenamiento.id_medico_verifica,
  urg_ordenamiento.id_atencion,
  urg_ordenamiento.id_medico,
  urg_ordenamiento.fecha_verificado,
  urg_ordenamiento.oxigeno');
  $this->db->from('urg_ordenamiento');
  $this->db->join('core_oxigeno','urg_ordenamiento.id_tipo_oxigeno = core_oxigeno.id_oxigeno','left');
  $this->db->join('core_oxigeno_tipo','urg_ordenamiento.id_oxigeno_valor = core_oxigeno_tipo.id_oxigeno_valor','left');
  $this->db->where('id_orden',$id_orden);
  $result = $this->db->get();
  return $result->row_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerDxFarmacia($id_atencion)
  {
    $this->db->select('urg_evoluciones.id_evolucion, urg_evoluciones.id_atencion, urg_evolucion_diag.id_diag, core_diag_item.diagnostico');
    $this->db->from('urg_evoluciones');
    $this->db->join('urg_evolucion_diag','urg_evoluciones.id_evolucion = urg_evolucion_diag.id_evolucion');
    $this->db->join('core_diag_item','core_diag_item.id_diag = urg_evolucion_diag.id_diag');
    $this->db->where('urg_evoluciones.id_atencion',$id_atencion);
    $this->db->group_by('urg_evolucion_diag.id_diag');
    $result = $this->db->get();
    
    $num = $result -> num_rows();
    if($num > 0)
    {
      return  $result->result_array();
    }
    else
    {
    $this->db->select('urg_consulta.id_consulta, urg_consulta.id_atencion, urg_consulta_diag.id_diag, core_diag_item.diagnostico');
    $this->db->from('urg_consulta');
    $this->db->join('urg_consulta_diag','urg_consulta.id_consulta = urg_consulta_diag.id_consulta');
    $this->db->join('core_diag_item','core_diag_item.id_diag = urg_consulta_diag.id_diag');
    $this->db->where('urg_consulta.id_atencion',$id_atencion);
    $this->db->group_by('urg_consulta_diag.id_diag');
    $result = $this->db->get();
    //print_r($result);die();
    return  $result->result_array();
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerPacientesExamenes($id_servicio)
  {
  $this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  urg_atencion.id_atencion,
  urg_atencion.id_paciente,
  urg_atencion.id_servicio,
  urg_atencion.ingreso,
  urg_ordenamiento.id_orden,
  urg_ordenamiento.fecha_verificado,
  urg_orde_laboratorios.id_orden,
  urg_orde_laboratorios.cups,
  urg_orde_laboratorios.cantidadCups,
  urg_orde_laboratorios.observacionesCups');
  $this->db->from('urg_atencion');
  $this->db->join('urg_ordenamiento','urg_atencion.id_atencion = urg_ordenamiento.id_atencion');
  $this->db->join('urg_orde_laboratorios','urg_ordenamiento.id_orden = urg_orde_laboratorios.id_orden');
  $this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->where('urg_atencion.consulta','SI');
  $this->db->where('urg_ordenamiento.verificado','SI');
  $this->db->where('urg_atencion.id_servicio',$id_servicio);
  $this->db->where('urg_orde_laboratorios.realizado',NULL);
  $this->db->order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('urg_orde_laboratorios.id_orden'); 
  $result = $this->db->get();
  return $result->result_array(); 
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerInfoServicio($id_servicio)
  {
    $this->db->where('id_servicio',$id_servicio);
    $result = $this->db->get('core_servicios_hosp');
    return $result->row_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
      /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function obtenerCamaFarmacia($id_atencion)
  {
  $this->db->SELECT('core_cama.id_cama, core_cama.numero_cama');
  $this->db->FROM('core_cama');
  $this->db->JOIN('urg_observacion','core_cama.id_cama = urg_observacion.id_cama');
  $this->db->where('urg_observacion.id_atencion',$id_atencion);
  $result =  $this->db->get();
  $num = $result->num_rows();
    if($num == 0)
    {
      $numero_cama=' ';  
      return $numero_cama;
    }
    else
    {
      return $result->row_array();
    }
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////  
      /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
  function registraRealizaLab($d)
  {
    
    for($i=0;$i<count($d['idLab']);$i++)
      {
        $update = array(
          'fecha_realizado' => date('Y-m-d H:i:s'),
          'realizado' => $d['realiza'][$i],
          'razon' => $d['razon'][$i],
          );
        $this->db->where('id',$d['idLab'][$i]);
        $this->db->update('urg_orde_laboratorios', $update); 
      }
    
   }

       	/* 
* @Descripcion: muestra ordenes de laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	function OrdenesLab($accion)
	{
	 $this->db->select('
  lab_ordenes.id_lab_orden,
  lab_ordenes.fecha_realizado,
  lab_ordenes.fecha_envio_lab,
  
  lab_ordenes.observacionesCups,
  lab_ordenes.cups,
  lab_ordenes.estado,
  lab_ordenes.accion,
  lab_ordenes.id_paciente,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  
  urg_ordenamiento.id_atencion,
   core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_tercero.id_tipo_documento,
  core_cups_subcategoria.id_subcategoria,
  core_cups_subcategoria.desc_subcategoria,
  lab_lista_ordenes_urg.cup,
  core_tipo_documentos.tipo_documento');
  $this->db->from('lab_ordenes');
  $this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden');
    $this->db->join('core_paciente','lab_ordenes.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
	$this->db->join('lab_lista_ordenes_urg','lab_lista_ordenes_urg.cup <> lab_ordenes.cups');
	
  
  
   if($accion!="todas"){
   $this->db->where('lab_ordenes.accion',$accion);
   }
   if($accion=="tomar"){
   $this->db->where('lab_ordenes.estado','tomada_lab');
   }
   if($accion=="recepcionar"){
   $this->db->where('lab_ordenes.estado','enviada');
   }
   if($accion=="registrar"){
   $this->db->where('lab_ordenes.estado','valida');
   }else{
	   $this->db->where('lab_ordenes.accion <>',"registrar"); 
	   }
   $this->db->where('lab_ordenes.estado <>','por_enviar');
  
   $this->db->where('lab_ordenes.estado <>',"rechazada"); 
   
   $this->db->where('lab_ordenes.accion <>',"finalizada"); 
   
   
   
   // $this->db->where('lab_ordenes.estado',"enviada"); 
   
  
  $this->db->order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('lab_ordenes.id_ordenes'); 
  $result = $this->db->get();
  return $result->result_array(); 
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
 
function OrdenesLabRegUrg($accion,$id_servicio)
	{
	 $this->db->select('
  lab_ordenes.id_lab_orden,
  lab_ordenes.fecha_realizado,
  
  lab_ordenes.observacionesCups,
  lab_ordenes.cups,
  lab_ordenes.estado,
  lab_ordenes.accion,
  lab_ordenes.id_paciente,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  
  urg_ordenamiento.id_atencion,
   core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_tercero.id_tipo_documento,
  core_cups_subcategoria.id_subcategoria,
  core_cups_subcategoria.desc_subcategoria,
  core_tipo_documentos.tipo_documento');
  $this->db->from('lab_ordenes');
  $this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden');
    $this->db->join('core_paciente','lab_ordenes.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
	
	$this->db->join('lab_lista_ordenes_urg','lab_lista_ordenes_urg.cup = lab_ordenes.cups');
  
  
   if($accion=="registrar"){
   $this->db->where('lab_ordenes.estado','valida');
   }
   $this->db->where('lab_ordenes.estado <>','por_enviar');
  
   $this->db->where('lab_ordenes.estado <>',"rechazada"); 
   
   
   
    $this->db->where('lab_ordenes.id_servicio',$id_servicio); 
   
  
  $this->db->order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('lab_ordenes.id_ordenes'); 
  $result = $this->db->get();
  return $result->result_array(); 
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 
    
function obtenerLabOrden($id_orden)
	{
	 $this->db->select('
  lab_ordenes.id_lab_orden,
  lab_ordenes.fecha_realizado,
  lab_ordenes.observacionesCups,
  
  lab_ordenes.cups,
  lab_ordenes.accion,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  core_cups_subcategoria.id_subcategoria,
  core_cups_subcategoria.desc_subcategoria,
  urg_ordenamiento.id_atencion');
  
  $this->db->from('lab_ordenes');
  $this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden');
  
  $this->db->where('lab_ordenes.id_ordenes',$id_orden);
 
  $result = $this->db->get();
  return $result->result_array(); 
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function lista_lab_rechazo()
	{
		$this->db->select('
		lab_motivo_rechazo.id_rechazo,
		lab_motivo_rechazo.motivo');
		$this->db->from('lab_motivo_rechazo');
		$result = $this->db->get();
  		return $result->result_array(); 
				
	}

 function registra_lab_orden($d)
  {
	  
         $update = array(
		  'id_orden'=>$d['id_orden'],
          'fecha' => date('Y-m-d H:i:s'),
          'estado' => $d['estado'],
          'observacion' => $d['razon'],
          );
		  if($d['estado']=='RECHAZADA')
		  {
			$update2 = array(
			'id_rechazo'=> $d['codigo_rechazo'],
			'accion'=> 'tomar',
		    'estado' => 'rechazada',
			'fecha_aprovacion_rechazo' => date('Y-m-d H:i:s'),
			);  
			    $this->db->where('id_ordenes',$d['id_orden']);
	   			$this -> db -> update('lab_ordenes',$update2);
		   }
		   
		    if($d['estado']=='APROBADA')
		  {
			$update2 = array(
			'accion'=> 'registrar',
		    'estado' => 'valida',
			'fecha_aprovacion_rechazo' => date('Y-m-d H:i:s'),
			);  
			    $this->db->where('id_ordenes',$d['id_orden']);
	   			$this -> db -> update('lab_ordenes',$update2);
		   }

	   $this -> db -> insert('lab_historia_muestra',$update);
	   
	  
	         
   }
   
function obtenerLabOrdenRechazada($accion,$id_servicio)
	{
	 $this->db->select('
  lab_ordenes.id_lab_orden,
  lab_ordenes.fecha_realizado,
  lab_ordenes.fecha_aprovacion_rechazo,
  lab_ordenes.observacionesCups,
  lab_ordenes.cups,
  lab_ordenes.estado,
  lab_ordenes.accion,
  lab_ordenes.id_paciente,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  
  urg_ordenamiento.id_atencion,
   core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_tercero.id_tipo_documento,
  core_tipo_documentos.tipo_documento,
  lab_motivo_rechazo.motivo,

  ');
  
  $this->db->from('lab_ordenes');
  
  $this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden');
    $this->db->join('core_paciente','lab_ordenes.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
	$this->db->join('lab_motivo_rechazo','lab_motivo_rechazo.id_rechazo = lab_ordenes.id_rechazo');
  
  
  
  $this->db->where('lab_ordenes.estado',$accion);
  $this->db->where('lab_ordenes.id_servicio',$id_servicio);
  
 
  $result = $this->db->get();
  return $result->result_array(); 
	}   
   
  
  function TomarLabOrdenEnf($accion,$id_servicio,$fecha_actual)
	{
		
		
	/*	
	 $this->db->select('
  lab_ordenes.id_lab_orden,
  lab_ordenes.id_rechazo,
  lab_ordenes.fecha_realizado,
  lab_ordenes.observacionesCups,
  lab_ordenes.cups,
  lab_ordenes.estado,
  lab_ordenes.accion,
  lab_ordenes.id_paciente,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  lab_ordenes.registro_numero,
  
  urg_ordenamiento.id_atencion,
   core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_tercero.id_tipo_documento,
  core_cups_subcategoria.id_subcategoria,
  core_cups_subcategoria.desc_subcategoria,
  core_tipo_documentos.tipo_documento');*/
  return $this->db->query('SELECT TIMESTAMPDIFF(MINUTE, lab_ordenes.fecha_ult_registro, "'.$fecha_actual.'") AS minutos,
  lab_ordenes.id_lab_orden,
  lab_ordenes.id_rechazo,
  lab_ordenes.fecha_realizado,
  lab_ordenes.observacionesCups,
  lab_ordenes.cups,
  lab_ordenes.estado,
  lab_ordenes.accion,
  lab_ordenes.id_paciente,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  lab_ordenes.registro_numero,
  lab_ordenes.periocidad_min,
  urg_ordenamiento.id_atencion,
   core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_tercero.id_tipo_documento,
  core_cups_subcategoria.id_subcategoria,
  core_cups_subcategoria.desc_subcategoria,
  core_tipo_documentos.tipo_documento
  FROM lab_ordenes
  INNER JOIN core_cups_subcategoria   ON core_cups_subcategoria.id_subcategoria = lab_ordenes.cups
  INNER JOIN urg_ordenamiento   ON urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden
  INNER JOIN core_paciente  ON lab_ordenes.id_paciente = core_paciente.id_paciente
  INNER JOIN core_tercero  ON core_paciente.id_tercero = core_tercero.id_tercero
  INNER JOIN core_tipo_documentos  ON core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento
where  lab_ordenes.accion = "'.$accion.'" AND  lab_ordenes.estado <> "rechazada" AND 
lab_ordenes.estado <> "tomada_lab" AND lab_ordenes.id_servicio = "'.$id_servicio.'"')->result_array();
  
 //$this->db->from('lab_ordenes');
  
  //$this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');
 // $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden');
    //$this->db->join('core_paciente','lab_ordenes.id_paciente = core_paciente.id_paciente');
	//$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	//$this->db->join('core_tipo_documentos','core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');

  /*
  
  $this->db->where('lab_ordenes.accion',$accion);
  $this->db->where('lab_ordenes.estado <>',"rechazada"); 
  $this->db->where('lab_ordenes.estado <>',"tomada_lab"); 
  $this->db->where('lab_ordenes.id_servicio',$id_servicio);
  $this->db->where('lab_ordenes.fecha_ult_registro =>',$fecha_actual);
  */
  
 
  //$result = $this->db->get();
  //return $result->result_array(); 
	}    

/* 
* @Descripcion: guarda el rechazo de una orden 
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	function RegistraRechazoOrd($id_ordenes)
	{
		 
		 $update2 = array(
			'accion'=> 'tomar',
		    'estado' => 'por_enviar',
			);  
			    $this->db->where('id_ordenes',$id_ordenes);
	   			$this -> db -> update('lab_ordenes',$update2);
		 
		
	}
	/* 
* @Descripcion: guarda  la lista de las ordenes enviadas al laboratorio 
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	function RegistraEnvioLab($id_ordenes)
	{
		$fecha = date('Y-m-d H:i:s');
		 $update2 = array(
			'accion'=> 'recepcionar',
		    'estado' => 'enviada',
			'fecha_envio_lab'=>$fecha,
			);  
			    $this->db->where('id_ordenes',$id_ordenes);
	   			$this -> db -> update('lab_ordenes',$update2);
		 
		
	}
/* 
* @Descripcion: Listado de ordenes registradas por cup
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	function listadoOrdenesRegUrg($id_ordenes){
		
		$this->db->select('
  lab_ordenes.cups,
  lab_lista_ordenes_urg.cup,
  ');
  
  $this->db->from('lab_ordenes');
  
  $this->db->join('lab_lista_ordenes_urg','lab_lista_ordenes_urg.cup = lab_ordenes.cups');
  
  $this->db->where ('id_ordenes',$id_ordenes);
 
 
  $result =$this->db->count_all_results();
  return $result; 
		
		
		
		}
	
	
	
	
		function RegistraRemiteLab($id_ordenes)
	{
		
		 $update2 = array(
			'accion'=> 'tomar',
		    'estado' => 'tomada_lab',
			);  
			    $this->db->where('id_ordenes',$id_ordenes);
	   			$this -> db -> update('lab_ordenes',$update2);
		 
		
	}

	 function TomarNodo()
	{
	 $this->db->select('
  lab_clinicos.id,
  lab_clinicos.nombre,
  lab_clinicos.abreviatura,
  lab_clinicos.tipo,
  lab_clinicos.idpadre');
  
  $this->db->from('lab_clinicos');
  
 
 
  $result = $this->db->get();
  return $result->result_array(); 
	}    
	
		
	
	 function Insert_tipo_lab($datos)
  		{
	  
         $update = array(
		  'abreviatura'=>$datos['abreviatura'],
          'nombre' => $datos['nombre'],
          'tipo' => $datos['tipo'],
		  
		  
          );
		    
	     
	   $this -> db -> insert('lab_clinicos',$update);
	   
   }
    
	
	function Insert_contenedor_lab($datos)
  {
	  
         $update = array(
		  'abreviatura'=>$datos['abreviatura'],
          'nombre' => $datos['nombre'],
          'tipo' => $datos['tipo'],
		  'idpadre' => $datos['idpadre'],
		  'investigativo'=>$datos['investigativo'],	      
		  'accion_alerta'=>$datos['accion_alerta'],
		  'vigilancia_epidemiologica'=>$datos['vigilancia_epidemiologica'],
	      'seguimiento_individuo'=>$datos['seguimiento_individuo'],
	      'diagnostico'=>$datos['diagnostico'],
	      'restriccion_sumatoria'=>$datos['restriccion_sumatoria'],
	      'normalidad_atomica'=>$datos['normalidad_atomica'],	
		  'valor_grupo_suma'=>$datos['valor_grupo_suma'],
	      'mensaje_grupo_suma'=> $datos['mensaje_grupo_suma'],
		  'id_cup'=> $datos['id_cup'],
	      'mensaje_normalidad_atomica'=> $datos['mensaje_normalidad_atomica'],
		  
		  	  
          );
		    
	     
	   $this -> db -> insert('lab_clinicos',$update);
	   
	  
	         
   }
   
   ///////////////////////////////////////////////////
   
   
       function Insert_clinico_lab($datos)
  {
	  
         $update = array(
		  'abreviatura'=>$datos['abreviatura'],
          'nombre' => $datos['nombre'],
          'tipo' => $datos['tipo'],
		  'tipo_dato' => $datos['tipo_dato'],
		  'idpadre' => $datos['idpadre'],
		  'valorminimonumerico' => $datos['valorminimonumerico'],
		  'valormaximonumerico' => $datos['valormaximonumerico'], 
		  'id_cup' =>$datos['id_cup'],
		   );
		    
	     
	   $this -> db -> insert('lab_clinicos',$update);
	   
	          
   }
   ///////////////////////////////
      function Id_ultimo_clinico_insertado()
  {
	  
	$this->db->select_max('id');
$result = $this->db->get('lab_clinicos');

  
  return $result->result_array(); 
	   
	          
   }
   
	///////////////////////////////////////////////////
	function RegistraCambioNom($Newname,$id)
	{
		 $update2 = array(
			'nombre'=> $Newname,
		    
			);  
			    $this->db->where('id',$id);
	   			$this -> db -> update('lab_clinicos',$update2);
		
		
		
	}
	function Tipos_laboratorios($id)
	{
		 $this->db->select('
  lab_clinicos.nombre,
  lab_clinicos.id');
  
  $this->db->from('lab_clinicos');
  $this->db->where('id',$id);  
 
 
  $result = $this->db->get();
  return $result->result_array(); 
	}
	
function Insert_Valores_List($d,$idfinal){
	
	 foreach($d['descripcion'] as $datos)
         {
			 $update = array(
		  'id_clinico'=>  $idfinal,
          'descripcion' => $datos,
        
		   );
		
		$this -> db -> insert('lab_val_lista',$update);
		    
         }
	  
	}
	
	function Editar_Clinico($id)
	{
		
	 $this->db->from('lab_clinicos');
 	 $this->db->where('id',$id);  
 
 
 	 $result = $this->db->get();
  	 return $result->result_array(); 
	
	
	}
function Listado_Valores_List($identificador){
		
	$this->db->select('
  lab_val_lista.id_clinico,
  lab_val_lista.descripcion');
  
  $this->db->from('lab_val_lista');
  $this->db->where('id_clinico',$identificador);  
 
 
  $result = $this->db->get();
  return $result->result_array(); 
		
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerCupsLab()
	{
		$result = $this->db->get('core_cups_seccion');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////



function obtenerIdClinico($cup){
	
	$this->db->select('
  lab_clinicos.id');
  
  $this->db->from('lab_clinicos');
  $this->db->where('id_cup',$cup);  
 
 
  $result = $this->db->get();
  return $result->result_array(); 
	
	
	}
	
function obtenerClinicos($id_clinico_cup){
		  
  $this->db->from('lab_clinicos');
  $this->db->where('idpadre',$id_clinico_cup);  
   
   $this->db->order_by('lab_clinicos.tipo','ASC');  
 
  
  $result = $this->db->get();
  return $result->result_array();
	}	
	
	
	
function CargaListadoValor($id){
  
  $this->db->from('lab_val_lista');
  $this->db->where('id_clinico',$id);  
 
 
  $result = $this->db->get();
  return $result->result_array();
		
			
		}
	
	
	// registra el resultado del informe de laboratorio
	function registra_informe_lab($datos){
		
		
		
	$contador= count($datos['codigo']);
		

for($i=0;$i < $contador;$i++){

	   $insertar = array(
		 'id_orden'=>  $datos['id_orden'],
		 'codigo'=>$datos['codigo'][$i],
		 'nombre'=>$datos['nombre'][$i],
		 'valor'=>$datos['valor'][$i],
		   );
		
		$this -> db -> insert('lab_resultados_analizadores',$insertar);
	

  }  
		
		
		
		
		
		
		
		
		
		
		
		
 // aqui se cargan los resultados que fueron ingresados manualmente; se separan por los de tipo numerico, los de texto y las listas.		
      if($datos['numero']!=''){	
		 foreach($datos['numero'] as $d)
         {
			 	$llave=key($datos['numero']);
				
				next($datos['numero']);
			 $update = array(
		  'id_orden'=>  $datos['id_orden'],
          'numero' => $d,
         'id_clinico'=>$llave,
		 'registro_numero'=>$datos['registro_numero'],
		 
		   );
		
		$this -> db -> insert('lab_resultados',$update);
		    
         }
  	}
		 
	 if($datos['texto']!=''){		 
		  foreach($datos['texto'] as $d)
         {
			$llave=key($datos['texto']);
				
				next($datos['texto']);
		 $update = array(
						  'id_orden'=>  $datos['id_orden'],
						  'texto' => $d,
						  'id_clinico'=>$llave,
						 'registro_numero'=>$datos['registro_numero'],
						
		  );
		
		$this -> db -> insert('lab_resultados',$update);
		    
         }
	 }
		
	if($datos['lista']!=''){		
	
	
		  foreach($datos['lista'] as $d)
         {
		$llave=key($datos['lista']);
				
				next($datos['lista']);
			 $update = array(
		  'id_orden'=>  $datos['id_orden'],
          'lista' => $d,
		  'id_clinico'=>$llave,
		  'registro_numero'=>$datos['registro_numero'],
		 
		    );
		
		$this -> db -> insert('lab_resultados',$update);
		    
         }
	}
		//////////cierre del cargue manual
		
		 //guardamos la ruta del archivo pdf en la tabla resultado_detalle
		  
		   $updatedetalle = array(
		   'id_orden'=>  $datos['id_orden'],          
		   'registro_numero'=>$datos['registro_numero'],
		   'ruta_archivos'=>$datos['ruta'],
		 );
		 $this -> db -> insert('lab_resultados_detalle',$updatedetalle);
		 ///////////////////////////////////////////////////////////////////
		if ($datos['cantidad'][0]['cantidadCups'] <= $datos['registro_numero']){
			
			$update5 = array(
		   'estado'=>'finalizada',
		   'accion'=>'finalizada',
		   'fecha_ult_registro' => date('Y-m-d H:i:s'),
		   'registro_numero'=>$datos['registro_numero'],
		  );
			}else if($datos['cantidad'][0]['cantidadCups'] > $datos['registro_numero']){
			
			$update5 = array( 
		   'estado'=>'por_enviar',
		   'accion'=>'tomar',
		   'fecha_ult_registro' => date('Y-m-d H:i:s'),
		   'registro_numero'=>$datos['registro_numero'],
		  );
			}
		
		
		$this->db->where('id_ordenes',$datos['id_orden']);
		$this -> db -> update('lab_ordenes',$update5);
		// GUARDAMOS EN EL HISTORIAL DE LAS ORDENES
		$detallehistorica = array(
		   'id_orden'=>  $datos['id_orden'],          
		   'registro_numero'=>$datos['registro_numero'],
		   'estado'=>'FINALIZADA',
		   'fecha' => date('Y-m-d H:i:s'),
		 );
		$this -> db -> insert('lab_historia_muestra',$detallehistorica);
		}
		
	function RegistraOrdRegUrg($d){
		
			$update2 = array(
			'accion'=> 'registrar',
		    'estado' => 'valida'); 
			    $this->db->where('id_ordenes',$d['id_orden']);
	   			$this -> db -> update('lab_ordenes',$update2);
		   }
		
		
	function Cantidad_registro_numero($id_orden){
		
		$this->db->from('lab_ordenes');
          
		$this->db->where('id_ordenes',$id_orden);  
 
 
  $result = $this->db->get();
  return $result->result_array();
	
		
		
		
		}
		
	function Cantidad_registro_tomar($id_orden){
		$this->db->select('lab_ordenes.cantidadCups');
		$this->db->from('lab_ordenes');
        $this->db->where('id_ordenes',$id_orden);  
 
 
  $result = $this->db->get();
  return $result->result_array();
	
		
		
		
		}	
		
		     	/* 
* @Descripcion: muestra ordenes de laboratorio por areas
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120304
* @version		20120304
*/
	function OrdenesLabAreas($accion,$area)
	{
	 $this->db->select('
  lab_ordenes.id_lab_orden,
  lab_ordenes.fecha_realizado,
  lab_ordenes.fecha_aprovacion_rechazo,
  lab_ordenes.observacionesCups,
  lab_ordenes.cups,
  lab_ordenes.estado,
  lab_ordenes.accion,
  lab_ordenes.id_paciente,
  lab_ordenes.id_ordenes,
  lab_ordenes.cantidadCups,
  lab_analizadores_pruebas.cups, 
  
  urg_ordenamiento.id_atencion,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_tercero.id_tipo_documento,
  core_cups_subcategoria.id_subcategoria,
  core_cups_subcategoria.desc_subcategoria,
  lab_lista_ordenes_urg.cup,
  core_tipo_documentos.tipo_documento');
  $this->db->from('lab_ordenes');
  $this->db->join('lab_analizadores_pruebas','lab_ordenes.cups = lab_analizadores_pruebas.cups');
  
  $this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = lab_ordenes.id_lab_orden');
    $this->db->join('core_paciente','lab_ordenes.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_tipo_documentos','core_tipo_documentos.id_tipo_documento = core_tercero.id_tipo_documento');
	$this->db->join('lab_lista_ordenes_urg','lab_lista_ordenes_urg.cup <> lab_ordenes.cups');
	
	
  
  
   if($accion!="todas"){
   $this->db->where('lab_ordenes.accion',$accion);
   }
   if($accion=="tomar"){
   $this->db->where('lab_ordenes.estado','tomada_lab');
   }
   if($accion=="recepcionar"){
   $this->db->where('lab_ordenes.estado','enviada');
   }
   if($accion=="registrar"){
   $this->db->where('lab_ordenes.estado','valida');
   $this->db->where('lab_analizadores_pruebas.AREA ',$area); 
   }else{
	   $this->db->where('lab_ordenes.accion <>',"registrar"); 
	   }
   $this->db->where('lab_ordenes.estado <>','por_enviar');
  
   $this->db->where('lab_ordenes.estado <>',"rechazada"); 
   
   // $this->db->where('lab_ordenes.estado',"enviada"); 
   
  
  $this->db->order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('lab_ordenes.id_ordenes'); 
  $result = $this->db->get();
  return $result->result_array(); 
	}

				
////////////////////////////////////////////////////////////////////////////////	


////////////////////////////////////////////////////////////////////////////////////////////////////////// 
function obtenerNombreAnalizador($cups)
	{
	 $this->db->select('lab_analizadores_pruebas.MAQUINA,lab_analizadores.serial');
  
  $this->db->from('lab_analizadores_pruebas');
  $this->db->join('lab_analizadores','lab_analizadores.id_analizador = lab_analizadores_pruebas.id_analizador');
  $this->db->where('lab_analizadores_pruebas.cups',$cups);
 
  $result = $this->db->get();
  return $result->result_array(); 
	}

}
?>
