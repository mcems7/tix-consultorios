
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
<!--Editor de texto-->

<!--Fin Editor de texto-->


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

echo form_hidden('id_usuario',$usr['id_usuario']);

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


<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">


	
<tr>
	<td class="campo_centro">Procedimiento:</td>
    <td><?=$resultado[0]['desc_subcategoria'] ?></td>
    
    
  
  </tr>

    
    <tr>
    <td class="campo_centro"colspan="2">Informe:</td>
    
	<tr>
     <td colspan="2"><?=$resultado[0]['informe'] ?></td>
    </tr>	
		
		</table>



<tr><td class="linea_azul"></td></tr>      
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