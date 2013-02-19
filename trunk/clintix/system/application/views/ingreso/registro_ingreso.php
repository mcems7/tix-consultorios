<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />

<script type="text/javascript">
var id=0;
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////////////////////////////////////////////////
function validarFormulario()
{	
  if (confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}

 function actualizarListaMedico()
 {
    var var_url = '<?=site_url()?>/agenda/agenda_medicos/listar_especialistas_por_especialidad/'+$('id_especialidad').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                                    $('lista_medicos_consultorio').set('html', html)
                                     },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();
     
 }

window.addEvent("domready", function(){	
  $('fecha_agenda').value="<?=date('Y')?>-<?=date('m')?>-<?=date('d');?>"
 
	    	
});
//


///////////////////////////////////////////////////////////////////////////////
//

///////////////////////////////////////////////////////////////////////////////
//

</script>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Ingreso Especialista</h2>
<div id="carga_agenda">
    <table width="100%" class="tabla_form">
<tr><th colspan="2"><em>Datos a guardar</em></th></tr>
<tr><td colspan="2">
    <?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/ingreso/ingreso_especialistas/crearNota_',$attributes);
?>
<table width="100%" class="tabla_interna">
<tr>
  <td class="campo_izquierda" width="20%">Fecha:</td>
  <td class="campo_izquierda"><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
  <img src='http://localhost/yage/resources/img/calendario_boton.png' id='fec leha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
<script type='text/javascript'>
Calendar.setup({
    inputField     :    'fecha_agenda',     		// id of the input field
    ifFormat       :    '%Y-%m-%d',
    daFormat       :    '%Y-%m-%d',          // format of the input field
    displayArea	   :	'fecha_agenda',
    showsTime      :	true,
    timeFormat     :    '12',
    button         :    'fecha_agenda_botton',       // trigger for the calendar (button ID)
    align          :    'Br',                   // alignment (defaults to 'Bl')
    singleClick    :    true
});
</script></td>
 
</tr>

<tr>
    <td class="campo_izquierda" width="20%">Especialidad:</td><td id="lista_especialidadess"><?=form_dropdown('id_especialidad',$listadoEspecialidades,'-1','id="id_especialidad" onChange="actualizarListaMedico()"')?></td>
  </td></tr>

<tr>
     <td class="campo_izquierda" width="20%">Especialista:</td><td id="lista_medicos_consultorio"></td></tr>
</tr>
<tr>
     <td class="campo_izquierda" width="20%">Hora de llegada:</td><td>
<input type="text" id="hora_llegada" name="hora_llegada"/>
<div id="capaError" style="color:red; visibility:hidden;"></div> </td></tr>
</tr>
<tr>
     <td class="campo_izquierda" width="20%">Hora Agendada:</td><td>
<input type="text" id="hora_agendada" name="hora_agendada"/>
<div id="capaError1" style="color:red; visibility:hidden;"></div> </td></tr>
</tr>


<tr>
<td colspan="2">
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</td>
</tr>




<script type="text/javascript">

var laCaja=document.getElementById("hora_llegada");
var valor="";    
var laCaja1=document.getElementById("hora_agendada");
var valor1="";                                    //los números que vayamos ingresando en la caja

/********
    MANEJADORES PARA EL CASO DE ERROR
********/
var capaError=document.getElementById("capaError");
var capaError1=document.getElementById("capaError1");

var errorMostrandose=false;
var errorMostrandose1=false;                        //variable de control que nos informa de si estamos mostrando la capaError
function mostrarError(errnum,str) {        //mostrar
    var cont;
    switch(errnum) {
        case 0: cont=str; break;
        case 1: cont="Caracter no permitido en esa posicion. Formato <b>HH:MM</b> 24h. Ejemplo: 23:59."; break;
        case 2: cont=laCaja.value+" no es una hora completa, termine de rellenarla por favor."; break;
        default: cont="Error de formato HH:MM"; break;
    }
    capaError.innerHTML=cont;
    capaError.style.visibility="visible";
    errorMostrandose=true;
    return false;
	
	
}
function mostrarError1(errnum,str) {        //mostrar
    var cont;
    switch(errnum) {
        case 0: cont=str; break;
        case 1: cont="Caracter no permitido en esa posicion. Formato <b>HH:MM</b> 24h. Ejemplo: 23:59."; break;
        case 2: cont=laCaja1.value+" no es una hora completa, termine de rellenarla por favor."; break;
        default: cont="Error de formato HH:MM"; break;
    }
	capaError1.innerHTML=cont;
    capaError1.style.visibility="visible";
    errorMostrandose1=true;
    return false;
	
	
}
function ocultarError() {                //ocultar
    capaError.style.visibility="hidden";
    errorMostrandose=false;
    return true;
}
function ocultarError1() {                //ocultar
    capaError1.style.visibility="hidden";
    errorMostrandose1=false;
    return true;
}

