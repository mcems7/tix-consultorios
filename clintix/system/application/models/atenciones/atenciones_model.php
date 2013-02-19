 <?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: atenciones_model
 *Tipo: modelo
 *Descripcion: Contiene todas las operaciones requeridas en la base de datos
 *             para la manipulación de los datos de la atención del paciente por
 *             del paciente.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Atenciones_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{        
    parent::Model();
    $this->load->database();
}
 ///////////////////////////////////////////////////////////////////////////////
 //
 ///////////////////////////////////////////////////////////////////////////////
 function TomarNodo()
{
  $this->db->select('cex_atencion_item_hc.id,cex_atencion_item_hc.nombre,
                     cex_atencion_item_hc.abreviatura,cex_atencion_item_hc.tipo,
                     cex_atencion_item_hc.idpadre');
  $this->db->from('cex_atencion_item_hc');
  $result = $this->db->get();
  return $result->result_array(); 
	}    
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
	
function Insert_Valores_List($d,$idfinal){

 foreach($d['descripcion'] as $datos)
 {
                 $update = array(
          'id_clinico'=>  $idfinal,
  'descripcion' => $datos,

           );

        $this -> db -> insert('cex_atencion_val_lista',$update);

 }

}
 //////////////////////////////////////////////////////////////////////////////
function Listado_Valores_List($identificador)
  {
    $this->db->SELECT('cex_atencion_val_lista.id_clinico, 
                       cex_atencion_val_lista.descripcion');
    $this->db->from('cex_atencion_val_lista');
    $this->db->WHERE('id_clinico',$identificador);  
    $result = $this->db->get();
    return $result->result_array(); 
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function Tipos_laboratorios($id)
{
    $this->db->select('cex_atencion_item_hc.nombre,cex_atencion_item_hc.id');
    $this->db->from('cex_atencion_item_hc');
    $this->db->where('id',$id);  
    $result = $this->db->get();
    return $result->result_array(); 
}	
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////

 function Insert_tipo_lab($datos)
 {
    $insert = array('abreviatura'=>$datos['abreviatura'],
                     'nombre' => $datos['nombre'],
                     'tipo' => $datos['tipo']  );
    $this->db-> insert('cex_atencion_item_hc',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////

function Insert_contenedor_aten($datos)
 {
    $insert = array('abreviatura'=>$datos['abreviatura'],
                    'nombre' => $datos['nombre'],
                    'tipo' => $datos['tipo'],
                    'idpadre' => $datos['idpadre'],
		    'accion_alerta'=>$datos['accion_alerta'],
		    'seguimiento_individuo'=>$datos['seguimiento_individuo'],
	            'restriccion_sumatoria'=>$datos['restriccion_sumatoria'],
	            'normalidad_atomica'=>$datos['normalidad_atomica'],	
		    'valor_grupo_suma'=>$datos['valor_grupo_suma'],
	            'mensaje_grupo_suma'=> $datos['mensaje_grupo_suma'],
		    'mensaje_normalidad_atomica'=> $datos['mensaje_normalidad_atomica'],
		    'id_especialidad'=> $datos['id_especialidad'] );
     $this->db->insert('cex_atencion_item_hc',$insert);
   }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////

function Insert_clinico_lab($datos)
  {
    $update = array( 'abreviatura'=>$datos['abreviatura'],
                     'nombre' => $datos['nombre'],
                     'tipo'=>$datos['tipo'],
		  'tipo_dato' => $datos['tipo_dato'],
		  'idpadre' => $datos['idpadre'],
		  'valorminimonumerico' => $datos['valorminimonumerico'],
		  'valormaximonumerico' => $datos['valormaximonumerico'], 
		  'lista_observacion' => $datos['lista_observacion'],
		  //'id_cup' =>$datos['id_cup'],
		   );
		    
	     
	   $this -> db -> insert('cex_atencion_item_hc',$update);
	   
	          
   }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function Id_ultimo_clinico_insertado()
  {
    $this->db->select_max('id');
    $result = $this->db->get('cex_atencion_item_hc');
    return $result->result_array();	          
   }
   
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////

function RegistraCambioNom($Newname,$id)
{
    $update2 = array('nombre'=> $Newname);  
    $this->db->where('id',$id);
    $this->db->update('cex_atencion_item_hc',$update2);		
}
///////////////////////////////////////////////////////////////////////////////
//
/////////////////////////////////////////////////////////////////////////////// 
function obtenerEspecialidad($id_especialidad)
  {
    $this->db->from('core_especialidad');
    $this->db->where('id_especialidad',$id_especialidad);
    $result = $this->db->get();
    return $result->result_array(); 
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
 function obtenerIdClinico($id_especialidad)
  {

    $this->db->select('cex_atencion_item_hc.id');
    $this->db->from('cex_atencion_item_hc');
    $this->db->where('id_especialidad',$id_especialidad);  
    $result = $this->db->get();
    return $result->result_array(); 
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////

function obtenerClinicos($id_clinico_cup)
{
    $this->db->from('cex_atencion_item_hc');
    $this->db->where('idpadre',$id_clinico_cup);  
    $this->db->order_by('cex_atencion_item_hc.tipo','ASC');  
    $result = $this->db->get();
    return $result->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function CargaListadoValor($id)
{
    $this->db->from('cex_atencion_val_lista');
    $this->db->where('id_clinico',$id);  
    $result = $this->db->get();
    return $result->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
public function lista_pacientes($id_especialista)
{
    $this->db->SELECT("caa.id_agenda_dia_detalle agenda, cr.id, cp.genero,
                   ct.numero_documento, ct.primer_nombre, ct.segundo_nombre,
                   ct.primer_apellido, ct.segundo_apellido, cd.nombre departamento, 
                   cm.nombre municipio , ct.telefono, ct.fecha_nacimiento, 
                   cr.fecha_solicitud,cr.id_especialidad, 
                   caa.orden_intervalo intervalo_cita, agdd.orden_intervalo");
    $this->db->from('cex_citas_asignadas_agenda caa');
    $this->db->JOIN('cex_cita_remisiones cr','caa.id_remision=cr.id');
    $this->db->JOIN('core_tercero ct','ct.id_tercero=cr.id_tercero');
    $this->db->JOIN('core_paciente cp ','ct.id_tercero=cp.id_tercero');
    $this->db->JOIN('cex_agenda_dia_detalle agdd',
                    'caa.id_agenda_dia_detalle = agdd.id_agenda_dia_detalle');
    $this->db->JOIN('core_municipio cm','cm.id_municipio = cr.id_municipio');
    $this->db->JOIN('core_departamento cd','cm.id_departamento=cd.id_departamento');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio addc',
                    'addc.id_agenda_consultorio = agdd.id_agenda_consultorio');
    $this->db->JOIN('cex_agenda_agenda_dia aad','addc.id_agenda_dia=aad.id_agenda_dia');
    $this->db->WHERE('aad.fecha',date('y-m-d'));
    $this->db->WHERE('cr.estado','confirmada');
   // $this->db->WHERE('agdd.`id_especialista',$id_especialista);
    $this->db->ORDER_BY('agdd.orden_intervalo, caa.orden_intervalo');
    $resultado=$this->db->get()->result_array();
    return $resultado;
}
///////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////
public function lista_pacientes_confirmar($id_especialidad)
{
    $this->db->SELECT("caa.id_agenda_dia_detalle agenda, cr.id, cp.genero,
                   ct.numero_documento, ct.primer_nombre, ct.segundo_nombre,
                   ct.primer_apellido, ct.segundo_apellido, cd.nombre departamento, 
                   cm.nombre municipio , ct.telefono, ct.fecha_nacimiento, 
                   cr.fecha_solicitud,cr.id_especialidad, ct.numero_documento,
                   caa.orden_intervalo intervalo_cita, agdd.orden_intervalo,
                   ac.descripcion consultorio,ce.descripcion especialidad,
                   ctdr.primer_nombre nombre_dr_1,  ctdr.segundo_nombre nombre_dr_2, 
                   ctdr.primer_apellido apellido_dr_1, 
                   ctdr.segundo_apellido apellido_dr_2");
    $this->db->from('cex_citas_asignadas_agenda caa');
    $this->db->JOIN('cex_cita_remisiones cr','caa.id_remision=cr.id');
    $this->db->JOIN('core_tercero ct','ct.id_tercero=cr.id_tercero');
    $this->db->JOIN('core_paciente cp ','ct.id_tercero=cp.id_tercero');
    $this->db->JOIN('cex_agenda_dia_detalle agdd',
                    'caa.id_agenda_dia_detalle = agdd.id_agenda_dia_detalle');
    $this->db->JOIN('core_municipio cm','cm.id_municipio = cr.id_municipio');
    $this->db->JOIN('core_departamento cd','cm.id_departamento=cd.id_departamento');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio addc',
                    'addc.id_agenda_consultorio = agdd.id_agenda_consultorio');
    $this->db->JOIN('cex_agenda_agenda_dia aad','addc.id_agenda_dia=aad.id_agenda_dia');
    $this->db->JOIN('cex_agenda_consultorios ac','ac.id_consultorio=addc.id_consultorio');
    $this->db->JOIN('core_especialidad ce','ce.id_especialidad = cr.id_especialidad');
    $this->db->JOIN('core_medico cdr','cdr.id_medico = agdd.id_especialista');
    $this->db->JOIN('core_tercero ctdr','ctdr.id_tercero = cdr.id_tercero');
    $this->db->WHERE('aad.fecha',date('y-m-d'));
    $this->db->WHERE('cr.estado','asignada');
    if($id_especialidad!="-1")
        $this->db->WHERE('cr.id_especialidad',$id_especialidad);
    $this->db->ORDER_BY('agdd.orden_intervalo, caa.orden_intervalo');
    $resultado=$this->db->get()->result_array();
    return $resultado;
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function iniciar_atencion($id_cita)
{
    $hora = getdate(time());
    $valor= $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"] ; 
    $this->db->where('id_remision', $id_cita);
    $this->db->update('cex_citas_asignadas_agenda', array('hora_atencion' => $valor)); 
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function finalizar_atencion($id_cita)
{
    $hora = getdate(time());
    $valor= $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"] ;
    $this->db->where('id_remision', $id_cita);
    $this->db->update('cex_citas_asignadas_agenda', array('hora_finaliza_atencion' => $valor));  
    $this->db->where('id', $id_cita);
    $this->db->update('cex_cita_remisiones', array('estado' => 'atendida'));  
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function agregar_hce($id_cita, $id_item_hce, $valor_item)
{
    $hora = getdate(time());
    $valor_hora= $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"] ;
    $insert= array(
        'id_cita'=>$id_cita, 'id_item_hc'=>$id_item_hce,
        'valor'=>mb_strtoupper($valor_item),'hora'=>$valor_hora
    );
    $this->db->insert('cex_atencion_hce',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function agregar_diagnostico($id_cita, $id_diagnostico,$principal)
{
    $hora = getdate(time());
    $valor_hora= $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"] ;
    $insert= array(
        'id_cita'=>$id_cita,
        'id_diagnostico'=>$id_diagnostico,
        'principal'=>$id_diagnostico==$principal?1:0
    );
    $this->db->insert('cex_atencion_diagnostico',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function agregar_plan($id_cita,$plan_manejo)
{
    $update=array('conducta'=>$plan_manejo);
    $this->db->where('id_remision',$id_cita);
    $this->db->update('cex_citas_asignadas_agenda',$update);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function obtener_id_especialidad_cita($id_cita)
{
    $this->db->select('id_especialidad');
    $this->db->from('cex_cita_remisiones');
    $this->db->where('id',$id_cita);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function datos_pacientes($id_cita)
{
    $this->db->SELECT("cr.*,cp.*,ctp.*,ct.*,agdd.*,caa.*, aad.fecha fecha_atencion,
                       cerp.razon_social eps, cer.razon_social entidad_remite"); 
    $this->db->FROM("cex_cita_remisiones cr");
    $this->db->JOIN('core_paciente cp','cp.id_paciente = cr.id_paciente');
    $this->db->JOIN('core_tercero ct','ct.id_tercero = cp.id_tercero');
    $this->db->JOIN('core_eapb cea','cr.id_entidad_remitente=cea.codigo_eapb');
    $this->db->JOIN('core_tercero cer','cea.id_tercero =cer.id_tercero'); 
    $this->db->JOIN('core_eapb ceap','cr.id_entidad=ceap.id_entidad');
    $this->db->JOIN('core_tercero cerp','ceap.id_tercero =cerp.id_tercero'); 
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision');
    $this->db->JOIN('cex_agenda_dia_detalle agdd','caa.id_agenda_dia_detalle = agdd.id_agenda_dia_detalle');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio=agdd.id_agenda_consultorio');
    $this->db->JOIN('cex_agenda_agenda_dia aad','aadc.id_agenda_dia=aad.id_agenda_dia');
    $this->db->JOIN('core_tipo_documentos ctp','ctp.id_tipo_documento = ct.id_tipo_documento');
    $this->db->WHERE('id',$id_cita);
    return $this->db->GET()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function numero_diagnosticos_cita($id_cita)
{
    $this->db->from('cex_atencion_diagnostico');
    $this->db->where('id_cita',$id_cita);
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function numero_datos_hce_cita($id_cita)
{
    $this->db->from('cex_atencion_hce');
    $this->db->where('id_cita',$id_cita);
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function numero_datos_ordenes_medicamentos($id_cita)
{
    $this->db->from('cex_atencion_orde_medicamentos');
    $this->db->where('id_atencion',$id_cita);
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function numero_datos_ordenes_ayudas_diagnosticas($id_cita)
{
    $this->db->from('cex_atencion_orde_cups');
    $this->db->where('id_atencion',$id_cita);
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function exite_incapacidad($id_cita)
{
    $this->db->from('cex_atencion_incapacidad');
    $this->db->where('id_atencion',$id_cita);
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function existe_remision($id_cita)
{
    $this->db->from('cex_atencion_remision');
    $this->db->where('id_atencion',$id_cita);
    $this->db->where("(tipo_cita='prioritaria' OR tipo_cita='no_prioritaria')");
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function existe_control($id_cita)
{
    $this->db->from('cex_atencion_remision');
    $this->db->where('id_atencion',$id_cita);
    $this->db->where('tipo_cita','control');
    return $this->db->count_all_results();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function agregar_medicamento_pos_orden($id_atencion, $atc,$dosis,$id_unidad,
                                       $frecuencia,$id_frecuencia,$id_via,$observacion)
{
    $insert=array('id_atencion'=>$id_atencion, 'atc'=>$atc,'dosis'=>$dosis,
                  'id_unidad'=>$id_unidad,'frecuencia'=>$frecuencia,
                  'id_frecuencia'=>$id_frecuencia,'id_via'=>$id_via,
                  'observacionesMed'=>$observacion,'pos'=>'SI','estado'=>'Nuevo');
    $this->db->insert('cex_atencion_orde_medicamentos',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
function agregar_medicamento_nopos_orden($id_atencion, $atc,$dosis,$id_unidad,
                                       $frecuencia,$id_frecuencia,$id_via,$observacion)
{
    $insert=array('id_atencion'=>$id_atencion, 'atc'=>$atc,'dosis'=>$dosis,
                  'id_unidad'=>$id_unidad,'frecuencia'=>$frecuencia,
                  'id_frecuencia'=>$id_frecuencia,'id_via'=>$id_via,
                  'observacionesMed'=>$observacion,'pos'=>'NO','estado'=>'Nuevo');
    $this->db->insert('cex_atencion_orde_medicamentos',$insert);
}


///////////////////////////////////////////////////////////////////////////////
function agregar_ayuda_diagnostica($cups, $observacionesCups,$cantidadCups,$id_atencion)
{
    $insert=array(
                    'cups'=>$cups, 'observacionesCups'=>$observacionesCups,
                    'cantidadCups'=>$cantidadCups,'id_atencion'=>$id_atencion
                  );
    $this->db->insert('cex_atencion_orde_cups',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function diagnostico_principal($id_cita)
{
    $this->db->SELECT('id_diagnostico');
    $this->db->from('cex_atencion_diagnostico');
    $this->db->WHERE('id_cita',$id_cita);
    $this->db->WHERE('principal','1');
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function crear_incapacidad($id_atencion, $id_diagnostico,$observacion, 
                           $fecha_inicio, $duracion)
{
    $insert=array('id_atencion'=>$id_atencion,
                  'id_diagnostico'=>$id_diagnostico,
                  'observacion'=>$observacion,
                  'fecha_inicio'=>$fecha_inicio,
                  'duracion'=>$duracion);
    $this->db->insert('cex_atencion_incapacidad',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function crear_remision( $id_atencion,$motivo_remision,
                                             $observacion,$especialidad,
                                             $prioridad,$otra_especialidad)
{
    $insert=array('id_atencion'=>$id_atencion,
                  'motivo_remision'=>$motivo_remision,
                  'observacion'=>$observacion,
                  'id_especialidad_remite'=>$especialidad,
                  'tipo_cita'=>$prioridad);
    if($especialidad==999)
        $insert['otra_especialidad']=$otra_especialidad;
    $this->db->insert('cex_atencion_remision',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function crear_cita_control( $id_atencion,$dias,$observacion,$pin)
{
    $insert=array('id_atencion'=>$id_atencion,
                  'dias_cita_control'=>$dias,
                  'observacion'=>$observacion,
                  'tipo_cita'=>'control',
                  'pin'=>$pin);
    $this->db->insert('cex_atencion_remision',$insert);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function atenciones_paciente($id_paciente)
{
    $this->db->SELECT("aad.fecha,ce.descripcion especialidad,
                      ctm.primer_nombre, ctm.segundo_nombre,
                      ctm.primer_apellido, ctm.segundo_apellido, cr.id");
    $this->db->FROM("cex_cita_remisiones cr");
    $this->db->JOIN('core_tercero ct','cr.id_tercero=ct.id_tercero');
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision');
    $this->db->JOIN('cex_agenda_dia_detalle agdd',
                    'caa.id_agenda_dia_detalle=agdd.id_agenda_dia_detalle');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc',
                    'agdd.id_agenda_consultorio=aadc.id_agenda_consultorio' );
    $this->db->JOIN('cex_agenda_agenda_dia aad','aadc.id_agenda_dia=aad.id_agenda_dia');
    $this->db->JOIN('core_medico cm','cm.id_medico=agdd.id_especialista');
    $this->db->JOIN('core_tercero ctm','cm.id_tercero=ctm.id_tercero');
    $this->db->JOIN('core_especialidad ce','ce.id_especialidad=cm.id_especialidad');
    $this->db->WHERE('cr.estado','atendida');
    $this->db->WHERE('cr.id_paciente',$id_paciente);
    return $this->db->get()->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function datos_diagnosticos($codigo_diagnostico)
{
    $this->db->SELECT('diagnostico');
    $this->db->from('core_diag_item');
    $this->db->WHERE('id_diag',$codigo_diagnostico);
    return $this->db->get()->row_array();
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function ultima_atencion_paciente($paciente)
{
    $this->db->SELECT('ce.descripcion especialidad');
    $this->db->SELECT_MAX('aad.`fecha','fecha_atencion');
    $this->db->FROM('cex_cita_remisiones cr');
    $this->db->JOIN('cex_citas_asignadas_agenda caa','cr.id=caa.id_remision');
    $this->db->JOIN('cex_agenda_dia_detalle agdd','agdd.id_agenda_dia_detalle=caa.id_agenda_dia_detalle');
    $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc','aadc.id_agenda_consultorio= agdd.id_agenda_consultorio');
    $this->db->JOIN('cex_agenda_agenda_dia aad','aad.id_agenda_dia=aadc.id_agenda_dia');
    $this->db->JOIN('core_especialidad ce','cr.id_especialidad=ce.id_especialidad');
    $this->db->WHERE('cr.id_paciente',$paciente);
    return $this->db->get()->row_array();
}
	
	//////////////////////////////////////////////////////
	function obtenerMediOrdenNoPos($id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->where('pos','NO');
		$result = $this->db->get('cex_atencion_orde_medicamentos');
		return $result->result_array();	
	}
///////////////////////////
	//////////////////////////////////////////////////////
	function obtenerMediOrdenNoPosId($id_orden_medicamento,$id_atencion)
	{
		$this->db->where('id_atencion',$id_atencion);
		$this->db->where('id',$id_orden_medicamento);
		$this->db->where('pos','NO');
		$result = $this->db->get('cex_atencion_orde_medicamentos');
		return $result->result_array();	
	}
///////////////////////////

	function formatoNoPosDb($d)
	{
		if(count($d['atcNoPos']) > 0 && strlen($d['atcNoPos'][0]) > 0)
		{
			for($i=0;$i<count($d['atcNoPos']);$i++)
			{
				$insert = array(
				'atcNoPos' => $d['atcNoPos'][$i], 
				'resumen_historia' => $d['resumen_historia'],   
				'dias_tratamiento' => $d['dias_tratamiento'][$i],
				'dosis_diaria' => $d['dosis_diaria'][$i],
				'cantidad_mes' => $d['cantidad_mes'][$i], 
				'ventajas' => $d['ventajas'][$i],
				'id_usuario' => $this -> session -> userdata('id_usuario'),
				'fecha' => date('Y-m-d H:i:s'),
				'id_atencion' => $d['id_atencion'],
				'id_medicamento' => $d['id_medicamento'],
				'justificacion' => $d['justificacion'],
				

				); 
				$this -> db -> insert('cex_orde_med_no_pos',$insert);
			}
		}
				
		if(count($d['atc_pos']) > 0 && strlen($d['atc_pos'][0]) > 0)
		{
			for($i=0;$i<count($d['atc_pos']);$i++)
			{		
				$insert = array(
				'atc_pos' => $d['atc_pos'][$i], 
				'atcNoPosSus' => $d['atcNoPosSus'][$i],   
				'dias_tratamientoPos' => $d['dias_tratamientoPos'][$i],
				'dosis_diariaPos' => $d['dosis_diariaPos'][$i],
				'cantidad_mesPos' => $d['cantidad_mesPos'][$i], 
				'resp_clinica' => $d['resp_clinica'][$i],
				'resp_clinica_cual' => $d['resp_clinica_cual'][$i],
				'contraindicacion' => $d['contraindicacion'][$i],
				'contraindicacion_cual' => $d['contraindicacion_cual'][$i],
				'id_atencion' => $d['id_atencion'],
				'id_medicamento' => $d['id_medicamento'],
				); 
				$this -> db -> insert('cex_orde_med_sustitutos',$insert);
			}
		}
	}
	
//////////////////////////////////////////////////////
	function datospersonalespaciente($id_tercero)
	{
	    $this->db->from('core_tercero');
    $this->db->WHERE('id_tercero',$id_tercero);
    return $this->db->get()->row_array();
	}	
	
	
//////////////////////////////////////////////////////
	function DiagnosticosCita($id_atencion)
	{
	    $this->db->from(' cex_atencion_diagnostico');
    $this->db->WHERE('id_cita',$id_atencion);
    return $this->db->get()->result_array();
	}	
	
	
	//////////////////////////////////////////////////////
	//  capturmamos los datos guardados en la tabla cex_orde_med_no_pos para imprimir la solicitud del medicamento
	//  
	function Datosmedicamentonopos($id_medicamento,$id_atencion)
	{
	    $this->db->from('cex_orde_med_no_pos');
    $this->db->WHERE('id_medicamento',$id_medicamento);
	$this->db->WHERE('id_atencion',$id_atencion);
    return $this->db->get()->result_array();
	}	
///////////////////////////////////
	function Datosmedicamentosustituto($id_medicamento,$id_atencion)
	{
	    $this->db->from('cex_orde_med_sustitutos');
    $this->db->WHERE('id_medicamento',$id_medicamento);
	$this->db->WHERE('id_atencion',$id_atencion);
    return $this->db->get()->result_array();
	}	
///////////////////////////////////

////////////////////////////////////////
}