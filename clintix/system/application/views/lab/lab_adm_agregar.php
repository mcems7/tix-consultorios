<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/lab/lab_adm_clinicos/ingresa_tipo_lab',$attributes);
?>
Abreviatura:
    <?=form_input(array('name' => 'abreviatura',
						'id'=> 'abreviatura',
						'class'=> "fValidate['integer']",
						'size'=> '4'))?>
    Nombre:
      <?=form_input(array('name' => 'nombre',
						'id'=> 'nombre',
						'class'=> "fValidate['integer']",
						'size'=> '15'))?>
						
<?=form_submit('boton', 'Guardar')?>

<?=form_close();?>                        