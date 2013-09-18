// JavaScript Document
var files = [];

$( document ).ready(function() {
	
	

	$('.categoria_archivo').click(function(){
		var id_original = $(this).attr('id');
		var id = id_original.split('_'); 										
		
		$('.bloque_archivos').hide();
		$('#bloque_cat_'+id[1]).show();
							  
	});	

	$('.archivo_file').click(function(){
		var id_original = $(this).attr('id');
		if ($('#'+id_original).attr('on') == 0)
		{
			$('#'+id_original).attr('style','background:#ccffff');
			$('#'+id_original).attr('on','1');

		}
		else
		{
			$('#'+id_original).attr('style','background:#fff');
			$('#'+id_original).attr('on','0');
		}
	});		

	$('#btnAsociarFiles').click(function(){
		files = [];
		$( ".archivo_file" ).each(function( index ) {

			if ($(this).attr('on') == 1)
			{
				console.log( index + ": " + $(this).text() );
				var id_original = $(this).attr('id');
				var id = id_original.split('_'); 
				files.push(id[1]);
				

			}
		});
		console.log( files);
		console.log( id_formulacion);
		var parametros = {
             "files" : files,
             "id_formulacion" : id_formulacion,
        };
		//asociar
		$.ajax({
			type: "POST",
			url: "?controller=FormulacionController&action=asociarArchivos",
			data: parametros,
			context: document.body
		}).done(function() {
			//
			location.reload(); 	
		});
	});			

	$('#btnCloseFiles').click(function(){
		console.log(files);
	});										
	

});





