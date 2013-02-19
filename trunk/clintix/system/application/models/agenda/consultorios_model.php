<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: consultorios_model
 *Tipo: controlador
 *Descripcion: Contiene todas las operaciones de base de datos requeridas para 
 *             el manejo de datos relacionadas con la programación y gestión
 *             de los consultorios
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
///////////////////////////////////////////////////////////////////////////////
class consultorios_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
        $this->load->database();
        $this->load->helper('array');
    }
    function listadoConsultorios()
    {
        $this->db->SELECT('id_consultorio, descripcion, estado');
	$this->db->FROM('cex_agenda_consultorios');
        return $this->db->get()->result_array();
    }
    
     function listadoEspecialidadesConsultorios($idConsultorio)
    {
        $this->db->SELECT('ac.id_consultorio, ce.id_especialidad, ce.descripcion, ace.estado');
	$this->db->FROM('core_especialidad ce ');
        $this->db->join('cex_agenda_consultorios_especialidades ace','ace.id_especialidad=ce.id_especialidad');
        $this->db->join('cex_agenda_consultorios ac','ace.id_consultorio=ac.id_consultorio');
        $this->db->where('ac.id_consultorio',$idConsultorio);
        return $this->db->get()->result_array();
    }
    function establecerEstadoConsultorio($id_consultorio, $estado_asignar_consultorio)
    { 
        $update=array('estado'=>$estado_asignar_consultorio=='true'?1:0);
        $this->db->where('id_consultorio',$id_consultorio);
        $this->db->update('cex_agenda_consultorios',$update);          
    }
    function establecerEstadoEspecialidadConsultorio($id_consultorio, $id_especialidad,$estado_asignar_especialidad_consultorio)
    { 
        $update=array('estado'=>$estado_asignar_especialidad_consultorio=='true'?1:0);
        $this->db->where('id_consultorio',$id_consultorio);
        $this->db->where('id_especialidad',$id_especialidad);
        $this->db->update('cex_agenda_consultorios_especialidades',$update);          
    }
    function listaConsultorios()
    {
        $this->db->SELECT('id_consultorio, descripcion');
        $this->db->FROM('cex_agenda_consultorios'); 
        $this->db->WHERE('estado',1);
        return $this->db->get()->result_array();
    }
    function datos_intervalo_agenda($dia, $id_consultorio, $intervarlo)
    {
        
    }
    function esta_disponible_consultorio($id_consultorio,$intervalo, $fecha)
    {
     if(count($this->agenda_model->buscar_detalle_agenda($fecha, $intervalo,$id_consultorio)))
            {
                echo 'Consultorio no Disponible';
                return;
            }
      echo "Si";
    }
    function buscar_id_consultorio($nombre_consultorio)
    {
        $this->db->SELECT('id_consultorio');
        $this->db->FROM('cex_agenda_consultorios'); 
        $this->db->WHERE('descripcion',$nombre_consultorio);
        return $this->db->get()->result_array();
    }
    function agregar_consultorio($nombre_consultorio)
    {
        $d=array(
         'descripcion'=>$nombre_consultorio,
         'estado'=>1
     );
     $this ->db->insert('cex_agenda_consultorios',$d);
    }
    function lista_especialidades()
    {
        $this->db->SELECT('id_especialidad, descripcion');
        $this->db->FROM('core_especialidad'); 
        $this->db->WHERE('id_especialidad <>','1000');
        return $this->db->get()->result_array();
    }
    function lista_especialidades_consultorios()
    {
        $this->db->SELECT('ce.id_especialidad,ce.descripcion');
        $this->db->FROM('core_especialidad ce'); 
        $this->db->distinct();
        $this->db->JOIN('cex_agenda_consultorios_especialidades  ace','ce.id_especialidad=ace.id_especialidad');
        return $this->db->get()->result_array();
    }
    function lista_consultorios_especialidad($id_especialidad)
    {
        $this->db->SELECT('ac.id_consultorio, ac.descripcion');
        $this->db->FROM('cex_agenda_consultorios` ac'); 
        $this->db->JOIN('cex_agenda_consultorios_especialidades  ace','ac.id_consultorio=ace.id_consultorio');
        $this->db->WHERE('ace.estado',1);
        if($id_especialidad!="-1")
            $this->db->WHERE('ace.id_especialidad',$id_especialidad);
        return $this->db->get()->result_array();
    }
    function agregar_especialidad_consultorio($id_consultorio, $id_especialidad)
    {
     $d=array(
         'id_especialidad'=>$id_especialidad,
         'estado'=>1,
         'id_consultorio'=>$id_consultorio
     );
     $this ->db->insert('cex_agenda_consultorios_especialidades',$d);
    }
	function consultorios_especialidad($id_especialidad)
	{
		$this->db->SELECT('id_consultorio');
		$this->db->FROM('cex_agenda_consultorios_especialidades');
		$this->db->WHERE("id_especialidad",$id_especialidad);
		$this->db->WHERE("estado","1");
		return $this->db->get()->result_array();
	}
}
?>
