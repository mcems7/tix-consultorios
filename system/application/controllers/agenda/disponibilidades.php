<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: disponibilidades
 *Tipo: controlador
 *Descripcion: Permite gestionar las disponibilidades de los médicos para ser 
 *             habilitados para la agenda.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
///////////////////////////////////////////////////////////////////////////////
class Disponibilidades extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/disponibilidades_model');
    $this->load->model('agenda/agenda_model');
    $this->load->model('agenda/consultorios_model');
    $this->load->helper('array');
  }
function index()
    {
     $d = array();
     $listado_especialidades=$this->consultorios_model->lista_especialidades();
     $d['listado_especialidades'][-1]="Todos";
     foreach($listado_especialidades as $item)
     {
         $d['listado_especialidades'][$item['id_especialidad']]=$item['descripcion'];
     }
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     $d['lista_medicos']=$this->disponibilidades_model->listado_medicos();
     foreach($d['lista_medicos'] as $item)
          $options_array[$item['id_medico']]=$item['primer_apellido']. ' '.$item['segundo_apellido']. ' '.$item['primer_nombre']. ' '.$item['segundo_nombre']. ' || '.$item['descripcion'];  
     $d['options_array_selected']=$options_array;
     $d['disponibilidades']=$this->disponibilidades_model->listado_disponibilidades();
 //-------------------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this->load->view('agenda/disponbilidades', $d);
    $this->load->view('core/core_fin');
    }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
    function disponibilidad_medico($id_medico)
    {
        
    }
    function disponibilidades_medicos($id)
    {
        $arreglo_dias_temporal=$this->disponibilidades_model->disponbilidades_medico($id);
        $lunes=0;
        $martes=0;
        $miercoles=0;
        $jueves=0;
        $viernes=0;
        $sabado=0;
        $domingo=0;
        $arreglo_dias=array();
        $contador=0;
        foreach($arreglo_dias_temporal as $item)
        {
            if($item['dia']==1)
            {
                $contador=$lunes;
                ++$lunes;
            }
            else if($item['dia']==2)
            {
                $contador=$martes;
                ++$martes;
            }
            else if($item['dia']==3)
            {
                $contador=$miercoles;
                ++$miercoles;
            }
             else if($item['dia']==4)
            {
                $contador=$jueves;
                ++$jueves;
            }
             else if($item['dia']==5)
            {
                $contador=$viernes;
                ++$viernes;
            }
             else if($item['dia']==6)
            {
                $contador=$sabado;
                ++$sabado;
            }
             else if($item['dia']==7)
            {
                $contador=$domingo;
                ++$domingo;
            }
            $arreglo_dias[$contador][$item['dia']]['hora_inicio']=$item['hora_inicio'];
            $arreglo_dias[$contador][$item['dia']]['hora_fin']=$item['hora_fin'];
            $arreglo_dias[$contador][$item['dia']]['tipo']=$item['tipo'];
            $arreglo_dias[$contador][$item['dia']]['id_disponibilidad']=$item['id_detalle_disponbilidad'];
        }
        $d['disponibilidad_medico']=$arreglo_dias;
        $this->load->view('agenda/disponibilidad_medico',$d);
    }
    function agregar_disponibilidad($id_medico, $horas)
    {
        $this->disponibilidades_model->agregar_disponbilidad($id_medico, $horas);
    }
    function eliminar_disponibilidad($id_detalle_disponibilidad)
    {
        $this->disponibilidades_model->eliminar_disponibilidad($id_detalle_disponibilidad);
    }
   function existe_disponibilidad($id_medico,$dia, $hora_inicio, $hora_final)
    {
        $resultado=$this->disponibilidades_model->buscar_disponibilidad($id_medico,$dia, $hora_inicio, $hora_final);
        if(count($resultado)==0)
            echo "false";
        else
            echo "true";
    }
    function agregar_detalle_disponbilidad($id_medico,$dia, $hora_inicio, $hora_final,$tipo)
    {
        $this->disponibilidades_model->agregar_detalle_disponibilidad($id_medico,$dia, $hora_inicio, $hora_final,$tipo);
    }
    function estaDisponibleMedico($id_consultorio, $id_medico, $intervalo, $fecha)
    {
        $dia = date('N', strtotime($fecha));
        
    }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function filtrar_especialistas($id_especialidad)
{
    echo form_dropdown('medico_disponibilidad',$this->lista_especialistas($id_especialidad),'','id=medico_disponibilidad');
}
///////////////////////////////////////////////////////////////////////////////
private function lista_especialistas($id_especialidad)
{
    $listado_medicos=$this->disponibilidades_model->listado_medicos_por_especialidad($id_especialidad);
    $lista=array();
    foreach($listado_medicos as $item)
    {
        $lista[$item['id_medico']]=$item['primer_apellido']. ' '.$item['segundo_apellido']. ' '.$item['primer_nombre']. ' '.$item['segundo_nombre']. ' || '.$item['descripcion'];  
    }
    return $lista;
}
}
