<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Factura
 *Tipo: controlador
 *Descripcion: Permite gestionar las facturas de la clinica.
 *Autor: Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
 *Fecha de creación: 6 de marzo de 2012
*/
class Consultar_facturas extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/medico_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('fac/factura_model');
		$this -> load -> model('core/Registro'); 
		
		$this -> load -> model('coam/coam_model');
		$this->load->library('session');
	}
///////////////////////////////////////////////////////////////////
/*
* Listado salas de observación
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120307
* @version		20120307
*/		
	function index()
	{
		
		//print_r($_SERVER);
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');

		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('fac/fac_buscarFacturas', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	

	
	
	///////////////////////////////////////////////////////////////////
/* Guardar factura
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120307
* @version		20120307
*/
	function factura_()
	{
		
		
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 		= $this->input->post('id_atencion');
		$d['id_medico'] 		= $this->input->post('id_medico');
		$d['fecha'] 		= $this->input->post('fecha');
		$d['medicamento'] 	= $this->input->post('medicamento');
		$d['insumo'] 	= $this->input->post('insumo');
		$d['ordenCups'] 	= $this->input->post('ordenCups');
		$d['ordenProcedimientoUvr'] 	= $this->input->post('ordenProcedimientoUvr');
		$d['ordenProcedimiento'] 	= $this->input->post('ordenProcedimiento');
		$d['UvrCirujano'] 	= $this->input->post('ValorUvrCirujano');
		$d['UvrAnesteciologo'] 	= $this->input->post('ValorUvrAnesteciologo');
		$d['UvrAyudante'] 	= $this->input->post('ValorUvrAyudante');
		$d['UvrSala'] 	= $this->input->post('ValorUvrSala');
		$d['UvrMateriales'] 	= $this->input->post('ValorUvrMateriales');
		$d['PagadorProcedimientoUvr'] 	= $this->input->post('PagadorProcedimientoUvr');
		$d['PagadorProcedimiento'] 	= $this->input->post('PagadorProcedimiento');
		$d['id_contrato'] 	= $this->input->post('id_contrato');
		

		
		
	
		
		/////////////////////////
		
		 if($d['PagadorProcedimientoUvr']!=null)
	   {
			foreach($d['PagadorProcedimientoUvr'] as $i)
			{
				$d['Pagador'][]= $i;
			}
	   }
	 if($d['PagadorProcedimiento']!=null)
	   {
			foreach($d['PagadorProcedimiento'] as $i)
			{
				$d['Pagador'][]= $i;
			}
	   }
	   
		
		
		$lista=array('-1');
	  //agrupamos para saber la cantidad de facturas que vamos a crear
      foreach($d['Pagador'] as $i)
	  {
		  
		  $factura = $i;
		   if (in_array($i, $lista))
		    {
	            
	        }else
			  {
	            $group[] =$factura;
					
				$lista[]=$i;	
					
              };
         
          
      }
		
		$plantillabase = $this->input->post('plantilla');
		//facturas por realizar
		$cantidadfacturas=count($group);
		//print_r($d['Pagador']);
		
				
		// realizaremos un foreach para grabar cada factura con su determinado contrato.
  foreach($group as $id_contrato_buscar)
	{
		
		$d['id_orden_procedimientouvr']=null;
		$d['id_orden_procedimiento']=null;
		
		//  generamos el id del contrato al cual se asignara a la factura
		if($id_contrato_buscar==0)
		{
			$d['contrato']=$d['id_contrato'];
			
		}else{
			$d['contrato']=$id_contrato_buscar; 
			 }
		
		
		
	if(count($d['ordenProcedimientoUvr']) > 0 && strlen($d['ordenProcedimientoUvr'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenProcedimientoUvr']);$i++)
			{
				$d['ValorUvrAyudante'][$i]  =0;
				$d['ValorUvrCirujano'][$i]  = 0;	
				$d['ValorUvrAnesteciologo'][$i]  = 0;
				$d['ValorUvrSala'][$i]= 0;
				$d['ValorUvrMateriales'][$i]= 0;
				//capturamos el id de la orden 
				$id_orden = $d['ordenProcedimientoUvr'][$i];
				// capturamos un id contrato con el id_orden en la ubicacion de pagador
				$id_contrato=$d['PagadorProcedimientoUvr'][$id_orden];
				
				
				if($id_contrato == $id_contrato_buscar)
				{

				// si el id_contrato es diferente de cero quiere decir que no es el contrato base con el cual se registro ...
				// el usuario de lo contrario se toma como el contrato base
					if($id_contrato!=0)
					{
							$plantilla = $this->factura_model->obtenerPlantilla($id_contrato);				
					}else
						{
							$plantilla=$plantillabase;
						}
						
					  $d['valcups'][$i] = $this->factura_model->obtenerCupProcedimiento($d['ordenProcedimientoUvr'][$i]);
					  $uvrplantilla =$this->factura_model->obtenerValorUnidadPlantilla($d['valcups'][$i]['cups'],$plantilla);
					  
					  $porcentageplantilla =$this->factura_model->valorvariacionplantilla($plantilla);
					  $variacionplantilla =$this->factura_model->obtenervariacion($plantilla);
					
				
					  $d['ordenProcedimientoUvrCantidad'][$i]= $d['valcups'][$i]['cantidadCups'];
					  $uvr = $this -> factura_model -> obtenerUvr($d['valcups'][$i]['cups']);
					  $uvrcirujano = $this -> factura_model -> obtenerValorUvr('1');
					  $uvranesteciologo = $this -> factura_model -> obtenerValorUvr('2');
					  $uvrayudante = $this -> factura_model -> obtenerValorUvr('3');
					  $uvrsala = $this -> factura_model -> obtenerValorSala($uvr);
					  $uvrmateriales = $this -> factura_model -> obtenerValorMateriales($uvr);
			  
						
							
							
					if(count($d['UvrCirujano']) > 0 && strlen($d['UvrCirujano'][0]) > 0)
					{
						for($e=0;$e<count($d['UvrCirujano']);$e++)
						{
							if($d['UvrCirujano'][$e]==$id_orden)
							   {
								   $valor = $uvrcirujano * $uvr ;
								  
								   $porciento = $this->porcentaje($valor,$porcentageplantilla,0);
								 
							   $d['ValorUvrCirujano'][$i]  = $valor + $porciento ;	
							   }
						}
						
						
					}
		
			
					if(count($d['UvrAnesteciologo']) > 0 && strlen($d['UvrAnesteciologo'][0]) > 0)
					{
						for($e=0;$e<count($d['UvrAnesteciologo']);$e++)
						{
							if($d['UvrAnesteciologo'][$e]==$id_orden)
							   {
								    $valor = $uvranesteciologo  * $uvr ;
								  
								   $porciento = $this->porcentaje($valor,$porcentageplantilla,0);
							   $d['ValorUvrAnesteciologo'][$i]  = $valor + $porciento ;	
							   }
						}
						
						
					}
						
					
					if(count($d['UvrAyudante']) > 0 && strlen($d['UvrAyudante'][0]) > 0)
					{
						for($e=0;$e<count($d['UvrAyudante']);$e++)
						{
							if($d['UvrAyudante'][$e]==$id_orden)
							   {
								    $valor = $uvrayudante  * $uvr ;
								  
								   $porciento = $this->porcentaje($valor,$porcentageplantilla,0);
							  $d['ValorUvrAyudante'][$i]  = $valor + $porciento ;	
							   }
						}
						
						
					}		
					
					
					if(count($d['UvrSala']) > 0 && strlen($d['UvrSala'][0]) > 0)
					{
						for($e=0;$e<count($d['UvrSala']);$e++)
						{
							if($d['UvrSala'][$e]==$id_orden)
							   {
								 $valor = $uvrsala ;
								  
								   $porciento = $this->porcentaje($valor,$porcentageplantilla,0);  
							  $d['ValorUvrSala'][$i]  =  $valor + $porciento ;		
							 
							   }
						}
						
						
					}
					
					if(count($d['UvrMateriales']) > 0 && strlen($d['UvrMateriales'][0]) > 0)
					{
						for($e=0;$e<count($d['UvrMateriales']);$e++)
						{
							if($d['UvrMateriales'][$e]==$id_orden)
							   {
								   $valor = $uvrmateriales;
								   $porciento = $this->porcentaje($valor,$porcentageplantilla,0);  
							  $d['ValorUvrMateriales'][$i]  =  $valor + $porciento ;	
							   }
						}
						
					
					}
					
							
							
							// capturamos el valor del procedimiento 
							$d['ordenProcedimientoUvrValorU'][$i]= $d['ValorUvrAyudante'][$i] + $d['ValorUvrAnesteciologo'][$i] +$d['ValorUvrCirujano'][$i]+$d['ValorUvrMateriales'][$i]+$d['ValorUvrSala'][$i];
							// capturamos el valor total 
							$d['ordenProcedimientoUvrTotal'][$i]= $d['ordenProcedimientoUvrValorU'][$i]* $d['valcups'][$i]['cantidadCups'];
							
						$d['id_orden_procedimientouvr'][$i]=$id_orden;	
			// se cierra el if del cual se verifica el contrato				
				}
			}
				
	
		}
		
		
	//////////////////////////////////////////	
	//////////////////////////////////////////
	
	if(count($d['ordenCups']) > 0 && strlen($d['ordenCups'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenCups']);$i++)
			{
				//capturamos el id de la orden 
				$id_orden = $d['ordenCups'][$i];
				// capturamos un id contrato con el id_orden en la ubicacion de pagador
				$id_contrato=$d['PagadorProcedimiento'][$id_orden];
			
				if($id_contrato == $id_contrato_buscar)
				{
					// si el id_contrato es diferente de cero quiere decir que no es el contrato base,
					// con el cual se registro el usuario de lo contrario se toma como el contrato base
					if($id_contrato!=0)
					{
							$plantilla = $this->factura_model->obtenerPlantilla($id_contrato);				
					}else
						{
							$plantilla=$plantillabase;
						}
						
				
						//capturamos la cantidad y el cups
					$d['cupsdato'][$i] = $this->factura_model->obtenerCupProcedimiento($d['ordenCups'][$i]);
					$total =$this->factura_model->obtenerValor($d['cupsdato'][$i]['cups'],$plantilla);
					// valor total del cups
					$d['ordenCupsTotal'][$i]= $total * $d['cupsdato'][$i]['cantidadCups'];
					$d['ordenCupsValorU'][$i]= $total ;
					$d['ordenCupsCantidad'][$i]= $d['cupsdato'][$i]['cantidadCups'];
						
						$d['id_orden_procedimiento'][$i]=$id_orden;				
				}
				
				
				
		     }
		}
	
	
	

				
				$r = $this -> factura_model -> facturaDb($d);
		
	
		
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de la factura id atencion".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realizo con exito.";
			$dat['urlRegresar'] = site_url('fac/factura/datos_facturar/'.$d['id_atencion']);
			$this -> load -> view('core/presentacionMensaje', $dat);
			return; 
			
		}
	//cerramos el group del foreach
  }
		
		//----------------------------------------------------
		$dt['mensaje']  = "La factura se ha almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("fac/factura/ListadoFacturasAtencion/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}

///////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////
/* se carga la factura
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120107
* @version		20120107
*/

///////////////////////////////////////////////////////////////////
	function consultarFactura($id_atencion,$id_contrato)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('fac/consultar_facturas/index');
		$d['atencion'] = $this -> coam_model -> obtenerAtencion($id_atencion);
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		
		$id_factura= $this -> factura_model ->obtenerIdFactura($id_atencion,$id_contrato);
		
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		
		//-----------------------------------------------------------
   // $d['facMedi'] = $this -> factura_model -> facMedi($id_factura);
   //$d['facCups'] = $this -> factura_model -> facCups($id_factura);

 	$d['facProcedimiento'] = $this -> factura_model -> facProcedimiento($id_factura);
	$d['facProcedimientoUvr'] = $this -> factura_model -> facProcedimientoUvr($id_factura);

	//$d['facOrdenInsumos'] = $this -> factura_model -> facOrdenInsumos($id_factura);	
	$d['factura_detalles'] = $this -> factura_model -> detalles_factura($id_factura);
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('fac/fac_consulta',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}	
	//////////////////////////////////////////////////////////////
	
///////////////////////////////////////////////////////////////////
/* Muestra las facturas de la atencion
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120417
* @version		20120417
*/

///////////////////////////////////////////////////////////////////
	function ListadoFacturasAtencion($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('fac/factura/index');
		$d['atencion'] = $this -> coam_model -> obtenerAtencion($id_atencion);
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		//$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		//$d['mediAtencion'] = $this -> coam_model ->obtenerMediAtencion($id_atencion);
		//$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		
		//-----------------------------------------------------------

		

	//capturamos las facturas de la atencion.
		$d['facturas_atencion'] = $this -> factura_model -> facturas_atencion($id_atencion);
	
	
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('fac/fac_listado_factura',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}	
	//////////////////////////////////////////////////////////////	
	
	
	
	
	
	
	
	
	
	
	
	
	//////////////////////////////////////////////////////////////
	function buscarPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('fac/consultar_facturas/index');
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		
		$d['facturas_atencion'] = $this -> factura_model -> buscarFacturas($d['numero_documento']);
		
		foreach ($d['facturas_atencion'] as $item)
		{
			$d['factura'][]= $this -> factura_model -> facturas_contrato($item['id_factura']);
			
			}
		
		
		if($d['facturas_atencion'] == null)
		{
		
					  	$dt['mensaje']  = "El documento no tiene factura en el sistema!!";
						$dt['urlRegresar'] 	= site_url('fac/consultar_facturas/index');
						$this -> load -> view('core/presentacionMensaje', $dt);
						return;
					
					}
			$this->load->view('core/core_inicio');
			$this->load->view('fac/fac_listado_facturas_paciente',$d);
			$this->load->view('core/core_fin');
			
	}
///////////////////////////////////////////////////////////////////
	
	function ValorUvrCirujano($uvr)
	{
		
		$resuvr = $this -> factura_model -> obtenerValorUvr($uvr);
		echo $resuvr;
		return $resuvr;
		
		}
		
	function ValorUvrAnesteciologo($uvr)
	{
		
		$resuvr = $this -> factura_model -> obtenerValorUvr($uvr);
		echo $resuvr;
		return $resuvr;
		
		}	
	
		function ValorUvrAyudante($uvr)
	{
		
		$resuvr = $this -> factura_model -> obtenerValorUvr($uvr);
		echo $resuvr;
		return $resuvr;
		
		}	
	
		function ValorUvrSala($uvr)
	{
		
		$resuvr = $this -> factura_model -> obtenerValorSala($uvr);
		echo $resuvr;
		return $resuvr;
		
		}	
		
		
		function ValorUvrMateriales($uvr)
	{
		
		$resuvr = $this -> factura_model -> obtenerValorMateriales($uvr);
		echo $resuvr;
		return $resuvr;
		
		}	
		
		
	
	 function porcentaje($porcentaje,$valor,$decimales)
	{
		
return $porcentaje*$valor/100;

		
		}
	
/////////////////////////////// fin ////////////////////////////////////
}
?>
