<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function resetDiv()
{
	$('con_evo').set('html','');
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
 var exValidatorA = new fValidator("formulario");
 	 
});


////////////////////////////////////////////////////////////////////////////////

function confirmarenvio() {
    if(confirm('¿Esta seguro que desea guardar la Interpretacion ?'))
	{
		return true;
	  
 }else{
 
 return false;
 }
}
///////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>

<?php

$usr = $this->Usuario->obtenerNombreTercero($this->session->userdata('id_usuario'));
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return confirmarenvio()');
echo form_open('/lab/hce_laboratorio/guardarInterpretacion',$attributes);
echo form_hidden('registro_numero',$registro_numero);
echo form_hidden('id_orden',$id_orden);
echo form_hidden('id_usuario',$usr['id_usuario']);
echo form_hidden('id_atencion',$id_atencion);

?>


<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Ordenamiento médico</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Resultado de la Orden </th></tr>
<tr>
<td>
<div id="con_ord">

</div>
<?php
	if($ordenes == 0)
	{
		echo "<center><strong>No se ha registrado ninguna orden médica</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">

<?php for ($i = 0; $i < $tamaño; $i++) 
		{ ?>
	<tr><th colspan="3"><?=$obtenernombrecont[$i]['nombre'];?> </th></tr>
<tr>
	<td class="campo_centro">Prueba</td>
    <td class="campo_centro">Resultado</td>
    <td class="campo_centro">Rangos Normales</td>
    
    
  
  </tr>
<?php
	foreach($resultado as $d)
	{
		if ($obtenernombrecont[$i]['id']==$d['idpadre'])
		{
	
?>
 
  <tr>
<td class="campo"><?=$d['clinico'];?> :</td>
		<?php if ($d['numero']>0)
		       {
		?>
			    <td align="center"><?=$d['numero'];?></td>
		<?php 
		       }else if ($d['texto']!='')
			   {
	     ?>
	            <td align="center"><?=$d['texto'];?></td>
		<?php  } else if ($d['lista']!='')
		       {
		?>
				<td align="center"><?=$d['lista'];?></td>
		<?php
				}
		 ?>
<td align="center">[<?=$d['valorminimonumerico'].'-'.$d['valormaximonumerico'];?>]</td>
<?php
	}
		
	}
?>
	
		<?php }} ?>
        <tr><td class="linea_azul" colspan="3"></td></tr>
 
 <?php if ($RutaArchivo['ruta_archivos']!='no se anexa imagen')
 
 {   ?>
	<tr>
 	   <td class="campo"> Descargar Archivo:</td>
    
       <td colspan="2"> <a target="_blank" href="<?php 
	   echo str_replace('index.php/','',site_url('/uploads/laboratorio/'.$RutaArchivo['ruta_archivos'])) ?>"> ARCHIVO </a> </td>
    </tr>      
 <?php }?>
     
	
    
    <tr>
    <td class="campo">Interpretacion:</td>
    <td colspan="2"><?=form_textarea(array('name' => 'interpretacion',
							'id'=> 'interpretacion',
							'rows' => '5',
							'class' => "fValidate['required']",
							'cols'=> '45'))?></td></tr>	
		
		
		</table>



<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);

echo form_submit('boton', 'Guardar')
?>
</td></tr>
</table>