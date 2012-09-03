<?php
/*
* @author Jorge Ivan Meza Martinez <jimezam@gmail.com>
* @author http://http://www.jorgeivanmeza.com/
*/
?>

<!-- JSCalendar -->

<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>resources/js/jscalendar/calendar-system.css" title="Calendario" />

<!-- /JSCalendar -->

<!-- ****************************************************************** -->
<script language="Javascript">

function retroceder()
{
	document.location = "<?php echo $spec['regresar_a']; ?>";
}
	
var valor_defecto = new Array();
	
<?php

// Determinar los valores por defecto de los campos del formulario de entrada.

$_campos = $spec['campos'];
$_llaves = array_keys($_campos);

for($i=0; $i<count($_campos); $i++)
{
    $_campo          = $_campos[$_llaves[$i]];
    $_valor_defecto  = (isset ($_campo['valor_defecto']))  ? $_campo['valor_defecto']  : '';

    echo "valor_defecto['{$i}'] = '$_valor_defecto';\n";
}

?>


function limpiar_formulario(nombre)
{
	formulario = $(nombre);

	index = 0;

	while (formulario.hasChild($('campo_' + index)))
	{
		elemento      = $('campo_' + index);
		elemento_orig = $('campo_' + index + "_orig");
		
		readonly = elemento.getProperty('readonly');
		
		// if (!readonly)
		// {
			switch(elemento.type)
			{
				case 'text': 
					// elemento.setProperty('value', '');
					// elemento_orig.setProperty('value', '');

					elemento.setProperty('value', valor_defecto[index]);
					elemento_orig.setProperty('value', valor_defecto[index]);
					break;
			}
		// }

		index ++;
	}
}
	
function obtener_cabecera_lista()
{
	str = "<table class='tabla_interna' width='100%'>\n";

	str += "<tr class='campo_centro'><td>Marca</td>";
	
	<?php
	
		for ($i=0; $i<count($spec['campos']); $i++)
		{
			$campo = $spec['campos'][$i];
			
			echo "str += \"<td class='titulocolumna'>{$campo['etiqueta']}</td>\";\n";
		}
	
	?>
	
	str += "</tr>";
	
	return str;
}
	
function listar()
{
		var jsonParam = JSON.encode({
			pagina: $('pagina_actual').value
		});

		var jsonRequest = new Request.JSON({
			url:    "<?php echo $url_peticion_ajax; ?>listar",
					
        onComplete: function(objeto)
        {
			html = obtener_cabecera_lista();
		
			// Por cada fila: elemento del listado
		
			objeto.each(function(elemento)
			{
				// Especificaci�n de los campos que determinan 
				// la llave primaria de un registro
		
				campos_pk = new Array(<?php 
				
										for($i=0; $i<count($spec["pk"]); $i++)
										{
											echo "'" . $spec["pk"][$i] . "'";
											
											if ($i<count($spec["pk"]) - 1)
												echo ", ";
										}
				
				                      ?>);
			
				// Calcular la llave primaria del registro
				
				valor_pk = "";
		
				for(iv=0; iv<campos_pk.length; iv++)
				{
					valor_pk += eval('elemento.campo_' + campos_pk[iv]);
					
					if (iv<campos_pk.length - 1)
						valor_pk += "||";
				}
		
				// Generar los elementos del registro
				
				indice = 0;
		
				html += "<tr onMouseOver='resaltar_fila(this, \"#FFFFFF\")'   \
				             onMouseOut='resaltar_fila(this, \"#EFEFEF\")'    \
							 style='height: 20px; border-bottom: 1px dashed #CDCDCD; background-color:#EFEFEF;' >";
		
				while ( eval('elemento.campo_' + indice) != undefined)
				{
					if (indice == 0) 
					{
						html += "<td style='text-align: center;'>";
						
						html += "<input type='checkbox'              \
						                value='" + valor_pk + "'     \
										id='seleccion_datos[]'       \
										name='seleccion_datos[]' />";
		
						html += "</td>";
					}
		
					valor = eval('elemento.campo_' + indice);
		
					if (eval('elemento.campo_' + indice + "_alt"))
						valor = eval('elemento.campo_' + indice + "_alt");
		
					html += "<td><a href='#' onClick='mostrar_registro(\"" + valor_pk + "\"); return false;' title='Haga click aqui para editar este registro'>" + valor + "</a></td>";
		
					indice ++;
				}
				
				html += "</tr>\n";
			});
		
			html += "</table>\n";
		
			$('tabla_datos').set('html', html);
        }
    }).post(
    {
    	json: jsonParam
    });

	mostrar_editar(false);
	
	limpiar_formulario('formulario_origen');
}

