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

