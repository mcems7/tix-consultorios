<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *TIX - http://www.tix.com.co
 *Proyecto: TIX CONSULTORIOS
 *Nobre: Coam_agenda_consultorio
 *Tipo: controlador
 *Descripcion: Permite crear la agenda de los consultorios
 *Autor: Carlos Andrés Jaramillo Patiño <cajaramillo@tix.com.co>
 *Fecha de creación: 06 de abril de 2012
 *Última fecha modificación: 10 de enero de 2013
*/
class Coam_agenda_consultorio extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('coam/coam_model');
		$this->load->model('core/registro');	 		
	}
///////////////////////////////////////////////////////////////////
function index()
{
	redirect('coam/coam_agenda_consultorio/calendario');
}
///////////////////////////////////////////////////////////////////
function agendaConsultorio()
{
	$d = array();
	
	//----------------------------------------------------------
	$d['id_consultorio'] 	= $this->input->post('id_consultorio');
	//----------------------------------------------------------
	$d['consultorio'] = $this ->coam_model->obtenerConsultorio($d['id_consultorio']);
	//----------------------------------------------------------
	$prefs = array (
		'start_day'	=> 'monday',
		'month_type'=> 'long',
		'day_type'	=> 'long'
	);

$prefs['template'] = '{table_open}<table border="0" cellpadding="2" cellspacing="3" width="100%" class="calendario">{/table_open}
{heading_row_start}<tr>{/heading_row_start}
{heading_previous_cell}<td><a href="{previous_url}">&lt;&lt;</a></td>{/heading_previous_cell}
{heading_title_cell}<td colspan="{colspan}" class="mes"><strong>{heading}</strong>&nbsp;-&nbsp;'.$d['consultorio']['consultorio'].'</td>{/heading_title_cell}
{heading_next_cell}<td><a href="{next_url}">&gt;&gt;</a></td>{/heading_next_cell}
{heading_row_end}</tr>{/heading_row_end}
{week_row_start}<tr>{/week_row_start}
{week_day_cell}<td class="dia">{week_day}</td>{/week_day_cell}
{week_row_end}</tr>{/week_row_end}
{cal_row_start}<tr>{/cal_row_start}
{cal_cell_start}<td class="celda">{/cal_cell_start}
{cal_cell_content}<strong>{day}</strong><div class="contenido">{content}</div></strong>{/cal_cell_content}
{cal_cell_content_today}<strong>{day}<div class="hoy_contenido">{content}</div></strong>{/cal_cell_content_today}
{cal_cell_no_content}<strong>{day}</strong>{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="hoy_no_contenido">{day}</div>{/cal_cell_no_content_today}
{cal_cell_blank}&nbsp;{/cal_cell_blank}
{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}
{table_close}</table>{/table_close}';
$this->load->library('calendar', $prefs);
$this -> load -> view('coam/coam_calendario', $d);
}
///////////////////////////////////////////////////////////////////
function calendario()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_agenda', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function agenda_dia_crear($dia,$mes,$anno,$id_consultorio,$val='v')
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_agenda_consultorio/calendario');
	//----------------------------------------------------------
	$d['consultorio'] = $this ->coam_model->obtenerConsultorio($id_consultorio);
	$d['dia'] = $dia;
	$d['mes'] = $mes;
	$d['anno'] = $anno;
	$d['id_consultorio'] = $id_consultorio;
	$d['val'] = $val;
	$d['agenda'] = $this ->coam_model->obtener_agenda_dia($dia,$mes,$anno,$id_consultorio);
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_agenda_dia', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function agenda_dia_consultar($dia,$mes,$anno,$id_consultorio)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_agenda_consultorio/calendario');
	//----------------------------------------------------------
	$d['consultorio'] = $this ->coam_model->obtenerConsultorio($id_consultorio);
	$d['dia'] = $dia;
	$d['mes'] = $mes;
	$d['anno'] = $anno;
	$d['id_consultorio'] = $id_consultorio;
	$d['agenda'] = $this ->coam_model->obtener_agenda_dia($dia,$mes,$anno,$id_consultorio);
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_agenda_dia_consultar',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function agenda_dia_eliminar($dia,$mes,$anno,$id_consultorio,$id)
{
	$this->coam_model->eliminar_dispo($id);
	
	$this->registro->agregar($this->session->userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
		,'aplicacion',"Eliminada la asignación ".$id);
	//----------------------------------------------------
	$dt['mensaje']  = "La operación se realizo con exito!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_agenda_consultorio/agenda_dia_crear/$dia/$mes/$anno/$id_consultorio");
	$this->load->view('core/presentacionMensaje', $dt);
	return;		
}
///////////////////////////////////////////////////////////////////
function agregar_dispo()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_consultorio'] 	= $this->input->post('id_consultorio');
	//----------------------------------------------------------	
	$d['anno'] 	= $this->input->post('anno');
	$d['mes'] 	= $this->input->post('mes');
	$d['dia'] 	= $this->input->post('dia');
	$d['hora_inicio'] 	= $this->input->post('hora_inicio');
	$d['hora_fin'] 	= $this->input->post('hora_fin');
	$d['min_inicio'] 	= $this->input->post('min_inicio');
	$d['min_fin'] 	= $this->input->post('min_fin');
	$d['tiempo_consulta'] 	= $this->input->post('tiempo_consulta');
	$d['id_medico'] 	= $this->input->post('medico_ID');
	$val = $this->coam_model->validar_disponibilidadDB($d);
	if($val != 'f')
		$this->coam_model->agregar_dispoDB($d);
	redirect('coam/coam_agenda_consultorio/agenda_dia_crear/'.$d['dia'].'/'.$d['mes'].'/'.$d['anno'].'/'.$d['id_consultorio'].'/'.$val);
}
///////////////////////////////////////////////////////////////////
function obtener_medico($l)
{
	$l = preg_replace("/[^a-z0-9 ]/si","",$l);
	$this->load->database();
	$this->db->like('core_tercero.primer_nombre',$l);
	$this->db->or_like('core_tercero.segundo_nombre',$l);
	$this->db->or_like('core_tercero.primer_apellido',$l);
	$this->db->or_like('core_tercero.segundo_apellido',$l);
	$this->db->select("
	CONCAT(core_tercero.primer_nombre,' ',core_tercero.segundo_nombre,' ',core_tercero.primer_apellido,' ',  core_tercero.segundo_apellido) AS medico,core_medico.id_medico",FALSE);
  $this->db->from('core_tercero');
  $this->db->JOIN('core_medico','core_tercero.id_tercero = core_medico.id_tercero');
	$r = $this->db->get();
	$dat = $r -> result_array();
	foreach($dat as $d)
	{
		echo $d["id_medico"]."###".$d["medico"]."|";
	}
}
///////////////////////////////////////////////////////////////////
}