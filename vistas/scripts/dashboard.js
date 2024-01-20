var tabla;

function init(){ //hace referencia a otras funciones
    $.post("../ajax/prestamos.php?op=selectusuarios", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_usuario").html(r);
        $('#id_usuario').selectpicker('refresh');
    });

    $.post("../ajax/prestamos.php?op=selectclientes", function(r){ //parametro r son las opciones que devuelve el id
        $("#id_cliente").html(r);
        $('#id_cliente').selectpicker('refresh');
    });

}

function pagosclientes(){
        var fecha_inicio = $("#fecha_inicio").val();
        var fecha_fin = $("#fecha_fin").val();
        var id_cliente = $("#id_cliente").val();
        
        $url = '../reportes/pagosclientes.php?fecha_inicio=' + fecha_inicio + '&fecha_fin='+ fecha_fin + '&id_cliente='+ id_cliente;
        target = "_blank";
        window.open($url, '_blank');
}

function cobrosagentes(){
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var id_usuario = $("#id_usuario").val();
    
    $url = '../reportes/cobrosagentes.php?fecha_inicio=' + fecha_inicio + '&fecha_fin='+ fecha_fin + '&id_usuario='+ id_usuario;
    target = "_blank";
    window.open($url, '_blank');
}

function cobrospendientes(){
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    
    $url = '../reportes/cobrospendientes.php?fecha_inicio=' + fecha_inicio + '&fecha_fin='+ fecha_fin;
    target = "_blank";
    window.open($url, '_blank');
}

function cobrosrealizados(){
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    
    $url = '../reportes/cobrosrealizados.php?fecha_inicio=' + fecha_inicio + '&fecha_fin='+ fecha_fin;
    target = "_blank";
    window.open($url, '_blank');
}

init();