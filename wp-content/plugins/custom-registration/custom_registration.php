<?php
    /*
    Plugin Name: Custom Registration
    Plugin URI: http://www.jts.name
    Description: Plugin for a custom registration page
    Author: Julian Screawn
    Version: 1.0
    Author URI: http://www.jts.name
    */
	
add_action('wp_ajax_searchemail','searchemail');	

function searchemail(){
$email=$_POST['email'];
if ( email_exists( $email ) )
           $status=0;
       else
          $status=1;

	  $returnArray=array('status'=> $status);
	  echo json_encode($returnArray);
	  die();

}
	
	
add_action('wp_ajax_checkpass','checkpass');	

function checkpass(){
$passW=$_POST['password'];
if (strlen($passW) < 8 ) 
$status=0;
 else
$status=1; 

	  $returnArray=array('status'=> $status);
	  echo json_encode($returnArray);
	  die();

}

add_action('wp_ajax_searchuser','searchuser');	

function searchuser(){
$username=$_POST['username'];
if ( username_exists( $username ) )
           $status=0;
       else
          $status=1;

	  $returnArray=array('status'=> $status);
	  echo json_encode($returnArray);
	  die();
}	
function wp_demo_load_scripts(){

//get the framework
$existing=get_option("framework");

	//if the framework is bootstrap load bootform
	if($existing=="bootstrap"){
	wp_enqueue_style('bootform', plugins_url('/css/bootform.css',__FILE__));
	}
	else if($existing=="foundation"){
	wp_enqueue_style('foundation', plugins_url('/css/foundationform.css',__FILE__));
	}
	else{
	wp_enqueue_style('html5', plugins_url('/css/html5form.css',__FILE__));
	}
	
	wp_enqueue_script( 'search_username',
	plugins_url('js/search_username.js',__FILE__ ), 
	array('jquery'), '1.0', true);
	
	
	
} //end wp_demo_load_css

add_action('wp_enqueue_scripts','wp_demo_load_scripts');
	

//directory name of our plugin folder
require_once(dirname(__FILE__ ) . "/admin/admin_options.php"); 


//validate the form	
function validate_registration_form(){

//get the form variables and put them in local function variables
$username=$_POST["username"];
$password=$_POST["password"];
$password2=$_POST["password2"];
$email=$_POST["email"];
$website=$_POST["website"];
$fname=$_POST["fname"];
$lname=$_POST["lname"];
$nickname=$_POST["nickname"];
$bio=$_POST["bio"];

//check for empty required fields username, email and password
//intialize our error variable
$error="";

if(empty($username)){
	$error.="Your username is empty.<br>";
}
else{
     //check if username is valid
	if(!validate_username( $username )){
	$error.="That username is invalid.<br>";
	}
	//if it is valid does it exist already ?
	else{
	if(username_exists( $username )){
	$error.="That username already exists.<br>";
	}
  } //end username exists
} //end username else not empty


if(empty($password) or empty($password2)){
	$error.="One of your password fields is empty.<br>";
}
else if($password !== $password2){
	$error.="Your password fields do not match.<br>";
}
else if(strlen($password) < 6){
	$error.="Your password must be greater than six characters.<br>";
}
else if (!preg_match("#[0-9]+#", $password)) {
    $error .= "Password must include at least one number!";
    }

if(empty($email)){
$error.="Your email is empty.<br>";
}
else if(!is_email($email)){
$error .="Your email address is invalid<br>";
}
else if(email_exists($email)){
$error .="That email address already exists<br>";
}

if (!empty($website)){

if (!filter_var($website, FILTER_VALIDATE_URL) === true) {
   $error.='Website is not a valid URL<br>';
	}
}

return $error; 
 
}

//registration on success

function register(){

//sanitize our data
$username=sanitize_user($_POST['username']);
$password=esc_attr($password);
$email=sanitize_email($_POST['email']);
$fname=sanitize_text_field($_POST['fname']);
$lname=sanitize_text_field($_POST['lname']);
$nickname=sanitize_text_field($_POST['nickname']);
$bio=sanitize_text_field($_POST['bio']);
$website=esc_url($_POST['website']);

$userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   $website,
        'first_name'    =>   $fname,
        'last_name'     =>   $lname,
        'nickname'      =>   $nickname,
        'description'   =>   $bio,
        );

$user_id=wp_insert_user($userdata);

if($user_id){
	echo 'Registration complete. Goto <a href="' . get_site_url().'/login/">login page</a>.';   
}
else{
	echo "Registration Failed"; 
}

}

