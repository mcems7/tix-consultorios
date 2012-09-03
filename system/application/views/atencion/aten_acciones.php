<script type="text/javascript">
    function validarFormulario()
    {
        if(confirm('Finalizar Atención del Paciente ¿Esta seguro que desea continuar?'))
            return true;
        return false;
    }
</script>
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
</table>