<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function contar()
{
	var n = parseInt(0);
	for (i=0;i<document.formulario.elements.length;i++) 
		if(document.formulario.elements[i].type == "checkbox")	
			if(document.formulario.elements[i].checked == true)
				n = parseInt(document.formulario.elements[i].value) + n;
	
	if(n <= 2){
		document.getElementById('total_valoracion').style.backgroundColor='#00FF00'
	}else if(n > 2 && n < 8){
		document.getElementById('total_valoracion').style.backgroundColor='#FFFF00'
	}else if(n >= 8){
		document.getElementById('total_valoracion').style.backgroundColor='#FF0000'
	}
	
	
	var h1 = document.getElementById('total_valoracion');
	h1.innerHTML = n;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<table width="95%" class="tabla_form">
<tr><th colspan="3">Valoración del riesgo de caídas. Escala de Crichton</th></tr>
<tr><td class="campo_centro" width="50%">Valoración del riesgo</td>
<td class="campo_centro" width="25%">Puntuación</td>
<td class="campo_centro" width="25%">Marca</td>
</tr>
<tr><td class="campo">Limitación física:</td><td class="campo_centro">2</td>
<td class="campo_centro"><input name="limitacion_fisica" id="limitacion_fisica" type="checkbox" value="2" onchange="contar()" /></td></tr>
<tr><td class="campo">Estado mental alterado:</td><td class="campo_centro">3</td>
<td class="campo_centro"><input name="estado_mental" id="estado_mental" type="checkbox" value="3" onchange="contar()" /></td></tr>
<tr><td class="campo">Tratamiento farmacológico que implica riesgo:</td><td class="campo_centro">2</td>
<td class="campo_centro"><input name="tratamiento_farmacologico" id="tratamiento_farmacologico" type="checkbox" value="2" onchange="contar()" /></td></tr>
<tr><td class="campo">Problemas de idioma o socioculturaes:</td><td class="campo_centro">2</td>
<td class="campo_centro"><input name="problemas_de_idioma" id="problemas_de_idioma" type="checkbox" value="2" onchange="contar()" /></td></tr>
<tr><td class="campo">Incontinencia urinaria:</td><td class="campo_centro">1</td>
<td class="campo_centro"><input name="incontinencia_urinaria" id="incontinencia_urinaria" type="checkbox" value="1" onchange="contar()" /></td></tr>
<tr><td class="campo">Déficit sensorial:</td><td class="campo_centro">2</td>
<td class="campo_centro"><input name="deficit_sensorial" id="deficit_sensorial" type="checkbox" value="2" onchange="contar()" /></td></tr>
<tr><td class="campo">Desarrollo psicomotriz:</td><td class="campo_centro">2</td>
<td class="campo_centro"><input name="desarrollo_psicomotriz" id="desarrollo_psicomotriz" type="checkbox" value="2" onchange="contar()" /></td></tr>
<tr><td class="campo">Pacientes sin factores de riesgo evidentes:</td><td class="campo_centro">1</td>
<td class="campo_centro"><input name="pacientes_sin_facores" id="pacientes_sin_facores" type="checkbox" value="1" onchange="contar()" /></td></tr>
<tr><td class="campo">Total:</td><td class="campo_centro">15</td>
<td id="total_valoracion" class="campo_centro">0</td></tr>                               
</table>