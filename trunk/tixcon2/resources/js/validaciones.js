/*
Validaciones
*/

/*
Función validar numero

Argumentos
campo: corresponde al id del campo a ser validado.
dmin: Número mínimo aceptado para el campo a validar
dmax: Número máximo aceptado para el campo a validar
*/
function vNum(campo,dmin,dmax){
	
	var valor = $(campo).value;
	if(valor == '')
		return true;
		
	valor = parseInt(valor);
	if( (valor < dmin ) || (valor > dmax) ){
		var cadena = "Debe especificar un valor entre "+dmin+" y "+dmax;
		alert(cadena);
		$(campo).value = '';
		return false;
	}
	return true;
}
