/* para los elementos de la administracion del index de ecommerce */

var divArticulosPedido;
var dropFx;
var dropFx2;
var dropFx3;
//var dropFx4;

function inicializarDragDrop()
{
		//alert("entro a la funcion inicializardrag");
		//alert("entro en el addevent del domready");
		drop = $('cart');
		drop2 = $('cart2');
		drop3 = $('cart3');
		//drop4 = $('cart4');
		
		divArticulosPedido = $('items').getElements('div[class^=item]');
		
		dropFx = drop.effect('background-color',{wait: false});
		dropFx2 = drop2.effect('background-color',{wait: false});
		dropFx3 = drop3.effect('background-color',{wait: false});
		//dropFx4 = drop4.effect('background-color',{wait: false});
		agregarEventosDragDrop();
}

function agregarEventosDragDrop()
{
	//alert("entro a la funcion agregar eventos drag");
	divArticulosPedido.each(function(item)
	{
		//alert('id: ' + item.getProperty('id')); funciona
		item.addEvent('mousedown', function(e)
		{
			e = new Event(e).stop();
			//alert('id: ' + this.getProperty('id')); funciona
			//$('id_aux').value = this.getProperty('id');
			//$('id_aux').setProperty('value', this.getProperty('id'));
			var temp = $('frm_admin_ini_ecommerce').getElement('input[name=id_aux]');
			temp.setProperty('value', this.getProperty('id'));
			//alert('valor de aux: ' + temp.value);
			
			var clone = this.clone().setStyles(this.getCoordinates())
			.setStyles(
			{
				'opacity': 0.7,
				'position': 'absolute'
			})
			.addEvent('emptydrop', function()
			{
				this.remove();
				drop.removeEvents();
				drop2.removeEvents();
				drop3.removeEvents();
				//drop4.removeEvents();
			})
			.inject(document.body);
			drop.addEvents(
			{
				'drop': function()
				{
					//pongo el valor del id del producto a la variable oculta correspondiente del formulario
					var prod1 = $('frm_admin_ini_ecommerce').getElement('input[name=id_prod1]');
					prod1.setProperty('value', temp.value);
					/////////////////////////////////////
					//pongo el valor del id en el texto del codigo que se debe incluir en el swf
					$('id_prod').setHTML(temp.value);
					/////////////////////////////////////
					drop.removeEvents();
					drop2.removeEvents();
					drop3.removeEvents();
					//drop4.removeEvents();
					clone.remove();
					cambiar_producto(drop);
					item.clone().inject(drop);
					
					dropFx.start('7389AE').chain(dropFx.start.pass('ffffff', dropFx));
				},
				'over': function()
				{
					dropFx.start('98B5C1');
				},
				'leave': function()
				{
					dropFx.start('ffffff');
				}
			});
			drop2.addEvents(
			{
				'drop': function()
				{
					//pongo el valor del id del producto a la variable oculta correspondiente del formulario
					var prod2 = $('frm_admin_ini_ecommerce').getElement('input[name=id_prod2]');
					prod2.setProperty('value', temp.value);
					/////////////////////////////////////
					drop.removeEvents();
					drop2.removeEvents();
					drop3.removeEvents();
					//drop4.removeEvents();
					clone.remove();
					cambiar_producto(drop2);
					item.clone().inject(drop2);
					dropFx2.start('7389AE').chain(dropFx2.start.pass('ffffff', dropFx2));
				},
				'over': function()
				{
					dropFx2.start('98B5C1');
				},
				'leave': function()
				{
					dropFx2.start('ffffff');
				}
			});
			drop3.addEvents(
			{
				'drop': function()
				{
					//pongo el valor del id del producto a la variable oculta correspondiente del formulario
					var prod3 = $('frm_admin_ini_ecommerce').getElement('input[name=id_prod3]');
					prod3.setProperty('value', temp.value);
					//////////////////////////////////////
					drop.removeEvents();
					drop2.removeEvents();
					drop3.removeEvents();
					//drop4.removeEvents();
					clone.remove();
					cambiar_producto(drop3);
					item.clone().inject(drop3);
					dropFx3.start('7389AE').chain(dropFx3.start.pass('ffffff', dropFx3));
				},
				'over': function()
				{
					dropFx3.start('98B5C1');
				},
				'leave': function()
				{
					dropFx3.start('ffffff');
				}
			});
			/*drop4.addEvents(
			{
				'drop': function()
				{
					//pongo el valor del id del producto a la variable oculta correspondiente del formulario
					var prod4 = $('frm_admin_ini_ecommerce').getElement('input[name=id_prod4]');
					prod4.setProperty('value', temp.value);
					///////////////////////////////////////
					drop.removeEvents();
					drop2.removeEvents();
					drop3.removeEvents();
					drop4.removeEvents();
					clone.remove();
					cambiar_producto(drop4);
					item.clone().inject(drop4);
					dropFx4.start('7389AE').chain(dropFx4.start.pass('ffffff', dropFx4));
				},
				'over': function()
				{
					dropFx4.start('98B5C1');
				},
				'leave': function()
				{
					dropFx4.start('ffffff');
				}
			});*/
			var drag = clone.makeDraggable(
			{
				droppables: [drop,drop2,drop3]//se quito el drop4
			}); // this returns the dragged element
			drag.start(e); // start the event manual
		});
	});
}

function cambiar_producto(div_)
{
	//vaciar el div
	div_.empty();
	//construyo un nuevo elemento
	var nuevoDiv = new Element ("div");
	//Meto el texto dentro del elemento
	nuevoDiv.setHTML("Arrastre aqui");
	//injecto ese elemento en el div
	nuevoDiv.inject(div_);
	//pongo la clase de estilo para el texto
	nuevoDiv.addClass('info'); 
}

function enviar_form (site_url)
{
	//alert('entro en buscar productos');
	var url = site_url + '/admin/ini_ecommerce/cambiar';
	alert('Url: ' + url);
	var ajax1 = new Ajax(url,
	{
		method: 'post',
		data: $('frm_admin_ini_ecommerce').toQueryString(),
		update: 'div_contenido',
		evalScripts: true,//permite que pueda ejecutar codigo javascript enviado en la respuesta del html
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.request();
}

function validar_form ()
{
	var ruta_aux = $('frm_admin_ini_ecommerce').getElement('input[name=ruta_aux]');
	var ruta_aux2 = $('frm_admin_ini_ecommerce').getElement('input[name=ruta_aux2]');
	if($('ruta_etiqueta').value == "" && ruta_aux2.value == "")
	{
		alert('Debe indicar la ruta del archivo.\nPara esto haga clic en el botón examinar');
		$('ruta_etiqueta').focus();
		return false;
	}
	if($('ruta').value == "" && ruta_aux.value == "")
	{
		alert('Debe indicar la ruta del archivo.\nPara esto haga clic en el botón examinar');
		$('ruta').focus();
		return false;
	}
	$('frm_admin_ini_ecommerce').getElement('input[name=ruta_aux_1]').value = $('ruta').value;
	$('frm_admin_ini_ecommerce').getElement('input[name=ruta_aux_2]').value = $('ruta_etiqueta').value;
	$('frm_admin_ini_ecommerce').submit();
}