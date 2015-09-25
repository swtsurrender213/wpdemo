jQuery(document).ready( function($){
// variable to hold request
// bind to the submit event of our form
//on the event of form being submitted
$("#username").blur(function(){
    // setup some local variables
	//get the username value from the username input box
    var $username = $(this).val();
	
	//var fullname = $('input[name=fullname]').val();
	//alert(fullname);
   
    // serialize the data in the form
    //if you serialize you dont need to do this
    //$("#input_form").submit(function(){
    //var first name = $('input[name=first name]').val();
    //var last name = $('input[name=last name]').val();
    //var email = $('input[name=email]').val();
 
// serializedData is a string that contains form input variables
// The string is sent in the ajax request
    //all data from form is place in query string with 
	//name/value pairs
    //var serializedData = $form.serialize();
	
	//alert(serializedData);
 
    // fire off the request to /form.php
    // request is a jqXHR object which handles the HTTP request and handles the callbacks 
    // of the request 
     
	var request; 
	 //fake post we dont have a post movement from input box
    request = $.ajax({
        //use a hook defined in the wordpress admin/admin-ajax file
        url: "../wp-admin/admin-ajax.php",
        //form method
        type: "post",
        //data from the form to be processed by test.php
        data: {action: 'searchuser', username: $username},
        //type of data to be returned to client(browser)
        dataType: "json"
    });
	
    // callback handler that will be called on success
    // response is the result of the processing by test.php, it is of type json
    // textStatus can be abort,error,notmodified,parsererror,success,timeout
    request.done(function (response, textStatus, jqXHR){
          //The json response object          
          //Place the response in the div with id=result
          //you can access the response like you would an array
		  if(response.status != 1){
          $("#result").html("<span style='color:red'>Sorry Try Different Name</span>");
		 }
		 else{
		 $("#result").html("<span style='color:green'>Available</span>");
		 }
    });
 
    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // alert the error
        alert( "Request failed: " + textStatus + errorThrown);
    });
 
    // prevent default posting of form
    event.preventDefault();
});


//password

$("#passW").blur(function(){
    // setup some local variables
	//get the username value from the username input box
    var $passW = $(this).val();
	
	
	//var fullname = $('input[name=fullname]').val();
	//alert(fullname);
   
    // serialize the data in the form
    //if you serialize you dont need to do this
    //$("#input_form").submit(function(){
    //var first name = $('input[name=first name]').val();
    //var last name = $('input[name=last name]').val();
    //var email = $('input[name=email]').val();
 
// serializedData is a string that contains form input variables
// The string is sent in the ajax request
    //all data from form is place in query string with 
	//name/value pairs
    //var serializedData = $form.serialize();
	
	//alert(serializedData);
 
    // fire off the request to /form.php
    // request is a jqXHR object which handles the HTTP request and handles the callbacks 
    // of the request 
     
	var request; 
	 //fake post we dont have a post movement from input box
    request = $.ajax({
        //use a hook defined in the wordpress admin/admin-ajax file
        url: "../wp-admin/admin-ajax.php",
        //form method
        type: "post",
        //data from the form to be processed by test.php
        data: {action: 'checkpass', password: $passW},
        //type of data to be returned to client(browser)
        dataType: "json"
    });
	
    // callback handler that will be called on success
    // response is the result of the processing by test.php, it is of type json
    // textStatus can be abort,error,notmodified,parsererror,success,timeout
    request.done(function (response, textStatus, jqXHR){
          //The json response object          
          //Place the response in the div with id=result
          //you can access the response like you would an array
		  if(response.status == 0){
          $("#result1").html("<span style='color:red'>Your password must be at least 8 characters</span>");
		 }
		 else{
		 $("#result1").html("<span style='color:green'>Password Available</span>");
		 }
    });
 
    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // alert the error
        alert( "Request failed: " + textStatus + errorThrown);
    });
 
    // prevent default posting of form
    event.preventDefault();
});

// email
$("#email").blur(function(){
    // setup some local variables
	//get the username value from the username input box
    var $email = $(this).val();
	
	//var fullname = $('input[name=fullname]').val();
	//alert(fullname);
   
    // serialize the data in the form
    //if you serialize you dont need to do this
    //$("#input_form").submit(function(){
    //var first name = $('input[name=first name]').val();
    //var last name = $('input[name=last name]').val();
    //var email = $('input[name=email]').val();
 
// serializedData is a string that contains form input variables
// The string is sent in the ajax request
    //all data from form is place in query string with 
	//name/value pairs
    //var serializedData = $form.serialize();
	
	//alert(serializedData);
 
    // fire off the request to /form.php
    // request is a jqXHR object which handles the HTTP request and handles the callbacks 
    // of the request 
     
	var request; 
	 //fake post we dont have a post movement from input box
    request = $.ajax({
        //use a hook defined in the wordpress admin/admin-ajax file
        url: "../wp-admin/admin-ajax.php",
        //form method
        type: "post",
        //data from the form to be processed by test.php
        data: {action: 'searchemail', email: $email},
        //type of data to be returned to client(browser)
        dataType: "json"
    });
	
    // callback handler that will be called on success
    // response is the result of the processing by test.php, it is of type json
    // textStatus can be abort,error,notmodified,parsererror,success,timeout
    request.done(function (response, textStatus, jqXHR){
          //The json response object          
          //Place the response in the div with id=result
          //you can access the response like you would an array
		  if(response.status != 1){
          $("#result2").html("<span style='color:red'>Sorry Try Different Email</span>");
		 }
		 else{
		 $("#result2").html("<span style='color:green'>Email Available</span>");
		 }
    });
 
    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // alert the error
        alert( "Request failed: " + textStatus + errorThrown);
    });
 
    // prevent default posting of form
    event.preventDefault();
});

}); //end document