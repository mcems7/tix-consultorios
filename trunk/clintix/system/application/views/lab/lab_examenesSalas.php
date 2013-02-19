<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
  obtenerSala();           
});


////////////////////////////////////////////////////////////////////////////////

function obtenerSala()
{
  var sala = $('salasMed').value;
  if(sala == 0){
    return false;
  }
  
  var var_url = '<?=site_url()?>/lab/main/listadoPacientesSala';
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
    onFailure: function(){alert('Error ejecutando ajax!');}
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
<h1 class="tituloppal">Laboratorio Clinico</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:right">
Servicios:&nbsp;
<select name="salasMed" id="salasMed" onchange="obtenerSala()">
  <option value="0">-Seleccione uno-</option>
  <option value="12">Urgencias adultos</option>
  <option value="13">Urgencias pediatría</option>
  <option value="14">Urgencias ginecologia</option>
  <option value="15">Urgencias psiquiatría</option>
  <option value="16">Observación adultos</option>
  <option value="17">Observación pediatría</option>
  <option value="18">Observación psiquiatría</option>
</select>&nbsp;Estado de la Solicitud:&nbsp;
<select name="estado" id="estado" onchange="obtenerSala()">
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