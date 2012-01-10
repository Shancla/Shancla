$(document).ready(function(){
	validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    $(".enviar").click(function() {
        var nombre = $(".nombre").val();
            mail = $(".mail").val();
            mensaje = $(".mensaje").val();
			flag=1;
 
        if (nombre == "") {
            $(".nombre").focus().after("<span class='error'><img src='images/incorrecto.png' /></span>");
			flag=0;
            return false;
        }
		if(mail == "" || !validacion_email.test(email)){
            $(".mail").focus().after("<span class='error'><img src='images/incorrecto.png' /></span>");
			flag=0;
            return false;
        }
		if(mensaje == ""){
            $(".mensaje").focus().after("<span class='error'><img src='images/incorrecto.png' /></span>");
			flag=0;
            return false;
		}
		if(flag == 1) {
                $('.ajaxgif').removeClass('hide');
				var datos = 'nombre='+ nombre + '&mail=' + mail + '&telefono=' + telefono + '&mensaje=' + mensaje;
				$.ajax({
					type: "POST",
					url: "proceso.php",
					data: datos,
					success: function() {
						$('.ajaxgif').hide();
						$('.msg').text('Mensaje enviado!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);
					},
					error: function() {
						$('.ajaxgif').hide();
						$('.msg').text('Hubo un error!').addClass('msg_error').animate({ 'right' : '130px' }, 300);
					}
				});
				return false;
        }
 
    });
});