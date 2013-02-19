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
class Rips_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{        
    parent::Model();

            $this->load->database();
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function citas_atendidas_especialidades($fecha_inicio, $fecha_fin)
{
    $this->db->SELECT('ces.descripcion especialidad, ces.id_especialidad');
    $this->db->FROM('cex_cita_remisiones cr');
    $this->db->JOIN('core_especialidad ces','ces.id_especialidad = cr.id_especialidad');
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision','left');
    $this->db->JOIN('cex_agenda_dia_detalle agdd','agdd.id_agenda_dia_detalle=caa.id_agenda_dia_detalle','left');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio=agdd.id_agenda_consultorio','left');
    $this->db->JOIN('cex_agenda_agenda_dia aad','aadc.id_agenda_dia=aad.id_agenda_dia','left');
    $this->db->WHERE("aad.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'");
    $this->db->ORDERBY('especialidad');
    $this->db->DISTINCT();
    $result = $this->db->get();
    $res = $result->result_array();
    return  $res;
}
function medicos_atencion_fecha($fecha_inicial, $fecha_final,$id_especialidad)
{
     $this->db->SELECT('ctm.primer_apellido primer_apellido_medico,
                       ctm.segundo_apellido segundo_apellido_medico,
                       ctm.primer_nombre primer_nombre_medico, 
                       ctm.segundo_nombre segundo_nombre_medico,
                       cmd.id_medico
                       ');
    $this->db->FROM('cex_cita_remisiones cr');
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision','left');
    $this->db->JOIN('cex_agenda_dia_detalle agdd','agdd.id_agenda_dia_detalle=caa.id_agenda_dia_detalle','left');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio=agdd.id_agenda_consultorio','left');
    $this->db->JOIN('cex_agenda_agenda_dia aad','aadc.id_agenda_dia=aad.id_agenda_dia');
    $this->db->JOIN('core_medico cmd','cmd.id_medico=agdd.id_especialista');
    $this->db->JOIN('core_tercero ctm','ctm.id_tercero=cmd.id_tercero');
    $this->db->ORDERBY('cr.fecha_solicitud');
    $this->db->WHERE("aad.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'");
    $this->db->WHERE("cmd.id_especialidad",$id_especialidad);
    $result = $this->db->get();
    $res = $result->result_array();
    return  $res;
}
function rips_medico($fecha_inicial, $fecha_final,$id_especialista)
{
    $this->db->SELECT('ctm.primer_apellido primer_apellido_medico,
                       ctm.segundo_apellido segundo_apellido_medico,
                       ctm.primer_nombre primer_nombre_medico, 
                       ctm.segundo_nombre segundo_nombre_medico,
                       ctp.numero_documento,cr.factura,
                       ces.descripcion especialidad,ad.id_diagnostico diagnostico,
                       ctp.primer_apellido, ctp.segundo_apellido,
                       ctp.primer_nombre,ctp.segundo_nombre, aad.fecha,
                       cr.tipo_atencion,cr.id id_atencion');
    $this->db->FROM('cex_cita_remisiones cr');
    $this->db->JOIN('core_tercero ctp ','cr.id_tercero=ctp.id_tercero');
    $this->db->JOIN('core_eapb cea',' id_entidad_remitente=cea.codigo_eapb');
    $this->db->JOIN('core_tercero cer',' cer.id_tercero=cea.id_tercero');
    $this->db->JOIN('core_especialidad ces','ces.id_especialidad = cr.id_especialidad');
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision','left');
    $this->db->JOIN('cex_agenda_dia_detalle agdd','agdd.id_agenda_dia_detalle=caa.id_agenda_dia_detalle','left');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio=agdd.id_agenda_consultorio','left');
    $this->db->JOIN('cex_agenda_agenda_dia aad','aadc.id_agenda_dia=aad.id_agenda_dia');
    $this->db->JOIN('cex_agenda_consultorios` ac','aadc.id_consultorio=ac.id_consultorio');
    $this->db->JOIN('core_medico cmd','cmd.id_medico=agdd.id_especialista');
    $this->db->JOIN('cex_atencion_diagnostico ad','ad.id_cita=cr.id');
    $this->db->JOIN('core_tercero ctm','ctm.id_tercero=cmd.id_tercero');
    $this->db->WHERE("aad.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'");
    $this->db->WHERE("ad.principal",1);
    $this->db->WHERE("agdd.id_especialista",$id_especialista);
    $result = $this->db->get();
    $res = $result->result_array();
    return  $res;
}
///////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function editar_factura($id_atencion, $factura)
{
    $update=array('factura'=>$factura);
    $this->db->WHERE('id',$id_atencion);
    $this->db->UPDATE('cex_cita_remisiones',$update);
}
}