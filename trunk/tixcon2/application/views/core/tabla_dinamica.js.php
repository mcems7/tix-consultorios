<?php
/*
* @author Jorge Ivan Meza Martinez<jimezam@gmail.com>
* @author http://http://www.jorgeivanmeza.com/
*/
?>
<script type="text/javascript">
	
////////////////////////////////////////////////////////////////////////////////

function TDAgregarRegistro(tablaId)
{
	var tabla = $(tablaId);
	var cabecera = $$("#" + tablaId + " #cabecera");
	
	var estructura = obtEstructuraRegistro(tablaId);
	
	if(estructura == null)
	{
		alert("ERROR obteniendo al estructura de '" + tablaId + "'.");
		
		return false;
	}
	
	var registro = new Element('tr', (obtPropiedadesFila(tablaId) != null) ? obtPropiedadesFila(tablaId) : {});
	registro.setProperty('class', registro.getProperty('class') + " TDRegistro");
	
	for(i=0; i<estructura.length; i++)
	{
		var tipo = estructura[i]['elemento'];
		
		delete(estructura[i]['elemento']);
		
		if(tipo == undefined)
		{
			alert("ERROR obteniendo el tipo del elemento #" + i + " de '" + tablaId + "'.");
			
			return false;
		}
		
		var campo = new Element('td', (obtPropiedadesCampo(tablaId) != null) ? obtPropiedadesCampo(tablaId) : {});
		campo.setProperty('class', campo.getProperty('class') + " TDCampo");
		
		if (estructura[i]['id'] == "marca") 
		{
			campo.setStyle('text-align', 'center');
			campo.setProperty('class', campo.getProperty('class') + " TDMarca");
		}
		
		var obj = new Element(tipo, estructura[i]);
		
		if(tipo == "select")
		{
			var opciones = new Array();
			
			if (estructura[i]['options'] != undefined )
			{
				opciones = $H(estructura[i]['options']);

				delete(estructura[i]['options'])
			}
		
			opciones.each(function(valor, llave) 
			{
				var option = new Element('option', {'value': valor});
				option.set('text',llave);
				
				option.injectInside(obj);
			});
		}
		
		obj.injectInside(campo);
		
		campo.injectInside(registro);
	}
	
	registro.injectInside(tabla.getElement("tbody"));
}

function TDRemoverRegistros(tablaId)
{
	var marcas = $$("#" + tablaId + " .TDMarca");

	var cantidad = 0;
	
	marcas.each(function(elemento, indice) 
	{
		var marca = elemento.getElement("input[id=marca]");
		
		if(!marca.getProperty('checked'))
			return;
			
		cantidad ++;
		
		var tr = elemento.getParent();
	
		tr.dispose();
	});	
	
	if(cantidad == 0)
		alert("Por favor seleccione las marcas de verificacion\n" + 
		      "de los elementos que desea remover.");
			  
	return cantidad;
}

////////////////////////////////////////////////////////////////////////////////
	
</script>