function agregar()
{
	var jsonParam = JSON.encode({
		<?php				
				$_campos = $spec['campos'];
				$_llaves = array_keys($_campos);
			
				for ($i = 0; $i<count($_campos); $i++) 
				{
					echo "campo_{$i}: \$('campo_{$i}').value";
					
					if ($i<count($_campos) - 1)
						echo ", ";
						
					echo "\n";
				}
		?>
	});
	//alert(jsonParam);
	var miJSON = new Request.JSON(
	{
		url: "<?php echo $url_peticion_ajax; ?>agregar",
		onComplete: function(objeto)
		{
			if (objeto.exito)
			{
				alert("Registro agregado a la base de datos");
				
				limpiar_formulario('formulario_origen');
				
				listar();
			}
			else
			{
				errno       = objeto.errno;
				descripcion = objeto.descripcion;
				
				alert("Error agregando la informacion a la base de datos.\n\nError: " + errno + "\nDescripcion: " + descripcion);
			}
		}
	}).post({
		json: jsonParam
		});

	mostrar_editar(false);
}

function remover_seleccion()
{
	// Determinar cuales elementos deber�an ser removidos
	/*var jsonParam = JSON.encode({
		 algo: seleccion
	});*/
	registros = document.getElementsByName('seleccion_datos[]');
	
	seleccion = new Array();
	
	for(i=0; i<registros.length; i++)
	{
		registro = registros[i];
		
		if(registro.checked)
		{
			valor = registro.value;
			
			seleccion.push(valor);
		}
	}
	var jsonParam = JSON.encode(seleccion);

	// Realizar la remocion de los registros solicitados

	var miJSON = new Request.JSON(
	{
		url: "<?php echo $url_peticion_ajax; ?>remover",
		onComplete: function(objeto)
		{
			removidos   = objeto.removidos;
			solicitados = objeto.solicitados;
			
			listar();

			if (removidos == 0) 
			{
				alert("No se removieron registros de la base de datos.");
			}
			else 
			{
				if (removidos == solicitados) 
					alert("Se removieron exitosamente los registros de la base de datos.");
				else 
					alert("Se removieron " + removidos + " registros de los " + solicitados + " solicitados.");
			}					
		}
	}).post({
			json: jsonParam
		});
	
	mostrar_editar(false);
}

function mostrar_registro(llave)
{
	var jsonParam = JSON.encode(llave);
	
	var miJSON = new Request.JSON(
	{
		url: "<?php echo $url_peticion_ajax; ?>mostrar_registro",
		onComplete: function(objeto)
		{
			<?php
			
			for($i=0; $i<count($spec['campos']); $i++)
			{
				echo "elemento = \$('campo_{$i}');\n";
				echo "elemento.setProperty('value', objeto.campo_{$i});\n\n";

				echo "elemento_orig = \$('campo_{$i}_orig');\n";
				echo "elemento_orig.setProperty('value', objeto.campo_{$i});\n\n";
			}
			
			?>					
		}
	}).post({
		json: jsonParam
		});
	
	/*miJSON.send(
	{
		data: llave
	});*/

	mostrar_editar(true);
}

function mostrar_editar(opcion)
{
	var boton = $('boton_editar');
	
	if(opcion)
		boton.setStyle("display", "block");
	else
		boton.setStyle("display", "none");
}

function editar()
{
	var jsonParam = JSON.encode({
		<?php				
				$_campos = $spec['campos'];
				$_llaves = array_keys($_campos);
			
				for ($i = 0; $i<count($_campos); $i++) 
				{
					echo "campo_{$i}: \$('campo_{$i}').value, \n";
          echo "campo_{$i}_orig: \$('campo_{$i}_orig').value";
					
					if ($i<count($_campos) - 1)
						echo ", ";
						
					echo "\n";
				}
		?>
	});

	var miJSON = new Request.JSON(
	{
		url: "<?php echo $url_peticion_ajax; ?>editar",
		
		onComplete: function(objeto)
		{
			exito        = objeto.exito;
			errno        = objeto.errno;
			descripcion  = objeto.descripcion;
			actualizados = objeto.actualizados;
			
			listar();

			if (exito)
				alert("Registro actualizado en la base de datos.");
			else
				alert("Error actualizando la informacion en la base de datos.\n\nError: " + errno + "\nDescripcion: " + descripcion);
		}
	}).post({
		json: jsonParam
		});
	
	mostrar_editar(false);
	
	listar();
}

