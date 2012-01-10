/* Author: 

*/
<!-- Google Maps API functions -->
	
    function initialize() {
		document.buscador.busqueda.focus();
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(39.939178,-1.534070), 6);
        map.setUIToDefault();
      }
	  GDownloadUrl("generaxml.php", function(data) {
          var xml = GXml.parse(data);
          var markers = xml.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
			var id = markers[i].getAttribute("id");
			var titulo = markers[i].getAttribute("titulo");
			var descripcion = markers[i].getAttribute("descripcion");
			var tipo = markers[i].getAttribute("tipo");
			var imagenes = markers[i].getAttribute("imagenes");
			var video = markers[i].getAttribute("video");
			var etiquetas = markers[i].getAttribute("etiquetas");
			var precio = markers[i].getAttribute("precio");
            var marcador = markers[i].getAttribute("marcador");
			var fecha = markers[i].getAttribute("fecha");
			var expira = markers[i].getAttribute("expira");
			var email = markers[i].getAttribute("email");
			var telefono = markers[i].getAttribute("telefono");
			var clave = markers[i].getAttribute("clave");
			var visitas = markers[i].getAttribute("visitas");
			var direccion = markers[i].getAttribute("direccion");
            var punto = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                    parseFloat(markers[i].getAttribute("lng")));
			//var marker = createMarker(punto, id, titulo, descripcion, marcador);
            var marker = createMarker(punto, id, titulo, descripcion, tipo, imagenes, video, etiquetas, precio, marcador, fecha, expira, email, telefono, clave, visitas, direccion);
            map.addOverlay(marker);
          }
        });
    }
	function createMarker(punto, id, titulo, descripcion, tipo, imagenes, video, etiquetas, precio, marcador, fecha, expira, email, telefono, clave, visitas, direccion) {
      var marker = new GMarker(punto, customIcons[marcador]);
	  function showdate(mydate){
		var year = mydate.getYear()
		if (year < 1000)
		 year += 1900
		var day = mydate.getDay()
		var month = mydate.getMonth()
		var daym = mydate.getDate()
		if (daym < 10)
		 daym = "" + daym
		var montharray = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
		return daym + " de " + montharray[month] + " del " + year;
	   }
	  var html = "<p class='fecha'>" + showdate(new Date(fecha)) + "</p>";
	  var html = html + "<h1 class='titulo yanone centrado'>" + titulo + "</h1>";
	  var html = html + "<div class='etiqueta'><p class='precio'>" + precio + " &euro;</p></div><!-- etiqueta -->";
	  var introduccion = descripcion.substr(0, 100); 
	  var html = html + "<div class='descripcion'><h1 class='yanone'>Descripción</h1><p><a href='#desc' class='descrp'>" + introduccion + "...[+]</a></p></div><!-- descripcion -->";
	  var html = html + '<div class="inline hid" id="desc"><h1 class="yanone">Descripción</h1><hr/><p>' + descripcion + '</p></div><!-- inline desc -->';
	  var html = html + '<hr/>';
	  var html = html + '<ul class="media">';
	  var listaimagenes = imagenes.split(/,\s*/);
	  for(var i in listaimagenes) {
		var html = html + '<li><a class="fancybox" rel="' + id + '" href="images/fotos/' + listaimagenes[i] + '"><img src="images/fotos/' + listaimagenes[i] + '" alt="' + listaimagenes[i] + '" /></a></li>';
	  }
	  if (video!="") {
	  var html = html + '<li><a class="various fancybox.iframe" href="' + video + '"><img src="images/play.png" alt="" /></a></li>';
	  }
	  var html = html + '</ul><!-- media -->';
	  var html = html + '<hr/>';
	  var html = html + '<h1 class="yanone">Etiquetas</h1>';
	  var html = html + '<ul class="tags">';
	  var listaetiquetas = etiquetas.split(/,\s*/);
	  for(var i in listaetiquetas) {
		var html = html + '<li><a href="#" class="tag"><span class="tag_name">' + listaetiquetas[i] + '</span></a></li>';
	  }
	  var html = html + '</ul><!-- tags -->';
	  var html = html + '<hr/>';
	  var html = html + '<a href="#denunciar" class="denunciar inline">Denunciar</a>';
	  var html = html + '<div class="inline" id="denunciar">';
	  var html = html + '<div class="form_contacto">';
	  var html = html + '<h1 class="yanone centrado">Denunciar</h1><hr/>';
	  var html = html + '<form method="POST" action="">';
	  var html = html + '<dl><dt><label for="nombre">Nombre*</label></dt>';
	  var html = html + '<dd><input type="text" name="nombre" /><br/></dd>';
	  var html = html + '<dt><label for="mail">E-mail*</label></dt>';
	  var html = html + '<dd><input type="text" name="mail" /><br/></dd>';
	  var html = html + '<dt><label for="motivo">Motivo*</label></dt>';
	  var html = html + '<dd><select name="motivo" class="chzn-select">';
		var html = html + '<option value="inapropiado">Contenido inapropiado</option>';
		var html = html + '<option value="estafa">Estafa</option>';
		var html = html + '<option value="abusivo">Precio abusivo</option>';
	  var html = html + '</select></dd>';
	  var html = html + '<dt><label for="mensaje">Mensaje*</label></dt>';
	  var html = html + '<dd><textarea name="mensaje"></textarea><br/></dd>';
	  var html = html + '<input type="hidden" name="id_denunciar" class="id_denunciar" value="'+id+'" />';
	  var html = html + '<input type="submit" name="enviar" value="Enviar" class="boton" />';
	  var html = html + '</dl></form>';
	  var html = html + '</div><!-- form_contacto -->';
	  var html = html + '</div><!-- inline contactar_administrador -->';
	  
      //var html = "<h1 class="yanone centrado">" + titulo + "</h1>" + id + descripcion + marcador;
      GEvent.addListener(marker, 'click', function() {
	    document.contacto_anunciante.email_contacto.value=email;
	    $('.telefono_contacto').html(telefono);
		$('.anuncio').hide(0);
		$('.contenido').html(html);
		$('.anuncio').show('fast');
      });
      return marker;
    }
/*-- Tiny Scrollbar --*/
    $(document).ready(function(){
      $('#scrollbar1').tinyscrollbar();	
    });
/*-- Fancybox --*/ 
        $(document).ready(function() {
            $("a.fancybox").fancybox({
				closeClick	: false
			});
        });
		$(document).ready(function() {
            $("a.inline").fancybox({
				closeClick	: false,
			});
        });
		$(document).ready(function() {
            $("a.descrp").fancybox({
				closeClick	: false,
				autoSize: false,
				width: 300,
				height: 300
			});
        });
		$(document).ready(function() {
			$(".various").fancybox({
				maxWidth	: 800,
				maxHeight	: 600,
				fitToView	: false,
				width		: '70%',
				height		: '70%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
/*-- Selects --*/
    $(".chzn-select").chosen();
