<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: consultorios
 *Tipo: controlador
 *Descripcion: Permite administrar los consultorios a usarse en la agenda.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
////////////////////////////////////////////////////////////////////////////////
class Consultorios extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/consultorios_model');
    $this->load->helper('array');
  }
function index()
    {
     $d = array();
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     $d['listadoConsultorios']=$this->consultorios_model->listadoConsultorios();
     $d['listadoEspecialidades']=$this->consultorios_model->lista_especialidades();
     $temporal_array=array();
     foreach($d['listadoEspecialidades'] as $item)
     {
         $temporal_array[$item['id_especialidad']]=$item['descripcion'];
     }
     $d['listadoEspecialidades']=$temporal_array;
    //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('agenda/admininistrar_consultorio', $d);
    $this->load->view('core/core_fin');
    }
    
   function especialidadesConsultorio($id_consultorio)
   {
       $d = array();
       $d['consultorioEspecialidades']=$this->consultorios_model->listadoEspecialidadesConsultorios($id_consultorio);
       $this->load->view('agenda/especialidades_consultorio', $d);
   }
   function cambiarEstadoConsultorio($id_consultorio,$estado_asignar_consultorio)
   {
       $this->consultorios_model->establecerEstadoConsultorio($id_consultorio,$estado_asignar_consultorio);
   }
   function cambiarEstadoEspecialidadConsultorio($id_consultorio, $id_especialidad,$estado_asignar)
   {
      $this->consultorios_model->establecerEstadoEspecialidadConsultorio($id_consultorio,$id_especialidad,$estado_asignar);
   }
   function agregar_consultorio($nombre_consultorio)
   {
       $this->consultorios_model->agregar_consultorio($nombre_consultorio);
   }
   function existe_consultorio($nombre_consultorio)
   {
       if(count($this->consultorios_model->buscar_id_consultorio($nombre_consultorio)))
               echo "true";
       else
           echo "false";
   }
   function agregar_especialidad_consultorio($id_consultorio, $id_especialidad)
   {
        $this->consultorios_model->agregar_especialidad_consultorio($id_consultorio, $id_especialidad);
   }
}
?>