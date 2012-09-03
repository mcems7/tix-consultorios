<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
  obtenerPiso();           
});
////////////////////////////////////////////////////////////////////////////////
function obtenerPiso()
{
  
  var var_url = '<?=site_url()?>/far/far_hospi/listadoPacientesPiso';
  var ajax1 = new Request(
  {
    url: var_url,
    method: 'post',
    data:  $('formulario').toQueryString(),
    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_detalle_sala').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');
	$('div_precarga').style.display = "none";
	}
  });
  ajax1.send();   
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
                  'name'     => 'formulario',
          'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Servicio Farmaceutico</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:right">
Servicios:&nbsp;
<select name="id_servicio" id="id_servicio" onchange="obtenerPiso()">
    <option value="0">-Seleccione uno-</option>
<?php
foreach($servicios as $d)
{
	echo '<option value="'.$d['id_servicio'].'" selected="selected">'.$d['nombre_servicio'].'</option>';	
}
?>      
    </select>&nbsp;Estado de la Solicitud:&nbsp;
<select name="estado" id="estado" onchange="obtenerPiso()">
  <option value="0">Todas</option>
 <?php
  foreach($estados as $d)
  {
    echo '<option value="'.$d['id_estado'].'">'.$d['estado'].'</option>'; 
  }
 ?>
</select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_sala">
</div>
</td></tr>
<tr><td align="center">
<?
$data = array(  'name' => 'bv',
        'onclick' => 'regresar()',
        'value' => 'Volver',
        'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>
