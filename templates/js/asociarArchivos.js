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
			$('#'+id_original).attr('style','background:#ccffff;cursor: pointer');
			$('#'+id_original).attr('on','1');

		}
		else
		{
			$('#'+id_original).attr('style','background:#fff;cursor: pointer');
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
			if (id_formulacion != -1)
				location.reload(); 	
		});
	});		

	$('#btnAsociarFilesNew').click(function(){
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

		$("#divArchivosAsociados").text('');

		var exit = "";
		exit += '<h3>Listado de Archivos Asociados</h3>';
		exit += '<div><table id="archivosAsociados" border="1">';
		exit += '<thead><tr>';
		exit += '<th></th>';
		exit += '<th>id archivo</th>';
		exit += '<th>nombre</th>';
		exit += '</tr></thead>';
		
		for (var i = 0; i < files.length; i++) {
		  exit += '<tr>';
		  exit += '<td>'+(i + 1)+'</td>';
		  exit += '<td>'+files[i]+'<input type="hidden" name="archivoAsociado[]" value="'+files[i]+'"/></td>';
		  exit += '<td><a href="?controller=ArchivosController&action=addForm&id='+files[i]+'">'+$('#file_'+files[i]).text()+'</a></td>';
		  exit += '</tr>';
		  // Do something with element i.
		}
	
		exit += '</table></div>';
		document.getElementById('divArchivosAsociados').innerHTML = exit;
		
	});		

	$('#btnCloseFiles').click(function(){
		console.log(files);
	});										
	

});





