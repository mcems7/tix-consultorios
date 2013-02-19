<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: citas_model
 *Tipo: modelo
 *Descripcion: Contiene todas las operaciones requeridas en la base de datos
 *             para la manipulación de los datos de la gestión de la cita de
 *             los pacientes.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
///////////////////////////////////////////////////////////////////////////////
class Citas_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////
    function __construct()

    {        
        parent::Model();
        $this->load->database();
        $this->load->helper('array');
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function buscar_pin($pin)
    {
        $this->db->SELECT('pin');
	$this->db->FROM('cex_cita_remisiones');
	$this->db->WHERE('pin',$pin);
	return $this->db->get()->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function ingresar_remision($variables_post_remision,$id_tercero,$variables_tercero,$variables_paciente)
{
    $this->db->insert('cex_cita_remisiones',$variables_post_remision);
    $this->db->where('id_tercero',$id_tercero);
    $this->db->update('core_tercero',$variables_tercero);
    $this->db->where('id_tercero',$id_tercero);
    $this->db->update('core_paciente',$variables_paciente);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function ingresar_remision_control($variables_post_remision,$id_tercero)
{
    $this->db->insert('cex_cita_remisiones',$variables_post_remision);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function lista_remisiones_por_autorizar($id_especialidad, $id_departamento, 
                                        $id_municipio, $tipo_atencion, $prioritaria,
                                        $id_entidad,$id_entidad_pago)
{
        $this->db->SELECT('cr.id, ct.primer_apellido, ct.segundo_apellido,
                           ct.primer_nombre, ct.segundo_nombre, cr.pin, 
                           cr.fecha_solicitud, cer.razon_social entidad_remite, 
                           cr.motivo_remision, ce.descripcion especialidad,
                           cr.solicitud_prioritaria,cerp.razon_social eps');
        $this->db->FROM('cex_cita_remisiones cr');
        $this->db->JOIN('core_tercero ct','cr.id_tercero=ct.id_tercero');
        $this->db->JOIN('core_eapb cea','cr.id_entidad_remitente=cea.codigo_eapb');
        $this->db->JOIN('core_tercero cer','cer.id_tercero= cea.id_tercero');
        $this->db->JOIN('core_eapb ceap','cr.id_entidad=ceap.id_entidad');
        $this->db->JOIN('core_tercero cerp','cerp.id_tercero= ceap.id_tercero');
        $this->db->JOIN('core_especialidad ce','ce.id_especialidad=cr.id_especialidad');
        $this->db->JOIN('core_municipio cm','cm.id_municipio=cr.id_municipio');
        $this->db->JOIN('core_departamento cd','cd.id_departamento=cm.id_departamento');
        $this->db->WHERE('cr.estado','solicitada');
        if($id_especialidad!="-1")
             $this->db->WHERE('cr.id_especialidad',$id_especialidad);
        if($id_departamento!="-1")
             $this->db->WHERE('cd.id_departamento',$id_departamento);
        if($id_municipio!="-1")
             $this->db->WHERE('cm.id_municipio',$id_municipio);
        if($tipo_atencion!="-1")
             $this->db->WHERE('cr.tipo_atencion',$tipo_atencion);
        if($prioritaria!="ambas")
             $this->db->WHERE('cr.solicitud_prioritaria',$prioritaria);
        if($id_entidad!="-1")
             $this->db->WHERE('cr.id_entidad_remitente',$id_entidad);
         if($id_entidad_pago!="-1")
             $this->db->WHERE('cr.id_entidad',$id_entidad_pago);
        $this->db->ORDERBY('cr.fecha_solicitud ASC, cr.id');
	return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////    
function detalle_cita($id)
{
    $this->db->SELECT("ct.primer_apellido, ct.segundo_apellido,
                       ct.primer_nombre, ct.segundo_nombre, 
                       cr.pin, cr.fecha_solicitud,cer.razon_social entidad_remite,
                       ce.descripcion especialidad,  ct.numero_documento,
                       cr.*, ct.fecha_nacimiento,ct.*,
                       cd.nombre departamento, cm.nombre municipio, cr.observaciones,
                       cerp.razon_social eps");
    $this->db->FROM('cex_cita_remisiones cr ');
    $this->db->JOIN('core_tercero ct','cr.id_tercero=ct.id_tercero');
    $this->db->JOIN('core_eapb cea','cr.id_entidad_remitente=cea.codigo_eapb');
    $this->db->JOIN('core_tercero cer','cea.id_tercero =cer.id_tercero'); 
    $this->db->JOIN('core_eapb ceap','cr.id_entidad=ceap.id_entidad');
    $this->db->JOIN('core_tercero cerp','ceap.id_tercero =cerp.id_tercero'); 
    $this->db->JOIN('core_especialidad ce','ce.id_especialidad=cr.id_especialidad'); 
    $this->db->JOIN('core_municipio cm','cm.id_municipio= cr.id_municipio');
    $this->db->JOIN('core_departamento cd','cm.id_departamento=cd.id_departamento');
    $this->db->WHERE('cr.id',$id);
    return $this->db->GET()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function actualizar_remision($variables_post)
    {
        $this->db->where('id',$variables_post['id']);
        $this->db->update('cex_cita_remisiones',$variables_post);
    }
///////////////////////////////////////////////////////////////////////////////
    function lista_consultas_espera()
    {
        $query="
select cr.`id`, ct.`primer_apellido`, ct.`segundo_apellido`,
ct.`primer_nombre`, ct.`segundo_nombre`, cr.`pin`, cr.`fecha_solicitud`,cr.prioridad,
cer.`nombre` \"entidad_remite\", cr.motivo_remision, ce.`descripcion` especialidad,
cr.tipo_cita, ct.fecha_nacimiento
from `cex_cita_remisiones` cr 
     inner join `core_tercero` ct on cr.`id_tercero`=ct.`id_tercero`
     inner join `core_entidad_remision` cer on cr.`id_entidad_remitente`=cer.`codigo_entidad`  
     inner join `core_especialidad` ce on ce.`id_especialidad`=cr.`id_especialidad`    
where cr.`estado`='autorizada'
order by cr.`fecha_solicitud` ASC, cr.`id`";
	return $this->db->query($query)->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////    
    function detalle_disponbilidad_medico($fecha,$id_medico)
    {
        $query="select agd.`id_agenda_dia_detalle`, agd.`orden_intervalo`
 from `cex_agenda_dia_detalle` agd
 	  inner join `cex_agenda_agenda_dia_consultorio` agdc on agd.`id_agenda_consultorio`= agdc.`id_agenda_consultorio`
      inner join cex_agenda_agenda_dia aad on aad.`id_agenda_dia`=agdc.`id_agenda_dia`
where agd.`id_especialista`=$id_medico and aad.`fecha`='$fecha'";
        return $this->db->query($query)->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function tiempos_disponibles($id_agenda)
{
$query="select IFNULL(sum(duracion),0) duracion FROM  `cex_citas_asignadas_agenda` a
    where a.`id_agenda_dia_detalle`=$id_agenda";
return $this->db->query($query)->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function tiempos_consulta($id_especialidad)
    {
        $this->db->SELECT('consulta_primera_vez, consulta_control_pos_operatorio,
                          consulta_control, consulta_procedimiento,
                          consulta_repetitiva,junta_medica');
        $this->db->WHERE('id_especialidad',$id_especialidad);
        $this->db->FROM('cex_tiempos_consulta');
        return $this->db->get()->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function suspender_cita($id_cita,$id_usuario)
    {
        $this->db->WHERE('id_remision',$id_cita);
        $this->db->DELETE('cex_citas_asignadas_agenda');
        $insert=array('id_cita'=>$id_cita,
                      'id_usuario'=>$id_usuario,
                      'operacion'=>'suspendida'
                      );
        $this->db->INSERT('cex_citas_historial',$insert);
        $this->db->WHERE('id',$id_cita);
        $update=array('estado'=>'autorizada');
        $this->db->UPDATE('cex_cita_remisiones',$update);
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function dar_baja_cita($id_cita,$causa,$id_usuario)
    {
        $this->db->WHERE('id_remision',$id_cita);
        $this->db->DELETE('cex_citas_asignadas_agenda');
        $insert=array('id_cita'=>$id_cita,
                      'id_usuario'=>$id_usuario,
                      'operacion'=>'cancelada'
                      );
        $this->db->INSERT('cex_citas_historial',$insert);
        $this->db->WHERE('id',$id_cita);
        $update=array('estado'=>'cancelada','id_usuario_cancela'=>$id_usuario,
                      'motivo_cancelacion'=>$causa);
        $this->db->UPDATE('cex_cita_remisiones',$update);
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function confirmar_cita($id_cita,$factura,$id_usuario)
{
    $insert=array('id_cita'=>$id_cita,
                  'id_usuario'=>$id_usuario,
                  'operacion'=>'confirmacion'
                  );
    $this->db->INSERT('cex_citas_historial',$insert);
    $this->db->WHERE('id',$id_cita);
    $update=array('estado'=>'confirmada','factura'=>$factura,
                  'id_usuario_confirma'=>$id_usuario,);
    $this->db->UPDATE('cex_cita_remisiones',$update);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function obtenerEntidadesRemision()
{
    $this->db->SELECT('ce.id_entidad, ce.codigo_eapb codigo_entidad, ct.razon_social nombre');
    $this->db->FROM('core_tercero ct');
    $this->db->JOIN('core_eapb ce','ct.id_tercero=ce.id_tercero');
    $this->db->ORDERBY('nombre');
    return $this->db->GET()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function datos_cita($pin)
{
    
    $this->base_consulta_cita();
    $this->db->WHERE('cr.pin',$pin);
    return $this->db->GET()->row_array();
}
////////////////////////////////////////////////////////////////////////////////
//
function datos_cita_online($pin,$documento)
{
    
    $this->base_consulta_cita();
    $this->db->WHERE('cr.pin',$pin);
	$this->db->WHERE('ctp.numero_documento',$documento);
    return $this->db->GET()->row_array();
}
////////////////////////////////////////////////////////////////////////////////
//

////////////////////////////////////////////////////////////////////////////////
function buscar_cita($d)
{
    $this->base_consulta_cita();
    if(strlen($d['primer_apellido']) > 0)
        $this->db->like('ctp.primer_apellido',$d['primer_apellido']); 

    if(strlen($d['primer_nombre']) > 0){
        $this->db->like('ctp.primer_nombre',$d['primer_nombre']); }

    if(strlen($d['segundo_apellido']) > 0){
        $this->db-> like('ctp.segundo_apellido',$d['segundo_apellido']); }

    if(strlen($d['segundo_nombre']) > 0){
        $this->db->like('ctp.segundo_nombre',$d['segundo_nombre']); }

    if(strlen($d['numero_documento']) > 0){
        $this-> db -> where('ctp.numero_documento',$d['numero_documento']);
        }
    if(strlen($d['pin']) > 0){
        $this-> db -> where('cr.pin',$d['pin']);
        }
    //$this->db->group_by('numero_documento');
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
function buscar_citas_listas($d)
{
    $this->base_consulta_cita();
    $fecha_inicio=$d['fecha_agenda_inicial'];
    $fecha_fin=$d['fecha_agenda'];
    if($d['id_estado']=="asignada")
        $this->db->WHERE("aad.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'");
    else
        $this->db->WHERE("cr.fecha_solicitud BETWEEN '$fecha_inicio' AND '$fecha_fin'");
    if($d['id_especialidad']!="-1")
       $this->db->WHERE('cr.id_especialidad',$d['id_especialidad']);
    if($d['id_entidad']!="-1")
       $this->db->WHERE('cr.id_entidad_remitente',$d['id_entidad']);
    if($d['id_entidad_pago']!="-1")
       $this->db->WHERE('cr.id_entidad',$d['id_entidad_pago']);
    if($d['id_estado']!="-1")
       $this->db->WHERE('cr.estado',$d['id_estado']);
    $result = $this->db->get();
    $num = $result -> num_rows();
    if($num == 0){
    return $num;}
    $res = $result -> result_array();
    return  $res;
}
////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
private function base_consulta_cita()
{
    $this->db->SELECT('cr.fecha_solicitud, cr.estado, ctp.primer_nombre,
                       ctp.segundo_nombre, ctp.primer_apellido, 
                       ctp.segundo_apellido, aad.fecha fecha_cita, 
                       ac.descripcion consultorio, 
                       ctm.primer_apellido primer_apellido_medico,
                       ctm.segundo_apellido segundo_apellido_medico,
                       ctm.primer_nombre primer_nombre_medico, 
                       ctm.segundo_nombre segundo_nombre_medico,
                       cer.razon_social entidad, ctp.numero_documento,
                       cr.motivo_rechazo,cr.pin,  ces.descripcion especialidad,
                       agdd.orden_intervalo,cr.id,caa.orden_intervalo intervalo_cita,
                       aad.fecha, cerp.razon_social eps
                       ');
    $this->db->FROM('cex_cita_remisiones cr');
    $this->db->JOIN('core_paciente cp','cr.id_paciente=cp.id_paciente');
    $this->db->JOIN('core_tercero ctp ','cp.id_tercero=ctp.id_tercero');
    $this->db->JOIN('core_eapb cea','cr.id_entidad_remitente=cea.codigo_eapb');
    $this->db->JOIN('core_tercero cer','cer.id_tercero=cea.id_tercero');
    $this->db->JOIN('core_eapb ceap','cr.id_entidad=ceap.id_entidad');
    $this->db->JOIN('core_tercero cerp','cerp.id_tercero=ceap.id_tercero');
    $this->db->JOIN('core_municipio cm','cr.id_municipio=cm.id_municipio');
    $this->db->JOIN('core_departamento cd','cm.id_departamento=cd.id_departamento');
    $this->db->JOIN('core_especialidad ces','ces.id_especialidad = cr.id_especialidad');
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision','left');
    $this->db->JOIN('cex_agenda_dia_detalle agdd','agdd.id_agenda_dia_detalle=caa.id_agenda_dia_detalle','left');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio=agdd.id_agenda_consultorio','left');
    $this->db->JOIN('cex_agenda_agenda_dia aad','aadc.id_agenda_dia=aad.id_agenda_dia','left');
    $this->db->JOIN('cex_agenda_consultorios` ac','aadc.id_consultorio=ac.id_consultorio','left');
    $this->db->JOIN('core_medico cmd','cmd.id_medico=agdd.id_especialista','left');
    $this->db->JOIN('core_tercero ctm','ctm.id_tercero=cmd.id_tercero','left');
    $this->db->ORDERBY('cr.fecha_solicitud');
}
///////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////

}
///////////////////////////////////////////////////////////////////////////////