/********
    SUSTITUYE HH:MM DEL CAMPO POR LO QUE VAYAMOS ESCRIBIENDO
********/
function ponMascara(valueActual,mascaraTotal) {
    var mascara=mascaraTotal.substring( valueActual.length, mascaraTotal.length );
    laCaja.value=valueActual+mascara;
}
function ponMascara1(valueActual,mascaraTotal) {
    var mascara1=mascaraTotal.substring( valueActual.length, mascaraTotal.length );
    laCaja1.value=valueActual+mascara1;
}

/********
    VALIDACIÓN DE LA HORA: Devuelve true en caso de que el caracter sea válido en la posición pos para el formato HH:MM 24h
********/
function esValidoHHMM(c,pos) {
    if( pos==1 )                // primer caracter de las horas (entre 0 y 2)
        return /^[0-2]$/.test(c);
    else if( pos==2 )            // segundo caracter de las horas (depende del primero)
        return /^(0[6-9])|(1[0-9])|(2[0-3])$/.test(valor+c);
    else if( pos==3 || pos==4 )    // primer caracter de los minutos (entre 0 y 5)
        return /^[0-5]$/.test(c);
    else if( pos==5 )             // segundo caracter de los minutos (entre 0 y 9)
        return /^[0-9]$/.test(c);
    else                        // cualquier otro caso
        return false;
}
function esValidoHHMM1(c,pos) {
    if( pos==1 )                // primer caracter de las horas (entre 0 y 2)
        return /^[0-2]$/.test(c);
    else if( pos==2 )            // segundo caracter de las horas (depende del primero)
        return /^(0[6-9])|(1[0-9])|(2[0-3])$/.test(valor1+c);
    else if( pos==3 || pos==4 )    // primer caracter de los minutos (entre 0 y 5)
        return /^[0-5]$/.test(c);
    else if( pos==5 )             // segundo caracter de los minutos (entre 0 y 9)
        return /^[0-9]$/.test(c);
    else                        // cualquier otro caso
        return false;
}
/********
    COLOCACIÓN DEL CURSOR: Da el foco a la caja colocando el cursor de inserción en la posición pos
********/
function ponCursorEnPos(pos){ 
    if(typeof document.selection != 'undefined' && document.selection){        //método IE
        var tex=laCaja.value;
        laCaja.value=''; 
        forzar_focus();            //debería ser focus(), pero nos salta el evento y no queremos
        var str = document.selection.createRange(); 
        laCaja.value=tex;
        str.move("character", pos); 
        str.moveEnd("character", 0); 
        str.select();
    }
    else if(typeof laCaja.selectionStart != 'undefined'){                    //método estándar
        laCaja.setSelectionRange(pos,pos); 
        forzar_focus();            //debería ser focus(), pero nos salta el evento y no queremos
    }
} 

function ponCursorEnPos1(pos){ 
    if(typeof document.selection != 'undefined' && document.selection){        //método IE
        var tex=laCaja1.value;
        laCaja1.value=''; 
        forzar_focus1();            //debería ser focus(), pero nos salta el evento y no queremos
        var str = document.selection.createRange(); 
        laCaja1.value=tex;
        str.move("character", pos); 
        str.moveEnd("character", 0); 
        str.select();
    }
    else if(typeof laCaja1.selectionStart != 'undefined'){                    //método estándar
        laCaja1.setSelectionRange(pos,pos); 
        forzar_focus1();            //debería ser focus(), pero nos salta el evento y no queremos
    }
} 

