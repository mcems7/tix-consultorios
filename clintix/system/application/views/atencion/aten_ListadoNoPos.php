<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
///////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}

////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Consulta Externa</h1>
<h2 class="subtitulo">Formato de solicitud de medicamentos No POS</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/atencion/atenciones/formatoNoPos_',$attributes);
echo form_hidden('id_atencion', $id_atencion);
?>

<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>

<tr><td>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">

<th colspan="3">
Medicamentos No Pos
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
<td class="campo_centro"><?php echo anchor('/atencion/atenciones/SolicitudformatoNoPos/'.$d['id'].'/'.$id_atencion, 'Solicitar',array('title'=>'Solicitar'));?></td>
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
<tr><td colspan="3" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>&nbsp;

</center>
</div>
<br />
</table>
<?=form_close();?>