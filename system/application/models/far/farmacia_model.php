<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Farmacia_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Farmacia
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 01 de Diciembre de 2010
*/
class Farmacia_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
    
    $this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function obtenerValorVarMedi($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('core_medicamento_var');
    $row = $result->row_array();
    return $row['descripcion']; 
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function obtenerNomMedicamento($atc)
  {
    $this->db->where('atc_full',$atc);
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
    $result = $this->db->get('core_cups_subcategoria');
    $row = $result->row_array();
    return $row['desc_subcategoria']; 
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function crearOrdenDb($d)
  {
    $dat = array();
    $dat['error'] = $error = false;
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
          'id_dieta'    => $d['id_dieta'][$i],
          'id_orden'    => $dat['id_orden'] );
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
          'id_orden'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_cuidados', $insert); 
      }
    }
    //----------------------------------------------------------
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
          'id_orden'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_medicamentos', $insert); 
      }
    }
    //----------------------------------------------------------
    if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
    {
      for($i=0;$i<count($d['cups']);$i++)
      {
        $insert = array(
          'cups'    => $d['cups'][$i],
          'observacionesCups' => $d['observacionesCups'][$i],
          'id_orden'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_cups', $insert); 
      }
    }
    //----------------------------------------------------------
    return $dat;
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function verificarOrdenDb($d)
  {
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
    $this->db->trans_start();
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
    $this->db->trans_complete();
    //----------------------------------------------------------
    $this->db->trans_start();
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
    $this->db->trans_complete();
    //----------------------------------------------------------
    $this->db->trans_start();
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
    $this->db->trans_complete();
    //----------------------------------------------------------
    $this->db->trans_start();
    $this->db->where('id_orden',$d['id_orden']);
    $this->db->delete('urg_orde_cups');
    
    if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
    {
      for($i=0;$i<count($d['cups']);$i++)
      {
        $insert = array(
          'cups'    => $d['cups'][$i],
          'observacionesCups' => $d['observacionesCups'][$i],
          'id_orden'    => $d['id_orden'] );
        $this->db->insert('urg_orde_cups', $insert); 
      }
    }
    $this->db->trans_complete();
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
    $this->db->where('estado <>','Continua');
	$this->db->where('id_orden',$id_orden);
    $result = $this->db->get('urg_orde_medicamentos');
    return $result->result_array(); 
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
 function obtenerMediOrdenDespa($id_orden)
  {
    $this->db->where('estado <>','Continua');
	$this->db->where('estado <>','Suspendido');
	$this->db->where('id_orden',$id_orden);
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
    $result = $this->db->get('core_cuidados_enfermeria');
    $row = $result->row_array();
    return $row['cuidado'];
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function obtenerDxConsulta($id_consulta)
  {
    $this->db->select('urg_consulta_diag.id_diag,core_diag_item.diagnostico,urg_consulta_diag.id_consulta');
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
  
  function obtenerDxFarmacia($id_atencion)
  {
    $this->db->select('urg_evoluciones.id_evolucion, urg_evoluciones.id_atencion, urg_evolucion_diag.id_diag, core_diag_item.diagnostico');
    $this->db->from('urg_evoluciones');
    $this->db->join('urg_evolucion_diag','urg_evoluciones.id_evolucion = urg_evolucion_diag.id_evolucion');
    $this->db->join('core_diag_item','core_diag_item.id_diag = urg_evolucion_diag.id_diag');
    $this->db->where('urg_evoluciones.id_atencion',$id_atencion);
    $this->db->group_by('urg_evolucion_diag.id_diag');
    $result = $this->db->get();
    //print_r($result);die();
    
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

  
  function crearPlanManejoDb($d)
  {
    $dat = array();
    $dat['error'] = $error = false;
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
          'id_dieta'    => $d['id_dieta'][$i],
          'id_orden'    => $dat['id_orden'] );
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
          'id_orden'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_cuidados', $insert); 
      }
    }
    //----------------------------------------------------------
    if(count($d['pos']) > 0 && strlen($d['pos'][0]) > 0)
    {
      for($i=0;$i<count($d['pos']);$i++)
      {
        $insert = array(
          'atc'     => $d['atc'][$i],
          'dosis'   => $d['dosis'][$i],
          'id_unidad' => $d['id_unidad'][$i],
          'frecuencia'=> $d['frecuencia'][$i],
          'id_frecuencia'=> $d['id_frecuencia'][$i],
          'id_via'  => $d['id_via'][$i],
          'observacionesMed'=> $d['observacionesMed'][$i],
          'pos'   => $d['pos'][$i],
          'id_orden'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_medicamentos', $insert); 
      }
    }
    //----------------------------------------------------------
    if(count($d['cups']) > 0 && strlen($d['cups'][0]) > 0)
    {
      for($i=0;$i<count($d['cups']);$i++)
      {
        $insert = array(
          'cups'    => $d['cups'][$i],
          'observacionesCups' => $d['observacionesCups'][$i],
          'id_orden'    => $dat['id_orden'] );
        $this->db->insert('urg_orde_cups', $insert); 
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
  function obtenerPacientesMedicamentos($id_servicio)
  {
  $this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_servicios_hosp.nombre_servicio,
  urg_atencion.id_atencion,
  urg_atencion.id_paciente,
  urg_atencion.id_servicio,
  urg_atencion.ingreso,
  urg_ordenamiento.id_orden,
  urg_ordenamiento.fecha_verificado');
  $this->db->from('urg_atencion');
  $this->db->join('urg_ordenamiento','urg_atencion.id_atencion = urg_ordenamiento.id_atencion');
  $this->db->join('urg_orde_medicamentos','urg_ordenamiento.id_orden = urg_orde_medicamentos.id_orden');
   $this->db->join('core_servicios_hosp','urg_ordenamiento.id_servicio =  core_servicios_hosp.id_servicio');
  $this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->where('urg_atencion.consulta','SI');
  $this->db->where('urg_ordenamiento.verificado','SI');
  $this->db->where('urg_ordenamiento.insumos','SI');
  $this->db->where('urg_ordenamiento.insumos_despacho','NO');
  if($id_servicio != 0)
  $this->db->where('urg_atencion.id_servicio',$id_servicio);
  $this -> db -> order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('urg_orde_medicamentos.id_orden'); 
  $result = $this->db->get();
  return $result->result_array(); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerInsumosOrden($id_orden)
{
	$this->db->SELECT('*');
$this->db->FROM('urg_orde_insumos');
$this->db->JOIN('urg_orde_insumos_detalle','urg_orde_insumos.id_orden_insumos = urg_orde_insumos_detalle.id_orden_insumos');
$this->db->JOIN('core_insumos','urg_orde_insumos_detalle.id_insumo = core_insumos.id_insumo');
	$this->db->where('id_orden',$id_orden);
    $result = $this->db->get();
    return $result->result_array(); 
}

  function obtenerNombreEntidad($id_paciente)
  {
    $this->db->select('core_paciente.id_entidad, core_eapb.id_tercero, core_tercero.razon_social');
    $this->db->from('core_paciente');
    $this->db->join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
    $this->db->join('core_tercero','core_tercero.id_tercero = core_eapb.id_tercero');
    $this->db->where('core_paciente.id_paciente',$id_paciente);
    $result = $this->db->get();
    //print_r($result);die();
    return $result->row_array();
     
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function obtenerInfoServicio($id_servicio)
  {
    $this->db->where('id_servicio',$id_servicio);
    $result = $this->db->get('core_servicios_hosp');
    return $result->row_array();
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
    $result = $this->db->get('urg_observacion');
    return $result->row_array();  
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function ingresoObservacionDb($id_observacion,$id_cama)
  {
    $update = array(
      'fecha_ingreso' => date('Y-m-d H:i:s'),
      'id_cama' => $id_cama,
      'ingreso_sala' => 'SI');
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
  core_estados_camas.icono,
 urg_observacion.id_atencion');
  $this->db->FROM('urg_observacion');
  $this->db->JOIN('core_cama','urg_observacion.id_cama = core_cama.id_cama','right');
  $this->db->JOIN('core_estados_camas','core_cama.id_estado = core_estados_camas.id_estado');
  $this->db->where('core_cama.id_servicio',$id_servicio);
  $this->db->order_by('core_cama.id_cama','ASC');
  $result =  $this->db->get();
    return $result->result_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  
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
  $this->db->JOIN('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
  $this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');  
  $this->db->where('urg_atencion.id_atencion',$id_atencion);
  $this->db->where('urg_atencion.id_estado','5');
  $result =  $this->db->get();
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
    $this->db->where('id_entidad_remision',$id_entidad);
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
    $result = $this->db->get('urg_origen_atencion');
    return $result->row_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////

 
//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene otros medicamentos con el mismo principio activo
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since  20110309
* @version  20110309
* @return   array[object]
*/
  function obtMediPrincipioActivo($principio_activo)
  {
      $this->db->where('principio_activo',$principio_activo);
      $res = $this->db->get('core_medicamento_cum');
      return $res->result_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*
* Obtiene el principio activo de un medicamento
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since  20110309
* @version  20110309
* @return   array
*/  
  function obtenerPrincipioActivo($atc)
  {
      $this->db->where('atc_full',$atc);
      $res = $this->db->get('core_medicamento');
      $result = $res->row_array();  
      return $result['principio_activo'];
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function despachoMedicamentosOrden($d)
	{
		$update = array(
			'fecha_despacho' => date('Y-m-d H:i:s'),
			'insumos_despacho'		=> 'SI'
		);
		$this->db->where('id_orden',$d['id_orden']);
		$this->db->update('urg_ordenamiento',$update);
		//---------------------------------------------------------
		if(count($d['idMed']) > 0 && strlen($d['idMed'][0]) > 0)
		{
			for($i=0;$i<count($d['idMed']);$i++)
			{
				$update = array(
					'atc_despa' => $d['atc_despa'][$i],
					'cantidadMed' => $d['cantidadMed'][$i],
					'despachoMed' => $d['despachoMed'][$i],
					'observacionMed' => $d['observacionMed'][$i],
				);
				$this->db->where('id',$d['idMed'][$i]);	
				$this->db->update('urg_orde_medicamentos', $update); 
			}
		}
		//---------------------------------------------------------
		if(count($d['idInsu']) > 0 && strlen($d['idInsu'][0]) > 0)
		{
			for($i=0;$i<count($d['idInsu']);$i++)
			{
				$update = array(
					'despacho' => $d['despacho'][$i],
					'cantidad_despachada' => $d['cantidad_despachada'][$i],
					'obsDespacho' => $d['obsDespacho'][$i]
				);
				$this->db->where('id',$d['idInsu'][$i]);	
				$this->db->update('urg_orde_insumos_detalle', $update); 
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerHistoMedica($id_atencion,$atc)
{
	$this->db->select('  urg_orde_medicamentos.observacionMed,
  urg_orde_medicamentos.despachoMed,
  urg_orde_medicamentos.cantidadMed,
  urg_orde_medicamentos.atc_despa,
  urg_orde_medicamentos.dosis,
  urg_orde_medicamentos.id_unidad,
  urg_orde_medicamentos.frecuencia,
  urg_orde_medicamentos.id_frecuencia,
  urg_orde_medicamentos.atc,
  urg_orde_medicamentos.id_via,
  urg_orde_medicamentos.observacionesMed,
  urg_orde_medicamentos.estado,
  urg_ordenamiento.insumos_despacho,
  urg_ordenamiento.fecha_creacion,
  urg_ordenamiento.id_atencion');
  $this->db->from('urg_ordenamiento');
  $this->db->join('urg_orde_medicamentos','urg_ordenamiento.id_orden = urg_orde_medicamentos.id_orden');
  $this->db->where('urg_orde_medicamentos.atc',$atc);
  $this->db->where('urg_ordenamiento.id_atencion',$id_atencion);
  $result = $this->db->get();
	return $result->result_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
 function obtenerOrdenesDespachadas()
  {
  $this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_servicios_hosp.nombre_servicio,
  urg_atencion.id_atencion,
  urg_atencion.id_paciente,
  urg_atencion.id_servicio,
  urg_atencion.ingreso,
  urg_ordenamiento.id_orden,
  urg_ordenamiento.fecha_verificado');
  $this->db->from('urg_atencion');
  $this->db->join('urg_ordenamiento','urg_atencion.id_atencion = urg_ordenamiento.id_atencion');
  $this->db->join('urg_orde_medicamentos','urg_ordenamiento.id_orden = urg_orde_medicamentos.id_orden');
   $this->db->join('core_servicios_hosp','urg_ordenamiento.id_servicio =  core_servicios_hosp.id_servicio');
  $this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->where('urg_ordenamiento.insumos_despacho','SI');
  $this ->db->order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('urg_orde_medicamentos.id_orden'); 
  $this->db->limit(50);
  $result = $this->db->get();
  return $result->result_array(); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerPacientesMedicamentosHosp($id_servicio)
  {
  $this->db->select(' 
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  core_tercero.fecha_nacimiento,
  core_tercero.numero_documento,
  core_servicios_hosp.nombre_servicio,
  hospi_atencion.id_atencion,
  hospi_atencion.id_paciente,
  hospi_atencion.id_servicio,
  hospi_atencion.ingreso,
  hospi_ordenamiento.id_orden,
  hospi_ordenamiento.fecha_creacion,
  core_cama.numero_cama');
  $this->db->from('hospi_atencion');
  $this->db->join('hospi_ordenamiento','hospi_atencion.id_atencion = hospi_ordenamiento.id_atencion');
  $this->db->join('hospi_orde_medicamentos','hospi_ordenamiento.id_orden = hospi_orde_medicamentos.id_orden');
   $this->db->join('core_servicios_hosp','hospi_atencion.id_servicio =  core_servicios_hosp.id_servicio');
  $this->db->join('core_paciente','hospi_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->join('core_cama','hospi_atencion.id_cama = core_cama.id_cama');
  $this->db->where('hospi_atencion.consulta','SI');
  $this->db->where('hospi_ordenamiento.insumos','SI');
  $this->db->where('hospi_ordenamiento.insumos_despacho','NO');
  if($id_servicio != 0)
  $this->db->where('hospi_atencion.id_servicio',$id_servicio);
  $this->db->group_by('hospi_orde_medicamentos.id_orden'); 
  $result = $this->db->get();
  return $result->result_array(); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerOrdenHospi($id_orden)
{
	$this->db->select(' 
	hospi_ordenamiento.cama_cabeza,
	hospi_ordenamiento.cama_pie,
	core_oxigeno.oxigeno As tipoO2,
	core_oxigeno_tipo.tipo_oxigeno As valorO2,
	hospi_ordenamiento.liquidos,
	hospi_ordenamiento.cuidados_generales,
	hospi_ordenamiento.id_orden,
	hospi_ordenamiento.fecha_creacion,,
	hospi_ordenamiento.id_atencion,
	hospi_ordenamiento.id_medico,
	hospi_ordenamiento.oxigeno');
	$this->db->from('hospi_ordenamiento');
	$this->db->join('core_oxigeno','hospi_ordenamiento.id_tipo_oxigeno = core_oxigeno.id_oxigeno','left');
	$this->db->join('core_oxigeno_tipo','hospi_ordenamiento.id_oxigeno_valor = core_oxigeno_tipo.id_oxigeno_valor','left');
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get();
	return $result->row_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerMediOrdenHospi($id_orden)
{
	$this->db->where('estado <>','Continua');
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_medicamentos');
	return $result->result_array(); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerInsumosOrdenHospi($id_orden)
{
	$this->db->SELECT('*');
	$this->db->FROM('hospi_orde_insumos');
	$this->db->JOIN('hospi_orde_insumos_detalle','hospi_orde_insumos.id_orden_insumos = hospi_orde_insumos_detalle.id_orden_insumos');
	$this->db->JOIN('core_insumos','hospi_orde_insumos_detalle.id_insumo = core_insumos.id_insumo');
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get();
	return $result->result_array(); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerDxFarmaciaHospi($id_atencion)
{
	$this->db->select('hospi_evoluciones.id_evolucion, hospi_evoluciones.id_atencion, hospi_evolucion_diag.id_diag, core_diag_item.diagnostico');
	$this->db->from('hospi_evoluciones');
	$this->db->join('hospi_evolucion_diag','hospi_evoluciones.id_evolucion = hospi_evolucion_diag.id_evolucion');
	$this->db->join('core_diag_item','core_diag_item.id_diag = hospi_evolucion_diag.id_diag');
	$this->db->where('hospi_evoluciones.id_atencion',$id_atencion);
	$this->db->group_by('hospi_evolucion_diag.id_diag');
	$result = $this->db->get();
	//print_r($result);die();
	
	$num = $result -> num_rows();
	if($num > 0)
	{
		return  $result->result_array();
	}
	else
	{
		$this->db->select('hospi_nota_inicial.id_consulta, hospi_nota_inicial.id_atencion, hospi_nota_inicial_diag.id_diag, core_diag_item.diagnostico');
		$this->db->from('hospi_nota_inicial');
		$this->db->join('hospi_nota_inicial_diag','hospi_nota_inicial.id_consulta = hospi_nota_inicial_diag.id_consulta');
		$this->db->join('core_diag_item','core_diag_item.id_diag = hospi_nota_inicial_diag.id_diag');
		$this->db->where('hospi_nota_inicial.id_atencion',$id_atencion);
		$this->db->group_by('hospi_nota_inicial_diag.id_diag');
		$result = $this->db->get();
		return  $result->result_array();
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function obtenerCamaFarmaciaHospi($id_atencion)
  {
  $this->db->SELECT('core_cama.id_cama, core_cama.numero_cama');
  $this->db->FROM('core_cama');
  $this->db->JOIN('hospi_atencion','core_cama.id_cama = hospi_atencion.id_cama');
  $this->db->where('hospi_atencion.id_atencion',$id_atencion);
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
function despachoMedicamentosOrdenHospi($d)
{
	$update = array(
		'fecha_despacho' => date('Y-m-d H:i:s'),
		'insumos_despacho'		=> 'SI'
	);
	$this->db->where('id_orden',$d['id_orden']);
	$this->db->update('hospi_ordenamiento',$update);
	//---------------------------------------------------------
	if(count($d['idMed']) > 0 && strlen($d['idMed'][0]) > 0)
	{
		for($i=0;$i<count($d['idMed']);$i++)
		{
			$update = array(
				'atc_despa' => $d['atc_despa'][$i],
				'cantidadMed' => $d['cantidadMed'][$i],
				'despachoMed' => $d['despachoMed'][$i],
				'observacionMed' => $d['observacionMed'][$i],
			);
			$this->db->where('id',$d['idMed'][$i]);	
			$this->db->update('hospi_orde_medicamentos', $update); 
		}
	}
	//---------------------------------------------------------
	if(count($d['idInsu']) > 0 && strlen($d['idInsu'][0]) > 0)
	{
		for($i=0;$i<count($d['idInsu']);$i++)
		{
			$update = array(
				'despacho' => $d['despacho'][$i],
				'cantidad_despachada' => $d['cantidad_despachada'][$i],
				'obsDespacho' => $d['obsDespacho'][$i]
			);
			$this->db->where('id',$d['idInsu'][$i]);	
			$this->db->update('hospi_orde_insumos_detalle', $update); 
		}
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerMediOrdenDespaHospi($id_orden)
{
	$this->db->where('estado <>','Continua');
	$this->db->where('estado <>','Suspendido');
	$this->db->where('id_orden',$id_orden);
	$result = $this->db->get('hospi_orde_medicamentos');
	return $result->result_array(); 
}  
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerOrdenesDespachadasHospi()
{
	$this->db->select(' 
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	core_tercero.fecha_nacimiento,
	core_tercero.numero_documento,
	core_servicios_hosp.nombre_servicio,
	hospi_atencion.id_atencion,
	hospi_atencion.id_paciente,
	hospi_atencion.id_servicio,
	hospi_atencion.ingreso,
	hospi_ordenamiento.id_orden');
	$this->db->from('hospi_atencion');
	$this->db->join('hospi_ordenamiento','hospi_atencion.id_atencion = hospi_ordenamiento.id_atencion');
	$this->db->join('hospi_orde_medicamentos','hospi_ordenamiento.id_orden = hospi_orde_medicamentos.id_orden');
	$this->db->join('core_servicios_hosp','hospi_ordenamiento.id_servicio =  core_servicios_hosp.id_servicio');
	$this->db->join('core_paciente','hospi_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->where('hospi_ordenamiento.insumos_despacho','SI');
	$this->db->group_by('hospi_orde_medicamentos.id_orden'); 
	$this->db->limit(50);
	$result = $this->db->get();
	return $result->result_array(); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