function paginador_anterior()
{
	indice = $('pagina_actual');

	if (indice.value == 1)
		alert("No existe una pagina anterior.");
	else
		indice.value = indice.value - 1;
	
	listar();	
}

function paginador_siguiente()
{
	indice = $('pagina_actual');

	indice.value = parseInt(indice.value) + 1;
	
	listar();	
}

function resaltar_fila(fila, color)
{
	fila.style.backgroundColor = color;
}

function inicio()
{
	listar();
	mostrar_editar(false);
}

window.addEvent('load', function() 
{
	inicio();
});

</script>

<!-- ****************************************************************** -->

<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo"><?php echo (isset($spec['descripcion'])) ? $spec['descripcion'] : "Sin descripci&oacute;n"; ?></h2>
<center>
<table width="100%" class="tabla_form">
<tr><th>&nbsp;</th></tr>
<tr>
	<td>

	<?php 
	
	$attributes = array('id'   => 'formulario_origen',
  	                    'name' => 'formulario_origen');
	
	echo form_open("", $attributes); 
	
	?>

	<table>
	<?php
	
		$_campos = $spec['campos'];
		$_llaves = array_keys($_campos);
	
		for($i=0; $i<count($_campos); $i++)
		{
			$_campo = $_campos[$_llaves[$i]];
			
			$_etiqueta       = (isset ($_campo['etiqueta']))       ? $_campo['etiqueta']       : null;
			$_tipo           = (isset ($_campo['tipo']))           ? $_campo['tipo']           : null;
			$_campo_nombre   = (isset ($_campo['campo_nombre']))   ? $_campo['campo_nombre']   : null;
			$_editable       = (isset ($_campo['editable']))       ? $_campo['editable']       : true;
			$_longitud       = (isset ($_campo['longitud']))       ? $_campo['longitud']       : 10;
			$_largo          = (isset ($_campo['largo']))          ? $_campo['largo']          : $_longitud;
			$_opciones       = (isset ($_campo['opciones']))       ? $_campo['opciones']       : null;
			$_origen_tabla   = (isset ($_campo['origen_tabla']))   ? $_campo['origen_tabla']   : null;
			$_origen_codigo  = (isset ($_campo['origen_codigo']))  ? $_campo['origen_codigo']  : null;
			$_origen_valor   = (isset ($_campo['origen_valor']))   ? $_campo['origen_valor']   : null;
			$_formato        = (isset ($_campo['formato']))        ? $_campo['formato']        : '%d/%m/%Y';
			$_formato_tiempo = (isset ($_campo['formato_tiempo'])) ? $_campo['formato_tiempo'] : '12';
			$_mostrar_hora   = (isset ($_campo['mostrar_hora']))   ? $_campo['mostrar_hora']   : false;
			$_filas          = (isset ($_campo['filas']))          ? $_campo['filas']          : 10;
			$_columnas       = (isset ($_campo['columnas']))       ? $_campo['columnas']       : 70;
            $_valor_defecto  = (isset ($_campo['valor_defecto']))  ? $_campo['valor_defecto']  : '';
			
			$_mostrar_hora = ($_mostrar_hora) ? 'true' : 'false';
			
			$_es_pk = (in_array ("$i", $spec['pk'])) ? true : false;
			
		?>
			
			<tr id='fila_<?php echo $i; ?>'>
				<td><?php echo ($_etiqueta == null) ? "Sin etiqueta" : $_etiqueta; ?></td>
				<td>
					<?php
						$_str = "Tipo desconocido";
						$_str_editable = "";
					
						// Determina si el componente sera o no editable
					
						if (!$_editable)
							$_str_editable = " readonly='readonly' title='Solo lectura' style='background-color: #E4F5CB;' ";
				
						// Determinar el componente HTML a incluirse en el formulario de datos
					
						switch(strtoupper($_campo['tipo']))
						{
							case 'AUTONUMERICO': 
										$_str = "<input type='text' id='campo_{$i}' name='campo_{$i}'
										                value='Automatico' {$_str_editable} />\n";
										 break;

							case 'TEXTO': 
										$_str = "<input type='text' id='campo_{$i}' name='campo_{$i}' 
										                value='{$_valor_defecto}' size='{$_largo}' maxlength='{$_longitud}' 
														 {$_str_editable} />\n";
										 break;

							case 'AREATEXTO':
										$_str = "<textarea id='campo_{$i}' name='campo_{$i}' 
										         cols='{$_columnas}' rows='{$_filas}' 
												 {$_str_editable}>{$_valor_defecto}</textarea>";
										 break;

							case 'ENTERO': 
										$_str = "<input type='text' id='campo_{$i}' name='campo_{$i}' 
										                 value='{$_valor_defecto}' size='{$_largo}' maxlength='{$_longitud}' 
														 {$_str_editable} />\n";
										 break;
							case 'FECHA':
										$_str = "<input type='text' id='campo_{$i}' name='campo_{$i}' 
										                 value='{$_valor_defecto}' size='21' maxlength='20' 
														 {$_str_editable} />\n";

										$_str .= "<img src='" . base_url() . "resources/img/calendario_boton.png' id='campo_{$i}_img' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=\"\"' />\n";

										$_str .= "<script type='text/javascript'>
													Calendar.setup({
														inputField     :    'campo_{$i}',     		// id of the input field
														ifFormat       :    '{$_formato}',
														daFormat       :    '{$_formato}',          // format of the input field
														displayArea	   :	'campo_{$i}',
														showsTime      :	{$_mostrar_hora},
														timeFormat     :    '{$_formato_tiempo}',
														button         :    'campo_{$i}_img',       // trigger for the calendar (button ID)
														align          :    'Br',                   // alignment (defaults to 'Bl')
														singleClick    :    true
													});
												</script>\n";
										 break;
							case 'ARREGLO': 
										$js = "id='campo_{$i}'";
										$_str = form_dropdown("campo_{$i}", $_opciones, '', $js);
										 break;

							case 'CONSULTA': 
										$this -> db -> select("{$_origen_codigo}, {$_origen_valor}");
										$resultado = $this -> db -> get($_origen_tabla);

										$_opciones = array();

										foreach($resultado -> result_array() as $row)
											$_opciones[$row[$_origen_codigo]] = $row[$_origen_valor];

										$js = "id='campo_{$i}'";
										$_str = form_dropdown("campo_{$i}", $_opciones, '', $js);
										 break;
						}
						
						// Agrega un campo oculto con el valor original del campo,
						// �til para el proceso de edici�n
						
						$_str .= "<input type='hidden' id='campo_{$i}_orig' 
						                 name='campo_{$i}_orig' value='' />\n";
						
						// Muestra el componente HTML elegido en la p�gina
						
						echo $_str;
					?>
				</td>
			</tr>
			
		<?php

		}
	
		?>
	</table>

	<br />

	<table align="center">
	<tr>
		<td>
			<input type="button" value="Agregar" onClick="agregar()" />
		</td>
		<td>
			<input type="button" value="Editar" onClick="editar()" id="boton_editar" />
		</td>
		<td>
			<input type="button" value="Regresar" onClick="retroceder()" />
		</td>
	</tr>
	</table>
	
	<?php
	
	echo form_close();
	
	?>
	
	</td>
