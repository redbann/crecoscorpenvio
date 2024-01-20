var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#imagenmuestra").hide();

    $.post("../ajax/pagosprestamos.php?op=selectprestamos", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_prest").html(r);
        $('#id_prest').selectpicker('refresh');
    });

	prueba();
}

function prueba(){
	if(navigator.geolocation){
		function success(pos){
				var pos_lat = pos.coords.latitude;
				var pos_lng = pos.coords.longitude;

				console.log(pos_lng);		
		}
		navigator.geolocation.getCurrentPosition(success)
	}
	
}

function initMap() {
	var latinput = parseFloat(document.getElementById('lat').value);
	var longinput= parseFloat(document.getElementById('lng').value);

	if(navigator.geolocation){
		function success(pos){
				var pos_lat = pos.coords.latitude;
				var pos_lng = pos.coords.longitude;

	

    const directionsRenderer = new google.maps.DirectionsRenderer();
    const directionsService = new google.maps.DirectionsService();
    const map = new google.maps.Map(document.getElementById("map-canvas"), {
      zoom: 14,
      center: { lat: pos_lat, lng: pos_lng },
    });
  
    directionsRenderer.setMap(map);
    calculateAndDisplayRoute(directionsService, directionsRenderer);
    document.getElementById("mode").addEventListener("change", () => {
      calculateAndDisplayRoute(directionsService, directionsRenderer);
    });

	console.log(pos_lng);		
}
navigator.geolocation.getCurrentPosition(success)
}	
  }
  
  function calculateAndDisplayRoute(directionsService, directionsRenderer) {
    const selectedMode = document.getElementById("mode").value;

	var latinput = parseFloat(document.getElementById('lat').value);
	var longinput= parseFloat(document.getElementById('lng').value);

	console.log(latinput);
	console.log(longinput);

	if(navigator.geolocation){
		function success(pos){
				var pos_lat = pos.coords.latitude;
				var pos_lng = pos.coords.longitude;

				console.log(pos_lng);		
		
  
    directionsService
      .route({
        origin: { lat: pos_lat, lng: pos_lng},
        destination: { lat: latinput, lng: longinput},
        // Note that Javascript allows us to access the constant
        // using square brackets and a string value as its
        // "property."
        travelMode: google.maps.TravelMode[selectedMode],
      })
      .then((response) => {
        directionsRenderer.setDirections(response);
      })
      .catch((e) => window.alert("Directions request failed due to " + status));
  }

}
	navigator.geolocation.getCurrentPosition(success)
}
  
  //window.initMap = initMap;

/* function drawMap(latlng){
	var options={zoom:14, center:latlng, mapTypeId: google.maps.MapTypeId.ROADMAP};
	var map= new google.maps.Map(parent.document.getElementById("map-canvas"),options);

	var marker = new google.maps.Marker
	({
		position: latlng,
		map: map,
		title: "Usted se encuentra acá!",
		position: map.getCenter(),
		draggable:true,
	})

	google.maps.event.addListener(marker, "dragend", function(){
		getCoords(marker);
	});
	marker.setMap(map);
	getCoords(marker);
} */

/* function getCoords(marker){
	parent.document.getElementById("lat").value=''+marker.getPosition().lat();
	parent.document.getElementById("lng").value=''+marker.getPosition().lng(); 
}

var defaultLatLng = new google.maps.LatLng(10.474992, -66815356); */

/* function init_map(){
	if(navigator.geolocation){
		function success(pos){
			lat=$("#lat").val();
			lng=$("#lng").val();

			console.log(lat);
				var pos_lat1 = lat;
				var pos_lng1 = lng;

				drawMap(new google.maps.LatLng(pos_lat1,pos_lng1));
		}

		function fail(error){
			drawMap(defaultLatLng);
		}
		navigator.geolocation.getCurrentPosition(success,fail)
	}
	else{
		drawMap(defaultLatLng);
	}
} */

//Función limpiar
function limpiar()
{
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

	$("#id_pago").val("");
    $("#id_prest").val("");
	$("#monto_mensual").val("");
	$("#fecha_pago").val("");
	$("#fecha_limite").val("");
	$("#mora").val("");
	$("#totalpagar").val("");
    $("#lat").val("");
    $("#lng").val("");
	$("#fecha_reg").val(today);
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	lat=$("#lat").val();
	lng=$("#lng").val();

	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#btnreporte").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btnreporte").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
    
    var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();

	tabla=$('#tbllistado').dataTable(
	{
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
	    buttons: [		          
		            /* 'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf' */
		        ],
		"ajax":
				{
					url: '../ajax/pagosprestamos.php?op=listar',
                    data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
            "copyTitle": "Tabla Copiada",
            "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/pagosprestamos.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(id_pago)
{
	$.post("../ajax/pagosprestamos.php?op=mostrar",{id_pago : id_pago}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

		$("#id_pago").val(data.id_pago);
        $("#id_prest").val(data.id_prest);
        $('#id_prest').selectpicker('refresh');
		$("#monto_mensual").val(data.monto_mensual);
		$("#fecha_pago").val(data.fecha_pago);
		$("#fecha_limite").val(data.fecha_limite);
		$("#mora").val(data.mora);
		$("#totalpagar").val(data.totalpagar);
        $("#lat").val(data.lat);
		$("#lng").val(data.lng);
		if(data.fecha_reg != null){
            $("#fecha_reg").val(data.fecha_reg);
        }else{
            $("#fecha_reg").val(today);
        }

		initMap();
 	});
 	
}

//Función para desactivar registros
function desactivar(id_cliente)
{
	bootbox.confirm("¿Está seguro de desactivar el cliente?", function(result){
		if(result)
        {
        	$.post("../ajax/clientes.php?op=desactivar", {id_cliente : id_cliente}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_cliente)
{
	bootbox.confirm("¿Está seguro de activar el cliente?", function(result){
		if(result)
        {
        	$.post("../ajax/clientes.php?op=activar", {id_cliente : id_cliente}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();