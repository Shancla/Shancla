//Cargar búsquedas
$(document).ready(function () {
	$(".buscador .busqueda").click(function () {
		var busqueda = $(".buscador .buscar").val();
		if( $(".buscador .buscar").val() == "" ) {
			$(".buscador .buscar").focus();
			return false;
		}
		else {
			var datos = 'busqueda=' + busqueda;
			$.ajax({
				type: "POST",
				url: "buscar.php",
				data: datos,
				success: function(data) {
					//map.clearOverlays();
					  var xml = GXml.parse(data);
					  var markers = xml.documentElement.getElementsByTagName("marker");
					  for (var i = 0; i < markers.length; i++) {
						  alert(markers.length);
						var id = markers[i].getAttribute("id");
						var marcador = markers[i].getAttribute("marcador");
						var punto = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
												parseFloat(markers[i].getAttribute("lng")));
						//var marker = createMarker(punto, id, titulo, descripcion, marcador);
						var marker = createMarker(punto, id, marcador);
						map.addOverlay(marker);
					  }
					  function createMarker(punto, id, marcador) {
      var marker = new GMarker(punto, customIcons[marcador]);	  
      GEvent.addListener(marker, 'click', function() {
		  $('.anuncio').hide(0);
		  var datos = 'id='+ id;
		$.ajax({
				type: "POST",
				url: "mostrar.php",
				data: datos,
				success: function(data) {
					$('.cargando').removeClass('hid'); /* Muestro el gif de carga del anuncio */
					presentar_datos(data); /* Llamada a la función para presentar los datos */
    				$(".chzn-select").chosen(); /* Llamada a la función para dar estilo a los campos select (Si se hace antes o después no funciona) */
					$('.anuncio').show('fast'); /* Despliego el div que contiene el anuncio */
					$('.cargando').hide(); /* Oculto el gif de carga del anuncio */
				},
				error: function() {
					
				}
			});
			return false;
      });
      return marker;
    }
				},
				error: function() {
					alert("error buscando");
				}
			});
			return false;
		}
	});
});
var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
//Comprobar contacto con el anunciante
$(document).ready(function () {
    $(".contacto_anunciante .comprobarcontacto").click(function (){
		var nombre = $(".contacto_anunciante .nombre").val();
            mail = $(".contacto_anunciante .mail").val();
            telefono = $(".contacto_anunciante .telefono").val();
			id = $(".contacto_anunciante .id_contacto").val();
            mensaje = $(".contacto_anunciante .mensaje").val();
        $(".contacto_anunciante .error").remove();
        if( $(".contacto_anunciante .nombre").val() == "" ){
            $(".contacto_anunciante .nombre").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir tu nombre' title='Debes introducir tu nombre' /></span>");
            return false;
        }else if( $(".contacto_anunciante .mail").val() == "" || !emailreg.test($(".contacto_anunciante .mail").val()) ){
            $(".contacto_anunciante .mail").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir un e-mail válido' title='Debes introducir un e-mail válido' /></span>");
            return false;
        }else if( $(".contacto_anunciante .mensaje").val() == "" ){
            $(".contacto_anunciante .mensaje").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir un mensaje' title='Debes introducir un mensaje' /></span>");
            return false;
        }else {
			$('.contacto_anunciante .ultimo').removeClass('hid');
			$('.contacto_anunciante .ajaxgif').removeClass('hid');
			var datos = 'nombre='+ nombre + '&mail=' + mail + '&telefono=' + telefono + '&id=' + id + '&mensaje=' + mensaje;
			$.ajax({
				type: "POST",
				url: "contactar_anunciante.php",
				data: datos,
				success: function() {
					$('.contacto_anunciante .ajaxgif').hide();
					$('.contacto_anunciante .ultimo').text('Mensaje enviado.');
					document.contacto_anunciante.reset();
				},
				error: function() {
					$('.contacto_anunciante .ajaxgif').hide();
					$('.contacto_anunciante.ultimo').text('Hubo un error enviando el mensaje. Intentelo mas tarde.');
				}
			});
			return false;	
		}
    });
    $(".contacto_anunciante .nombre, .contacto_anunciante .mensaje").keyup(function(){
        if( $(this).val() != "" ){
            $(".contacto_anunciante .error").fadeOut();
            return false;
        }
    });
    $(".contacto_anunciante .mail").keyup(function(){
        if( $(this).val() != "" && emailreg.test($(this).val())){
            $(".contacto_anunciante .error").fadeOut();
            return false;
        }
    });
});