function show_registration_form_bootstrap($error=""){ ?>
    
   <?php if(!empty($error)){ ?> 
   <div class="alert alert-danger">
   <strong><?php echo $error; ?></strong>
   </div>
   <?php } ?>
   
   <div class="panel panel-primary">
    <div style="background:#16a085;" class="panel-heading">required *</div>
    <div class="panel-body">
     <div class="col-lg-6 col-lg-offset-3 centered">
	 
		<form  role="form" action="" method="post">
		<div class="form-group">
		<label for="username">Username <strong>*</strong></label>
		<input id="username" type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
		<!-- result from ajax success -->
		<div id="result">&nbsp;</div>
		</div>
		
		<div class="form-group">
		<label for="password">Password <strong>*</strong></label>
		<input id="passW" type="password" name="password" 
		value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>">
		<div id="result1">&nbsp;</div>
		</div>
		
		<div class="form-group">
		<label for="password">Password Match<strong>*</strong></label>
		<input type="password" name="password2" 
		value="<?php if(isset($_POST['password2'])) echo $_POST['password2'];?>">
		</div>
		 
		<div class="form-group">
		<label for="email">Email <strong>*</strong></label>
		<input id="email" type="text" name="email" 
		value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
		<div id="result2">&nbsp;</div>
		</div>
		 
		<div class="form-group">
		<label for="website">Website</label>
		<input type="text" name="website" 
		value="<?php if(isset($_POST['website'])) echo $_POST['website'];?>">
		</div>
		 
		<div class="form-group">
		<label for="firstname">First Name</label>
		<input type="text" name="fname" 
		value="<?php if(isset($_POST['fname'])) echo $_POST['fname'];?>">
		</div>
		 
		<div class="form-group">
		<label for="website">Last Name</label>
		<input type="text" name="lname" 
		value="<?php if(isset($_POST['lname'])) echo $_POST['lname'];?>">
		</div>
		 
		<div class="form-group">
		<label for="nickname">Nickname</label>
		<input type="text" name="nickname" 
		value="<?php if(isset($_POST['nickname'])) echo $_POST['nickname'];?>">
		</div>
		 
		<div class="form-group">
		<label for="bio">About / Bio</label>
		<textarea name="bio">
		<?php if(isset($_POST['bio'])) echo $_POST['bio'];?>
		</textarea>
		</div>
		<input type="submit" name="Submit" value="Register"/>
		
		</form>
		
	    </div>
      </div>
	</div>  

 
<?php } //end show_custom_registration_form


function show_registration_form_foundation($error=""){ ?>
   
   <div class="row">
	<div class="large-6 large-centered columns">
   
   <?php if(!empty($error)){ ?> 
   <div data-alert class="alert-box">
    <strong><?php echo $error; ?></strong>
    <a href="#" class="close">&times;</a>
   </div>
   <?php } ?>
   
    
		<div class="panel">
		<form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		
	    <div class="row">
        <div class="small-3 columns">
         <label for="username" class="right inline">Username <strong>*</strong></label>
        </div>
        <div class="small-9 columns">
         <input type="text" name="username" 
		  value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
	  </div>
    </div>
		
	<div class="row">
        <div class="small-3 columns">
          <label class="right inline" for="password">Password <strong>*</strong></label>
		</div>
        <div class="small-9 columns">
          <input type="password" name="password" 
		value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>">
	    </div>
    </div>
		 
	  <div class="row">
        <div class="small-3 columns">
          <label class="right inline" for="password">Password Match<strong>*</strong></label>
	   </div>
        <div class="small-9 columns">
          <input type="password" name="password2" 
		   value="<?php if(isset($_POST['password2'])) echo $_POST['password2'];?>">
	   </div>
      </div>
		
		
		  <div class="row">
        <div class="small-3 columns">
          <label class="right inline" for="email">Email <strong>*</strong></label>
	   </div>
        <div class="small-9 columns">
          <input type="text" name="email" 
		value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
	  </div>
      </div>
		 
		   <div class="row">
        <div class="small-3 columns">
          <label class="right inline" for="website">Website</label>
		</div>
        <div class="small-9 columns">
          <input type="text" name="website" 
		value="<?php if(isset($_POST['website'])) echo $_POST['website'];?>">
		   </div>
      </div>
		 
		   <div class="row">
        <div class="small-3 columns">
          <label class="right inline" for="firstname">First Name</label>
		   </div>
        <div class="small-9 columns">
          <input type="text" name="fname" 
		value="<?php if(isset($_POST['fname'])) echo $_POST['fname'];?>">
		   </div>
      </div>
		 
		   <div class="row">
        <div class="small-3 columns">
          <label class="right inline" for="website">Last Name</label>
	 </div>
        <div class="small-9 columns">
          <input type="text" name="lname" 
		value="<?php if(isset($_POST['lname'])) echo $_POST['lname'];?>">
	   </div>
      </div>
		 
	<div class="row">
       <div class="small-3 columns">
        <label class="right inline" for="nickname">Nickname</label>
	   </div>
        <div class="small-9 columns">
         <input type="text" name="nickname" 
		value="<?php if(isset($_POST['nickname'])) echo $_POST['nickname'];?>">
	   </div>
    </div>
	
	<div class="row">
    <div class="large-12 columns">
      <label>About / Bio</label>
        <textarea placeholder="Enter information">
		<?php if(isset($_POST['bio'])) echo $_POST['bio']; ?>
		</textarea>
      </label>
    </div>
  </div>
		<div class="row">
    <div class="large-12 columns">
		<input type="submit" name="Submit" value="Register"/>
		</div></div>
		</form>
		
	   </div> <!--end panel-->
      </div> <!-- end large-6 -->
	</div> <!--end row-->

 
<?php } //end show_custom_registration_form


