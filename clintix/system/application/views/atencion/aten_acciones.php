<script type="text/javascript">
    function validarFormulario()
    {
        if(confirm('Finalizar Atención del Paciente ¿Esta seguro que desea continuar?'))
            return true;
        return false;
    }
</script>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos Paciente</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
    
       <tr > <td class="campo_izquierda">Fecha Nacimiento</td><td><?=$info_cita['fecha_nacimiento']?></td>
       <td class="campo_izquierda">Edad</td><td><?=$info_cita['edad']?></td></tr>
       <tr> 
        <td class="campo_izquierda">Documento</td><td><?=$info_cita['numero_documento']?></td>
        <td class="campo_izquierda">Nombre</td><td><?=$info_cita['primer_nombre']?> <?=$info_cita['segundo_nombre']?> <?=$info_cita['primer_apellido']?> <?=$info_cita['segundo_apellido']?></td> 
       </tr>
       <tr> 
        <td class="campo_izquierda">Departamento</td><td><?=$info_cita['departamento']?></td>
        <td class="campo_izquierda">Ciudad</td><td><?=$info_cita['municipio']?> </td> 
       </tr>
       <tr> 
        <td class="campo_izquierda">Direccion</td><td><?=$info_cita['direccion']?></td>
        <td class="campo_izquierda">Teléfono</td><td><?=$info_cita['telefono']?> </td> 
       </tr>
       <tr> 
        <td class="campo_izquierda">Celular</td><td><?=$info_cita['celular']?></td>
        <td class="campo_izquierda">Email</td><td><?=$info_cita['email']?> </td> 
       </tr>
</table>
    </td></tr>
</table>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Detalle Solicitud</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
       <tr> <td class="campo_izquierda">Fecha Solicitud</td><td><?=$info_cita['fecha_solicitud']?></td> </tr>    
       <tr> <td class="campo_izquierda">Tiempo Espera</td><td><?=$info_cita['tiempo_espera']?></td> </tr> 
           <?php 
           if($info_cita['estado']=='solicitada' && $info_cita['solicitud_prioritaria']=='prioritaria') 
           {
              ?>
       <tr> <td class="campo_izquierda">Prioritaria</td><td><?=valor_prioritaria($info_cita['solicitud_prioritaria'])?></td> </tr>    
       <tr> <td class="campo_izquierda">Justificación Prioridad</td><td><?=$info_cita['justificacion_solicitud_prioritaria']?></td> </tr> 
           <?php
           }
           ?>
       <tr> <td class="campo_izquierda">Entidad Encargada Pago</td><td><?=$info_cita['eps']?></td> </tr> 
       <tr> <td class="campo_izquierda">Entidad Remite</td><td><?=$info_cita['entidad_remite']?></td> </tr> 
       <tr> <td class="campo_izquierda">Especialidad</td><td><?=$info_cita['especialidad']?></td> </tr> 
       <tr> <td class="campo_izquierda">Médico Remite</td><td><?=$info_cita['medico_remite']?></td> </tr> 
       <tr> <td class="campo_izquierda">Motivo Remision</td><td><?=$info_cita['motivo_remision']?></td> </tr> 
       <tr> <td class="campo_izquierda">Motivo Consulta</td><td><?=$info_cita['motivo_consulta']?></td> </tr> 
       <tr> <td class="campo_izquierda">Enfermedad Actual</td><td><?=$info_cita['enfermedad_actual']?></td> </tr> 
       <tr> <td class="campo_izquierda">Antecedentes Personales</td><td><?=$info_cita['antecedentes_personales']?></td> </tr> 
       <tr> <td class="campo_izquierda">Antecedentes Familiares</td><td><?=$info_cita['antecedentes_familiares']?></td> </tr> 
       <tr> <td class="campo_izquierda">Revisión Sistemas</td><td><?=$info_cita['revision_sistemas']?></td> </tr> 
       <tr> <td class="campo_izquierda">Examen Físico</td><td><?=$info_cita['examen_fisico']?></td> </tr> 
       <tr> <td class="campo_izquierda">Impresiones Diagnósticas</td><td><?=$info_cita['impresiones_diagnosticas']?></td> </tr> 
       <tr> <td class="campo_izquierda">Paraclinicos Realizadas</td><td><?=$info_cita['paraclinicos_realizados']?></td> </tr> 
       <tr> <td class="campo_izquierda">Tratamientos Realizados</td><td><?=$info_cita['tratamientos_realizados']?></td> </tr> 
       <tr> <td class="campo_izquierda">Observaciones</td><td><?=$info_cita['observaciones']?></td> </tr> 
