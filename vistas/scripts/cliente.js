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
	
	
	//$('#mAcceso').addClass("treeview active");
    //$('#lUsuarios').addClass("active");
}

function drawMap(latlng){
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
}

function getCoords(marker){
	parent.document.getElementById("lat").value=''+marker.getPosition().lat();
	parent.document.getElementById("lng").value=''+marker.getPosition().lng(); 

	/* parent.document.getElementById("lat").value='10.474992';
	parent.document.getElementById("lng").value='-66815356'; */
}

var defaultLatLng = new google.maps.LatLng(10.474992, -66815356);

function init_map(){
	if(navigator.geolocation){
		function success(pos){
			lat=$("#lat").val();
			lng=$("#lng").val();
			id_cliente=$("#id_cliente").val();

			console.log(lat);

		/* 	var pos_lat = pos.coords.latitude;
			var pos_lng = pos.coords.longitude; */
			if(id_cliente != '' && lat != '' && lng != ''){
				console.log("hola");
				var pos_lat1 = lat;
				var pos_lng1 = lng;

				drawMap(new google.maps.LatLng(pos_lat1,pos_lng1));
			}else if(lat == null && lng == null && id_cliente != ''){
				console.log("hola");
				var pos_lat = pos.coords.latitude;
				var pos_lng = pos.coords.longitude;

				drawMap(new google.maps.LatLng(pos_lat,pos_lng));
			}else{
				var pos_lat = pos.coords.latitude;
				var pos_lng = pos.coords.longitude;

				drawMap(new google.maps.LatLng(pos_lat,pos_lng));
			}
			/* var pos_lat = '-0.16376637272617106';
			var pos_lng = '-78.47991391623576'; */

			
		}

		function fail(error){
			drawMap(defaultLatLng);
		}
		navigator.geolocation.getCurrentPosition(success,fail)
	}
	else{
		drawMap(defaultLatLng);
	}
}

/* window.onload = function(){
	init_map();
} */

//Función limpiar
function limpiar()
{
	
	$("#id_cliente").val("");
    $("#cedula").val("");
	$("#nombre").val("");
	$("#apellido").val("");
	$("#direccion_dom").val("");
	$("#direccion_tra").val("");
	$("#telefono").val("");
	$("#nombre_conyuge").val("");
	$("#cedula_conyuge").val("");
	$("#lat").val("");
	$("#lng").val("");
	//init_map();
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	init_map();
	lat=$("#lat").val();
	lng=$("#lng").val();

	console.log(lat);
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
					url: '../ajax/clientes.php?op=listar',
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
		url: "../ajax/clientes.php?op=guardaryeditar",
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

function mostrar(id_cliente)
{
	$.post("../ajax/clientes.php?op=mostrar",{id_cliente : id_cliente}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id_cliente").val(data.id_cliente);
        $("#cedula").val(data.cedula);
		$("#nombre").val(data.nombres);
		$("#apellido").val(data.apellidos);
		$("#direccion_dom").val(data.direccion);
		$("#lat").val(data.lat);
		$("#lng").val(data.lng);
		$("#telefono").val(data.telefono);
		$("#direccion_tra").val(data.direccion_tra);
		$("#nombre_conyuge").val(data.nombre_conyuge);
		$("#cedula_conyuge").val(data.cedula_conyuge);
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