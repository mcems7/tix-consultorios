<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Gestion_atencion
 *Tipo: controlador
 *Descripcion: Permite gestionar el proceso de atencion del paciente en el servicio
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 16 de septiembre de 2010
*/
class Hce_consulta extends Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
        parent::Controller();			
        $this -> load -> model('urg/urgencias_model');
        $this -> load -> model('hce/hce_model');
        $this -> load -> model('core/medico_model');
        $this -> load -> model('core/paciente_model');
        $this -> load -> model('core/tercero_model');
        $this -> load -> model('inter/interconsulta_model'); 
        $this -> load -> model('hce/hce_consulta_model');
        $this -> load -> helper('text');
        $this->load->model('atenciones/atenciones_model');
        $this->load->model('agenda/consultorios_model');
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('url');
        $this->load->library('lib_edad');
        $this->load->model('lab/laboratorio_model'); 
        $this->load->model('urg/urgencias_model'); 
        $this->load->model('core/paciente_model');
        $this->load->model('citas/citas_model');
	}
/////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function generar_impresion_formato_hce($id,$datos)
{
	
    return $this->generar_impresion_formato($id, $datos, 1);
}
///////////////////////////////////////////////////////////////////////////////
//Función:      generar_impresion_formato
//Visibilidad:  privada
//Descripción:  Función recursiva que permite la impresión de los elementos
//              de la historia clínica electrónica.
///////////////////////////////////////////////////////////////////////////////
private function generar_impresion_formato($id,$datos,$nivel)
{
    $resultado=array();
    $cadena_texto="";
    $contador=0;
    if($nivel==1)
        $resultado=$this->hce_consulta_model->cargar_items_hce($id);
    else
       $resultado=$this->hce_consulta_model->cargar_items_hijos_hce($id);
    foreach($resultado as $item)
    {
       $cadena_texto_temporal="";
        if($item['tipo']=='clinico')
            $cadena_texto_temporal=$this->imprimir_formato('titulo',$item['tipo_dato'],$item['nombre'],$this->valor_asociado_clinico($item['id'], $datos),$contador);
        else
        {
            $cadena_texto_temporal=$this->imprimir_formato('titulo_contenedor',$item['tipo_dato'],$item['nombre'],'',$contador);
            $cadena_texto_temporal.=$this->generar_impresion_formato($item['id'],$datos,$nivel+1);
            $cadena_texto_temporal=$this->imprimir_formato_resaltar_contenedor($cadena_texto_temporal,$nivel+1);
        }
        $cadena_texto.=$this->determinar_ubicacion_dato($cadena_texto_temporal,$item['tipo_dato'],$contador);
    }
    return $cadena_texto;
}
////////////////////////////////////////////////////////////////////////////////
//Función:      adición_texto
//Visibilidad:  privada
//Descripción:  Determina el lugar de impresión del dato. Números y listas 
//              se imprimen de forma líneal hasta 4 posiciones; textos y 
//              contenedores se imprimen en una nueva línea.
////////////////////////////////////////////////////////////////////////////////
private function determinar_ubicacion_dato($texto,$tipo,&$contador)
{
    $adicion='';
    if($tipo!='texto'&&$tipo!='sindato')
      {
        if($contador==0)
            $adicion='<tr><td><table width="100%"><tr>';
        else if($contador==4)
            $adicion='</tr></table></td></tr><tr><td><table width="100%"><tr>';
        $contador=$contador==4?1:++$contador;      
      }
    else if($contador!=0)
      {
         $adicion='</tr></table></td></tr>';
         $contador=0;
      }
   return $adicion.$texto;
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
private function imprimir_formato_resaltar_contenedor($cadena,$nivel)
{
    return "<tr><td><table border=1 rules=none width=100%>
           $cadena</table></td></tr>";
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
private function imprimir_formato($opcion,$tipo_dato,$titulo,$valor,$contador)
{
    $clase='"campo_izquierda"';
    $color=$tipo_dato=='sindato'?'style="background-color:#CCC"':'';
    
    $imprimir="<tr $color><td class=$clase>$titulo</td></tr>" ;
    $imprimir.=$tipo_dato=='sindato'?'':"<tr><td>$valor</td></tr>" ;
    
    if($tipo_dato!='texto'&&$tipo_dato!='sindato') 
        $imprimir='<td><table>'.$imprimir.'</table></td>';
    
    return $imprimir;
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
private function valor_asociado_clinico($id_clinico,$datos)
{
  foreach($datos as $item)
   {
   if($item['id_item_hc']==$id_clinico)
       return $item['valor'];
   }
   return "NO DILIGENCIADO";
}
}
?>