<?php
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hce_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 12 de mayo de 2011
*/
class Hce_consulta_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{        
    parent::Model();

            $this->load->database();
}
function obtenerAtencionesPacientes($d)
{
    $this->db->select('ct.primer_nombre, ct.segundo_nombre, ct.primer_apellido,
                       ct.segundo_apellido, ct.numero_documento,
                       ce.`descripcion` especialidad,
                       caa.hora_atencion hora_atencion, aad.fecha, cp.id_paciente,
                       ctd.tipo_documento');
    $this->db->from('core_tercero ct');	
    $this->db->join('cex_cita_remisiones cr',' cr.id_tercero=ct.id_tercero');
    $this->db->join('core_especialidad ce','cr.id_especialidad=ce.id_especialidad');
    $this->db->join('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision');
    $this->db->join('cex_agenda_dia_detalle agdd','agdd.id_agenda_dia_detalle= caa.id_agenda_dia_detalle');
    $this->db->join('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio = agdd.id_agenda_consultorio');
    $this->db->join('cex_agenda_agenda_dia aad','aad.id_agenda_dia= aadc.id_agenda_dia');
    $this->db->join('core_paciente cp','ct.id_tercero=cp.id_tercero');
    $this->db->join('core_tipo_documentos ctd','ctd.id_tipo_documento=ct.id_tipo_documento');
    $this->db->where('cr.estado','atendida');
    
    if(strlen($d['primer_apellido']) > 0)
        $this-> db -> like('ct.primer_apellido',$d['primer_apellido']); 

    if(strlen($d['primer_nombre']) > 0){
        $this-> db -> like('ct.primer_nombre',$d['primer_nombre']); }

    if(strlen($d['segundo_apellido']) > 0){
        $this-> db -> like('ct.segundo_apellido',$d['segundo_apellido']); }

    if(strlen($d['segundo_nombre']) > 0){
    $this-> db -> like('ct.segundo_nombre',$d['segundo_nombre']); }

    if(strlen($d['numero_documento']) > 0){
    $this-> db -> where('ct.numero_documento',$d['numero_documento']);
    }
    $this->db->group_by('numero_documento');
    $this->db->order_by('aad.fecha', 'desc'); 

    $result = $this->db->get();
    $num = $result -> num_rows();
    if($num == 0){
    return $num;}
    $res = $result -> result_array();
    return  $res;
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function hce_paciente($id_cita)
{
    $this->db->SELECT('*');
    $this->db->FROM('cex_atencion_hce');
    $this->db->WHERE('id_cita',$id_cita);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function incapacidad_paciente($id_cita)
{
    $this->db->SELECT('ai.id_diagnostico, ai.fecha_inicio,
                       ai.duracion,ai.observacion, cdi.diagnostico');
    $this->db->FROM('cex_atencion_incapacidad ai');
    $this->db->JOIN('core_diag_item cdi','ai.id_diagnostico=cdi.id_diag');
    $this->db->WHERE('ai.id_atencion',$id_cita);
    return $this->db->get()->row_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function plan_y_manejo_paciente($id_cita)
{
    $this->db->SELECT('conducta');
    $this->db->FROM('cex_citas_asignadas_agenda');
    $this->db->WHERE('id_remision',$id_cita);
    $resultado=$this->db->get()->row_array();
    return $resultado['conducta'];
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function diagnosticos_paciente($id_cita)
{
    $this->db->SELECT('cdi.id_diag codigo, cdi.diagnostico');
    $this->db->FROM('cex_atencion_diagnostico ad');
    $this->db->JOIN('core_diag_item cdi','ad.id_diagnostico=cdi.`id_diag');
    $this->db->WHERE('ad.id_cita',$id_cita);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function medicamentos_paciente($id_cita)
{  
    $this->db->SELECT('cm.principio_activo, cm.descripcion, 
                       cmvvia.descripcion via, aom.frecuencia,
                       cmvfr.descripcion descripcion_frecuencia,
                       cmvun.descripcion descripcion_dosis, aom.dosis,
                       observacionesMed');
    $this->db->FROM('cex_atencion_orde_medicamentos aom');
    $this->db->JOIN('core_medicamento  cm','cm.atc_full=aom.atc');
    $this->db->JOIN('core_medicamento_var cmvvia','cmvvia.id=aom.id_via');
    $this->db->JOIN('core_medicamento_var cmvfr','cmvfr.id=aom.id_frecuencia');
    $this->db->JOIN('`core_medicamento_var cmvun',' cmvun.id=aom.id_unidad');
    $this->db->WHERE('aom.id_atencion',$id_cita);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function ayudas_diagnosticas($id_cita)
{
    $this->db->SELECT('aoc.cantidadCups` cantidad, aoc.observacionesCups observaciones,
                       ccs.desc_subcategoria');
    $this->db->FROM('cex_atencion_orde_cups` aoc');
    $this->db->JOIN('core_cups_subcategoria ccs','aoc.cups=ccs.id_subcategoria');
    $this->db->WHERE('aoc.`id_atencion`',$id_cita);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////

function cargar_items_hce($id_especialidad)
{
    $this->db->SELECT('id,abreviatura,nombre,tipo,idpadre,tipo_dato');
    $this->db->FROM('cex_atencion_item_hc aiha');
    $this->db->WHERE("aiha.idpadre=(select id from cex_atencion_item_hc aih 
                                    where aih.id_especialidad=$id_especialidad)");
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function cargar_items_hijos_hce($id_padre)
{
    $this->db->SELECT('id,abreviatura,nombre,tipo,idpadre,tipo_dato');
    $this->db->FROM('cex_atencion_item_hc aiha');
    $this->db->WHERE('aiha.idpadre',$id_padre);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function remision($id_cita)
{
    $this->db->SELECT('motivo_remision,observacion,otra_especialidad,descripcion especialidad,
                       tipo_cita');
    $this->db->FROM('cex_atencion_remision ar');
    $this->db->JOIN('core_especialidad ce','ce.id_especialidad=ar.id_especialidad_remite');
    $this->db->WHERE('id_atencion',$id_cita);
    $this->db->WHERE("(tipo_cita='prioritaria' OR tipo_cita='no_prioritaria')");
    return $this->db->get()->row_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function control($id_cita)
{
    $this->db->SELECT('ar.dias_cita_control,ar.observacion,cr.fecha_solicitud,
                       ar.pin');
    $this->db->FROM('cex_atencion_remision ar');
    $this->db->JOIN('cex_cita_remisiones cr','cr.id=ar.id_atencion');
    $this->db->WHERE('id_atencion',$id_cita);
    $this->db->WHERE('ar.tipo_cita','control');
    return $this->db->get()->row_array();
}
}