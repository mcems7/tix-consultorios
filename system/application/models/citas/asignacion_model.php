<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: atenciones_model
 *Tipo: modelo
 *Descripcion: Contiene todas las operaciones requeridas en la base de datos
 *             para la manipulación de los datos de la asignación de citas a la
 *             agenda del médico.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Asignacion_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
        $this->load->database();
        $this->load->helper('array');
    }
//////////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////////
    function especialistas_programados_dia($fecha, $id_especialidad)
    {
       $query="select distinct cm.`id_medico`, ct.`primer_apellido`, 
               ct.`segundo_apellido`, ct.`primer_nombre`, ct.`segundo_nombre`
               from `agenda_dia_detalle`  ad
               inner join `core_medico` cm on ad.`id_especialista`=cm.`id_medico`
               inner join core_tercero ct on cm.`id_tercero`=ct.`id_tercero`
               WHERE ad.`id_agenda_consultorio` in (                                    
                                    select distinct aadc.`id_agenda_consultorio` 
                                    from `agenda_agenda_dia_consultorio` aadc
                                    where aadc.`id_agenda_dia` in (
                                          select aad.`id_agenda_dia` 
                                          from`agenda_agenda_dia` aad where fecha='$fecha'))
                                          and cm.`id_especialidad`=$id_especialidad";
       return $this->db->query($query)->result_array();
    }
