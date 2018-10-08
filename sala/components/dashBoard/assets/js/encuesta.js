$(function(){
    alowNavigate = false;
    $("#evaluacionDocente").click(function(e){
        var url = $('#url').val();        
        e.preventDefault();
        e.stopPropagation();
        cargarEncuesta(url);        
    });
});

function cargarEncuesta(url){
    showLoader();
    
    if(url == 1){
        //Evaluacion docente generica
        hr = HTTP_ROOT+"/serviciosacademicos/consulta/encuesta/encuestaenfermeria/encuestaenfermeria.php";
    }
    
    if(url == 2){
        //Evaluacion por instrumento
        hr = HTTP_ROOT+"/serviciosacademicos/mgi/autoevaluacion/interfaz/EvaluacionDocente.php";
    }
        
    var height = $(window).outerHeight() - 175;
    var frame = '<iframe width="100%" height="'+height+'" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" name="contenidocentral" id="contenidocentral" src="'+hr+'"></iframe>';
    $( "#page-content" ).html( frame ); 
    $('#page-content #contenidocentral').on("load", function() {
        hideLoader();
    });
    timeOutVar = window.setTimeout(function(){
        $("#mensajeLoader").html("La carga esta tardando demaciado...");
        timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
    }, 15000);
    hideAsideModule(222);
}