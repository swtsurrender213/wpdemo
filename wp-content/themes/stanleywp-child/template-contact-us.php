<?php
/*
Template Name: Contact Us
*/

get_header(); 

//if form submitted
if(isset($_POST['contact-submit']))
{
//check for errors
$error=check_show_contact_form_error();

//success
  if($error=="")
   {
	 show_contact_form();
	 //send an email 
	 echo '<div style="text-align:center;" 
	 class="alert alert-success"><strong>Success!</strong> 
	 Email has been sent.</div>';
	 //create a hook for the event of a contact
	 //form being submitted by a user
	 do_action('wpdemo_contact_submit');
   }
  else
  //the form has errors
   {
  //show the form and the error to the user
   show_contact_form($error);
   }
}

//first time user sees the form
else
{
	show_contact_form();
}

get_footer(); ?>