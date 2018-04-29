// JavaScript Document
$(document).ready(function(e) {
	//$(".alt-email-div").hide();
	$('.input-mask-date').mask('99/99/9999');
	/*-------------------------------------------------------*/
	$('input[name*="profile_type"]').change(function(e) {
        if( $('input[name*="profile_type"]:checked').val() == 'OU'){
			$(".search-cli").hide();
			$(".alt-email-div").hide();
			
			
			$("#search_cli").val('');
			$("#cli_id").val('');
			$("#token").val('');
			
			$("#profile_name").val('');
			$("#age").val('');
			$("#email_id").val('');
			$("#mobile").val('');
			$("#dob").val('');
					
					
			$('select[name="location"]').val('');
			$('select[name="policy_type"]').val('');
			$('select[name="payment_mode"]').val('');
			$('select[name="channel"]').val('');
			
			$("#insurer_name").prop('disabled', false);
			$('input[name="policy_status"][value="Active"]').prop('checked', 'checked');
			$('input[name="policy_status"]').prop('disabled', true);
			
					
			$('#chl_area').hide();
			$("#ins_name").show();
			
		}else{
			$(".search-cli").show();
			$("#insurer_name").prop("disabled", true);
			$(".alt-email-div").show();
			$('input[name="policy_status"]').prop('disabled', false);
			
			$("#search_cli").val('');
			$("#cli_id").val('');
			$("#token").val('');
			
			$("#profile_name").val('');
			$("#age").val('');
			$("#email_id").val('');
			$("#mobile").val('');
			$("#dob").val('');
			
			$('select[name="location"]').val('');
			$('select[name="policy_type"]').val('');
			$('select[name="payment_mode"]').val('');
			$('select[name="channel"]').val('');
			
			$("#ins_name").hide();
			
		}
    });
	/*-------------------------------------------------------*/
	
	$("#dob").on('keyup keypress blur change click',function(e) {

        var date = new Date($(this).val());
		var year = date.getFullYear();
		var currentYear = new Date().getFullYear(); 
		var age = parseInt(currentYear)-parseInt(year);
		var cleanAge = isNaN(age) ? '0' : age;
		var cleanAge = cleanAge < 0 ? '0' : cleanAge;
		$("#age").val(parseInt(cleanAge));
    });
	
	$("#age").on('blur', function(e){
		var cleanAge = $(this).val();
		if(cleanAge < 25 || cleanAge > 45){
			alert( 'Age should between 25 to 45' );
		}
	});
	
	/*------------------------------------------------*/
	
	$("#search_cli_btn_for_req").click(function(e) {
		var cli = $("#search_cli_for_req").val();
		if( cli != ""){
			var datastr = { 'cli' : cli }
			$.ajax({
				type: "POST",
				url: SITE_URL + FOLDER + '/' + CONTROLLER + '/ajax_fetch_record_by_cli',
				dataType: "json",
				data: datastr,
				success: function(data){
					if(data.error == '')
					{
						
					$("#token").val(data.unique_code);
					$("#cli_id").val(data.cli_id);
					$("#profile_name").val(data.profile_name);
					$("#email_id").val(data.email_id);
					$("#alt_email_id").val(data.alt_email_id);
					$("#mobile").val(data.mobile);
					$("#alt_mobile").val(data.alt_mobile);
					$("#note").val(data.note);
					$("#dob").val(data.dob);
					$("#is_req_sent").prop("checked", false);
					$("#take_the_survey").prop("checked", false);
					
					$('select[name="location"]').val(data.location);
					$('select[name="policy_type"]').val(data.policy_type);
					
					}else{
						alert("CLI : " + $("#search_cli_for_req").val() + " - " + data.error);	
						$("#search_cli_for_req").val('');
					}
					
				}
			});
		}
	});
	
	$("#swap").click(function(e) {
		var email_id 		= $("#email_id").val();
		var alt_email_id 	= $("#alt_email_id").val();
		if( email_id != "" && alt_email_id != "" ){
			$("#email_id").val(alt_email_id);
			$("#alt_email_id").val(email_id);
		}else{
			alert('Please enter both email ids!');
		}
	});
	
	
	
	$("#send_link_for_pro_req").click(function(e) {
		var email_id = $("#email_id").val();
		var cli_id 	 = $("#search_cli_for_req").val();
		
		if(email_id != ""){
			if(cli_id != ""){
				var unique_code		= $("#token").val();
				var email_id 		= $("#email_id").val();
				var alt_email_id 	= $("#alt_email_id").val();
				var mobile			= $("#mobile").val();
				var alt_mobile 		= $("#alt_mobile").val();
				var name 			= $("#profile_name").val();
				var cli_id 			= $("#search_cli_for_req").val();
				var dob 			= $("#dob").val();
				
				var location 		= $("#location").val();
				var policy_type 	= $("#policy_type").val();
				var policy_status	= $("#policy_status_Active").is(":checked") ? 'Active' : 'Lapsed';
				
				var is_req_sent 	= $("#is_req_sent").is(":checked") ? 'Y': 'N';
				var take_the_survey = $("#take_the_survey").is(":checked") ? 'Y': 'N';
				var type_of_action	= $("#type_of_action").val();
				var note 			= $("#note").val();
				
				
				
				var datastr = { 
					'unique_code'		: unique_code,
					'email_id' 			: email_id,
					'alt_email_id' 		: alt_email_id,
					'mobile' 			: mobile,
					'alt_mobile' 		: alt_mobile,
					'name' 				: name, 
					'cli_id' 			: cli_id, 
					'dob' 				: dob, 
					'location' 			: location, 
					'policy_type' 		: policy_type, 
					'policy_status' 	: policy_status,
					'type_of_action'	: type_of_action,
					'note' 				: note, 
					'policy_status' 	: policy_status, 
					'is_req_sent' 		: is_req_sent, 
					'take_the_survey' 	: take_the_survey 
					}
					
					
				
				
				$.ajax({
					type: "POST",
					url: SITE_URL + FOLDER + '/' + CONTROLLER + '/ajax_send_email_by_email_id',
					dataType: "json",
					data: datastr,
					success: function( data ){
						
						
						if( data.response == 'SAVED' ){
							
							$("#token").val("");
							$("#email_id").val("");
							$("#alt_email_id").val("");
							$("#alt_mobile").val("");
							$("#profile_name").val("");
							$("#search_cli_for_req").val("");
							$("#mobile").val("");
							$("#type_of_action").val("");
							$("#note").val("");
							$("#dob").val("");
							
							$('select[name="location"]').val('');
							$('select[name="policy_type"]').val('');
			
							$('input[name="policy_status"][value="Active"]').prop('checked', 'checked');
			
			
							$("#is_req_sent").prop("checked", false);
							$("#take_the_survey").prop("checked", false);
							
							alert("Data saved successfully.");
							
							
						}else if( data.response == 'MAIL-SENT' ){
							
							$("#token").val("");
							$("#email_id").val("");
							$("#alt_email_id").val("");
							$("#alt_mobile").val("");
							$("#profile_name").val("");
							$("#search_cli_for_req").val("");
							$("#mobile").val("");
							$("#type_of_action").val("");
							$("#note").val("");
							$("#dob").val("");
							
							$('select[name="location"]').val('');
							$('select[name="policy_type"]').val('');
			
							$('input[name="policy_status"][value="Active"]').prop('checked', 'checked');
			
			
							$("#is_req_sent").prop("checked", false);
							$("#take_the_survey").prop("checked", false);
							
							alert("Data saved and mail Sent successfully ");
						}else if( data.response == 'ERROR' ){
							alert("Error! Email-ID already exists.");
						}else if( data.response == 'ER-EMAIL' ){
							alert("Error! Email-ID already exists.");
						}else if( data.response == 'ER-MOBILE' ){
							alert("Error! Mobile no. already exists.");
						}else if( data.response == 'ER-ALTEMAIL' ){
							alert("Error! Alternate Email already exists.");
						}else{
							window.location.href = SITE_URL + "recruiter/profile/view/" + data.response;
						}
						
					}
				});
				
				
			}else{
				alert('Please enter cli id!');
				$("#search_cli_for_req").focus();
			}
		}else{
			alert('Please enter email id!');
			$("#email_id").focus();
		}
	});
	
	/*------------------------------------------------*/
	
	
	
	
	
	$("#save_solicitation_other").click(function(e) {
		var mobile = $.trim($("#mobile").val());
		var profile_name = 	$.trim($("#profile_name").val());
		var location = 	$.trim($("#location").val());
		var insurer_name = 	$.trim($("#insurer_name").val());
		var email_id 		= $("#email_id").val();
		
		var valid = 1;
		if(mobile != ""){
			
			if(mobile.length < 10)
			{
				alert('Mobile no. should be 10 digit!');
				$("#mobile").focus();
				valid = 0;
			}
			
			if(valid == 1 && email_id != '')
			{
				if(!isEmail(email_id))
				{
					alert('Please enter a valid email id.!');
					$("#email_id").focus();
					valid = 0;
				}
			}
			
			if(valid == 1 && profile_name == ""){
				alert('Please enter Name!');
				$("#profile_name").focus();
				valid = 0;
			}
			
			if(valid == 1 && location == ""){
				alert('Please enter location!');
				$("#location").focus();
				valid = 0;
			}
			
			if(valid == 1 && insurer_name == ""){
				if($("#type_of_action").val() != ''){
					$("#type_of_action").val('NINT');
				}
			}
			
			if(valid == 1){
				
				var alt_email_id 	= $("#alt_email_id").val();
				var alt_mobile 		= $("#alt_mobile").val();
				var profile_name 	= $("#profile_name").val();
				var age 			= $("#age").val();
				var location 		= $("#location").val();
				var policy_type 	= $("#policy_type").val();
				var insurer_name	= $("#insurer_name").val();
				var policy_status	= $("#policy_status_Active").is(":checked") ? 'Active' : 'Lapsed';
				
				var is_survey_sent 	= $("#is_survey_sent").is(":checked") ? 'Y': 'N';
				var take_the_survey = $("#take_the_survey").is(":checked") ? 'Y': 'N';
				var type_of_action 	= $("#type_of_action").val();	
				var note 			= $("#note").val();
				
				
				
				var datastr = { 
					'email_id' 			: email_id,
					'alt_email_id' 		: alt_email_id,
					'mobile' 			: mobile,
					'alt_mobile' 		: alt_mobile,
					'profile_name' 		: profile_name,
					'age' 				: age, 
					'location' 			: location, 
					'insurer_name'		: insurer_name,
					'policy_type' 		: policy_type, 
					'policy_status' 	: policy_status, 
					'type_of_action'	: type_of_action,
					'note' 				: note,
					'is_survey_sent' 	: is_survey_sent, 
					'take_the_survey' 	: take_the_survey 
					}
					
					
				
				
				$.ajax({
					type: "POST",
					url: SITE_URL + FOLDER + '/' + CONTROLLER + '/ajax_save_solicitation_other',
					dataType: "json",
					data: datastr,
					success: function( data ){
						
						
						if( data.response == 'SAVED' ){
							
							$("#mobile").val("");
							$("#profile_name").val("");
							$("#email_id").val("");
							$("#alt_email_id").val("");						
							$("#alt_mobile").val("");
							
							
							$("#type_of_action").val("");
							$("#note").val("");
							$("#dob").val("");
							
							$('select[name="location"]').val('');
							$('select[name="policy_type"]').val('');
							$('select[name="insurer_name"]').val('');
			
							$('input[name="policy_status"][value="Active"]').prop('checked', 'checked');
							$('select[name="type_of_action"]').val('');
			
			
							$("#is_survey_sent").prop("checked", false);
							$("#take_the_survey").prop("checked", false);
							
							alert("Data saved successfully.");
							
							
						}else if( data.response == 'DM' ){
							alert("Duplicate mobile no.");
						}else if( data.response == 'PDM' ){
							
							alert("Mobile no. already exist in profile");
							
						}else if( data.response == 'DE' ){
							
							alert("Duplicate Email Id.");
							
						}else if( data.response == 'PDE' ){
							alert("Email Id. already exist in profile");
							
						}else if( data.response == 'MAIL-SENT' ){
							
							$("#mobile").val("");
							$("#profile_name").val("");
							$("#email_id").val("");
							$("#alt_email_id").val("");						
							$("#alt_mobile").val("");
							
							
							$("#type_of_action").val("");
							$("#note").val("");
							$("#dob").val("");
							
							$('select[name="location"]').val('');
							$('select[name="policy_type"]').val('');
							$('select[name="insurer_name"]').val('');
			
							$('input[name="policy_status"][value="Active"]').prop('checked', 'checked');
							$('select[name="type_of_action"]').val('');
			
			
							$("#is_survey_sent").prop("checked", false);
							$("#take_the_survey").prop("checked", false);
							
							alert("Data saved and mail Sent successfully ");
						}else if( data.response == 'ERROR' ){
							alert("Error! Email-ID already exists.");
						}else if( data.response == 'ER-EMAIL' ){
							alert("Error! Email-ID already exists.");
						}else if( data.response == 'ER-MOBILE' ){
							alert("Error! Mobile no. already exists.");
						}else if( data.response == 'ER-ALTEMAIL' ){
							alert("Error! Alternate Email already exists.");
						}else{
							window.location.href = SITE_URL + "recruiter/profile/view/" + data.response;
						}
						
					}
				});
			}
		}else{
			
			alert('Please enter mobile number!');
			$("#mobile").focus();
		}
	});
	
	/*------------------------------------------------*/
	
	
	$("#search_cli_btn").click(function(e) {
		var cli = $("#search_cli").val();
        if( cli != ""){
			var datastr = { 'cli' : cli }
			$.ajax({
				type: "POST",
				url: SITE_URL + FOLDER + '/' + CONTROLLER + '/ajax_fetch_record_by_cli',
				dataType: "json",
				data: datastr,
				success: function(data){
					if(data.error == ""){
						$("#cli_id").val(data.cli_id);
						$("#profile_name").val(data.profile_name);
						$("#token").val(data.unique_code);
						$("#email_id").val(data.email_id);
						$("#alt_email_id").val('');
						$("#mobile").val(data.mobile);
						$("#dob").val(data.dob);
						
						var date = new Date(data.dob);
						var year = date.getFullYear();
						var currentYear = new Date().getFullYear(); 
						var age = parseInt(currentYear)-parseInt(year);
						var cleanAge = isNaN(age) ? '0' : age;
						$("#age").val(parseInt(cleanAge));
						
						$("#occupation").val(data.occupation);
						$('select[name="location"]').val(data.location);
						$('select[name="policy_type"]').val(data.policy_type);
						$('select[name="payment_mode"]').val(data.payment_mode);
						$('select[name="channel"]').val(data.channel);
						
						if(data.channel == 'Online')
						{
						   $('#chl_area').show();
						}else{					
							$('#chl_area').hide();
						}
					
					}else{
						alert("CLI : " + $("#search_cli").val() + " - " + data.error);	
						$("#search_cli_for_req").val('');
					}
					  
				}
			});
		}
    });
	/*-------------------------------------------------------*/
	
	$(".send_profile_link").click(function(e) {
        var code = $(this).attr('profile-code');

		if( code != "" || code != null ){
			var datastr = { 'code' : code }
			$.ajax({
				type: "POST",
				url: SITE_URL + 'survey/response/send_mail',
				dataType: "json",
				data: datastr,
				success: function(data){
					if(data == 1){
						alert('Email sent successfully.');
					}
				}
			});
		}
    });
	/*-------------------------------------------------------*/
	
	$("#dashboard_recruiter_select").change(function(e) {
		var recruiter_id = $(this).val();
		
		if( recruiter_id != "" || recruiter_id != null ){
			var datastr = { 'recruiter_id' : recruiter_id }
			$("#ajax_details_div").html("<div align='center'><img src='"+SITE_URL + '/assets/admin/images/ajax-loader.gif' +"' align='middle'></div>");
			$.ajax({
				type: "POST",
				url: SITE_URL + 'recruiter/dashboard/ajax_details',
				dataType: "html",
				data: datastr,
				success: function(data){
					$("#ajax_details_div").html(data);
				}
			});
		}
    });
	
	
});


function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}