//Comprobar contacto con el administrador
$(document).ready(function () {
    $(".contacto_admin .comprobar_contacto_admin").click(function (){
		var nombre = $(".contacto_admin .nombre").val();
            mail = $(".contacto_admin .mail").val();
            mensaje = $(".contacto_admin .mensaje").val();
        $(".contacto_admin .error").remove();
        if( $(".contacto_admin .nombre").val() == "" ){
            $(".contacto_admin .nombre").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir tu nombre' title='Debes introducir tu nombre' /></span>");
            return false;
        }else if( $(".contacto_admin .mail").val() == "" || !emailreg.test($(".contacto_admin .mail").val()) ){
            $(".contacto_admin .mail").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir un e-mail válido' title='Debes introducir un e-mail válido' /></span>");
            return false;
        }else if( $(".contacto_admin .mensaje").val() == "" ){
            $(".contacto_admin .mensaje").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir un mensaje' title='Debes introducir un mensaje' /></span>");
            return false;
        }else {
			$('.ultimo').removeClass('hid');
			$('.ajaxgif').removeClass('hid');
			var datos = 'nombre='+ nombre + '&mail=' + mail + '&mensaje=' + mensaje;
			$.ajax({
				type: "POST",
				url: "contactar_admin.php",
				data: datos,
				success: function() {
					$('.ajaxgif').hide();
					$('.ultimo').text('Mensaje enviado.');
					document.contacto_admin.reset();
				},
				error: function() {
					$('.ajaxgif').hide();
					$('.ultimo').text('Hubo un error enviando el mensaje. Intentelo mas tarde.');
				}
			});
			return false;	
		}
    });
    $(".contacto_admin .nombre, .contacto_admin .mensaje").keyup(function(){
        if( $(this).val() != "" ){
            $(".contacto_admin .error").fadeOut();
            return false;
        }
    });
    $(".contacto_admin .mail").keyup(function(){
        if( $(this).val() != "" && emailreg.test($(this).val())){
            $(".contacto_admin .error").fadeOut();
            return false;
        }
    });
});

//Comprobar denuncia
$(document).ready(function () {
    $(".denuncia .comprobar_denuncia").click(function (){
		alert("fdsf");
		var nombre = $(".denuncia .nombre").val();
            mail = $(".denuncia .mail").val();
			motivo = $(".denuncia .motivo").val();
            mensaje = $(".denuncia .mensaje").val();
			id = $(".denuncia .id_denunciar").val();
        $(".denuncia .error").remove();
        if( $(".denuncia .nombre").val() == "" ){
            $(".denuncia .nombre").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir tu nombre' title='Debes introducir tu nombre' /></span>");
            return false;
        }else if( $(".denuncia .mail").val() == "" || !emailreg.test($(".denuncia .mail").val()) ){
            $(".denuncia .mail").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir un e-mail válido' title='Debes introducir un e-mail válido' /></span>");
            return false;
        }else if( $(".denuncia .mensaje").val() == "" ){
            $(".denuncia .mensaje").focus().after("<span class='error'><img src='images/incorrecto.png' alt='Debes introducir un mensaje' title='Debes introducir un mensaje' /></span>");
            return false;
        }else {
			$('.ultimo').removeClass('hid');
			$('.ajaxgif').removeClass('hid');
			var datos = 'nombre='+ nombre + '&mail=' + mail + '&mensaje=' + mensaje + '&motivo=' + motivo + '&id=' + id;
			$.ajax({
				type: "POST",
				url: "denunciar.php",
				data: datos,
				success: function() {
					$('.ajaxgif').hide();
					$('.ultimo').text('Mensaje enviado.');
					document.denuncia.reset();
				},
				error: function() {
					$('.ajaxgif').hide();
					$('.ultimo').text('Hubo un error enviando el mensaje. Intentelo mas tarde.');
				}
			});
			return false;	
		}
    });
    $(".denuncia .nombre, .denuncia .mensaje").keyup(function(){
        if( $(this).val() != "" ){
            $(".denuncia .error").fadeOut();
            return false;
        }
    });
    $(".denuncia .mail").keyup(function(){
        if( $(this).val() != "" && emailreg.test($(this).val())){
            $(".denuncia .error").fadeOut();
            return false;
        }
    });
});