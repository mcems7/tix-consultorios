<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Coam_agenda_consultorio
 *Tipo: controlador
 *Descripcion: Permite crear la agenda de los consultorios
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 19 de abril de 2012
*/
class Coam_agenda_consultorio extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('coam/coam_model');	 		
	}
///////////////////////////////////////////////////////////////////
function index()
{
	redirect('coam/coam_agenda_consultorio/calendario');
}

function calendario()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$prefs = array (
'start_day' => 'moonday',
'month_type' => 'long',
'day_type' => 'long'
);

$prefs['template'] = '{table_open}<table border="1" cellpadding="0" cellspacing="0" class="interna">{/table_open}
{heading_row_start}<tr>{/heading_row_start}
{heading_previous_cell}<td><a href="{previous_url}">&lt;&lt;</a></td>{/heading_previous_cell}
{heading_title_cell}<td colspan="{colspan}" style="text-align:center; font-weight:bold"><strong>{heading}</strong></td>{/heading_title_cell}
{heading_next_cell}<td><a href="{next_url}">&gt;&gt;</a></td>{/heading_next_cell}
{heading_row_end}</tr>{/heading_row_end}
{week_row_start}<tr>{/week_row_start}
{week_day_cell}<td class="dia">{week_day}</td>{/week_day_cell}
{week_row_end}</tr>{/week_row_end}
{cal_row_start}<tr>{/cal_row_start}
{cal_cell_start}<td>{/cal_cell_start}
{cal_cell_content}<strong>{day}</strong><div class="contenido">{content}</div>{/cal_cell_content}
{cal_cell_content_today}<div class="hoy_contenido"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
{cal_cell_no_content}<strong>{day}</strong>{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
{cal_cell_blank}&nbsp;{/cal_cell_blank}
{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}
{table_close}</table>{/table_close}';
$this->load->library('calendar', $prefs);

	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_agenda', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}

}