<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: disponibilidades_model
 *Tipo: controlador
 *Descripcion: Contiene todas las operaciones requeridad en la base de datos 
 *             para la manipulación de los datos de las disponibilidades 
 *             médicas.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Disponibilidades_model extends Model 
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
    function listado_medicos()
    {
        $this->db->SELECT('a.id_tercero, a.primer_nombre, a.primer_apellido, 
                           a.segundo_apellido, a.segundo_nombre, c.descripcion,b.id_medico');
        $this->db->FROM('core_tercero a');
        $this->db->JOIN('core_medico b',' a.id_tercero = b.id_tercero');
        $this->db->JOIN('core_especialidad c','b.id_especialidad= c.id_especialidad');
        $this->db->ORDERBY('a.primer_apellido');
        return $this->db->get()->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function listado_medicos_por_especialidad($id_especialidad)
    {
        $this->db->SELECT('a.id_tercero, a.primer_nombre, a.primer_apellido, 
                           a.segundo_apellido, a.segundo_nombre, c.descripcion,b.id_medico');
        $this->db->FROM('core_tercero a');
        $this->db->JOIN('core_medico b',' a.id_tercero = b.id_tercero');
        $this->db->JOIN('core_especialidad c','b.id_especialidad= c.id_especialidad');
        if($id_especialidad!="-1")
            $this->db->WHERE('c.id_especialidad',$id_especialidad);
        $this->db->ORDERBY('a.primer_apellido');
        return $this->db->get()->result_array();
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
    function listado_disponibilidades()
    {
        $this->db->SELECT('b.id_medico, a.primer_nombre, a.primer_apellido, 
                           a.segundo_apellido, a.segundo_nombre, c.descripcion, d.total_horas_mes');
        $this->db->FROM('core_tercero a');
        $this->db->JOIN('core_medico b',' a.id_tercero = b.id_tercero');
        $this->db->JOIN('core_especialidad c','b.id_especialidad= c.id_especialidad');
        $this->db->JOIN('cex_agenda_disponibilidades d','d.id_core_medico = b.id_medico');
        return $this->db->get()->result_array();
    }
    function disponbilidades_medico($id)
    {
        $this->db->SELECT('a.dia, a.hora_fin, a.hora_inicio, 
                           a.tipo, a.id_detalle_disponbilidad');
        $this->db->FROM('cex_agenda_detalle_disponbilidades a');
        $this->db->WHERE('id_disponbilidad',$id);
        $this->db->order_by('a.dia,a.hora_inicio');
        return $this->db->get()->result_array();
    }
    function agregar_disponbilidad($id_medico,$horas)
    {
        $this->db->DELETE('cex_agenda_disponibilidades',array('id_core_medico'=>$id_medico));
        $this->db->INSERT('cex_agenda_disponibilidades',array('id_core_medico'=>$id_medico,
                                                          'total_horas_mes'=>$horas,
                                                          'estado'=>$horas==0?0:1));
    }
    function eliminar_disponibilidad($id_disponibilidad)
    {
        $this->db->DELETE('cex_agenda_detalle_disponbilidades',array('id_detalle_disponbilidad'=>$id_disponibilidad));
    }
    function buscar_disponibilidad($id_medico,$dia, $hora_inicio, $hora_final)
    {
        return $this->db->query("SELECT a.id_detalle_disponbilidad  
                                 FROM cex_agenda_detalle_disponbilidades a
                                 WHERE a.dia=$dia and a.id_disponbilidad= $id_medico AND 
                                 (($hora_inicio BETWEEN a.hora_inicio and a.hora_fin - 1 ) OR 
                                  ($hora_final BETWEEN a.hora_inicio -1 and a.hora_fin )) ")
                ->result_array();
        
    }
    function agregar_detalle_disponibilidad($id_medico,$dia, $hora_inicio, $hora_final,$tipo)
    {
         $this->db->INSERT('cex_agenda_detalle_disponbilidades',array('id_disponbilidad'=>$id_medico,
                                                          'hora_inicio'=>$hora_inicio,
                                                          'hora_fin'=>$hora_final,
                                                          'tipo'=>$tipo,
                                                          'dia'=>$dia));
    }
///////////////////////////////////////////////////////////////////////////////
    function lista_medicos_agenda()
    {
        $this->db->SELECT("ct.primer_nombre, ct.segundo_nombre, ct.primer_apellido,
	   ct.segundo_apellido, ce.descripcion especialidad, cm.id_medico");
        $this->db->FROM('core_medico cm ');
        $this->db->JOIN('cex_agenda_disponibilidades ad','cm.id_medico = ad.id_core_medico');
        $this->db->JOIN('core_tercero ct','cm.id_tercero = ct.id_tercero');
        $this->db->JOIN('core_especialidad ce','ce.id_especialidad=cm.id_especialidad');
        return $this->db->get()->result_array();
    }
    function especialidad_medico($id_medico)
    {
        $this->db->SELECT('id_especialidad');
        $this->db->WHERE('id_medico',$id_medico);
        $this->db->FROM('core_medico');
        return $this->db->get()->result_array();
    }
    
}
?>