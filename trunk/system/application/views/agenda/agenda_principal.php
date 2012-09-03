<script type="text/javascript">
var idParametroActivo="radio_1";
</script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
  if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}
function asignarComoActivo(boton)
{
    if(confirm('¿Realmente Desea Asignar como Configuración Activa para Crear Agendas Médicas?'))
     {
         modificarEstado(boton.value);
     }
    else
        {
            document.getElementById(idParametroActivo).checked=true;
            document.getElementById(idParametroActivo).blur();
        }
}
////////////////////////////////////////////////////////////////////////////////
function modificarEstado(id)
{
    var var_url = '<?=site_url()?>/agenda/main/asignarParametroActivo/'+id;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
		onSuccess: function(html){ idParametroActivo="radio_"+id;
                                            document.getElementById(idParametroActivo).checked=true;
                                            document.getElementById(idParametroActivo).blur();
                                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Consulta Externa - Agenda</h1>
<h2 class="subtitulo">Parametrización Agenda</h2>
<center>
 <?php
$attributes = array('id'=> 'formulario','name'=> 'formulario',
                    'method' => 'post','onsubmit'=> 'return validarFormulario()');
echo form_open('agenda/main/agregarParametroAgenda',$attributes);
?>
    <table width="100%" class="tabla_form">
<tr><th colspan="2">Parametro Agenda</th></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <td class="campo">Hora Inicio:</td><td><?=form_input('horaInicio')?></td>
  <td class="campo">Hora Fin:</td><td><?=form_input('horaFin')?></td>
  <td class="campo">Aplica Sábado:</td><td><?=form_checkbox('aplica_sabado', '1', FALSE);?></td>
  <td class="campo">Aplica Domingo:</td><td><?=form_checkbox('aplica_domingo', '1', FALSE);?></td>
</tr>
</table>
</td></tr>
<tr><td colspan="2">
 <?=form_submit('boton', 'Guardar')?>
<?=form_close();?>
<table width="90%" class="tabla_interna">
    <tr>
              <td class="campo_centro">Usar</td>
              <td class="campo_centro">Hora Inicio</td>
              <td class="campo_centro">Hora Fin</td>
              <td class="campo_centro">S&aacute;bado</td>
              <td class="campo_centro">Domingo</td>
            </tr>
    <?php 
        foreach($listaParametros as $itemArray)
        {
           ?>
            <tr>
              <td><?=form_radio('activo', $itemArray['id'],$itemArray['activo']==1?TRUE:FALSE,'onClick="asignarComoActivo(this)" id="radio_'.$itemArray['id'].'"')?></td>
              <td><?=$itemArray['horaInicio']?></td>
              <td><?=$itemArray['horaFin']?></td>
              <td><?=form_checkbox('aplica_sabado', '1', $itemArray['aplica_sabado']==1?TRUE:FALSE,'DISABLED');?></td>
              <td><?=form_checkbox('aplica_domingo', '1',$itemArray['aplica_domingo']==1?TRUE:FALSE,'DISABLED');?></td>
            </tr>
           <?php
           if($itemArray['activo']==1)
           {?>
               <script type="text/javascript"> idParametroActivo="radio_<?=$itemArray['id']?>"; </script>
               <?php
           }
        }
    ?>
</table>
</td></tr>
    </table>
</center>

