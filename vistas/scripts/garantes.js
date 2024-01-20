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

}

//Función limpiar
function limpiar()
{
	
	$("#id_garante").val("");
    $("#cedula").val("");
	$("#nombres").val("");
	$("#apellidos").val("");
	$("#direccion").val("");
	$("#telefono").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();

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
					url: '../ajax/garantes.php?op=listar',
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
		url: "../ajax/garantes.php?op=guardaryeditar",
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

function mostrar(id_garante)
{
	$.post("../ajax/garantes.php?op=mostrar",{id_garante : id_garante}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id_garante").val(data.id_garante);
        $("#cedula").val(data.cedula);
		$("#nombres").val(data.nombres);
		$("#apellidos").val(data.apellidos);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
 	});
 	
}

//Función para desactivar registros
function desactivar(id_garante)
{
	bootbox.confirm("¿Está seguro de desactivar el garante?", function(result){
		if(result)
        {
        	$.post("../ajax/garantes.php?op=desactivar", {id_garante : id_garante}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(id_garante)
{
	bootbox.confirm("¿Está seguro de activar el garante?", function(result){
		if(result)
        {
        	$.post("../ajax/garantes.php?op=activar", {id_garante : id_garante}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();