var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
    document.getElementById("plazodiv").style.display = "block";

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#imagenmuestra").hide();
	
    $.post("../ajax/prestamos.php?op=selectusuarios", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_usuario").html(r);
        $('#id_usuario').selectpicker('refresh');
    });

    $.post("../ajax/prestamos.php?op=selectclientes", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cliente").html(r);
        $('#id_cliente').selectpicker('refresh');
    });

    $.post("../ajax/prestamos.php?op=selectplazos", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_plazo").html(r);
        $('#id_plazo').selectpicker('refresh');
    });

	$.post("../ajax/prestamos.php?op=selectgarantes", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_garante").html(r);
        $('#id_garante').selectpicker('refresh');
    });
}


//Función limpiar
function limpiar()
{
	$("#id_prest").val("");
    $("#id_usuario").val("");
	$('#id_usuario').selectpicker('refresh');
	$("#id_cliente").val("");
	$('#id_cliente').selectpicker('refresh');
    $("#id_plazo").val("");
	$('#id_plazo').selectpicker('refresh');
	$("#monto").val("");
    $("#fecha_prest").val("");
    $("#id_garante").val("");
	$('#id_garante').selectpicker('refresh');
    $("#dia_cobro").val("");
    $("#dia_limite").val("");
    $("#interes_mora").val("");
    document.getElementById("plazodiv").style.display = "block";
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
					url: '../ajax/prestamos.php?op=listar',
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
		url: "../ajax/prestamos.php?op=guardaryeditar",
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

function mostrar(id_prest)
{
	$.post("../ajax/prestamos.php?op=mostrar",{id_prest : id_prest}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id_prest").val(data.id_prest);
        $("#id_usuario").val(data.id_usuario);
        $('#id_usuario').selectpicker('refresh');
		$("#id_cliente").val(data.id_cliente);
        $('#id_cliente').selectpicker('refresh');
        $("#id_plazo").val(data.id_plazo);
        $('#id_plazo').selectpicker('refresh');
        $("#fecha_prest").val(data.fecha_prest);
		$("#monto").val(data.monto);
        $("#id_garante").val(data.id_garante);
        $('#id_garante').selectpicker('refresh');
        $("#dia_cobro").val(data.dia_cobro);
        $("#dia_limite").val(data.dia_limite);
        $("#interes_mora").val(data.interes_mora);
        document.getElementById("plazodiv").style.display = "none";
 	});
 	
}

//Función para desactivar registros
function desactivar(id_prest)
{
	bootbox.confirm("¿Está seguro de eliminar el préstamo?", function(result){
		if(result)
        {
        	$.post("../ajax/prestamos.php?op=desactivar", {id_prest : id_prest}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function aprobar(id_prest)
{
	bootbox.confirm("¿Está seguro de aprobar el préstamo?", function(result){
		if(result)
        {
        	$.post("../ajax/prestamos.php?op=aprobar", {id_prest : id_prest}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();