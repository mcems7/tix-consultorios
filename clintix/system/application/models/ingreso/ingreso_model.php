<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Enfermeria_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades de enfermeria en el modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 04 de marzo de 2011
 
*/
class Ingreso_model extends Model 
{
////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
///////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
	function crearNotaDb($d)
	{
		$insert = array(
			'fecha' => $d['fecha'],
			'id_especialista' => $d['id_especialista'],
			'id_especialidad' => $d['id_especialidad'],
			'hora_llegada' => $d['hora_llegada'],
			'hora_agendada' => $d['hora_agendada'],
			'id_usuario' => $this -> session -> userdata('id_usuario'),
			);
		$this->db->insert('cex_ingreso_especialistas',$insert);
		//----------------------------------------------------
	}

	// se verifica si han sido ingresados gases arteriales o signos vitales anteriormente para el horario establecido
	function VerificarExistencia($fecha,$id_especialista)
	{
	$this->db->from('cex_ingreso_especialistas');
	$this->db->where('fecha',$fecha);
	$this->db->where('id_especialista',$id_especialista);
	$result = $this->db->get();
    $num = $result->num_rows();
			return $num;
		
	}	
	
/////////////////////////////fin///////////////////////////////////////////////





	
}


