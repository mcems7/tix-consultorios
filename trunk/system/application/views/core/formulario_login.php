<?php
$this->load->helper('form');

$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/core/login/entrar',$attributes);
?>

<center>
<table width="50%" class="tabla_form">
<tr><th colspan="2">Inicio de sesi&oacute;n</th></tr>
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
    <td colspan="2" align="center"><?=form_submit('enviar', 'Enviar');?></td>
  </tr>
</table>
</center>
<?=form_close();?>