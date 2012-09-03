<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: factura_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a los datos para la creacion de la factura.
 *Autor: Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
 *Fecha de creación: 7 de marzo de 2012
*/
class Factura_model extends Model 

{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////

	function obtenerDietasOrden($id_atencion)
	{
	
		
		$this->db->where('id_orden',$id_atencion);
		$result = $this->db->get('hospi_orde_dietas');
		return $result->result_array();	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerMediOrden($id_atencion)
	{
		$this->db->select('hospi_ordenamiento.id_orden,
			hospi_ordenamiento.id_atencion,
			hospi_orde_medicamentos.id,
			hospi_orde_medicamentos.atc,
			hospi_orde_medicamentos.dosis,
			hospi_orde_medicamentos.id_unidad,
			hospi_orde_medicamentos.pos,
			hospi_orde_medicamentos.cantidadMed,
			hospi_orde_medicamentos.estado,
			hospi_orde_medicamentos.id_via,
			hospi_orde_medicamentos.id_frecuencia
			
			
		  ');
		$this->db->from('hospi_ordenamiento');  
		 $this->db->join('hospi_orde_medicamentos','hospi_ordenamiento.id_orden = hospi_orde_medicamentos.id_orden ');
		
		$this->db->where('id_atencion',$id_atencion);
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> result_array();
		
		
		
		
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function obtenerCupsOrden($id_atencion)
	{
		
			$this->db->select('hospi_ordenamiento.id_orden,
			hospi_ordenamiento.id_atencion,
			hospi_orde_cups.cantidadCups,
			hospi_orde_cups.cups,
			hospi_orde_cups.id,
		  ');
		$this->db->from('hospi_ordenamiento');  
		 $this->db->join('hospi_orde_cups','hospi_ordenamiento.id_orden = hospi_orde_cups.id_orden ');
		
		$this->db->where('id_atencion',$id_atencion);
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> result_array();
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerCupsLaboratorios($id_atencion)
	{
	$this->db->select('hospi_ordenamiento.id_orden,
			hospi_ordenamiento.id_atencion,
			hospi_orde_laboratorios.cantidadCups,
			hospi_orde_laboratorios.cups,
			hospi_orde_laboratorios.id,
		  ');
		$this->db->from('hospi_ordenamiento');  
		 $this->db->join('hospi_orde_laboratorios','hospi_ordenamiento.id_orden = hospi_orde_laboratorios.id_orden ');
		
		$this->db->where('id_atencion',$id_atencion);
	  $result = $this->db->get();
		$numcupslab = $result -> num_rows();
		if($numcupslab == 0){
		return $numcupslab;}
		return $res = $result -> result_array();
		
		
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerCupsImagenes($id_atencion)
	{
	
			$this->db->select('hospi_ordenamiento.id_orden,
			hospi_ordenamiento.id_atencion,
			hospi_orde_imagenes.cantidadCups,
			hospi_orde_imagenes.cups,
			hospi_orde_imagenes.id,
		  ');
		$this->db->from('hospi_ordenamiento');  
		 $this->db->join('hospi_orde_imagenes','hospi_ordenamiento.id_orden = hospi_orde_imagenes.id_orden ');
		
		$this->db->where('id_atencion',$id_atencion);
	  $result = $this->db->get();
		$numcupsimg = $result -> num_rows();
		if($numcupsimg == 0){
		return $numcupsimg;}
		return $res = $result -> result_array();
		
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerOrdenInsumos($id_atencion)
  {
    $this->db->select(' 
  hospi_orde_insumos_detalle.id_insumo,
  core_insumos.insumo,
  core_insumos.codigo_interno,
  hospi_ordenamiento.id_atencion,
  hospi_orde_insumos.id_orden_insumos,
  hospi_orde_insumos_detalle.cantidad,
  
  hospi_orde_insumos_detalle.observaciones');
  $this->db->from('core_insumos');
  $this->db->join('hospi_orde_insumos_detalle','core_insumos.id_insumo = hospi_orde_insumos_detalle.id_insumo');
  $this->db->join('hospi_orde_insumos','hospi_orde_insumos.id_orden_insumos = hospi_orde_insumos_detalle.id_orden_insumos');
  $this->db->join('hospi_ordenamiento','hospi_ordenamiento.id_orden = hospi_orde_insumos.id_orden');
  
  $this->db->where('hospi_ordenamiento.id_atencion',$id_atencion);
   $result = $this->db->get();
		$numordenamiento = $result -> num_rows();
		if($numordenamiento == 0){
		return $numordenamiento;}
		return $res = $result -> result_array();
  
}


	/*
* guarda la factura
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

*/		

	function facturaDb($d)
	{
		
		
		
		
		
		$det_fac['detalles']=$this->Numero_estado_factura();
		$numero_factura= $det_fac['detalles'][0]['estado_fac'] + 1;
		$registro_factura=$det_fac['detalles'][0]['factura_detalle'];
		
		//le agregamos los ceros a la izquierda para la factura
		$nfactura=$this->agrega_cero($numero_factura,11);
		
		
		//  cambiamos el estado de la factura con el nuevo numero creado.
		$actualizar = array(
		'estado_fac' => $numero_factura);
		$this -> db -> update('hospi_factura_detalle',$actualizar);
		
		
		

		
		
		// guardamos los datos de la factura
		$dat = array();
		$insert = array(
		'id_atencion' 		=> $d['id_atencion'],
		'id_medico' 		=> $d['id_medico'],
		'factura_numero' 		=> $nfactura,
		'factura_detalle' 		=> $registro_factura,
		'fecha' 		=> $d['fecha'],
		'id_contrato' 		=> $d['contrato'],		
		'id_usuario' 		=> $this -> session -> userdata('id_usuario'));
		$this -> db -> insert('hospi_factura',$insert);
		$dat['id_factura'] = $this->db->insert_id();
		
		
	
		
		
			//----------------------------------------------------
		if(count($d['ordenProcedimientoUvr']) > 0 && strlen($d['ordenProcedimientoUvr'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenProcedimientoUvr']);$i++)
			{
				if( $d['id_orden_procedimientouvr']!=null)
				 if (in_array($d['ordenProcedimientoUvr'][$i], $d['id_orden_procedimientouvr']))
		    {
	            $insert = array(
				'valor_total' => $d['ordenProcedimientoUvrTotal'][$i],
				'valor_unidad' => $d['ordenProcedimientoUvrValorU'][$i] ,
				'cantidad' => $d['ordenProcedimientoUvrCantidad'][$i],
				'valor_cirujano' => $d['ValorUvrCirujano'][$i],
				'valor_anesteciologo' => $d['ValorUvrAnesteciologo'][$i],
				'valor_ayudante' => $d['ValorUvrAyudante'][$i],
				'valor_sala' => $d['ValorUvrSala'][$i],
				'valor_materiales' => $d['ValorUvrMateriales'][$i],
				'id_orde_cups'	=> $d['ordenProcedimientoUvr'][$i],
				'id_factura' 	=> $dat['id_factura'] );
				$this->db->insert('hospi_fac_procedimientouvr', $insert);
	        }
				 
			}
		}
		//----------------------------------------------------
		

		//----------------------------------------------------
		if(count($d['ordenCups']) > 0 && strlen($d['ordenCups'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenCups']);$i++)
			{
			  if( $d['id_orden_procedimiento']!=null)
				if (in_array($d['ordenCups'][$i], $d['id_orden_procedimiento']))
				{
				
					$insert = array(
					'valor_total' => $d['ordenCupsTotal'][$i],
					'valor_unidad' => $d['ordenCupsValorU'][$i] ,
					'cantidad' => $d['ordenCupsCantidad'][$i],
					'id_orde_cups'	=> $d['ordenCups'][$i],
					'id_factura' 	=> $dat['id_factura'] );
					$this->db->insert('hospi_fac_procedimiento', $insert); 
				}
			
			}
		}
		//----------------------------------------------------
			//----------------------------------------------------
		if(count($d['ordenCupsImagenes']) > 0 && strlen($d['ordenCupsImagenes'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenCupsImagenes']);$i++)
			{
				if( $d['id_orden_imagenes']!=null)
					if (in_array($d['ordenCupsImagenes'][$i], $d['id_orden_imagenes']))
				{
		
				$insert = array(
				'valor_total' => $d['ordenCupsImagenesTotal'][$i],
				'valor_unidad' => $d['ordenCupsImagenesValorU'][$i] ,
				'cantidad' => $d['ordenCupsImagenesCantidad'][$i],
				'id_orde_imagenes'	=> $d['ordenCupsImagenes'][$i],
				'id_factura' 	=> $dat['id_factura'] );
				$this->db->insert('hospi_fac_imagenes', $insert); 
				}
			}
		}
		//----------------------------------------------------
		if(count($d['insumo']) > 0 && strlen($d['insumo'][0]) > 0)
		{
			for($i=0;$i<count($d['insumo']);$i++)
			{
				$insert = array(
					'id_orde_insumos' 		=> $d['insumo'][$i],
					'id_factura' 	=> $dat['id_factura'] );
				$this->db->insert('hospi_fac_insumos', $insert); 
			}
		}
		//----------------------------------------------------
			//----------------------------------------------------
		if(count($d['ordenCupsLaboratorios']) > 0 && strlen($d['ordenCupsLaboratorios'][0]) > 0)
		{
			for($i=0;$i<count($d['ordenCupsLaboratorios']);$i++)
			{
			  if( $d['id_orden_laboratorio']!=null)
				if (in_array($d['ordenCupsLaboratorios'][$i], $d['id_orden_laboratorio']))
				{
					$d['id_orden_laboratorio']=null;
					$insert = array(
					'valor_total' => $d['ordenCupsLaboratoriosTotal'][$i],
					'valor_unidad' => $d['ordenCupsLaboratoriosValorU'][$i] ,
					'cantidad' => $d['ordenCupsLaboratoriosCantidad'][$i],
					'id_orde_laboratorios' 		=> $d['ordenCupsLaboratorios'][$i],
					'id_factura' 	=> $dat['id_factura'] );
					$this->db->insert('hospi_fac_laboratorios', $insert); 
				}
			}
		}
		//----------------------------------------------------
				//----------------------------------------------------
		if(count($d['medicamento']) > 0 && strlen($d['medicamento'][0]) > 0)
		{
			for($i=0;$i<count($d['medicamento']);$i++)
			{
				$insert = array(
					'id_orde_medicamentos' 		=> $d['medicamento'][$i],
					'id_factura' 	=> $dat['id_factura'] );
				$this->db->insert('hospi_fac_medicamentos', $insert); 
			}
		}
		//----------------------------------------------------
	}
	
	//----------------------------------------------------
	//----------------------------------------------------
		function obtenerAtencion($id_paciente)
	{
		
			$this->db->select('hospi_atencion.id_atencion,
		  ');
		$this->db->from('hospi_atencion');  
		$this->db->join('hospi_factura', 'hospi_factura.id_atencion = hospi_atencion.id_atencion','left outer');
		
		$this->db->where('hospi_atencion.id_paciente',$id_paciente);
		$this->db->where('hospi_factura.id_atencion IS NULL');
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row_array();
	}

///////////////////////////////////////////////////////////////////////////

// captura el valor venta en plantilla fact detalle
		function obtenerValor($cup,$id_plantilla)
	{
		
			$this->db->select('plantilla_fact_detalle.valor_venta,
		  ');
		$this->db->from('plantilla_fact_detalle');  
		
		
		$this->db->where('plantilla_fact_detalle.cod_cups',$cup);
		$this->db->where('plantilla_fact_detalle.id_plantilla',$id_plantilla);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('valor_venta');
	}
	
		
// captura el valor de uvr en plantilla fact detalle
		function obtenerValorUnidadPlantilla($cup,$plantilla)
	{
		
			$this->db->select('plantilla_fact_detalle.unidad_plantilla,
		  ');
		$this->db->from('plantilla_fact_detalle');  
		
		
		$this->db->where('plantilla_fact_detalle.cod_cups',$cup);
		$this->db->where('plantilla_fact_detalle.id_plantilla',$plantilla);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('unidad_plantilla');
	}
	
////////////////////////////////////////////////////////////////////////////////
// captura el valor del porcentage de la plantilla
		function valorvariacionplantilla($id)
	{
		
			$this->db->select('plantilla_fact.valor_variacion ,
			plantilla_fact.variacion ,
		  ');
		$this->db->from('plantilla_fact');  
		
		
		$this->db->where('plantilla_fact.id_plantilla',$id);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('valor_variacion');
	}
	
	
////////////////////////////////////////////////////////////////////////////////
// captura el valor de la variacion de la plantilla
		function obtenervariacion($id)
	{
		
			$this->db->select('plantilla_fact.variacion ,
		  ');
		$this->db->from('plantilla_fact');  
		
		
		$this->db->where('plantilla_fact.id_plantilla',$id);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('variacion');
	}	

///////////////////////////////////////////////////////////////////////////
		function obtenerUvr($cup)
	{
		
			$this->db->select('plantilla_fact_detalle.unidad_plantilla,
		  ');
		$this->db->from('plantilla_fact_detalle');  
		
		
		$this->db->where('plantilla_fact_detalle.cod_cups',$cup);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('unidad_plantilla');
	}
	
	
////////////////////////////////////////////////////////////////////////////////

function obtenerCupLab($id)
	{
		
			$this->db->select('hospi_orde_laboratorios.cups,
			hospi_orde_laboratorios.cantidadCups,
		  ');
		$this->db->from('hospi_orde_laboratorios');  
		
		
		$this->db->where('hospi_orde_laboratorios.id',$id);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row_array();
	}
	
	
	//----------------------------------------------------
	
function obtenerCupProcedimiento($id)
	{
		
			$this->db->select('hospi_orde_cups.cups,
			hospi_orde_cups.cantidadCups,
		  ');
		$this->db->from('hospi_orde_cups');  
		
		
		$this->db->where('hospi_orde_cups.id',$id);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row_array();
	}
	
	//----------------------------------------------------
	
function obtenerCupImagen($id)
	{
		
			$this->db->select('hospi_orde_imagenes.cups,
			hospi_orde_imagenes.cantidadCups,
		  ');
		$this->db->from('hospi_orde_imagenes');  
		
		
		$this->db->where('hospi_orde_imagenes.id',$id);
		
	  $result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row_array();
	}	
	//----------------------------------------------------
	
	// servicios profesionales valor en uvr
		function obtenerValorUvr($id_concepto)
	{
		
			$this->db->select('man_tarifario_serv_profesionales.valor_x_uvr,
		  ');
		$this->db->from('man_tarifario_serv_profesionales');  		
		$this->db->where('man_tarifario_serv_profesionales.id_concepto',$id_concepto);
		$result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('valor_x_uvr');
	}
	
	
	
	//----------------------------------------------------
	
	// salas y materiales
	function obtenerValorSala($uvr)
	{
		return $this->db->query("select plantilla_fact_salas_materiales.venta_sala
							from plantilla_fact_salas_materiales
							where $uvr between plantilla_fact_salas_materiales.uvr_inicial and plantilla_fact_salas_materiales.uvr_final")->row('venta_sala');
		
		$result = $this->db->get();
	
		
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('venta_sala');
	}
	

	//----------------------------------------------------
	
	// salas y materiales
	function obtenerValorMateriales($uvr)
	{
		return $this->db->query("select plantilla_fact_salas_materiales.venta_materiales
							from plantilla_fact_salas_materiales
							where $uvr between plantilla_fact_salas_materiales.uvr_inicial and plantilla_fact_salas_materiales.uvr_final")->row('venta_materiales');
		
		$result = $this->db->get();
	
		
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('venta_materiales');
	}
	
	
	

/////////////////////////////////////////////////////////////////////////
/*
* Obtiene el ID de la factura con el id_atencion
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/		function obtenerIdFactura($id_atencion,$id_contrato)
	{
		$this->db->select('hospi_factura.id_factura,
		  ');
		$this->db->from('hospi_factura');  		
		$this->db->where('hospi_factura.id_atencion',$id_atencion);
		$this->db->where('hospi_factura.id_contrato',$id_contrato);
		
		$result = $this->db->get();
		$numcups = $result -> num_rows();
		if($numcups == 0){
		return $numcups;}
		return $res = $result -> row('id_factura');
		
		
		
	}
	
	
/*
* Obtiene los datos de la factura para los laboratorios.
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function facCupsLaboratorios($id_factura)
	{
$this->db->select('hospi_fac_laboratorios.valor_unidad,
			hospi_fac_laboratorios.valor_total,
			hospi_fac_laboratorios.cantidad,
			hospi_fac_laboratorios.id_factura,
			hospi_fac_laboratorios.id_orde_laboratorios,
			hospi_orde_laboratorios.id,
			hospi_orde_laboratorios.cups,
		  ');
$this->db->FROM('hospi_fac_laboratorios');
$this->db->JOIN('hospi_orde_laboratorios','hospi_orde_laboratorios.id = hospi_fac_laboratorios.id_orde_laboratorios');
$this->db->where('hospi_fac_laboratorios.id_factura',$id_factura);
$res = $this->db->get();
return $res->result_array();
	}	
	
	
	/*
* Obtiene los datos de la factura para las imagenes diagnosticas.
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function facCupsImagenes($id_factura)
	{
$this->db->select('hospi_fac_imagenes.valor_unidad,
			hospi_fac_imagenes.valor_total,
			hospi_fac_imagenes.cantidad,
			hospi_fac_imagenes.id_factura,
			hospi_fac_imagenes.id_orde_imagenes,
			hospi_orde_imagenes.id,
			hospi_orde_imagenes.cups,
		  ');
$this->db->FROM('hospi_fac_imagenes');
$this->db->JOIN('hospi_orde_imagenes','hospi_orde_imagenes.id = hospi_fac_imagenes.id_orde_imagenes');
$this->db->where('hospi_fac_imagenes.id_factura',$id_factura);
$res = $this->db->get();
return $res->result_array();
	}
	
	
	/*
* Obtiene los datos de la factura para los procedimientos.
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function facProcedimiento($id_factura)
	{
$this->db->select('hospi_fac_procedimiento.valor_unidad,
			hospi_fac_procedimiento.valor_total,
			hospi_fac_procedimiento.cantidad,
			hospi_fac_procedimiento.id_factura,
			hospi_fac_procedimiento.id_orde_cups,
			hospi_orde_cups.id,
			hospi_orde_cups.cups,
		  ');
$this->db->FROM('hospi_fac_procedimiento');
$this->db->JOIN('hospi_orde_cups','hospi_orde_cups.id = hospi_fac_procedimiento.id_orde_cups');
$this->db->where('hospi_fac_procedimiento.id_factura',$id_factura);
$res = $this->db->get();
return $res->result_array();
	}	
	
		/*
* Obtiene los datos de la factura para los procedimientos con UVR.
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function facProcedimientoUvr($id_factura)
	{
$this->db->select('hospi_fac_procedimientouvr.valor_unidad,
			hospi_fac_procedimientouvr.valor_total,
			hospi_fac_procedimientouvr.cantidad,
			hospi_fac_procedimientouvr.id_factura,
			hospi_fac_procedimientouvr.id_orde_cups,
			hospi_orde_cups.id,
			hospi_orde_cups.cups,
		  ');
$this->db->FROM('hospi_fac_procedimientouvr');
$this->db->JOIN('hospi_orde_cups','hospi_orde_cups.id = hospi_fac_procedimientouvr.id_orde_cups');
$this->db->where('hospi_fac_procedimientouvr.id_factura',$id_factura);
$res = $this->db->get();
return $res->result_array();
	}	
			/*
* Obtenemos la plantilla asociada a un determinado contrato.
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function obtenerPlantilla($id_contrato)
	{
		$this->db->select('core_contrato.id_plantilla');
		$this->db->FROM('core_contrato');
		$this->db->where('core_contrato.id_contrato',$id_contrato);
		$result = $this->db->get();
		return $res = $result -> row('id_plantilla');
	
	}
		/*
* Obtiene el listado de contratos de la clinica.
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/		
	
	function ListadoContratos()
	{	
		$this->db->FROM('core_contrato');
		$this->db->where('core_contrato.estado','ACTIVO');
		$result = $this->db->get();
		return $res = $result -> result_array();
		
		
	}
	
		/*
* Numero de estado de factura.
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	
	function Numero_estado_factura()
	{
		$this->db->FROM('hospi_factura_detalle');
		$result = $this->db->get();
		return $res = $result -> result_array();
		
	}
	
	
	function detalles_factura($id_factura)
	{
		$this->db->FROM('hospi_factura');
		$this->db->WHERE('hospi_factura.id_factura',$id_factura);
		
		$result = $this->db->get();
		return $res = $result -> result_array();
		
		
	}
	
		function facturas_atencion($id_atencion)
	{
		$this->db->FROM('hospi_factura');
		$this->db->WHERE('hospi_factura.id_atencion',$id_atencion);
		
		$result = $this->db->get();
		return $res = $result -> result_array();
		
		
	}
	
	
		/*
* Obtenemos los datos de un contrato determinado.
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0

* @return		array[object]
*/	
	function obtenerDatosContrato($id_contrato)
	{
	
		$this->db->FROM('core_contrato');
		$this->db->where('core_contrato.id_contrato',$id_contrato);
		$result = $this->db->get();
		return $res = $result -> result_array();
	
	}
	
function agrega_cero($numero,$ceros){
echo strlen($numero);
if(strlen($numero)<$ceros) {
	 for($j=strlen($numero);$j<$ceros;$j++)
	 $numero='0'.$numero;
}
echo $numero;
return $numero;
}
	
	
	
	
	///////////////////////////////Fin//////////////////////////////////////////////////
}