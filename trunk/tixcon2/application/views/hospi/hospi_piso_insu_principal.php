<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerOrdenesServicio();					 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerOrdenesServicio()
{
	var var_url = '<?=site_url()?>/hospi/hospi_insumos/listadoOrdenesServicio';
	var ajax1 = new Request(
	{
		url: var_url,
		method:'post',
		evalScripts: true,
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_sala').set('html', html);
		$('div_precarga').style.display = "none";},
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
<h1 class="tituloppal">Unidad de hospitalizaci&oacute;n</h1>
<h2 class="subtitulo">Solicitud de insumos y dispositivos m&eacute;dicos</h2>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Servicio:<?=nbs()?>
<?php
$id = $this->session->userdata('id_servicio_insu_hosp');
?>
<select name="id_servicio" id="id_servicio" onchange="obtenerOrdenesServicio()">
    <option value="0">-Seleccione uno-</option>
<?php
foreach($servicios as $d)
{
	if($id == $d['id_servicio']){
	echo '<option value="'.$d['id_servicio'].'" selected="selected">'.$d['nombre_servicio'].'</option>';	
	}else{
	echo '<option value="'.$d['id_servicio'].'">'.$d['nombre_servicio'].'</option>';	
	}
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
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>