</table></td></tr>
<table width="100%" class="tabla_form">
<tr><th colspan="2"></th></tr>
<table width="100%" class="tabla_interna">
<tr>
  <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/lista_atenciones/<?=$info_cita['id_paciente']?>">Ver Otras Atenciones</a></td>
  <?php if($registrar_hce)
  {?>
  <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/registro_hce/<?=$info_cita['id_especialidad']?>/<?=$info_cita['id']?>">Registrar Historia Clínica Nueva</a></td>
  <?php }else {?>
  <td class="opcion">
      <table>
          <tr>
              <td class="opcion"  height="70px"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_paciente/<?=$info_cita['id']?>">Consultar Historia Clínica Actual</a></br></td>
          </tr>
          <tr>
              <?php
                $ruta=site_url().'/impresion/impresiones_consulta/imprimir_hce/'.$info_cita['id'];
              ?>
              <td class="opcion"><a href="#" onClick="Abrir_ventana('<?=$ruta?>'); return false">Imprimir</a></br></td>
          </tr>
      </table>
  </td>
  <?php } ?>
  <?php if($registrar_hce){?>
  <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/registro_hce/<?=$info_cita['id_especialidad']?>/<?=$info_cita['id']?>">Registrar Historia Clínica en Base a la Última</a></td>
  <?php } ?>
  <?php if(!$registrar_hce)
  {
      if($total_ordenes==0)
      {?>
        <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/registro_ordenes/<?=$info_cita['id']?>">Formulaciones y Órdenes</a></td>
        <?php
      }
      else
      {
          ?>
          <td class="opcion">
              <table>
                  <tr><td class="opcion"  height="70px">
                  <a href="<?=site_url()?>/hce/main_consulta_externa/hce_ordenes/<?=$info_cita['id']?>">Consultar Órdenes</a></td></tr>
                  <tr>
              <?php
                $ruta=site_url().'/impresion/impresiones_consulta/imprimir_ordenes/'.$info_cita['id'];
              ?>
              <td class="opcion"><a href="#" onClick="Abrir_ventana('<?=$ruta?>');return false">Imprimir</a></br></td>
                </tr>

              </table>
          </td>
          <?php
      }
    if($existe_remision==0)
      {
        ?>
          <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/registro_remision/<?=$info_cita['id']?>">Solicitar Interconsulta</a></td>
          <?php
      }
       else
      {
          ?>
          <td class="opcion">
              <table>
                  <tr><td class="opcion" height="70px"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_remision/<?= $info_cita['id']?>">Consultar Interconsulta</a></td></tr>
                  <tr>
              <?php
                $ruta=site_url().'/impresion/impresiones_consulta/imprimir_remision/'.$info_cita['id'];
              ?>
              <td class="opcion"><a href="#" onClick="Abrir_ventana('<?=$ruta?>'); return false">Imprimir</a></br></td>
                </tr>
              </table>
          </td>
          <?php
      }
      if(!$existe_incapacidad)
      {
      ?>
    <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/registro_incapacidad/<?=$info_cita['id']?>">Crear Incapacidad</a></td>
    <?php
      }
      else
      {
          ?>
    <td class="opcion">
        <table>
            <tr><td class="opcion"  height="70px"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_incapacidad/<?= $info_cita['id']?>">Consultar Incapacidad</a></td></tr>
            <tr>
              <?php
                $ruta=site_url().'/impresion/impresiones_consulta/imprimir_incapacidad/'.$info_cita['id'];
              ?>
              <td class="opcion"><a href="#" onClick="Abrir_ventana('<?=$ruta?>'); return false">Imprimir</a></br></td>
                </tr>
              </table>
    </td>        
    <?php
      }
       if(!$existe_control)
      {
      ?>
  <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/registro_cita_control/<?=$info_cita['id']?>">Solicitar Cita Control</a></td>
  <?php  
  }
      else
      {
          ?>
    <td class="opcion">
        <table><tr><td class="opcion"  height="70px"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_control/<?= $info_cita['id']?>">Consultar Cita Control</a></td></tr>
                  <tr>
              <?php
                $ruta=site_url().'/impresion/impresiones_consulta/imprimir_control/'.$info_cita['id'];
              ?>
              <td class="opcion"><a href="#" onClick="Abrir_ventana('<?=$ruta?>'); return false">Imprimir</a></br></td>
                </tr>
              </table>
          </td>
                
    <?php
      }
      
      ?>
  <td class="opcion"><a href="<?=site_url()?>/atencion/atenciones/finalizar_atencion/<?=$info_cita['id']?>" onClick="return validarFormulario()">Finalizar Atención</a></td>
   <?php } ?>
</tr>
</td></tr>
</table>
<?php 
if($ordenMedi!=null)
{
?>

<table width="100%" class="tabla_form">

<tr><td>
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">

<th colspan="3">
Formulario de medicamentos no-POS
</th>

<tr>
<td class="campo_centro">Medicamento</td>
<td class="campo_centro">Accion</td>
<td class="campo_centro">Imprimir</td>
</tr>
<?php
	$cont=1;
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		$d['pos'] = $this->urgencias_model->obtenerMedicamentoPos($d['atc']);
		$d['cont'] = $cont;
		
?>
	<td class="campo_centro"><?= $d['medicamento'] ?></td>
<td class="campo_centro"><?php echo anchor('/atencion/atenciones/SolicitudformatoNoPos/'.$d['id'].'/'.$id_atencion.'/'.$valor_temporal, 'Diligenciar',array('title'=>'Solicitar'));?></td>
<td class="campo_centro"><?php $data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/ImprimirMedicamentoNopos/'.$d['id'].'/'.$id_atencion)."')",
				'value' => 'Imprimir',
			
				'type' =>'button');
echo form_input($data); ?></td>
		
	<?php
    	
	
		$cont++;
	}
?>  
  </td></tr>
  </table>
  <?php
		}
   
   ?>
<tr><td colspan="3" class="linea_azul"></td></tr>                               
</table>
