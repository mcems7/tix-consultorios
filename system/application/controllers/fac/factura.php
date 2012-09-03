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
class Factura extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('inter/interconsulta_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/medico_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('lab/ordenes_model');
		$this -> load -> model('fac/factura_model');
		$this -> load -> model('hosp/hosp_model');
		$this -> load -> model('hospi/hospi_model');
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
		$this -> load -> view('fac/fac_buscarDocumento', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	
///////////////////////////////////////////////////////////////////
/*se cargan los datos a facturar del paciente
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120107
* @version		20120107
*/

///////////////////////////////////////////////////////////////////
	function datos_facturar($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('fac/factura/index');
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		
		$d['contrato'] = $d['atencion']['id_contrato'];
		$d['plantilla'] = $this -> factura_model -> obtenerPlantilla($d['contrato']['id_contrato']);
		
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> hospi_model ->obtenerMediAtencion($id_atencion);
		//$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		
		//-----------------------------------------------------------
    $d['ordenDietas'] = $this -> factura_model -> obtenerDietasOrden($id_atencion);
    $d['ordenMedi'] = $this -> factura_model -> obtenerMediOrden($id_atencion);
    $d['ordenCups'] = $this -> factura_model -> obtenerCupsOrden($id_atencion);
    $d['ordenCupsLaboratorios'] = $this -> factura_model -> obtenerCupsLaboratorios($id_atencion);
    $d['ordenCupsImagenes'] = $this -> factura_model -> obtenerCupsImagenes($id_atencion);
	$d['ordenInsumos'] = $this -> factura_model -> obtenerOrdenInsumos($id_atencion);	
	
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('fac/fac_generar',$d);
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
		$d['ordenCupsLaboratorios'] 	= $this->input->post('ordenCupsLaboratorios');
		$d['ordenCupsImagenes'] 	= $this->input->post('ordenCupsImagenes');
		$d['ordenProcedimiento'] 	= $this->input->post('ordenProcedimiento');
		$d['UvrCirujano'] 	= $this->input->post('ValorUvrCirujano');
		$d['UvrAnesteciologo'] 	= $this->input->post('ValorUvrAnesteciologo');
		$d['UvrAyudante'] 	= $this->input->post('ValorUvrAyudante');
		$d['UvrSala'] 	= $this->input->post('ValorUvrSala');
		$d['UvrMateriales'] 	= $this->input->post('ValorUvrMateriales');
		$d['PagadorProcedimientoUvr'] 	= $this->input->post('PagadorProcedimientoUvr');
		$d['PagadorProcedimiento'] 	= $this->input->post('PagadorProcedimiento');
		$d['Pagadorimagenes'] 	= $this->input->post('pagadorimagenes');
		$d['Pagadorlaboratorio'] 	= $this->input->post('pagadorlaboratorio');
		$d['id_contrato'] 	= $this->input->post('id_contrato');
		

		
		
	   if($d['Pagadorlaboratorio']!=null)
	   {
			foreach($d['Pagadorlaboratorio'] as $i)
			{
				$d['Pagador'][]= $i;
			}   
		}
		
		/////////////////////////
		
		 if($d['PagadorProcedimientoUvr']!=null)
	   {
			foreach($d['PagadorProcedimientoUvr'] as $i)
			{
				$d['Pagador'][]= $i;
			}
	   }
	   ////////////////////////////////
	   if($d['Pagadorimagenes']!=null)
	   {	   
			foreach($d['Pagadorimagenes'] as $i)
			{
				$d['Pagador'][]= $i;
			}
	   }
	   
		//print_r($d['Pagador']);
		
		
		
		
		
		
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
		$d['id_orden_laboratorio']=null;
		$d['id_orden_imagenes']=null;
		
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
	
	
		
	if(count($d['ordenCupsLaboratorios']) > 0 && strlen($d['ordenCupsLaboratorios'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenCupsLaboratorios']);$i++)
			{
				//capturamos el id de la orden 
				$id_orden = $d['ordenCupsLaboratorios'][$i];
				// capturamos un id contrato con el id_orden en la ubicacion de pagador
				$id_contrato=$d['Pagadorlaboratorio'][$id_orden];
				
				if($id_contrato == $id_contrato_buscar)
				{
					// si el id_contrato es diferente de cero quiere decir que no es el contrato base con el cual se registro el usuario de lo contrario se toma como el contrato base
					if($id_contrato!=0)
					{
							$plantilla = $this->factura_model->obtenerPlantilla($id_contrato);				
					}else
						{
							$plantilla=$plantillabase;
						}
				
			    
				
				
				
				
					$d['cupslab'][$i] = $this->factura_model->obtenerCupLab($d['ordenCupsLaboratorios'][$i]);
					$total =$this->factura_model->obtenerValor($d['cupslab'][$i]['cups'],$plantilla);
					
					$d['ordenCupsLaboratoriosTotal'][$i]= $total * $d['cupslab'][$i]['cantidadCups'];
					$d['ordenCupsLaboratoriosValorU'][$i]= $total ;
					$d['ordenCupsLaboratoriosCantidad'][$i]= $d['cupslab'][$i]['cantidadCups'];
					$d['id_orden_laboratorio'][$i]=$id_orden;	
				}
		     }
		}


	if(count($d['ordenCupsImagenes']) > 0 && strlen($d['ordenCupsImagenes'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenCupsImagenes']);$i++)
			{
				
			    //capturamos el id de la orden 
				$id_orden = $d['ordenCupsImagenes'][$i];
				// capturamos un id contrato con el id_orden en la ubicacion de pagador
				$id_contrato=$d['Pagadorimagenes'][$id_orden];
				
				if($id_contrato == $id_contrato_buscar)
				{
					// si el id_contrato es diferente de cero quiere decir que no es el contrato base con el cual se registro el usuario de lo contrario se toma como el contrato base
					if($id_contrato!=0)
					{
							$plantilla = $this->factura_model->obtenerPlantilla($id_contrato);				
					}else
						{
							$plantilla=$plantillabase;
						}
								
					  
					  $d['cupsImagen'][$i] = $this->factura_model->obtenerCupImagen($d['ordenCupsImagenes'][$i]);
					  $total =$this->factura_model->obtenerValor($d['cupsImagen'][$i]['cups'],$plantilla);
					  
					  $d['ordenCupsImagenesTotal'][$i]= $total * $d['cupsImagen'][$i]['cantidadCups'];
					  $d['ordenCupsImagenesValorU'][$i]= $total ;
					  $d['ordenCupsImagenesCantidad'][$i]= $d['cupsImagen'][$i]['cantidadCups'];
					  $d['id_orden_imagenes'][$i]=$id_orden;
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
		$d['urlRegresar'] 	= site_url('fac/factura/index');
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> hospi_model ->obtenerMediAtencion($id_atencion);
		$id_factura= $this -> factura_model ->obtenerIdFactura($id_atencion,$id_contrato);
		
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		
		//-----------------------------------------------------------
   // $d['facMedi'] = $this -> factura_model -> facMedi($id_factura);
   //$d['facCups'] = $this -> factura_model -> facCups($id_factura);
    $d['facCupsLaboratorios'] = $this -> factura_model -> facCupsLaboratorios($id_factura);
	
    $d['facCupsImagenes'] = $this -> factura_model -> facCupsImagenes($id_factura);
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
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> hospi_model ->obtenerMediAtencion($id_atencion);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		
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
		$d['urlRegresar'] 	= site_url('fac/factura/index');
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		
		$verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);

		if($verTer != 0)
		{
			$verPas = $this -> paciente_model -> verificarPaciente($verTer);
			//Verifica la existencia del tercero como paciente
			if($verPas != 0)
			{	
				$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($verPas);
				
				$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
				$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
				$d['atencion'] = $this -> factura_model ->obtenerAtencion($d['paciente']['id_paciente']);
						

				if ($d['atencion'] !=0)
				{
					$this->datos_facturar($d['atencion']['id_atencion']);
				}else{
					  	$dt['mensaje']  = "El paciente no se encuentra registrado en el sistema!!";
						$dt['urlRegresar'] 	= site_url('fac/factura/index');
						$this -> load -> view('core/presentacionMensaje', $dt);
						return;
					
					}
			//	$this->load->view('core/core_inicio');
			//	$this->load->view('hosp/hosp_registro_atencion',$d);
			//	$this->load->view('core/core_fin');
			}else
			{
				$dt['mensaje']  = "El paciente no se encuentra registrado en el sistema!!";
				$dt['urlRegresar'] 	= site_url('fac/factura/index');
				$this -> load -> view('core/presentacionMensaje', $dt);
				return;
			}
		}else{
			$dt['mensaje']  = "El paciente no se encuentra registrado en el sistema!!";
			$dt['urlRegresar'] 	= site_url('fac/factura/index');
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;
		}	
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
