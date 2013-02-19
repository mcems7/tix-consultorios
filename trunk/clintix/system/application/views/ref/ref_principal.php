<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");			 
});
////////////////////////////////////////////////////////////////////////////////
function buscar_paciente()
{
	var var_url = '<?=site_url()?>/ref/traslados/buscarPaciente';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_listado').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function cambio()
{
	var tipo = $('tipo_traslado').value;
	var estado = $('estado').value;
	document.location = "<?=site_url('ref/traslados/index')?>/"+tipo+"/"+estado;	
}
</script>
<h1 class="tituloppal">Referencia y contrareferencia</h1>
<h2 class="subtitulo">Principal</h2>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
	echo form_open('',$attributes);
?>
<center>
<table width="70%" class="tabla_form">
<tr><th colspan="2">Buscar paciente</th></tr>
<tr><td width="50%" class="campo">Número de documento del paciente:</td>
<td width="50%"><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['nit']"))?>
</td></tr>
<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'buscar_paciente()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<br />
<table width="100%" class="tabla_form">
<tr>
  <th>Resultados
</th></tr>
<tr><td style="padding:0px" id="div_listado">

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
</center>
<?=form_close().br();?>
<table width="100%" class="tabla_form">
<tr><th align="right">Traslados activos<?=nbs()?><select name="tipo_traslado" id="tipo_traslado" onchange="cambio()">
<?php
$res0 = '';
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';	
if($tipo == 0){
	$res0 = 'selected="selected"';	
}else if($tipo == 1){
	$res1 = 'selected="selected"';	
}else if($tipo == 2){
	$res2 = 'selected="selected"';	
}else if($tipo == 3){
	$res3 = 'selected="selected"';	
}else if($tipo == 4){
	$res4 = 'selected="selected"';	
}

?>  
  <option value="0" <?=$res0?>>Ver todos</option>
  <option value="1" <?=$res1?>>Remisión</option>
  <option value="4" <?=$res4?>>Contra remisión</option>
  <option value="2" <?=$res2?>>Procedimientos o examenes</option>
  <option value="3" <?=$res3?>>Otro</option>
</select><?=nbs()?>Estado:<?=nbs()?>
<select name="estado" id="estado" onchange="cambio()">
<option value="SI" selected="selected">Activo</option>
<option value="NO">Inactivo</option>
</select>
</th></tr>
<tr><td>

<table border="0" width="100%" cellpadding="2" cellspacing="2" class="tabla_interna">
<tr><td class="campo_centro">Nombres y apellidos</td>
<td class="campo_centro">Trámite</td>
<td class="campo_centro">Prioridad</td>
<td class="campo_centro">Tipo traslado</td>
<td class="campo_centro">Fecha creación</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
if($lista != 0)
{
	foreach($lista as $d)
	{
?>
<tr>
<td><?=$d['nombres']?></td>
<td><?=$d['tramite']?></td>
<td class="campo_centro"><?=$d['prioridad']?></td>
<td><?php
if($d['tipo_traslado'] == 1){
	echo "Remisión";
}else if($d['tipo_traslado'] == 2){
	echo "Procedimientos o examenes";
}else if($d['tipo_traslado'] == 3){
	echo "Otro";
}else if($traslado['tipo_traslado'] == 4){
	echo "Contra remisión";
}
?></td>
<?php
//Horas de espera para permitir apertura atención
$horas_espera = 72;
$segundos_espera = $horas_espera * 3600;

$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
$fecha = explode(" ", $d['fecha_creacion']);
list($anno, $mes, $dia) = explode( '-', $fecha[0] );
list($hora, $min, $seg)= explode( ':', $fecha[1] );
$fecha_egreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
$segundos = $fecha_actual_time - $fecha_egreso_time;

if($segundos_espera <= $segundos && $d['activo'] == 'SI'){
?>
<td style="background-color:#FF0" align="center"><strong><?=$d['fecha_creacion'].br(2)."Más de 72 horas"?></strong></td>
<?php
}else{
?>
<td><?=$d['fecha_creacion']?></td>
<?php
}
?>
<td class="opcion">
<?php 
if($d['activo'] == 'SI')
	{
?>
<a href="<?=site_url('ref/traslados/gestionar_traslado/'.$d['id_traslado'])?>"><strong>Gestionar</strong></a>
<?php 
	}else{
?>
<a href="<?=site_url('ref/consultar_traslados/consultar_traslado/'.$d['id_traslado'])?>"><strong>Consultar</strong></a>
<?php 
	}
?>
</td>
</tr>
<?php
	}
}
?>
</table>

</td></tr>
</table>