//////////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////////
    function especialidades_programadas_dia($fecha)
    {

        $this->db->SELECT('ce.id_especialidad, ce.descripcion');
        $this->db->DISTINCT();
        $this->db->FROM('agenda_dia_detalle agdt ');
        $this->db->JOIN('agenda_agenda_dia_consultorio agdc','agdt.id_agenda_consultorio= agdc.id_agenda_consultorio');
        $this->db->JOIN('agenda_agenda_dia agd ','agdc.id_agenda_dia=agd.id_agenda_dia');
        $this->db->JOIN('core_medico cm ','cm.id_medico=agdt.id_especialista');
        $this->db->JOIN('core_especialidad ce','ce.id_especialidad= cm.id_especialidad');
        $this->db->where('fecha',$fecha);
        $resultado=$this->db->get();
        return $resultado->result_array();
    }
    ////////////////////////////////////////////////////////////////////////////
    //Función utilizada por el módulo de asignación de citas, básicamente recibe
    //como parámetro el id de la especialidad y los criterios de filtros.
    //retorna el listado de pacientes esperando a ser asignados para atención.
    ///////////////////////////////////////////////////////////////////////////
    
    function pacientes_espera_especialidad($id_especialidad,$id_departamento,$id_municipio,$tipo_atencion,$prioridad,$prioritaria,$id_entidad_remitente,$id_tiempo)
    {
        $this->db->SELECT("cr.id, ct.primer_nombre, 
                           ct.segundo_nombre, ct.primer_apellido,
                           ct.segundo_apellido, cr.prioridad, 
                           ct.fecha_nacimiento, cr.fecha_solicitud,
                           ct.numero_documento");
        $this->db->FROM("cita_remisiones cr");
        $this->db->JOIN("core_tercero ct","cr.id_tercero = ct.id_tercero");
        $this->db->JOIN("core_municipio cm","cr.id_municipio = cm.id_municipio");
        $this->db->WHERE("cr.estado","autorizada");
        $this->db->WHERE("id_especialidad",$id_especialidad);
        if($id_departamento!=-1)
            $this->db->WHERE("cm.id_departamento",$id_departamento);
        if($id_municipio!="-1")
             $this->db->WHERE("cm.id_municipio",$id_municipio);
        if($tipo_atencion!="-1")
             $this->db->WHERE("tipo_atencion",$tipo_atencion);
        if($prioridad!="ninguna")
            $this->db->WHERE('prioridad',$prioridad);
        if($prioritaria!="ambas")
             $this->db->WHERE('prioritaria',$prioritaria);
        if($id_entidad_remitente!="-1")
            $this->db->WHERE('id_entidad_remitente',$id_entidad_remitente);
        if($id_tiempo!="todas")
             $this->db->WHERE('tipo_cita',$id_tiempo);
        return $this->db->get()->result_array();
        
    }
///////////////////////////////////////////////////////////////////////////////
//Retorna la información básica de la cita, esta información es usada por el módulo
//de asignación de cita cuando se selecciona un paciente de la búsqueda filtrada.
//////////////////////////////////////////////////////////////////////////////
    function datos_basicos_cita($id_cita)
    {
        $query="select cr.`fecha_solicitud`,
                cr.`prioridad`, cer.`razon_social` 'entidad',
                cm.`nombre` 'municipio', cd.`nombre` 'departamento',
                cr.`motivo_consulta`,cr.impresiones_diagnosticas,
                cr.prioritaria,
                ct.`celular`, ct.`email`, ct.`fecha_nacimiento`,
                ct.`telefono`,cr.`tipo_atencion`,cr.`tipo_cita`, cr.duracion_cita,
                cp.`genero`, ct.`telefono`, cr.tipo_cita
                from `cita_remisiones` cr
      inner join `core_eapb` cae on cr.`id_entidad_remitente`=cae.`codigo_eapb`
      inner join core_tercero cer on cer.`id_tercero`=cae.`id_tercero`
      inner join core_tercero ct on ct.`id_tercero` = cr.`id_tercero`
      left join `core_municipio` cm on cm.`id_municipio`=cr.`id_municipio`
      left join `core_departamento` cd on cm.`id_departamento`=cd.`id_departamento`
      inner join `core_paciente` cp on cp.`id_tercero`=ct.`id_tercero`
      where id=$id_cita";
      //cambiar los left por inner, para eso solucionar el registro de ciudad en la remisión.
        return $this->db->query($query)->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//REtorna el listado de los pacientes programados en una fecha determinada de un 
//medico.
///////////////////////////////////////////////////////////////////////////////
    function pacientes_programados_dia_medico($fecha, $id_medico)
    {
        $query="select cr.`id`, ct.`primer_nombre`, ct.`segundo_nombre`, ct.`primer_apellido`,
                ct.`segundo_apellido`, cr.`duracion_cita`, cr.`tipo_cita`,agdd.`orden_intervalo`,
                cag.`orden_intervalo` intervalo_cita, cr.estado
                from `citas_asignadas_agenda` cag
                inner join `cita_remisiones` cr on cr.`id`=cag.`id_remision`
                inner join `agenda_dia_detalle` agdd on agdd.`id_agenda_dia_detalle`=cag.`id_agenda_dia_detalle`
                inner join `core_tercero` ct on cr.`id_tercero`=ct.`id_tercero`
                inner join `agenda_agenda_dia_consultorio` aggdc on aggdc.`id_agenda_consultorio`= agdd.`id_agenda_consultorio`
                inner join `agenda_agenda_dia` aad on aad.`id_agenda_dia`= aggdc.`id_agenda_dia`
                where agdd.`id_especialista`=$id_medico and
                      aad.`fecha`='$fecha'
                order by agdd.`orden_intervalo`,cag.id_remision ";
        return $this->db->query($query)->result_array();
    }
     function pacientes_no_notificados($id_especialidad)
    {
        $query="select cr.`id`, ct.`primer_nombre`, ct.`segundo_nombre`, ct.`primer_apellido`,
                ct.`segundo_apellido`, cag.`duracion`, cr.`tipo_cita`
                from `citas_asignadas_agenda` cag
                inner join `cita_remisiones` cr on cr.`id`=cag.`id_remision`
                inner join `agenda_dia_detalle` agdd on agdd.`id_agenda_dia_detalle`=cag.`id_agenda_dia_detalle`
                inner join `core_tercero` ct on cr.`id_tercero`=ct.`id_tercero`
                inner join `agenda_agenda_dia_consultorio` aggdc on aggdc.`id_agenda_consultorio`= agdd.`id_agenda_consultorio`
                inner join `agenda_agenda_dia` aad on aad.`id_agenda_dia`= aggdc.`id_agenda_dia`
                where agdd.`id_especialista`=$id_especialidad ";
        return $this->db->query($query)->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
     function maximo_intervalo($id_detalle_agenda)
    {
        $query="select IFNULL( max(orden_intervalo),0) orden_intervalo
                FROM `citas_asignadas_agenda`
                where id_agenda_dia_detalle=$id_detalle_agenda";
        return $this->db->query($query)->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function asignar_cita($id_detalle_agenda, $id_cita, $orden_intervalo,$duracion_cita,$id_usuario)
    {
        $insert=array('id_agenda_dia_detalle'=>$id_detalle_agenda,
                      'id_remision'=>$id_cita,
                      'orden_intervalo'=>$orden_intervalo+1,
                      'duracion'=>$duracion_cita);
        
        $this ->db->insert('citas_asignadas_agenda',$insert);
        $insert=array('id_agenda_dia_detalle'=>$id_detalle_agenda,
                      'id_cita'=>$id_cita,
                      'orden_intervalo'=>$orden_intervalo+1,
                      'duracion'=>$duracion_cita,
                      'id_usuario'=>$id_usuario,
                      'operacion'=>'asignacion');
        
        $this ->db->insert('citas_historial',$insert);
        
        $update=array('estado'=>'asignada');
        $this ->db->where('id',$id_cita);
        $this ->db->update('cita_remisiones',$update);
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function minutos_cita($intervalo, $id_remision)
    {
        $query="select ifnull(sum(caa.`duracion`),0) minutos
                from `citas_asignadas_agenda` caa
                    where caa.`id_agenda_dia_detalle` = 
                                    (select caa2.`id_agenda_dia_detalle` 
                                     from citas_asignadas_agenda caa2
                                     where caa2.`id_remision`=$id_remision)
                and caa.`orden_intervalo`<$intervalo";
        return $this->db->query($query)->result_array();
    }
}
?>
