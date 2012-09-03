<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
		$this->load->database();
	}
	
	function index()
	{
		$this->tiempo('12','16','1');
		$this->tiempo('12','16','2');
		$this->tiempo('12','16','3');
		$this->tiempoTotal('12','16');
		$this->tiempo('13','17','1');
		$this->tiempo('13','17','2');
		$this->tiempo('13','17','3');
		$this->tiempoTotal('13','17');
		$this->tiempo('14','19','1');
		$this->tiempo('14','19','2');
		$this->tiempo('14','19','3');
		$this->tiempoTotal('14','19');
		
	}
	
	function tiempo($id_servicio1,$id_servicio2,$class)
	{
		$sql = "SELECT 
  urg_triage.fecha_fin_triage As fecha1,
  urg_consulta.fecha_ini_consulta As fecha2
FROM
  urg_atencion
  JOIN urg_consulta ON (urg_atencion.id_atencion = urg_consulta.id_atencion)
  JOIN urg_triage ON (urg_atencion.id_atencion = urg_triage.id_atencion)
WHERE
  urg_atencion.fecha_ingreso BETWEEN '2011-08-01 00:00:00' AND '2011-08-31 23:59:59' AND 
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
		
		echo 'Servicio: ',$id_servicio1 , " Tiempo: ",($suma/$n)/60," Numero: ",$res->num_rows(), ' Clasificasion: ',$class,'<br>';
	
	}
	
	function tiempoTotal($id_servicio1,$id_servicio2)
	{
		$sql = "SELECT 
  urg_triage.fecha_fin_triage As fecha1,
  urg_consulta.fecha_ini_consulta As fecha2
FROM
  urg_atencion
  INNER JOIN urg_consulta ON (urg_atencion.id_atencion = urg_consulta.id_atencion)
  INNER JOIN urg_triage ON (urg_atencion.id_atencion = urg_triage.id_atencion)
WHERE
  urg_atencion.fecha_ingreso BETWEEN '2011-08-01 00:00:00' AND '2011-08-31 23:59:59' AND 
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
		
		echo 'Servicio: ',$id_servicio1 , " Tiempo: ",($suma/$n)/60," Numero: ",$res->num_rows(),'<br>';
	
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */