<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Tiempo extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function obtenerDateTimeActual()
	{
		$this->load->helper('date');
		
		// Datetime: DATETIME is YYYY-MM-DD HH:MM:SS
		
		return mdate('%Y-%m-%d %H:%i:%s', time());
	}
	
	public function obtenerDateActual()
	{
		$this->load->helper('date');
		
		// Datetime: DATE is YYYY-MM-DD
		
		return mdate('%Y-%m-%d', time());
	}

	public function obtenerTimeActual()
	{
		$this->load->helper('date');
		
		// Datetime: TIME is HH:MM:SS
		
		return mdate('%H:%i:%s', time());
	}
	
	function obtenerMesesSemestre($semestre)
	{
		if (strtolower($semestre) === "a" || $semestre === 0)
		{
			return array(0 => 'enero',
                         1 => 'febrero',
                         2 => 'marzo',
                         3 => 'abril',
                         4 => 'mayo',
                         5 => 'junio');
		}
		
		if (strtolower($semestre) === "b" || $semestre === 1)
		{
			return array(0 => 'julio',
                         1 => 'agosto',
                         2 => 'septiembre',
                         3 => 'octubre',
                         4 => 'noviembre',
                         5 => 'diciembre');
		}
		
		return null;
	}
	
	function obtenerMesesAno()
	{ 
			return array(0  => 'enero',
                         1  => 'febrero',
                         2  => 'marzo',
                         3  => 'abril',
                         4  => 'mayo',
                         5  => 'junio',
						 6  => 'julio',
                         7  => 'agosto',
                         8  => 'septiembre',
                         9  => 'octubre',
                         10 => 'noviembre',
                         11 => 'diciembre');
	}
	
	function calcularSemestreSiguiente($ano, $semestre)
	{	
		if ($semestre === 0)
			$semestre = 'a';

		if ($semestre === 1)
			$semestre = 'b';
				
		$semestre = strtolower($semestre);
	
		if ($semestre == 'a')
			return array('ano' => $ano, 'semestre' => 'b');
			
		return array('ano' => ($ano + 1), 'semestre' => 'a');
	}
	
	function calcularSemestresSiguientes($ano, $semestre, $cuantos)
	{
		for ($i=0; $i<$cuantos; $i++)
		{
			$tmp = $this -> calcularSemestreSiguiente($ano, $semestre);
			
			$ano      = $tmp['ano'];
			$semestre = $tmp['semestre'];
		}
		
		return array('ano' => $ano, 'semestre' => $semestre);
	}
	
	function separarFechaDMA($fecha, $separador='/')
	{
		$resultado = array();
		
		$partes = explode($separador, $fecha);
		
		$resultado['ano'] = $partes[2];
		$resultado['mes'] = $partes[1];
		$resultado['dia'] = $partes[0];
		
		return $resultado;
	}

	function separarFechaAMD($fecha, $separador='-')
	{
		$resultado = array();
		
		$partes = explode($separador, $fecha);
		
		$resultado['ano'] = $partes[0];
		$resultado['mes'] = $partes[1];
		$resultado['dia'] = $partes[2];
		
		return $resultado;
	}
}

?>