</tr>

<?php
	if (isset($spec['ayuda'])):
?>

<tr>
	<td>
		<br />
		<?php echo $spec['ayuda']; ?>
		<br />
		<br />
	</td>
</tr>

<?php
	endif;
?>

<tr>
	<td>
		<input type="button" id="ir_a_anterior"  name="ir_a_anterior"  value="<"  style="font-size: 10px" onclick="paginador_anterior()" />
		<input type="text"   id="pagina_actual"  name="pagina_actual"  value="1"  style="font-size: 12px" size="3" readonly='readonly' />
		<input type="button" id="ir_a_siguiente" name="ir_a_siguiente" value=">"  style="font-size: 10px" onclick="paginador_siguiente()" />
	</td>
</tr>

<tr>
	<td>
<center>
	<?php 
	
	$attributes = array('id'   => 'formulario_datos',
  	                    'name' => 'formulario_datos');
	
	echo form_open("", $attributes); 
	
	?>

	<div id="tabla_datos" style="overflow: auto;">
	</div>

	<br />

<?php
	if('core/administrar_usuario' != $url_controlador_accion)
	{
?>
		<input type="button" value="Remover seleccionados"  onClick="remover_seleccion()" />
<?php
	}
?>
		<input type="button" value="Refrescar listado" onClick="listar()" />
		<input type="button" value="Regresar" onClick="retroceder()" />
	

	<?php
	
	echo form_close();
	
	?>
</center>
	</td>
</tr>
<tr><td align="center">
<input type="button" value="Regresar" onClick="retroceder()" />
</td></tr>
</table>
