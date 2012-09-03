<script language='javascript'>

function editar_permisos()
{	
	var var_url = 'actualizar_permisos';
	var miAjax = new Request(
	{
		url: 				var_url,
		method:     'post',
		data:       $('formulario'),
		onComplete: function() 
		{
			alert('Se actualizaron los permisos');
		}
	});

	miAjax.send();
}

function retroceder()
{
	document.location = '../home/index';
}

function cargar_entidades()
{
	//alert("etntro a cargar entidades");
	var var_url = 'listar_entidades';
	var miAjax = new Request(
	{
		url:				var_url,
		method:     'post',
		data:       $('formulario'),
		//onSuccess: function(html){$('id_entidad_div').set('html', html);},
		onComplete: function(html)
		{
			//html = "esto se lo puse como html";
			//alert(html);
			$('id_entidad_div').set('html', html);
			$('id_entidad').addEvent('change', function()
			{
				cargar_permisos();
			});
 		} 
	});
	miAjax.send();
}

function cargar_permisos()
{
	if($('id_entidad').value == '')
		return;
	
	var jsonParam = JSON.encode({
		id_entidad:   $('id_entidad').value,
		tipo_usuario: $('tipo_usuario').checked,
		tipo_grupo:   $('tipo_grupo').checked
	});

	var miAjax = new Request.JSON(
	{
		url:		'listar_permisos',
		method:     'post',
		onSuccess:  function(obj)
					{
		//alert(obj);
						// Remover la selección de todos los items

						$$('input').each(function(elemento, indice) 
						            {
										if (elemento.getProperty('type') == 'checkbox')
											elemento.setProperty('checked', false);
									});
						
						//var objeto = JSON.decode(obj);
						//alert(objeto);
						//objeto.each(function(elemento, indice)
						obj.each(function(elemento, indice)
						{
							// Seleccionar los items correspondientes a los permisos
							
							$('permisos[' + elemento + ']').setProperty('checked', true);
						});
					}
	}).post({
		json: jsonParam
		});
}

window.addEvent('domready', function()
{
	// Entidad
	
	$('id_entidad').addEvent('change', function(){
		cargar_permisos();
	});

	// Tipo de entidad
	
	$('tipo_usuario').addEvent('change', function(){
		cargar_entidades();
	});

	$('tipo_grupo').addEvent('change', function(){
		cargar_entidades();
	});

	// Botón de aceptar
	
	$('aceptar').addEvent('click', function(){
		editar_permisos();
	});

	// Botón de cancelar

	$('cancelar').addEvent('click', function(){
		retroceder();
	});

	// Filas de permisos
	
	var permisos = $$('tr.filapermiso');

	permisos.addEvent('mouseenter', function(){
		this.setStyle('background-color', '#E3FFC8');
	});
	
	permisos.addEvent('mouseleave', function(){
		this.setStyle('background-color', '#ffffff');
	});
	
});

</script>
<?php 

$attributes = array('id'   => 'formulario',
	                'name' => 'formulario');

echo form_open("", $attributes); 

?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Administración la asignación de permisos</h2>
<center>
<table width="100%" cellpadding="0" cellspacing="0" class="tabla_form">
	<tr>
		<th>
			Seleccione la entidad
		</th>
	</tr>
	<tr>
		<td>
		
		<table width="50%">
			<tr>
				<td class="campo">
					Entidad:
				</td>
				<td>

					<div id='id_entidad_div'>

					<?php

					$options = array();

					$js = 'id="id_entidad"';

					echo form_dropdown('id_entidad', $options, '', $js);

					?>

					</div>
					
				</td>
			</tr>
			<tr>
				<td class="campo">
					Tipo:				
				</td>
				<td>

					<table cellspacing='0' cellpadding='0'>
						<tr>
							<td>
								Usuarios&nbsp;
							</td>
							<td>
								<?php
			
								$data = array('name'        => 'tipo',
								              'id'          => 'tipo_usuario',
								              'value'       => 'usuario',
								              'checked'     => false
								             );
			
								echo form_radio($data);
			
								?>							
							</td>
						</tr>
						<tr>
							<td>
								Grupos&nbsp;
							</td>
							<td>
								<?php
								
								$data = array('name'        => 'tipo',
								              'id'          => 'tipo_grupo',
								              'value'       => 'grupo',
								              'checked'     => false
								             );
			
								echo form_radio($data);
								
								?>							
							</td>
						</tr>
					</table>

				</td>
			</tr>
			
			<tr>
				<td colspan='2' align="center">
					<br />
					<input id='aceptar'  type="button" value="Aceptar"/>
					<input id='cancelar' type="button" value="Cancelar"/>
				</td>
			</tr>
		</table>
		
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<table class='tabla_interna' width="100%">
			<tr>
				<th colspan='2'>
					Especifique los permisos requeridos
				</th>
			</tr>
			
			<?php
			
				$ultimo_modulo = '';
			
				foreach($permisos as $permiso):
			
					if($ultimo_modulo != $permiso['modulo'])
					{
						$info_modulo = $this -> modulo -> obtener($permiso['modulo']);
						
						$nombre_modulo = 'M&oacute;dulo de ' . $info_modulo['nombre'];
						
						if (strlen($info_modulo['nombre']) == 0)
							$nombre_modulo = 'M&oacute;dulo ' . $permiso['modulo'];
						
						echo "<tr>
								  <td colspan='3' style='font-size: 17px; font-weight: bolder;'>
								  	  {$nombre_modulo}
								  </td>
						      </tr>";
							  
						$ultimo_modulo = $permiso['modulo'];
					}
			
			?>
						
				<tr>
					<td>
						<?php
						
							$descripcion = $permiso['descripcion'];
							$ruta        = $permiso['modulo'] . '/' . $permiso['controlador'] . '/' . $permiso['accion'];				

							if(strlen($descripcion) == 0)
								$descripcion = "<span style='color: orange;'>" . $ruta . "</span>";
						
							echo "<label for='permisos[{$permiso['id_permiso']}]' style='font-weight: normal;'>" . $descripcion . "</label>";
						
						?>
					</td>
					<td>

						<?php

								$checked = false;

								$data = array('name'        => "permisos[{$permiso['id_permiso']}]",
								              'id'          => "permisos[{$permiso['id_permiso']}]",
								              'value'       => $permiso['id_permiso'],
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
						?>

					</td>
				</tr>
			
			<?php
			
				endforeach;			
				
			?>


			</table>
		</td>
	</tr>

</table>
</center>
<?php

form_close();

?>

<br />
