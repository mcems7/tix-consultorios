<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: agenda_model
 *Tipo: modelo
 *Descripcion: Contiene todas las operaciones necesarias de la base de datos
 *             para la gestión de la agenda.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
////////////////////////////////////////////////////////////////////////////////
class agenda_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
        $this->load->database();
        $this->load->helper('array');
    }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
    function cargar_parametros($id=null)
    {
        $this->db->SELECT('id, horaInicio, horaFin, activo, 
                           activo, aplica_sabado, aplica_domingo, duracion_intervalo');
	$this->db->FROM('cex_agenda_parametros');
	$this->db->WHERE('cex_agenda_parametros.activo','1');
	return $this->db->get()->result_array();
    }
    function listaParametros()
    {
        $this->db->SELECT('id, horaInicio, horaFin, activo, 
                           activo, aplica_sabado, aplica_domingo');
	$this->db->FROM('cex_agenda_parametros');
        return $this->db->get()->result_array();
    }
    function ingresarNuevoParametroAgenda($d)
    {
        $insert=elements(Array('horaInicio','horaFin','aplica_sabado',
                               'aplica_domingo'),$d);
        $insert['activo']=1;
        $insert['aplica_sabado']=$insert['aplica_sabado']==''?0:1;
        $insert['aplica_domingo']=$insert['aplica_domingo']==''?0:1;
        $this ->db->insert('agenda_parametros',$insert);
    }
    function establecerParametroComoActivo($id)
    {
        $update=array('activo'=>0);
        $this->db->where('activo',1);
        $this->db->update('agenda_parametros',$update);
        
        $update=array('activo'=>1);
        $this->db->where('id',$id);
        $this->db->update('agenda_parametros',$update);
    }
   
 function datosAgenda($fecha)
 {
     
     $this->db->SELECT('adt.id_agenda_consultorio, aadc.id_consultorio,
                        adt.orden_intervalo, adt.hora,
                        ct.primer_nombre, ct.segundo_nombre, 
                        ct.primer_apellido,
                        ct.segundo_apellido, ce.descripcion especialidad');
      $this->db->FROM('cex_agenda_dia_detalle adt');
      $this->db->JOIN('core_medico cm','adt.id_especialista = cm.id_medico');
      $this->db->JOIN('core_tercero ct','cm.id_tercero= ct.id_tercero');
      $this->db->JOIN('core_especialidad ce ','cm.id_especialidad= ce.id_especialidad');
      $this->db->JOIN('cex_agenda_agenda_dia_consultorio aadc ','aadc.id_agenda_consultorio= adt.id_agenda_consultorio');
      $this->db->JOIN('cex_agenda_agenda_dia aad','aad.id_agenda_dia=aadc.id_agenda_dia');
      $this->db->where('fecha',$fecha);
      
      return $this->db->get()->result_array();
	//$this->db->WHERE('agenda_parametros.activo','1');
 }
 
 function disponibilidades_medicos($id_consultorio)
 {
    return $query= $this->db->query("SELECT a.total_horas_mes - (SELECT sum(duracion) 
                                                                 FROM cex_agenda_dia_detalle 
                                                                 WHERE id_especialista=a.id_core_medico)
                                                                 horas_disponibles,
                                    a.total_horas_mes horas_disponibles_mes, 
                                    (SELECT sum(duracion) 
                                     FROM cex_agenda_dia_detalle) horas_programadas,
                                     a.id_core_medico, CONCAT(ct.primer_nombre,' ',ct.primer_apellido) nombre_medico
                                     FROM cex_agenda_disponibilidades a
                                          INNER JOIN core_medico cm on a.id_core_medico=cm.id_medico
                                          INNER JOIN core_tercero ct on cm.id_tercero=ct.id_tercero
                                     WHERE a.total_horas_mes<>0 and a.estado=1
                                           AND cm.id_especialidad in (SELECT tf.id_especialidad
                                                                      FROM cex_agenda_consultorios_especialidades tf
                                                                      WHERE tf.id_consultorio = $id_consultorio)"
                                     )->result_array();
 }
 function disponibilidades_medicos_especialidad($id_especialidad)
 {
     $sql_query="SELECT IFNULL(a.total_horas_mes - (SELECT sum(duracion) 
                                                                 FROM cex_agenda_dia_detalle 
                                                                 WHERE id_especialista=a.id_core_medico),a.total_horas_mes)
                                                                 horas_disponibles,
                                    a.total_horas_mes horas_disponibles_mes, 
                                    (SELECT sum(duracion) 
                                     FROM cex_agenda_dia_detalle) horas_programadas,
                                     a.id_core_medico, CONCAT(ct.primer_nombre,' ',segundo_nombre,' ',ct.primer_apellido,' ',segundo_apellido) nombre_medico,
                                     ce.`descripcion` especialidad
                                     FROM cex_agenda_disponibilidades a
                                          INNER JOIN core_medico cm on a.id_core_medico=cm.id_medico
                                          INNER JOIN core_tercero ct on cm.id_tercero=ct.id_tercero
                                          INNER JOIN `core_especialidad` ce on ce.`id_especialidad`= cm.`id_especialidad`
                                     WHERE a.total_horas_mes<>0 and a.estado=1";
     if($id_especialidad!="-1")
        $sql_query.=" AND cm.id_especialidad =$id_especialidad";
     return $this->db->query($sql_query)->result_array();
 }
 //////////////////////////////////////////////////////////////////////////////
 function agenda_dia($dia)
 {
     $this->db->SELECT('id_agenda_dia, id_parametro_agenda');
     $this->db->FROM('cex_agenda_agenda_dia');
     $this->db->WHERE('fecha',$dia);
     return $this->db->get()->result_array();
 }
 function agenda_consultorio_dia($dia,$id_consultorio)
 {
     $agenda_dia=$this->agenda_dia($dia);
     //echo "valor de la agenda: "; print_r()
     if(count($agenda_dia)!=0)
     {
         $this->db->SELECT('id_agenda_consultorio');
         $this->db->FROM('cex_agenda_agenda_dia_consultorio');
         $this->db->WHERE('id_agenda_dia',$agenda_dia[0]['id_agenda_dia']);
         $this->db->WHERE('id_consultorio',$id_consultorio);
         return $this->db->get()->result_array();
     }
     return array();
 }
 function agregar_agenda_consultorio_dia($id_agenda_dia, $id_consultorio)
 {
       $insert=Array('id_agenda_dia'=>$id_agenda_dia,
                    'id_consultorio'=>$id_consultorio);
       $this ->db->insert('cex_agenda_agenda_dia_consultorio',$insert);
       return $this->db->insert_id();
 }
  function agregar_agenda_dia($dia)
 {
    $d=array(
         'fecha'=>$dia
     );
     $this ->db->insert('cex_agenda_agenda_dia',$d);
 }
 function agregar_detalle_agenda($id_medico, $id_consultorio, $intervalo, $dia,$hora,$duracion)
 {
     $id_agenda_dia=$this->agenda_dia($dia);
     if(count($id_agenda_dia)==0)
     {
         $this->agregar_agenda_dia($dia);
         $id_agenda_dia=$this->agenda_dia($dia);
     }
     print_r($id_agenda_dia);
     $agenda_consultorio=$this->agenda_consultorio_dia($dia,$id_consultorio );
     $id_agenda_consultorio=-1;
     print_r($agenda_consultorio);
     if(count($agenda_consultorio)!=0)
         $id_agenda_consultorio=$agenda_consultorio[0]["id_agenda_consultorio"];
     else
         $id_agenda_consultorio=$this->agregar_agenda_consultorio_dia ($id_agenda_dia[0]['id_agenda_dia'], $id_consultorio);
         
     $insert=array(
         'id_agenda_consultorio'=>$id_agenda_consultorio,
         'id_especialista'=>$id_medico,
         'orden_intervalo'=>$intervalo,
         'hora'=>$hora,
         'duracion'=>$duracion
     );
     //print_r($insert);
     $this->db->insert('cex_agenda_dia_detalle',$insert);
 }
 function agregar_agenda_consultorio($fecha)
 {
     
 }
 function agenda_consultorio_dia_no($dia, $id_consultorio)
 {
    return $this->db->query(
            "SELECT id_agenda_consultorio from cex_agenda_agenda_dia_consultorio a
            WHERE a.id_agenda_dia in (SELECT b.id_agenda_dia 
                                      FROM  cex_agenda_agenda_dia b 
                                      WHERE b.fecha='2011-09-01')
            AND a.id_agenda_consultorio=1")->result_array();
 }
 function agenda_intervalo_dia_consultorio($dia,$consultorio)
 {
     return $this->db->query(
                "SELECT a.id_agenda_dia_detalle from cex_agenda_dia_detalle a
                 WHERE a.id_agenda_consultorio in (
                                SELECT b.id_agenda_consultorio
                                FROM cex_agenda_agenda_dia_consultorio b
                                WHERE b.id_agenda_dia in(SELECT c.id_agenda_dia 
                                     			 FROM  cex_agenda_agenda_dia c 
                                     			 WHERE c.fecha='2011-09-01')
                                    
					              )
            AND a.orden_intervalo=1")->result_array();
 }
 function agenda_agenda_medico()
 {
     "select a.`orden_intervalo`, c.`fecha`, d.`id_consultorio`,
	   d.`descripcion`,c.`dia`

from cex_agenda_dia_detalle a 
         inner join `cex_agenda_agenda_dia_consultorio` b
		 on a.`id_agenda_consultorio`=b.`id_agenda_consultorio`
         inner join `cex_agenda_agenda_dia` c 
         on b.`id_agenda_dia`= c.`id_agenda_dia`
         inner join `cex_agenda_consultorios` d
         on b.`id_consultorio`=d.`id_consultorio`";
 }
 function listar_especialidades_por_consutorio($id_consultorio)
 {
     
 }
 function buscar_detalle_agenda($fecha, $hora,$id_consultorio)
 {
     return array();
 }
 function lista_especialidades_contratadas()
 {
     $this->db->SELECT('ace.id_especialidad, ce.descripcion');
     $this->db->FROM('cex_agenda_consultorios_especialidades ace');
     $this->db->JOIN('core_especialidad ce', 'ace.id_especialidad=ce.id_especialidad');
     $this->db->WHERE('ace.estado',1);
     return $this->db->get()->result_array();
 }
 //////////////////////////////////////////////////////////////////////////////
 function agenda_medicos($fecha_inicial, $fecha_final, $id_especialista)
 {
     $this->db->SELECT("agd.fecha, ac.descripcion consultorio,
                        agdd.orden_intervalo, agd.id_agenda_dia");
     $this->db->distinct();
     $this->db->FROM("cex_agenda_agenda_dia agd");
     $this->db->JOIN("cex_agenda_agenda_dia_consultorio agdc","agd.id_agenda_dia = agdc.id_agenda_dia");
     $this->db->jOIN("cex_agenda_consultorios ac","ac.id_consultorio = agdc.id_consultorio");
     $this->db->JOIN("cex_agenda_dia_detalle agdd","agdd.id_agenda_consultorio=agdc.id_agenda_consultorio");
     $this->db->WHERE("agd.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'");
     $this->db->WHERE("agdd.id_especialista",$id_especialista);
     $this->db->ORDER_BY("agd.fecha, agdd.orden_intervalo");
     $resultado=$this->db->get()->result_array();
     return $resultado;
 }
 function agenda_medicos_fechas($fecha_inicial, $fecha_final, $id_especialista)
 {
     $this->db->SELECT("agd.fecha");
     $this->db->distinct();
     $this->db->FROM("cex_agenda_agenda_dia agd");
     $this->db->JOIN("cex_agenda_agenda_dia_consultorio agdc","agd.id_agenda_dia = agdc.id_agenda_dia");
     $this->db->jOIN("cex_agenda_consultorios ac","ac.id_consultorio = agdc.id_consultorio");
     $this->db->JOIN("cex_agenda_dia_detalle agdd","agdd.id_agenda_consultorio=agdc.id_agenda_consultorio");
     $this->db->WHERE("agd.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'");
     $this->db->WHERE("agdd.id_especialista",$id_especialista);
     $this->db->ORDER_BY("agd.fecha");
     $resultado=$this->db->get()->result_array();
     return $resultado;
 }
 function suspender_citas_agenda_intervalos($fecha, $id_consultorio, $intervalo_inicial, $intervalo_final)
 {
     $consulta="SELECT caa.`id_remision`
        from `cex_citas_asignadas_agenda` caa 
        inner join `cex_agenda_dia_detalle` agdd on caa.`id_agenda_dia_detalle` =agdd.`id_agenda_dia_detalle`       
        inner join `cex_agenda_agenda_dia_consultorio` aadc on aadc.`id_agenda_consultorio`=agdd.`id_agenda_consultorio`
        inner join `cex_agenda_agenda_dia` aad on  aad.`id_agenda_dia`=aadc.id_agenda_dia
        WHERE  aad.fecha= '$fecha' and aadc.`id_consultorio`=$id_consultorio
             and (agdd.`orden_intervalo` between $intervalo_inicial and $intervalo_final) ";
     $resultado=$this->db->query($consulta)->result_array();
     if(count($resultado)!=0)
     {
          $lista=array();
         foreach($resultado as $item)
         {
             $lista[]=$item['id_remision'];
         }
         $update=array('estado'=>'autorizada');
         $this->db->WHERE_IN('id',$lista);
         $this->db->UPDATE('cex_cita_remisiones',$update);
         $this->db->WHERE_IN('id_remision',$lista);
         $this->db->DELETE('cex_citas_asignadas_agenda');
         
     }
    $select="select `cex_agenda_dia_detalle`.`id_agenda_dia_detalle` id
            from  `cex_agenda_dia_detalle` 
            inner join `cex_agenda_agenda_dia_consultorio` aadc ON cex_agenda_dia_detalle.`id_agenda_consultorio`=aadc.`id_agenda_consultorio`
            inner join `cex_agenda_agenda_dia` aagd ON aadc.`id_agenda_dia`=aagd.`id_agenda_dia`
            WHERE aagd.`fecha`='$fecha' and 
                        (`cex_agenda_dia_detalle`.`orden_intervalo` between $intervalo_inicial and $intervalo_final) and
                        aadc.`id_consultorio`=$id_consultorio";
   $resultado= $this->db->query($select)->result_array();
   if(count($resultado)!=0)
   {
       $lista=array();
       foreach($resultado as $item)
       {
           $lista[]=$item['id'];
       }
       $this->db->WHERE_IN('id_agenda_dia_detalle',$lista);
       $this->db->DELETE('cex_agenda_dia_detalle');
   }
 }
 //////////////////////////////////////////////////////////////////////////////
 //
 //////////////////////////////////////////////////////////////////////////////
 function medico_ocupa_consultorio_hora($id_medico, $intervalo_inicial,$intervalo_final,$fecha)
 {
     $query="select count(*) total
            from `cex_agenda_agenda_dia` aad
            inner join `cex_agenda_agenda_dia_consultorio` aadc on aad.`id_agenda_dia`=aadc.`id_agenda_dia`
            inner join `cex_agenda_dia_detalle` agdd on aadc.`id_agenda_consultorio`=agdd.`id_agenda_consultorio`
            where agdd.`id_especialista`=$id_medico 
            and aad.fecha='$fecha'
            and agdd.`orden_intervalo` between $intervalo_inicial and $intervalo_final";
      $total= $this->db->query($query)->row_array();
      return $total['total'];
 }
 
 
 /*
 Se captura la agenda del consultorio dia
 */
 function CapturaAgendaConsultorio($fecha, $intervalo_inicial,$intervalo_final,$id_consultorio)
 {
	$this->db->select('cex_agenda_agenda_dia_consultorio.id_agenda_consultorio');	 
  $this->db->from('cex_agenda_agenda_dia');
  $this->db->join('cex_agenda_agenda_dia_consultorio','cex_agenda_agenda_dia_consultorio.id_agenda_dia = cex_agenda_agenda_dia.id_agenda_dia');
  $this->db->where('fecha',$fecha);
  $this->db->where('id_consultorio',$id_consultorio);
  $result = $this->db->get();
  return $result->result_array(); 
 }
 //////////////////////////////////////////////////////////////////////////////
 //
 
 function BloquearAgenda($id_agenda_consultorio,$id_especialista)
 {
	  $update = array(
		  'bloqueado'=>'SI',
          );
			    $this->db->where('id_agenda_consultorio',$id_agenda_consultorio);
				 $this->db->where('id_especialista',$id_especialista);
	   			$this -> db -> update('cex_agenda_dia_detalle',$update);
			 }
 function DesbloquearAgenda($id_agenda_consultorio,$id_especialista)
 {
	  $update = array(
		  'bloqueado'=>'NO',
          );
			    $this->db->where('id_agenda_consultorio',$id_agenda_consultorio);
				 $this->db->where('id_especialista',$id_especialista);
	   			$this -> db -> update('cex_agenda_dia_detalle',$update);
			 }			  

 
 
 
 
}
 ?>