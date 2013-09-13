// JavaScript Document
$( document ).ready(function() {
	
	$('.categoria_archivo').click(function(){
		var id_original = $(this).attr('id');
		var id = id_original.split('_'); 										
		
		$('.bloque_archivos').hide();
		$('#bloque_cat_'+id[1]).show();
							  
	});																
	

});



function recargaTipoUsuario(){
	if ($("#tipo_usuario").val() == 0)
	{
		usuarioShow();
	}
	else
	{
		organizacionShow();

	}
}

function usuarioShow() {
	//Personas
	$(".organizacion").hide();
	$(".persona").show();
}

function organizacionShow(){
	//Organizaciones
	$(".persona").hide();
	$(".organizacion").show();

}

function removeDireccion(parametro){
	var r=confirm("¿Estás seguro?");
	var p = parametro.toString();
	if (r==true)
	{
		$.ajax({
			type: "POST",
			url: "?controller=DireccionesController&action=del&id="+parametro,
			context: document.body
		}).done(function() {
			var remove = "#direccion_"+trim(p);
			$(remove).remove();	
		});
	}
	else
	{
		//x="You pressed Cancel!";
	} 
}

function removeTelefono(parametro){
	var r=confirm("¿Estás seguro?");
	var p = parametro.toString();
	if (r==true)
	{
		$.ajax({
			type: "POST",
			url: "?controller=TelefonosController&action=del&id="+parametro,
			context: document.body
		}).done(function() {
			var remove = "#telefono_"+trim(p);
			$(remove).remove();	
		});
	}
	else
	{
		//x="You pressed Cancel!";
	} 
}

function removeMail(parametro){
	var r=confirm("¿Estás seguro?");
	var p = parametro.toString();
	if (r==true)
	{
		$.ajax({
			type: "POST",
			url: "?controller=MailsController&action=del&id="+parametro,
			context: document.body
		}).done(function() {
			var remove = "#mail_"+trim(p);
			$(remove).remove();	
		});
	}
	else
	{
		//x="You pressed Cancel!";
	} 
}

function trim (myString)
{
return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

