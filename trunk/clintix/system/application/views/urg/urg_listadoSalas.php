<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - SALAS DE ESPERA</h1>
<h2 class="subtitulo">Listado de pacientes por sala de espera</h2>
<center>
<table width="90%" class="tabla_form" cellpadding="5">
<tr><th colspan="2">Seleccione la sala de espera</th></tr>
<tr align="center"><td width="50%" class="campo">
<a href="<?=site_url()?>/urg/salas/detalleSalaEspera/1">
<img src="<?=base_url()?>/resources/images/urgAdultos.png" alt="Urgencias adultos" title="Urgencias adultos" border="0"/></a>
</td>
<td width="50%" class="campo">
<a href="<?=site_url()?>/urg/salas/detalleSalaEspera/2">
<img src="<?=base_url()?>/resources/images/urgPedi.png" alt="Urgencias pediátricas" title="Urgencias pediátricas" border="0"/></a>
</td></tr>
<tr align="center"><td class="campo">
<a href="<?=site_url()?>/urg/salas/detalleSalaEspera/3">
<img src="<?=base_url()?>/resources/images/urgGine.png" alt="Urgencias ginecológicas" title="Urgencias ginecológicas" border="0"/></a>
</td>
<td class="campo">
<a href="<?=site_url()?>/urg/salas/detalleSalaEspera/4">
<img src="<?=base_url()?>/resources/images/urgPsiqui.png" alt="Urgencias psiquiátricas" title="Urgencias psiquiátricas" border="0"/></a>
</td></tr>
<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</center>
