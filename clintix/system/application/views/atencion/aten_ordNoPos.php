<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
///////////////////////////////////////////////////////////////////////////////
function agregarMedPos(id_div,cont)
{
	if(!validarMedi(cont))
	{
		return false;
	}
		
	var div = "div"+id_div;
	var var_url = '<?=site_url()?>/atencion/atenciones/agregarPosSustituto';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $(div).get('html');
		$(div).set('html',html2, html);
		$('div_precarga').style.display = "none";},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarMedicamento(id_tabla)
{	
	if(confirm('¿Desea eliminar el medicamento seleccionado?'))
		$(id_tabla).dispose();	
}

////////////////////////////////////////////////////////////////////////////////
function validarMedi(cont)
{
	var v1 = cont+'atc_pos';
	if($(v1).value == 0 ){
		alert("Se debe seleccionar un medicamento POS que es sustituido");
		return false;
	}
	
	var v2 = cont+'dias_tratamientoPos';
	if($(v2).value == 0){
		alert("Debe ingresar los días del tratamiento");
		return false;
	}
	
	var v3 = cont+'dosis_diariaPos';
	if($(v3).value == 0){
		alert("Debe ingresar la dosis diaria");
		return false;
	}
	
	var v4 = cont+'cantidad_mes';
	if($(v4).value == 0){
		alert("Debe ingresar la cantidad total por mes");
		return false;
	}
	
	
	
	return true;
}

function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Formato de solicitud de medicamentos No POS</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/atencion/atenciones/formatoNoPos_',$attributes);
echo form_hidden('id_atencion', $id_atencion);
echo form_hidden('id_medicamento', $ordenMedi[0]['id']);
?>

<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>

<tr><td>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">

<tr>
  <th colspan="2">Medicamentos NO POS</th></tr>
<tr>
<td class="campo">Resumen de la historia clínica:</td>
<td>

<?=form_textarea(array('name' => 'resumen_historia',
								'id'=> 'resumen_historia',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr>
  <td colspan="2">
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
		echo $this->load->view('atencion/aten_ordFormNoPos',$d) ,"<br>";
		$cont++;
	}
?>  
  </td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>&nbsp;<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
</td></tr></table>
<?=form_close();?>