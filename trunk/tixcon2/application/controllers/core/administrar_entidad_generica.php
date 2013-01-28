<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Administrar_entidad_generica extends CI_Controller
{
	///////////////////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////////////////////

	public function __construct()
	{
		parent::__construct();

		$this -> load -> database();
		$this -> load -> model('core/Tiempo');
		$this -> load -> model('core/Registro');
		$this -> load -> helper('url');
		$this -> load -> helper('form');
	}
	
	///////////////////////////////////////////////////////////////////

	protected function _obtenerEspecificacion()
	{
		return array();
	}

	///////////////////////////////////////////////////////////////////

	public function index()
	{		
		$datos = array();
	
		// Especificaci�n
	
		$datos['spec'] = $this -> _obtenerEspecificacion();
	
		if (!isset($datos['spec']['items_por_pagina']))
			$datos['spec']['items_por_pagina'] = 15;
	
		// URL de petici�n AJAX

		$datos['url_controlador_accion'] = $this -> uri -> segment(1) . "/" . $this -> uri -> segment(2);
		$datos['url_peticion_ajax'] = base_url() . "index.php/" . $datos['url_controlador_accion'] . "/";
	
	
		// Cargar la vista
		
		//header('Content-Type: text/html; charset=utf-8');
		$dat['titulo'] = $datos['spec']['descripcion'];
		$this -> load -> view("core/core_inicio",$dat);
		$this -> load -> view("core/administrar_entidad_generica", $datos);	
		$this -> load -> view("core/core_fin");
	}
	
	///////////////////////////////////////////////////////////////////

	public function listar()
	{
		///////////////////////////////////////////////////////////////

		$request = file_get_contents('php://input');  // json={variable:"valor"}

		$data = str_replace('json=', '', urldecode($request));
		$data = str_replace("\n", '\\n', $data);

		$json = json_decode($data);

		$spec = $this -> _obtenerEspecificacion();
		//print_r($spec);
		///////////////////////////////////////////////////////////////

		$cant_items_pagina = (isset($spec['items_por_pagina'])) ? $spec['items_por_pagina'] : 15;

		$this -> db -> limit($cant_items_pagina, ($json -> pagina - 1) * $cant_items_pagina);
		$this -> db -> order_by($spec['campo_orden']);
		$query = $this -> db -> get($spec['tabla']);

		$result = array();

		if ($query != null)
			$result = $query -> result_array();

		$resultado = array();
		
		foreach($result as $row)
		{
			$r = 0;

			$fila_resultado = array();

			$llaves = array_keys($row);
			//print_r($spec);
			//die();
			foreach ($llaves as $llave)
			{
				//echo "debajo debe ir el valor print_r:<br>";
				//print_r($spec['campos'][$r]['tipo']);
				//echo "<br>";
				switch(strtoupper($spec['campos'][$r]['tipo']))
				{
					case 'ARREGLO':
						//print_r($row);
						//echo "<br>llave: $llave<br>";
						 //print_r($spec['campos'][$r]['opciones'][$row[$llave]]);
							$fila_resultado["campo_".$r] = $spec['campos'][$r]['opciones'][$row[$llave]];
							break;
							
					case 'CONSULTA':
							// Calcular el valor representado por el c�digo encontrado
					
							$this -> db -> where($spec['campos'][$r]['origen_codigo'], $row[$llave]);
							$this -> db -> select($spec['campos'][$r]['origen_valor']);
							$rr = $this -> db -> get($spec['campos'][$r]['origen_tabla']);
							$vv = $rr -> row_array();
							
							// Almacenar el c�digo encontrado (requerido para formar la llave 
							// primaria en el listado)
							
							$fila_resultado["campo_" . $r] = $row[$llave];
							
							// En caso de encontrarse una 'descripci�n' (valor) para ese c�digo
							// se almacena de manera alterna para ser presentado en el listado
							
							if(isset($vv[$spec['campos'][$r]['origen_valor']]))
								$fila_resultado["campo_" . $r . "_alt"] = $vv[$spec['campos'][$r]['origen_valor']];
							break;
							
					default:
							$fila_resultado["campo_" . $r] = $row[$llave];
							break;
				}

				// Corregir la presentaci�n de las entidades HTML que provienen de la
				// tabla de valores

				if (isset($fila_resultado["campo_" . $r]) == null)
					$fila_resultado["campo_" . $r] = "";
				
				if (isset($fila_resultado["campo_" . $r . "_alt"]) == null)
					$fila_resultado["campo_" . $r . "_alt"] = "";
				
				if (isset($fila_resultado["campo_" . $r]))
					//$fila_resultado["campo_" . $r] = htmlentities($fila_resultado["campo_" . $r]);
					$fila_resultado["campo_" . $r] = $fila_resultado["campo_" . $r];

				if (isset($fila_resultado["campo_" . $r . "_alt"]))
					//$fila_resultado["campo_" . $r . "_alt"] = htmlentities($fila_resultado["campo_" . $r . "_alt"]);
					$fila_resultado["campo_" . $r . "_alt"] = $fila_resultado["campo_" . $r . "_alt"];
				
				$r++;
			}
			
			$resultado[] = $fila_resultado;
		}

		$json = json_encode($resultado);

		//header('Content-Type: text/html; charset=iso-8859-1');
		echo $json;
		
		///////////////////////////////////////////////////////////////
	}
	
	///////////////////////////////////////////////////////////////////

	public function agregar()
	{
		///////////////////////////////////////////////////////////////
		
		$request = file_get_contents('php://input');  // json={variable:"valor"}
		$data = str_replace('json=', '', urldecode($request));
		
		$data = str_replace("\n", '\\n', $data);
		
		$json_data = json_decode($data);
		//print_r($json);
		//$json_data = $json -> data;
		
		$spec = $this -> _obtenerEspecificacion();
		
		$resultado = array();
		
		///////////////////////////////////////////////////////////////

		$cantidad_campos = count($spec['campos']);
		
		for($i=0; $i<$cantidad_campos; $i++)
		{
			$nombre_campo = $spec['campos'][$i]['campo_nombre'];
			$identificador_campo = "campo_{$i}";
			//$valor_campo  = utf8_decode($json_data -> $identificador_campo);
			$valor_campo  = $json_data -> $identificador_campo;

			switch(strtoupper($spec['campos'][$i]['tipo']))
			{
				case 'AUTONUMERICO':
								$valor_campo = null;
								break;

				case 'TEXTO':
								// Nada que cambiar por ahora, conservar el valor obtenido antes.
								break;
								
				case 'FECHA':
								$fecha = $valor_campo;
								$hora  = null;

								// Verificar si no se especific� un valor para el campo fecha,
								// en ese caso, asigna la fecha actual
								
								if (strlen(trim($fecha)) == 0)
								{
									$hoy_ymd = $this -> Tiempo -> obtenerDateActual();
									
									$hoy_partes = $this -> Tiempo -> separarFechaAMD($hoy_ymd, '-');
									
									$fecha = $hoy_partes['dia'] . '/' . $hoy_partes['mes'] . '/' . $hoy_partes['ano'];
									
									if(isset($spec['campos'][$i]['mostrar_hora']) && 
								       $spec['campos'][$i]['mostrar_hora'])
									{
										$fecha .= ' ' . $this -> Tiempo -> obtenerTimeActual();
									}
								}

								// Si el valor incluye a la hora, se separan los valores
								// de fecha y de hora
								
								if(isset($spec['campos'][$i]['mostrar_hora']) && 
								   $spec['campos'][$i]['mostrar_hora'])
								{
									$partes = explode(' ', $fecha);
									
									if (count($partes) == 0)
									{
										$fecha = $this -> Tiempo -> obtenerDateActual();
										$hora  = $this -> Tiempo -> obtenerTimeActual();
										
										$fecha = str_replace('-', '/', $fecha);
									}
									else
									{
										$fecha = $partes[0];
										$hora  = $partes[1];
									}
								}
								
								// Se separa la fecha que viene en formato yyyy/mm/dd
								
								$partes_fecha = $this -> Tiempo -> separarFechaDMA($fecha);
								
								// Se recompone la fecha en formato yyyy-mm-dd [hh:mm:ss]
								// para ser insertada en la base de datos
								
								$valor_campo = $partes_fecha['ano'] . "-" . $partes_fecha['mes'] . "-" . $partes_fecha['dia'];

								if($hora != null)
									$valor_campo .= " " . $hora;
						
								// Anular la restricci�n de longitud si esta existe
								
								if(isset($spec['campos'][$i]['longitud']))
									unset($spec['campos'][$i]['longitud']);
								break;

				case 'ENTERO':
								// Nada que cambiar por ahora, conservar el valor obtenido antes.
								break;
			}

			if (isset($spec['campos'][$i]['longitud']))
				$valor_campo = substr($valor_campo, 0, $spec['campos'][$i]['longitud']);

			// Aplicar una funci�n al valor del campo si esta es solicitada, la funci�n debe
			// recibir a la cadena como �nico par�metro
			
			if(isset($spec['campos'][$i]['funcion']) && function_exists($spec['campos'][$i]['funcion']))
				$valor_campo = call_user_func($spec['campos'][$i]['funcion'], $valor_campo);

			$this -> db -> set ($nombre_campo, $valor_campo);
		}

		$this -> db -> insert($spec['tabla']);
		
		$no_error = $this -> db -> call_function('errno', $this -> db -> conn_id);
		
		$resultado['exito']       = ($no_error == 0) ? true : false;
		$resultado['errno']       = $no_error;
		$resultado['descripcion'] = $this -> db -> call_function('error', $this -> db -> conn_id);
		
		///////////////////////////////////////////////////////////////

		$ladescripcion = ($no_error == 0) ? 'exitosa.' : 'fallida (' . $resultado['descripcion'] . ').';

		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'), 
		                             'core', 
									 get_class($this), 
									 __FUNCTION__, 
									 'aplicacion', 
	                                 "La acci�n de agregar el registro fue {$ladescripcion}");
		
		///////////////////////////////////////////////////////////////

		$json = json_encode($resultado);
		//header('Content-Type: text/html; charset=iso-8859-1');
		echo $json;

		///////////////////////////////////////////////////////////////
	}

	///////////////////////////////////////////////////////////////////

	public function remover()
	{
		///////////////////////////////////////////////////////////////
		
		$request = file_get_contents('php://input');  // json={variable:"valor"}
		$data = str_replace('json=', '', urldecode($request));
		
		$data = str_replace("\n", '\\n', $data);
		
		$json_data = json_decode($data);
		//$json_data = $json -> data;
		
		$spec = $this -> _obtenerEspecificacion();
		
		$resultado = array();
		
		///////////////////////////////////////////////////////////////

		$removidos = 0;

		// Especificar cuales campos representan a la llave primaria
		// del registro
		
		$campos_nombre_pk = array();
		
		foreach($spec['pk'] as $pk_indice)
		{
			$campos_nombre_pk[] = $spec['campos'][$pk_indice]['campo_nombre'];
		}

		// Recorrer cada una de las filas que se van a remover

		foreach($json_data as $fila)
		{
			$i=0;
			// Por cada una de las filas a remover, obtener
			// la llave primaria de cada una de estas
			
			//$llaves = explode("||", $fila);		

			//for($i=0; $i<count($llaves); $i++)
			//{
				// $resultado['msg'] = $campos_nombre_pk[$i] . " = " . $llaves[$i];
				//$this -> db -> where($campos_nombre_pk[$i], $llaves[$i]);
				$this -> db -> where($campos_nombre_pk[$i], $fila);
			//}
			
			//$this -> db -> delete($spec['tabla']);
			$this -> db -> delete($spec['tabla']);
			
			$removidos ++;
			$i++;
		}
		$resultado['removidos']   = $removidos;
		$resultado['solicitados'] = count($json_data);
		
		///////////////////////////////////////////////////////////////

		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'), 
		                             'core', 
									 get_class($this), 
									 __FUNCTION__, 
									 'aplicacion', 
	                                 "Se removieron {$resultado['removidos']} elementos de los {$resultado['solicitados']} solicitados.");
		
		///////////////////////////////////////////////////////////////

		$json = json_encode($resultado);
		echo $json;

		///////////////////////////////////////////////////////////////
	}

	///////////////////////////////////////////////////////////////////

	public function mostrar_registro()
	{
		///////////////////////////////////////////////////////////////
		
		$request = file_get_contents('php://input');  // json={variable:"valor"}
		$data = str_replace('json=', '', urldecode($request));
		
		
		$data = str_replace("\n", '\\n', $data);
		
		$json_data = json_decode($data);
		//$json_data = $json -> data;
		
		$spec = $this -> _obtenerEspecificacion();
		
		$resultado = array();

		///////////////////////////////////////////////////////////////

		// Especificar cuales campos representan a la llave primaria
		// del registro
		
		$campos_nombre_pk = array();
		
		foreach($spec['pk'] as $pk_indice)
		{
			$campos_nombre_pk[] = $spec['campos'][$pk_indice]['campo_nombre'];
		}

		// Determinar los valores que corresponden a cada uno de los campos
		// de la llave primaria y realizar la consulta para obtener el
		// registro asociado

		$pk = $json_data;
		
		$llaves = explode("||", $pk);		

		for($i=0; $i<count($llaves); $i++)
		{
			$this -> db -> where($campos_nombre_pk[$i], $llaves[$i]);
		}
			
		$result = $this -> db -> get($spec['tabla']);
		
		$datos  = $result -> row_array();
		$llaves = array_keys($datos);
		
		// Convertir la informaci�n resultante a un arreglo con campos campo_<i>
		// para ser enviado a la p�gina solicitante en formato JSON.
		
		$indice = 0;

		foreach($llaves as $llave)
		{
			$valor_campo = $datos[$llave];

			switch(strtoupper($spec['campos'][$indice]['tipo']))
			{
				case 'FECHA':
							$fecha = $valor_campo;
							$hora  = null;
							
							if(isset($spec['campos'][$indice]['mostrar_hora']) && 
							   $spec['campos'][$indice]['mostrar_hora'])
							{
								$partes = explode(' ', $valor_campo);
									
								$fecha = $partes[0];
								$hora  = $partes[1];
							}

							// Se separa la fecha que viene en formato yyyy-mm-dd
								
							$partes_fecha = explode('-', $fecha);

							// Se recompone la fecha en formato dd/mm/yyyy [hh:mm:ss]
							// para ser mostrada al usuario
								
							$valor_campo = $partes_fecha[2] . "/" . $partes_fecha[1] . "/" . $partes_fecha[0];

							if($hora != null)
								$valor_campo .= " " . $hora;
							break;
			}

			$resultado['campo_' . $indice] = utf8_encode($valor_campo);
			$resultado['campo_' . $indice] = $valor_campo;

			$indice ++;
		}

		///////////////////////////////////////////////////////////////

		$json = json_encode($resultado);

		echo $json;

		///////////////////////////////////////////////////////////////
	}
	
	///////////////////////////////////////////////////////////////////

	public function editar()
	{
		///////////////////////////////////////////////////////////////

		$request = file_get_contents('php://input');  // json={variable:"valor"}
		
		$data = str_replace('json=', '', urldecode($request));

		$data = str_replace("\n", '\\n', $data);

		$json = json_decode($data);

		$spec = $this -> _obtenerEspecificacion();
		
		$resultado = array();
		
		///////////////////////////////////////////////////////////////

		$actualizados = 0;
		
		// Especificar cuales campos representan a la llave primaria
		// del registro
		
		$campos_nombre_pk = array();
		
		foreach($spec['pk'] as $pk_indice)
		{
			$campos_nombre_pk[] = $spec['campos'][$pk_indice]['campo_nombre'];
		}
// Establecer la condici�n espec�fica de la actualizaci�n seg�n
		// los campos de la llave primaria del registro y la informaci�n
		// suministrada por el formulario

		$valores = array();

		for($i=0; $i<count($spec['campos']); $i++)
		{
			$campo = $spec['campos'][$i];
			
			// Si el campo actual es parte de la llave primaria ...
			
			$identificador_campo      = "campo_{$i}";
			$identificador_campo_orig = "campo_{$i}_orig";
			

			if (in_array($i, $spec['pk']))
			{
				$this -> db -> where ($campo['campo_nombre'], utf8_decode($json -> $identificador_campo_orig));
			}
/*
 * 	Con esta versi�n, la llave primaria no se actualizaba
 * 
			else	// Si el campo actual NO es parte de la llave primaria
			{
				$valores[$campo['campo_nombre']] = $json -> $identificador_campo;
			}
*/

			//$valores[$campo['campo_nombre']] = utf8_decode($json -> $identificador_campo);
			$valores[$campo['campo_nombre']] = $json -> $identificador_campo;

			switch(strtoupper($campo['tipo']))
			{
				case 'AUTONUMERICO':
								// Nada que cambiar por ahora, conservar el valor obtenido antes.
								break;

				case 'TEXTO':
								// Nada que cambiar por ahora, conservar el valor obtenido antes.
								break;
								
				case 'FECHA':
								$fecha = $valores[$campo['campo_nombre']];
								$hora  = null;

								// Verificar si no se especific� un valor para el campo fecha,
								// en ese caso, asigna la fecha actual
								
								if (strlen(trim($fecha)) == 0)
								{
									$hoy_ymd = $this -> Tiempo -> obtenerDateActual();
									
									$hoy_partes = $this -> Tiempo -> separarFechaAMD($hoy_ymd, '-');
									
									$fecha = $hoy_partes['dia'] . '/' . $hoy_partes['mes'] . '/' . $hoy_partes['ano'];
									
									if(isset($spec['campos'][$i]['mostrar_hora']) && 
								       $spec['campos'][$i]['mostrar_hora'])
									{
										$fecha .= ' ' . $this -> Tiempo -> obtenerTimeActual();
									}
								}

								// Si el valor incluye a la hora, se separan los valores
								// de fecha y de hora
								
								if(isset($campo['mostrar_hora']) && 
								   $campo['mostrar_hora'])
								{
									$partes = explode(' ', $fecha);
									
									if (count($partes) == 0)
									{
										$fecha = $this -> Tiempo -> obtenerDateActual();
										$hora  = $this -> Tiempo -> obtenerTimeActual();
										
										$fecha = str_replace('-', '/', $fecha);
									}
									else
									{
										$fecha = $partes[0];
										$hora  = $partes[1];
									}
								}
								
								// Se separa la fecha que viene en formato dd/mm/yyyy
								
								$partes_fecha = $this -> Tiempo -> separarFechaDMA($fecha);
								
								// Se recompone la fecha en formato yyyy-mm-dd [hh:mm:ss]
								// para ser insertada en la base de datos
								
								$valores[$campo['campo_nombre']] = $partes_fecha['ano'] . "-" . $partes_fecha['mes'] . "-" . $partes_fecha['dia'];

								if($hora != null)
									$valores[$campo['campo_nombre']] .= " " . $hora;
								break;

				case 'ENTERO':
								// Nada que cambiar por ahora, conservar el valor obtenido antes.
								break;
			}

			// Aplicar una funci�n al valor del campo si esta es solicitada, la funci�n debe
			// recibir a la cadena como �nico par�metro
			
			if(isset($campo['funcion']) && function_exists($campo['funcion']))
				$valores[$campo['campo_nombre']] = call_user_func($campo['funcion'], $valores[$campo['campo_nombre']]);
		}

		$this -> db -> update($spec['tabla'], $valores);
		
		$actualizados = $this -> db -> affected_rows();
		
		$no_error = $this -> db -> call_function('errno', $this -> db -> conn_id);
		
		$resultado['exito']        = ($no_error == 0) ? true : false;
		$resultado['errno']        = $no_error;
		$resultado['descripcion']  = $this -> db -> call_function('error', $this -> db -> conn_id);
		$resultado['actualizados'] = $actualizados;

		///////////////////////////////////////////////////////////////

		$ladescripcion = ($no_error == 0) ? 'exitosa.' : 'fallida (' . $resultado['descripcion'] . ').';

		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'), 
		                             'core', 
									 get_class($this), 
									 __FUNCTION__, 
									 'aplicacion', 
	                                 "La acci�n de editar el registro fue {$ladescripcion}");
		
		///////////////////////////////////////////////////////////////
		
		$json = json_encode($resultado);
		//header('Content-Type: text/html; charset=iso-8859-1');
		echo $json;

		///////////////////////////////////////////////////////////////
	}

	///////////////////////////////////////////////////////////////////
}

?>
