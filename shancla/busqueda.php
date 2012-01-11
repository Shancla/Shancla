<!-- JAVASCRIPT y ESTILO PARA BÚSQUEDA AVANZADA DESPLEGABLE -->
	<script type="text/javascript">   
	
	function avanzada(divId,accion) {
	  	var ver = document.getElementById(divId);
		var mas = document.getElementById('mas');
		var menos = document.getElementById('menos');
		var busqueda = document.getElementById('buscar');
	 	var barra = document.getElementById('buscador');
		if (accion == 1) {  
			ver.style.display = 'inline';
			mas.style.display = 'none';
			menos.style.display = 'inline';
			buscar.value = 'Buscar'
			barra.style.height = '70px';
			
		} else { 
			ver.style.display = 'none';
			mas.style.display = 'inline';
			menos.style.display = 'none';
			buscar.value = 'Buscar';
			barra.style.height = '45px';
		}	  
	} 

	</script>
    
	<style type='text/css'>
		#busqueda_avanzada {
			display:none;
			padding-left: 100px;
			float:none;
		}
		#menos {
			display:none;
			float:none;
		}
		#mas {
			display:inline;
			float:none;
		}
	</style>
<!-- Final de javascript y estilo para búsqueda avanzada desplegable -->