/********
    ONKEYPRESS: controlará cada caracter, si es especial haremos su función, si es válido lo escribirá, y si es inválido muestra error
********/
laCaja.onkeypress=function(e){
    var code;
    if (!e) var e = window.event;
    if (e.keyCode) code = e.keyCode;            // detectamos el codigo de la tecla
    else if (e.which) code = e.which;
    var caracter = String.fromCharCode(code);    // extraemos su caracter
    if (code==8) {        // caracter BACKSPACE para borrar números de la caja
        // borramos un caracter de valor, y si hay un ":" borramos dos
        if(valor.length==3)                    //hay colocado HH:
            valor=valor.substring(0,1);             //dejamos H
        else if(valor.length>0)                //si hay algo que borrar, borramos un caracter
            valor=valor.substring(0,valor.length-1);
        ponMascara(valor,"HH:MM");                    //actualizamos el contenido
        ponCursorEnPos(valor.length);                //movemos el cursor ya que el contenido ha sido modificado
        if(errorMostrandose) ocultarError();        //ocultamos el error si hubiera
    }
    else if( esValidoHHMM(caracter, valor.length+1) ) {        // si es un número válido en el contexto, lo añadiremos
        if(valor.length==2)
            valor+=":";
        if(valor.length<"HH:MM".length)
            valor+=caracter;
        ponMascara(valor,"HH:MM");                //actualizamos el contenido
        ponCursorEnPos(valor.length);            //movemos el cursor ya que el contenido ha sido modificado
        if(errorMostrandose) ocultarError();    //ocultamos el error si hubiera
    }
    else 
        mostrarError(1);    // caracter NO PERMITIDO
    return false;        //nunca aceptaremos que el evento continúe, controlaremos el value siempre nosotros
}
laCaja1.onkeypress=function(e){
    var code1;
    if (!e) var e = window.event;
    if (e.keyCode) code1 = e.keyCode;            // detectamos el codigo de la tecla
    else if (e.which) code1 = e.which;
    var caracter1 = String.fromCharCode(code1);    // extraemos su caracter
    if (code1==8) {        // caracter BACKSPACE para borrar números de la caja
        // borramos un caracter de valor, y si hay un ":" borramos dos
        if(valor1.length==3)                    //hay colocado HH:
            valor1=valor1.substring(0,1);             //dejamos H
        else if(valor1.length>0)                //si hay algo que borrar, borramos un caracter
            valor1=valor1.substring(0,valor1.length-1);
        ponMascara1(valor1,"HH:MM");                    //actualizamos el contenido
        ponCursorEnPos1(valor1.length);                //movemos el cursor ya que el contenido ha sido modificado
        if(errorMostrandose1) ocultarError1();        //ocultamos el error si hubiera
    }
    else if( esValidoHHMM1(caracter1, valor1.length+1) ) {        // si es un número válido en el contexto, lo añadiremos
        if(valor1.length==2)
            valor1+=":";
        if(valor1.length<"HH:MM".length)
            valor1+=caracter1;
        ponMascara1(valor1,"HH:MM");                //actualizamos el contenido
        ponCursorEnPos1(valor1.length);            //movemos el cursor ya que el contenido ha sido modificado
        if(errorMostrandose1) ocultarError1();    //ocultamos el error si hubiera
    }
    else 
        mostrarError1(1);    // caracter NO PERMITIDO
    return false;        //nunca aceptaremos que el evento continúe, controlaremos el value siempre nosotros
}




/********
    MANEJADOR PARA EL FOCO: Función para el evento onfocus
********/
function focus_handler() {
    ponCursorEnPos(valor.length);
}
laCaja.onfocus=focus_handler;
function focus_handler1() {
    ponCursorEnPos1(valor1.length);
}
laCaja1.onfocus=focus_handler1;

/********
    MANEJADOR PARA EL FOCO: hace el focus sin hacer saltar el evento onfocus, es decir, sin hacer saltar focus_handler
********/
function forzar_focus() {
    laCaja.onfocus=null;                            //quito
    laCaja.focus();                                    //hago
    setTimeout("laCaja.onfocus=focus_handler",1);    //pongo (retrasado para IE...)
}
function forzar_focus1() {
    laCaja1.onfocus=null;                            //quito
    laCaja1.focus();                                    //hago
    setTimeout("laCaja1.onfocus=focus_handler1",1);    //pongo (retrasado para IE...)
}

/********
    ONBLUR: Comprueba si la hora está a medias para escribir el error
********/
laCaja.onblur=function() {
    if(valor.length>0 && valor.length<5)        //hora incompleta
        mostrarError(2);
    else if(errorMostrandose) ocultarError();    //ocultamos el error si hubiera
}
laCaja1.onblur=function() {
    if(valor1.length>0 && valor1.length<5)        //hora incompleta
        mostrarError1(2);
    else if(errorMostrandose1) ocultarError1();    //ocultamos el error si hubiera
}


ponMascara("","HH:MM");
ponMascara1("","HH:MM");        //inicialización




</script> 
</table>
<table>


</table>
<?=form_close();?>
    
        
        
    </table>
</div>