function show_registration_form_html5($error=""){ ?>
   
   
   <?php if(!empty($error)){ ?> 
   <div>
   <strong style="color:red;text-align:center;" >
   <?php echo $error; ?>
   </strong>
   </div>
   <?php } ?>
   
		<form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<label for="username">Username <strong>*</strong></label>
		<input type="text" name="username" 
		value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>"><br>
		
		<label for="password">Password <strong>*</strong></label>
		<input type="password" name="password" 
		value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>"><br>
		
		
		<label for="password">Password Match<strong>*</strong></label>
		<input type="password" name="password2" 
		value="<?php if(isset($_POST['password2'])) echo $_POST['password2'];?>"><br>
		
		
		<label for="email">Email <strong>*</strong></label>
		<input type="text" name="email" 
		value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"><br>
		
		
		<label for="website">Website</label>
		<input type="text" name="website" 
		value="<?php if(isset($_POST['website'])) echo $_POST['website'];?>"><br>
	
		
		<label for="firstname">First Name</label>
		<input type="text" name="fname" 
		value="<?php if(isset($_POST['fname'])) echo $_POST['fname'];?>"><br>
	
		 
		<label for="website">Last Name</label>
		<input type="text" name="lname" 
		value="<?php if(isset($_POST['lname'])) echo $_POST['lname'];?>"><br>
		
		 
		
		<label for="nickname">Nickname</label>
		<input type="text" name="nickname" 
		value="<?php if(isset($_POST['nickname'])) echo $_POST['nickname'];?>"><br>
	
		 
		
		<label for="bio">About / Bio</label>
		<textarea name="bio">
		<?php if(isset($_POST['bio'])) echo $_POST['bio'];?>
		</textarea><br>
		
		<input type="submit" name="Submit" value="Register"/><br>
		
		</form>
		

 
<?php } //end show_custom_registration_form


	
//main function or main program
function custom_registration(){	
 
//structure for handling a form 
//if the form has been submitted
if(isset($_POST["Submit"])){

//check for errors
 $error=validate_registration_form();
 if($error==""){
 //success
 register();
 }
 else{
     //get the current framework
	 //if it is empty default will be html5
     $framework=get_option("framework","html5");
	 
	 if($framework=="html5"){
	 show_registration_form_html5($error);
	 } 
   	 else if($framework=="bootstrap"){
	 show_registration_form_bootstrap($error);
	 }
	 else if($framework=="foundation"){
	 show_registration_form_foundation($error);
     }
	 
	 }

} //end post submit

//first time to see the form
else{
 //get the current framework
	 //if it is empty default will be html5
     $framework=get_option("framework","html5");
	 
	 if($framework=="html5"){
	 show_registration_form_html5();
	 } 
   	 else if($framework=="bootstrap"){
	 show_registration_form_bootstrap();
	 }
	 else if($framework=="foundation"){
	 show_registration_form_foundation();
     }

} //end else submit

} //end custom registration main program
//[cr]
add_shortcode('cr', 'custom_registration_shortcode');


function custom_registration_shortcode(){
    //prevents the sending of any data to the page until the function below
	//has executed.
    ob_start();
	
	//name of our main plugin function
    custom_registration();
	
    return ob_get_clean();
}