<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: autorizar_cita
 *Tipo: controlador
 *Descripcion: Permite la gestión de las autorizaciones de las citas solicitadas
 *             por los terceros
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
///////////////////////////////////////////////////////////////////////////////
class Autorizar_cita extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->model('citas/citas_model');
    $this->load->model('atenciones/atenciones_model');
    $this->load->library('lib_edad');
    $this->load->helper('url');
    $this->load->helper('date');
    $this->load->helper('array');
    $this->load->helper('datos_listas');
    $this->load->model('core/ubicacion_model');
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function index()
{
    $departamentos=$this->ubicacion_model->departamentos();
    $lista=$this->agenda_model->lista_especialidades_contratadas();
    $especialidades=array();
    $especialidades["-1"]="todas";
    foreach($lista as $item)
    {
        $especialidades[$item['id_especialidad']]=$item['descripcion'];
    }
    $d['especialidades']=$especialidades;
    $d['departamento']=array(-1=> "Todos");
    foreach($departamentos as $item)
    {
        if($item['nombre']!="No aplica")
            $d['departamento'][$item['id_departamento']]=$item['nombre'];
    }
    $d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();
    $this->load->view('core/core_inicio');
    $this->load->view('citas/autorizar_citas', $d);
    $this->load->view('core/core_fin');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function detalle($id)
    {
    $d['listado_citas']=$this->citas_model->detalle_cita($id);
    $d['info_cita']=$d['listado_citas'][0];
    $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
    $d['info_cita']['tiempo_espera']=$this->lib_edad->dias($d['info_cita']['fecha_solicitud'],date('Y-m-d'))." Días";
    $this->load->view('core/core_inicio');
    $this->load->view('citas/detalle_cita',$d);
    $this->load->view('citas/autorizar_cita',$d);
    $this->load->view('core/core_fin');
    }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
   function cambiar_estado_cita_pedida()
   {
       if(count($_POST)==0)
           return;
       $variables_post=array();
       if($this->input->post('estado')=='autorizada')
       {
           $variables_post=elements(Array('prioridad','estado','id','tipo_cita','prioritaria'), $_POST);
           $id_cita=$id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($this->input->post('id'));
           $duracion_citas=$this->citas_model->tiempos_consulta($id_cita[0]['id_especialidad']);
           $variables_post['duracion_cita']= $duracion_citas[0][$this->input->post('tipo_cita')];
           
       }
       else
      $variables_post=elements(Array('motivo_rechazo','estado','id'), $_POST);
      $variables_post['fecha_rechazo_aprobacion']=date('y-m-d');
      $variables_post['id_usuario_aprobo']=$this->session->userdata('id_usuario');
      $this->citas_model->actualizar_remision($variables_post);
      header('Location:  '.site_url('citas/autorizar_cita/'));
   }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function lista_autorizacion($id_especialidad, $id_departamento, $id_municipio, $tipo_atencion,$prioritaria,$id_entidad,$id_entidad_pago)
{
    $d['listado_citas']=$this->citas_model->lista_remisiones_por_autorizar($id_especialidad, $id_departamento, $id_municipio, $tipo_atencion, $prioritaria,$id_entidad,$id_entidad_pago);
    $this->load->view('citas/lista_citas_autorizar', $d);
}
}