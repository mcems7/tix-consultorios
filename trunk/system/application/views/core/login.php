<?php
$this->load->helper('form');

$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/core/autenticacion/login',$attributes);
?>
<table width="400" border="1">
  <tr>
    <td>Nombre de usuario:</td>
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
    <td>Contraseña</td>
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
    <td colspan="2"><?=form_submit('enviar', 'Enviar');?></td>
  </tr>
</table>
<?=form_close();?>