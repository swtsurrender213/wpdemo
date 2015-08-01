<?php
/*
Template Name: Request 
*/

get_header(); 

//if form submitted
if(isset($_POST['request-submit']))
{
//check for errors
$error=check_show_request_form_error();

//success
  if($error=="")
   {
	 show_request_form();
	 //send form 
	 echo '<div style="text-align:center;" 
	 class="alert alert-success"><strong>Success!</strong> 
	 form has been sent.</div>';
	 //create a hook for the event of a contact
	 //form being submitted by a user
	 do_action('wpdemo_request_submit');
   }
  else
  //the form has errors
   {
  //show the form and the error to the user
   show_request_form($error);
   }
}

//first time user sees the form
else
{
	show_request_form();
}

get_footer(); ?>