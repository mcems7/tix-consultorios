<?php
error_reporting(0);
class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
		$this->load->database();
	}
	
	function index()
	{
		
	$this->load->view('core/core_inicio');
   
	$this -> load -> view('informes/informetriage');
	
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
		
	$this->tiempo('12','16','1',$fecha_ini,$fecha_fin);
		$this->tiempo('12','16','2',$fecha_ini,$fecha_fin);
		$this->tiempo('12','16','3',$fecha_ini,$fecha_fin);
		$this->tiempoTotal('12','16',$fecha_ini,$fecha_fin);
		$this->tiempo('13','17','1',$fecha_ini,$fecha_fin);
		$this->tiempo('13','17','2',$fecha_ini,$fecha_fin);
		$this->tiempo('13','17','3',$fecha_ini,$fecha_fin);
		$this->tiempoTotal('13','17',$fecha_ini,$fecha_fin);
		$this->tiempo('14','19','1',$fecha_ini,$fecha_fin);
		$this->tiempo('14','19','2',$fecha_ini,$fecha_fin);
		$this->tiempo('14','19','3',$fecha_ini,$fecha_fin);
		$this->tiempoTotal('14','19',$fecha_ini,$fecha_fin);
		
	$sql = "select ct.`razon_social` Entidad,cp.`genero` Sexo,sum(cp.`genero`) Cantidad
from urg_atencion ua
inner join `core_paciente` cp on ua.`id_paciente`= cp.`id_paciente`
inner join `core_eapb` ce on cp.`id_entidad`=ce.`id_entidad`
inner join `core_tercero` ct on ct.`id_tercero`=ce.`id_tercero`
where ua.`consulta`='SI' and ua.`fecha_ingreso` between '{$fecha_ini}' and '{$fecha_fin}'

group by cp.`genero`, ct.`razon_social`
order by ct.`razon_social`,cp.`genero`";
	
	$res = $this->db->query($sql);
		
		$row['resultado'] = $res->result_array();
		//print_r($row);
		
		$this -> load -> view('informes/resultados', $row);

		
		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */