<?php

/* Template name: Login Form */

get_header(); ?>

<?php

$args = array(

'redirect' => site_url(),
);

?>

<?php
//if variable has been set in the 
if(isset($_GET["login"])){
	//check for empty
	if($_GET["login"]=="empty"){
	echo '<div class="alert alert-danger centered" role="alert">
	Hellllo Users!! Please type your <strong>USERNAME</strong> or <strong>PASSWORD</strong> thank you!
	</div>';
	}
// check for fail
else if($_GET["login"]=="fail"){
	echo '<div class="alert alert-danger centered" role="alert">
	Hellllo Users!! Your <strong>USERNAME</strong> or <strong>PASSWORD</strong> not in the database<br>
	Please type the correct username and password!
	</div>';
	}
	
if($_GET["login"]=="out"){
	echo '<div class="alert alert-success centered" role="alert">
	You are <strong>SUCCESSFULLY</strong> logout Please come back!
	</div>';
	}
	
}
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2 centered">
		<?php wp_login_form( $args ); ?> 
		</div>
	</div>
</div>













<?php
get_footer(); ?>