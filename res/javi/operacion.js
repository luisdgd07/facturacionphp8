
function operacion()
{
	var num1=Number(document.getElementById("precio1").value);
	var num2=Number(document.getElementById("precio2").value);
	// var num3=Number(document.getElementById("q").value);
	var r=(num1-num2);
	var resultado=(r/num2*100);

	document.getElementById('resultado').value=resultado;
	
	
	
	
	
}


function operacionmoneda()
{
	var num3=Number(document.getElementById("valor").value);
	var num4=Number(document.getElementById("money").value);
	// var num5=Number(document.getElementById("valor").value);
	var pagototal=num3*num4;
	var cambio=num3;
	document.getElementById('pagototal').value=pagototal;
	document.getElementById('cambio').value=cambio;
}

// function tipocambio()
// {
// 	var num5=Number(document.getElementById("tipomoneda_id").value);
// 	var num6=Number(document.getElementById("tipomoneda_id").value);
// 	var cambio=num5;
// 	var cambio2=num6;
// 	document.getElementById('cambio').value=cambio;
// 	document.getElementById('cambio2').value=cambio2;

// }


