jQuery(document).ready(function($) {
	
	 "use strict";
	
	var mainDocument = $(document);
	
	var manageCustomerTable = $('#manageCustomerTable').DataTable({
		'ajax': 'fetchUser.php',
		'order': []
	});
	var manageAnnouncementTable = $('#manageAnnouncementTable').DataTable({
		'ajax': 'fetchAnnouncement.php',
		'order': []
	});
	var manageEmailTable = $('#manageEmailTable').DataTable({
		'ajax': 'fetchSentEmail.php',
		'order': []
	});
	var manageNonCustomerTable = $('#manageNonCustomerTable').DataTable({
		'ajax': 'fetchNonUserSentEmail.php',
		'order': []
	});
	
	mainDocument.on("click","#hide", function() {
		$(".errorMessage").hide();
	});
	mainDocument.on('click', '.changeAnnounceStatus', function(){
			var announceId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeAnnounceStatus";
			if(confirm("Are you sure you want to change Announcement status?"))
			{
				$.ajax({
					url:"change_announcement_status.php",
					method:"POST",
					data:{announceId:announceId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageAnnouncementTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
		mainDocument.on('click', '#add_announce', function(){
		$('#announcementModal').modal('show');
		$('#announcement_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-bullhorn'></i> Add Announcement");
		$('#action').val('Add Announcement');
		$('#btn_action').val('AddAnnouncement');
	});
	mainDocument.on('submit','#announcement_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"add_announcement_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#announcement_form')[0].reset();
				$('#announcementModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageAnnouncementTable.ajax.reload();
			}
		})
	});
	mainDocument.on('click', '.editAnnounceStatus', function(){												
		var announceId = $(this).attr("id");
		var btn_action = 'fetch_announcement';
		$('#announcement_form')[0].reset();
		$.ajax({
			url:"change_announcement_status.php",
			method:"POST",
			data:{announceId:announceId, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{	
				$('#announcementModal').modal('show');
				$('.modal-title').html("<i class='fa fa-bullhorn'></i> Edit Announcement");
				$('#announce_date').val(data.announcementDate);
				$('#announceText').val(decodeEntities(data.announcementText));
				$('#announcement_id').val(data.announcementId);
				$('#action').val('Edit Announcement');
				$('#btn_action').val('EditAnnouncement');
			}
		})
	});
	mainDocument.ready(function(){
		$('.announce_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			orientation: "top"
		});
	});
	$(document).on('submit','.announcementOption', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "save_announcement_setting.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				if(data == 0) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-success errorMessage">Setting Saved Successfully.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				if(data == 1) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">All Fields are mandatory. Try Again.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
			}
		})
	});
	
		mainDocument.on('click', '.changeUserStatus', function(){
			var customerId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeUserStatus";
			if(confirm("Are you sure you want to change User status?"))
			{
				$.ajax({
					url:"change_status.php",
					method:"POST",
					data:{customerId:customerId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCustomerTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
		mainDocument.on('click', '#add_user', function(){
		$('#userModal').modal('show');
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User & Send SMS");
		$('#action').val('Add User & Send Credential SMS');
		$('#btn_action').val('AddUser');
	});
	mainDocument.on('submit','#user_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"action_add_user.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				if(data == 1) {
					$('.removeuser-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 2) {
					$('.removeuser-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">This Email is already Exist.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				data = JSON.parse(data);
				if(data.error == 0){
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					$('.remove-messages').fadeIn().html('<div class="alert alert-info">User Added & Email Sent Successfully.</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				}
				$('#action').attr('disabled', false);
				manageCustomerTable.ajax.reload();
			}
		})
	});
	
	mainDocument.on('click', '.sendEmail', function(){
			var userId = $(this).attr("id");
			var btn_action_sms = "fetchUserdetail";
				$.ajax({
					url:"fetch_user_detail.php",
					method:"POST",
					data:{userId:userId, btn_action_sms:btn_action_sms},
					success:function(data)
					{
						$('#emailModal').modal('show');
						$('#email_form')[0].reset();
						$('.modal-title').html("<i class='fa fa-comments'></i>Send Email to User");
						$('#action_sms').val('Send Email');
						$('#btn_action_sms').val('SendEmail');
						data = JSON.parse(data);
						$('#user_name').val(data.username);
						$('#useremail').val(data.useremail);
						$('#userId').val(data.userId);
					}
				})
	});
	
	mainDocument.on('submit','#email_form', function(event){
		event.preventDefault();
		$('#action_sms').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"fetch_user_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#email_form')[0].reset();
				$('#emailModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action_sms').attr('disabled', false);
				manageCustomerTable.ajax.reload();
			}
		})
	});
	
	mainDocument.on('click', '#add_nonuser_email', function(){
		$('#nonuserModal').modal('show');
		$('#nonuser_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-envelope'></i> Send Email");
		$('#action_nonuser').val('Send Email');
		$('#btn_action_nonuser').val('SendEmail');
	});
	 
	 $(document).on('submit','#nonuser_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_nonuser_sendsms.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#nonuserModal').modal('hide');
				$('#nonuser_form')[0].reset();
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageNonCustomerTable.ajax.reload();
			}
		})
	});
	 
	 $(document).on('submit','.password_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_password_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#password_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	
	$(document).on('submit','.email_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_email_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#email_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
		
		 function decodeEntities(encodedString) {
	  var textArea = document.createElement('textarea');
	  textArea.innerHTML = encodedString;
	  return textArea.value;
	}
});
