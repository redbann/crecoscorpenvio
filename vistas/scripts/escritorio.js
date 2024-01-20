var tabla;

function init(){ //hace referencia a otras funciones
    actualizar();
}

function actualizar(){
    $.get("../ajax/pagosprestamos.php?op=actualizar");
}

init();