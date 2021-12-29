$(document).ready(function () {

    //Change
    $('#comentarios').change(function(){
        $('#comentarios').val($(this).val());
    });



    // FOcus
    $("textarea").focus(function(){
        $("span").css("display", "inline").fadeOut(5000);
      });

      $("#btn1").click(function(){
        $("input").focus();
        $("p").html("focus event triggered");
      });  

    //FUNCION keyup
    $("#precio").keydown(function () {
        $("#precio").css("background-color", "#F8EFBA");
    });
    $("#precio").keyup(function () {
        $("#precio").css("background-color", "pink");
    });


    //Boton mouse over  
    $('#agregar').on({
        'mouseover': function () {
            $(this).text('Nueva factura');
        },
        'mouseout': function () {
            $(this).text('Nuevo');
        }
    });

    //Funcion click

    $("#guardar").click(function () {
        $("#guardar").text("Factura guardada");
        alert("Factura guardada");
    });

  
    var modal = document.getElementById("modal");
    var btn = document.getElementById("agregar");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
        modal.style.display = "block";
    }
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    //Generar registros
    $("#guardar").click(function () {

        var _id = document.getElementById("ip").value;
        var _odo = document.getElementById("odo").value;
        var _paciente = document.getElementById("paciente").value;
        var _fecha = document.getElementById("fecha").value;
        var _pago = document.getElementById("pago").value;
        var _pedpago = document.getElementById("pedpago").value;
        var _tratamiento = document.getElementById("tratamiento").value;
        var _comentarios = document.getElementById("comentarios").value;
        var _total = document.getElementById("total").value;

        var fila = "<tr><td>" + _id + "</td><td>" + _fecha + "</td><td>" + _paciente + "</td><td>" + _tratamiento +
            "</td><td>" + _pago + "</td><td>" + _total + "</td><td>Pendiente" +
            "</td><td> <button type='button' id='guardar' class='btn btn-success'>Guardar </button> <br> <button type='button' id='pagado' class='btn btn-danger'>Pagado </button>" +
            "</td></tr>";

        var btn = document.createElement("TR");
        btn.innerHTML = fila;
        document.getElementById("registro").appendChild(btn);

        var arreglo = ({
            _id,
            _odo,
            _paciente,
            _fecha,
            _pago,
            _pedpago,
            _tratamiento,
            _comentarios,
            _total
        });
        console.log(arreglo);

    });


    //Checked
  	
    $("input[name=pago]").click(function () {    
        alert("El tipo de pago seleccionado es: " + $('input:radio[name=pago]:checked').val());
        alert("El tipo de pago seleccionado es: " + $(this).val());
       
        
        switch ($('input:radio[name=pago]:checked').val()) { 
	case 'credito': 
		  $('#pago1').attr('disabled', true);
           $("#pago1").prop("checked", true);
            $('#pago2').attr('disabled', true);
             $('#pago3').attr('disabled', true);
		break;
	case 'contado': 
		 $('#pago1').attr('disabled', false);
         $("#pago2").prop("checked", true);
         $('#pago2').attr('disabled', false);
         $('#pago3').attr('disabled', true);
		break;
	case '5%': 
		 $('#pago1').attr('disabled', false);
         $("#pago1").prop("checked", true);
         $('#pago2').attr('disabled', false);
         $('#pago3').attr('disabled', false);
		break;		
	default:
		alert('NO PASA NADA');
		
          }
    });

});


