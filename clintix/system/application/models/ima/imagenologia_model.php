<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Laboratorio_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de laboratorio
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 27 de Abril de 2011
*/
class Imagenologia_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
    
    $this->load->database();
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////

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
    
  function obtenerConsulta($id_atencion)
  {
    $this -> db -> where('id_atencion',$id_atencion);
    $result = $this -> db ->get('urg_consulta');
    return $result -> row_array();
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    
  function obtenerImagenOrden($id_orden)
  {
  $this->db->select('
  urg_orde_imagenes.id, 
  urg_orde_imagenes.id_orden,
  urg_orde_imagenes.cups,
  urg_orde_imagenes.cantidadCups,
  urg_orde_imagenes.observacionesCups,
  core_cups_subcategoria.desc_subcategoria');
  $this->db->from('urg_orde_imagenes');
  $this->db->join('core_cups_subcategoria','urg_orde_imagenes.cups = core_cups_subcategoria.id_subcategoria');
  $this->db->join('urg_ordenamiento','urg_ordenamiento.id_orden = urg_orde_imagenes.id_orden');
  $this->db->where('urg_ordenamiento.verificado','SI');
  $this->db->where('urg_orde_imagenes.id_orden',$id_orden);
  $this -> db -> order_by('urg_orde_imagenes.cups','ASC');
  $result = $this->db->get();
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
  function obtenerPacientesImagenes($id_servicio)
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
  urg_orde_imagenes.id_orden,
  urg_orde_imagenes.cups,
  urg_orde_imagenes.cantidadCups,
  urg_orde_imagenes.observacionesCups');
  $this->db->from('urg_atencion');
  $this->db->join('urg_ordenamiento','urg_atencion.id_atencion = urg_ordenamiento.id_atencion');
  $this->db->join('urg_orde_imagenes','urg_ordenamiento.id_orden = urg_orde_imagenes.id_orden');
  $this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
  $this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
  $this->db->where('urg_atencion.consulta','SI');
  $this->db->where('urg_ordenamiento.verificado','SI');
  $this->db->where('urg_atencion.id_servicio',$id_servicio);
  $this->db->where('urg_orde_imagenes.realizado',NULL);
  $this->db->order_by('urg_ordenamiento.fecha_verificado','DESC');
  $this->db->group_by('urg_orde_imagenes.id_orden'); 
  $result = $this->db->get();
  return $result->result_array(); 
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function obtenerInfoServicio($id_servicio)
  {
    $this->db->where('id_servicio',$id_servicio);
    $result = $this->db->get('core_servicios_hosp');
    return $result->row_array();
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
  
  function registraRealizaIma($d)
  {
    
    for($i=0;$i<count($d['idIma']);$i++)
      {
        $update = array(
          'fecha_realizado' => date('Y-m-d H:i:s'),
          'realizado' => $d['realiza'][$i],
          'razon' => $d['razon'][$i],
          );
        $this->db->where('id',$d['idIma'][$i]);
        $this->db->update('urg_orde_imagenes', $update); 
      }
    
   }

/////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
