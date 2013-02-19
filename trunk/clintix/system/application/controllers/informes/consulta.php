<?php
//error_reporting(0);
class Consulta extends Controller {

	function Consulta()
	{
		parent::Controller();	
		$this->load->database();
	}
	
	function index()
	{
		
	$this->load->view('core/core_inicio');
   
	$this -> load -> view('informes/informeconsulta');
	
    $this->load->view('core/core_fin');
		
	}
	
	function tiempo($id_servicio1,$id_servicio2,$class,$fecha_ini,$fecha_fin)
	{
		$sql = "SELECT 
  urg_triage.fecha_fin_triage As fecha1,
  urg_consulta.fecha_ini_consulta As fecha2
FROM
  urg_atencion
  JOIN urg_consulta ON (urg_atencion.id_atencion = urg_consulta.id_atencion)
  JOIN urg_triage ON (urg_atencion.id_atencion = urg_triage.id_atencion)
WHERE
  urg_atencion.fecha_ingreso BETWEEN '{$fecha_ini} 00:00:00'  AND '{$fecha_fin} 23:59:59' AND 
  urg_atencion.clasificacion = '{$class}' AND (urg_atencion.id_servicio ='{$id_servicio1}' OR urg_atencion.id_servicio ='{$id_servicio2}')";
		
		$res = $this->db->query($sql);
		
		$row = $res->result_array();
		
		foreach($row as $d)
		{
		
		$fecha_ingreso = explode(" ", $d['fecha1']);
		list($anno, $mes, $dia) = explode( '-', $fecha_ingreso[0] );
		list($hora, $min, $seg)= explode( ':', $fecha_ingreso[1] );
		$fecha_ingreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
		
		$fecha_egreso = explode(" ", $d['fecha2']);
		list($anno, $mes, $dia) = explode( '-', $fecha_egreso[0] );
		list($hora, $min, $seg)= explode( ':', $fecha_egreso[1] );
		$fecha_egreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
		
		$segundos[] = $fecha_egreso_time - $fecha_ingreso_time;
		}
		
		$n = count($segundos);
		$suma = 0;
		foreach($segundos as $dat)
		{
			$suma = $dat+$suma;	
		}
		
			if ($id_servicio1==12)
		{
			$nombre="Adulto";
		}
		if ($id_servicio1==13)
		{
			$nombre="Pediatria";
		}
			if ($id_servicio1==14)
		{
			$nombre="Ginecologia";
		}
		
		
		echo 'Servicio: ',$nombre , " Tiempo: ",($suma/$n)/60," Numero: ",$res->num_rows(), ' Clasificacion: ',$class,'<br>';
	
	}
	
	function tiempoTotal($id_servicio1,$id_servicio2,$fecha_ini,$fecha_fin)
	{
		$sql = "SELECT 
  urg_triage.fecha_fin_triage As fecha1,
  urg_consulta.fecha_ini_consulta As fecha2
FROM
  urg_atencion
  INNER JOIN urg_consulta ON (urg_atencion.id_atencion = urg_consulta.id_atencion)
  INNER JOIN urg_triage ON (urg_atencion.id_atencion = urg_triage.id_atencion)
WHERE
  urg_atencion.fecha_ingreso BETWEEN '{$fecha_ini} 00:00:00' AND '{$fecha_fin} 23:59:59' AND 
  urg_atencion.clasificacion <> '0' AND ( urg_atencion.id_servicio ='{$id_servicio1}' OR urg_atencion.id_servicio ='{$id_servicio2}')";
		
		$res = $this->db->query($sql);
		
		$row = $res->result_array();
		
		foreach($row as $d)
		{
		
		$fecha_ingreso = explode(" ", $d['fecha1']);
		list($anno, $mes, $dia) = explode( '-', $fecha_ingreso[0] );
		list($hora, $min, $seg)= explode( ':', $fecha_ingreso[1] );
		$fecha_ingreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
		
		$fecha_egreso = explode(" ", $d['fecha2']);
		list($anno, $mes, $dia) = explode( '-', $fecha_egreso[0] );
		list($hora, $min, $seg)= explode( ':', $fecha_egreso[1] );
		$fecha_egreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
		
		$segundos[] = $fecha_egreso_time - $fecha_ingreso_time;
		}
		
		$n = count($segundos);
		$suma = 0;
		foreach($segundos as $dat)
		{
			$suma = $dat+$suma;	
		}
		if ($id_servicio1==12)
		{
			$nombre="Adulto";
		}
		if ($id_servicio1==13)
		{
			$nombre="Pediatria";
		}
			if ($id_servicio1==14)
		{
			$nombre="Ginecologia";
		}
		echo 'Servicio: ',$nombre , " Tiempo: ",($suma/$n)/60," Numero: ",$res->num_rows(),'<br>';
	
	}
	
	
	function informe()
	{
		$fecha_ini= $this->input->post('fecha_agenda');
		$fecha_fin = $this->input->post('fecha_final');
	
		$row['informe']=$this -> estado($fecha_ini,$fecha_fin);
	
		

		
		$this -> load -> view('informes/consultaresultados', $row);

		
		
	}
	
	function estado($fecha_ini,$fecha_fin)
	{
		$sql = "select count(cr.`estado`) total, cr.`estado`estado, ce.`descripcion` 
	  from `cex_cita_remisiones` cr 
	  join  `core_especialidad` ce on  cr.`id_especialidad` = ce.`id_especialidad`
	  where cr.`fecha_solicitud` between '{$fecha_ini}' and '{$fecha_fin}'
	  group by ce.`descripcion`,cr.`estado`";
	
	$res = $this->db->query($sql);
		
		return $res->result_array();
		
		
		
	}
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */