<script language="javascript">
function confirmarCon()
{
	if(!confirm("¿Esta seguro que desea verificar la consulta?"))
	{
		return false;	
	}
	var var_url = '<?=site_url()?>/urg/atencion_inicial/consultaConfirma';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_verificar').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
</script>
<center>
<?=form_hidden('verificado','NO')?>
<?=form_hidden('id_medico_verifica','')?>
<table width="60%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td colspan="2" class="campo_centro">Verificación de la consulta</td></tr>
  <tr>
    <td class="campo">Nombre de usuario:</td>
    <td>
<?php $data = array(
              'name'        => 'user_log',
              'id'          => 'user_log',
              'maxlength'   => '50',
              'size'        => '20');
	echo form_input($data);
?>
</td>
  </tr>
  <tr>
    <td class="campo">Contraseña:</td>
    <td>
<?php $data = array(
              'name'        => 'pass_log',
              'id'          => 'pass_log',
              'maxlength'   => '50',
              'size'        => '20');
	echo form_password($data)
?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
<?
$data = array(	'name' => 'confirmar',
				'onclick' => 'confirmarCon()',
				'value' => 'Confirmar',
				'type' =>'button');
echo form_input($data);
?>
</td>
  </tr>
</table>
</center>