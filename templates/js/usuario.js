$( document ).ready(function() {
	
	recargaTipoUsuario();

	$('#tipo_usuario').change(function() {
		recargaTipoUsuario();
	});

	$('#prg_becas_old').change(function() {
		if ($('#prg_becas_old').is(':checked'))
			$('#fechasBecas').show();
		else
		{
			$('#fechasBecas').hide();
			$('#becas_fecha_in').val("");
			$('#becas_fecha_out').val("");
		}
	});

	$('#administrador').change(function() {
		if ($('#administrador').is(':checked'))
			$('#divPass').show();
		else
		{
			$('#divPass').hide();
			$('#pass').val("");
		}
	});

	if ($('#administrador').is(':checked'))
		$('#divPass').show();

	if ($('#prg_becas_old').is(':checked'))
		$('#fechasBecas').show();

	$('#enviarTelefonosForm').click(function(){

		// setup some local variables
	    var $form = $('#telefonosForm');
	    // let's select and cache all the fields
	    var $inputs = $form.find("input, select, button, textarea");
	    // serialize the data in the form
	    var serializedData = $form.serialize();

	    // let's disable the inputs for the duration of the ajax request
	    $inputs.prop("disabled", true);		
		
		$.ajax({
			type: "POST",
			url: "?controller=TelefonosController&action=updateTelefonos",
			data: serializedData,
			context: document.body
		}).done(function() {
			$(this).addClass("done");
			$inputs.prop("disabled", false);	
		});
	});

	$('#enviarMailsForm').click(function(){

		// setup some local variables
	    var $form = $('#mailsForm');
	    // let's select and cache all the fields
	    var $inputs = $form.find("input, select, button, textarea");
	    // serialize the data in the form
	    var serializedData = $form.serialize();

	    // let's disable the inputs for the duration of the ajax request
	    $inputs.prop("disabled", true);		
		
		$.ajax({
			type: "POST",
			url: "?controller=MailsController&action=updateMails",
			data: serializedData,
			context: document.body
		}).done(function() {
			$(this).addClass("done");
			$inputs.prop("disabled", false);	
		});
	});


	$('#enviarDireccionesForm').click(function(){

		// setup some local variables
	    var $form = $('#direccionesForm');
	    // let's select and cache all the fields
	    var $inputs = $form.find("input, select, button, textarea");
	    // serialize the data in the form
	    var serializedData = $form.serialize();

	    // let's disable the inputs for the duration of the ajax request
	    $inputs.prop("disabled", true);		
		
		$.ajax({
			type: "POST",
			url: "?controller=DireccionesController&action=updateDirecciones",
			data: serializedData,
			context: document.body
		}).done(function() {
			$(this).addClass("done");
			$inputs.prop("disabled", false);	
		});
	});

	$('#anadirMail').click(function(){
		if ($('#nuevoMail').is(':visible'))
			$('#nuevoMail').hide();
		else
			$('#nuevoMail').show();
	});

	$('#anadirTelefono').click(function(){
		if ($('#nuevoTelefono').is(':visible'))
			$('#nuevoTelefono').hide();
		else
			$('#nuevoTelefono').show();
	});

	$('#anadirDireccion').click(function(){
		if ($('#nuevaDireccion').is(':visible'))
			$('#nuevaDireccion').hide();
		else
			$('#nuevaDireccion').show();
	});

	$('#addDireccion').click(function(){

		// setup some local variables
		    var $form = $('#nuevaDireccion');
		    // let's select and cache all the fields
		    var $inputs = $form.find("input, select, button, textarea");
		    // serialize the data in the form
		    var serializedData = $form.serialize();

		    // let's disable the inputs for the duration of the ajax request
		    $inputs.prop("disabled", true);		
			
			$.ajax({
				type: "POST",
				url: "?controller=DireccionesController&action=ajasAdd",
				data: serializedData,
				context: document.body
			}).done(function(respuesta) {
				respuesta = trim(respuesta);
				$(this).addClass("done");
				$inputs.prop("disabled", false);
				if($("#direccionesForm").length > 0)
				{
					var identidad = "direccion_"+respuesta;
					var anadirEsto = '<li id="direccion_'+respuesta+'">';
					anadirEsto += '<input type="hidden" name="id_direccion[]" id="id_direccion[]" value="'+respuesta+'"/>';
					anadirEsto += '<input type="hidden" name="id_usuario[]" value="'+$("#id_usuario_direccion").val()+'"/>';
					anadirEsto += '<input type="text" name="alias[]" value="'+$("#alias_direccion").val()+'" />';
					anadirEsto += '<input type="text" name="direccion1[]" value="'+$("#direccion1").val()+'" />';
					anadirEsto += '<input type="text" name="direccion2[]" value="'+$("#direccion2").val()+'" />';
					anadirEsto += '<input type="text" name="cp[]" value="'+$("#cp").val()+'" />';
					anadirEsto += '<input type="text" name="localidad[]" value="'+$("#localidad").val()+'" />';
					anadirEsto += '<input type="text" name="provincia[]" value="'+$("#provincia").val()+'" />';
					anadirEsto += '<input type="text" name="pais[]" value="'+$("#pais").val()+'" />';
					anadirEsto += '<input type="text" name="orden_direccion[]" value="'+$("#orden_direccion").val()+'" maxlength="2" />';
					anadirEsto += '<a href="javascript:void(0)" id="removeDireccion_'+respuesta+'" class="" onclick="removeDireccion('+respuesta+')"><i class="icon-remove"></i> Borrar</a>';
					anadirEsto += '</li>';
					$('#nuevaDireccion').hide();
					$("#listadoDirecciones").append(anadirEsto);	
					
				}
				else
				{
					

					var anadirEsto = '<form action="?controller=DireccionesController&amp;action=updateTelefonos" name="direccionesForm" id="direccionesForm"  method="post" >';
					anadirEsto += '<fieldset><legend>Direcciones</legend>';
					anadirEsto += '<ul id="listadoDirecciones">';
					anadirEsto += '<li id="direccion_'+respuesta+'">';
					anadirEsto += '<input type="hidden" name="id_direccion[]" id="id_direccion[]" value="'+respuesta+'"/>';
					anadirEsto += '<input type="hidden" name="id_usuario[]" value="'+$("#id_usuario_direccion").val()+'"/>';
					anadirEsto += '<input type="text" name="alias[]" value="'+$("#alias_direccion").val()+'" />';
					anadirEsto += '<input type="text" name="direccion1[]" value="'+$("#direccion1").val()+'" />';
					anadirEsto += '<input type="text" name="direccion2[]" value="'+$("#direccion2").val()+'" />';
					anadirEsto += '<input type="text" name="cp[]" value="'+$("#cp").val()+'" />';
					anadirEsto += '<input type="text" name="localidad[]" value="'+$("#localidad").val()+'" />';
					anadirEsto += '<input type="text" name="provincia[]" value="'+$("#provincia").val()+'" />';
					anadirEsto += '<input type="text" name="pais[]" value="'+$("#pais").val()+'" />';
					anadirEsto += '<input type="text" name="orden_direccion[]" value="'+$("#orden_direccion").val()+'" maxlength="2" />';
					anadirEsto += '<a href="javascript:void(0)" id="removeDireccion_'+respuesta+'" class="" onclick="removeDireccion('+respuesta+')"><i class="icon-remove"></i> Borrar</a>';
					anadirEsto += '</li>';
					anadirEsto += '</ul>';
					anadirEsto += '</fieldset></form>';
					$("#bloqueDirecciones").append(anadirEsto);	
					$('#nuevaDireccion').hide();
				}	
				$inputs.val("");
			});
		
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

