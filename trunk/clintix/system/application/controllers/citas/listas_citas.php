<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: listas_cita
 *Tipo: controlador
 *Descripcion: Permite consulta el estado de las citas.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 20 de Febrero de 2012
*/
///////////////////////////////////////////////////////////////////////////////
class Listas_citas extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->model('citas/citas_model');
    $this->load->model('citas/asignacion_model');
    $this->load->helper('array');
    $this->load->helper('datos_listas');
  }
function index()
    {
     $d = array();
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     $d['listaParametros']=$this->agenda_model->listaParametros();
    //----------------------------------------------------------
    $lista=$this->agenda_model->lista_especialidades_contratadas();
    $especialidades=array();
    $especialidades["-1"]="todas";
    foreach($lista as $item)
    {
        $especialidades[$item['id_especialidad']]=$item['descripcion'];
    }
    $entidades=array();
    $entidades["-1"]="todas";
    $lista_entidades = $this -> citas_model -> obtenerEntidadesRemision();
    foreach($lista_entidades as $item)
    {
        $entidades[$item['codigo_entidad']]=$item['nombre'];
    }
    $d['entidades']=  $entidades;
    $entidades=array();
    $entidades["-1"]="todas";
    foreach($lista_entidades as $item)
        {
            $entidades[$item['id_entidad']]=$item['nombre'];
        }
    $d['entidades_pago']=  $entidades;
    $d['especialidades']=$especialidades;
    $d['departamento']=array(-1=> "Todos");
    
    $this->load->view('core/core_inicio');
    $this -> load -> view('citas/listas_citas',$d);
    $this->load->view('core/core_fin');
    }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function filtrar()
{
    $d['citas']=$this->citas_model->buscar_citas_listas($_POST);
    $d['filtros']=$_POST;
    $d['id_estado']=$_POST['id_estado'];
    //$minutos=$this->asignacion_model->minutos_cita($d['citas']['intervalo_cita'], $d['citas']['id']);
    $this->load->view('citas/lista_citas_filtrada',$d);
}

}
