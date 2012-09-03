<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">M&oacute;dulo de reportes - Urgencias</h1>
<h2 class="subtitulo">Listado de reportes</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th>Reportes disponibles</th></tr>
<tr><td>


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