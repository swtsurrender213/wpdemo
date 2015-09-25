<?php 

function add_menu_item($items,$args){

//echo '<pre>';
//print_r($args);
//echo '</pre>';

//echo $args-> theme_location;
//exit;
//if the user login show the menu item
if(is_user_logged_in() and $args->theme_location=='top-bar'){

$member_menu_item='<li id="menu-item-124" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-73 current_page_item active menu-item-124"><a href="http://localhost/wpdemo/members/">Members</a></li>';

$items .= $member_menu_item;
}
return $items;


}

add_filter('wp_nav_menu_items','add_menu_item',12,2);


function add_browser_class($classes){
	
	global $is_chrome;

	//if chrome  add class to body
	if($is_chrome){
	$classes[]="chrome-only";	
	}
	return $classes;
}

add_filter('body_class','add_browser_class');

//USING FILTERS
// filter to remove bad content from content
function wp_demo_remove($content){
//create a list of bad words and put them in a array
$BadWords=array('shit','fuck');

//loop through array
foreach($BadWords as $BadWord){
// replace bad content with a neutral content
//3 parameters where to find what to replace and content to be reach
$content=str_ireplace($BadWord,"sorry try again",$content);	
	
}
return $content;
}

add_filter('the_content','wp_demo_remove');




//APPLYING FILTER
// filter to remove bad content from content
function wp_demo_remove_message($message){
//create a list of bad words and put them in a array
$BadWords=array('shit','fuck');

//loop through array
foreach($BadWords as $BadWord){
// replace bad content with a neutral content
//3 parameters where to find what to replace and content to be reach
$message=str_ireplace($BadWord,"sorry try again",$message);	
	
}
return $message;
}

add_filter('clean_message','wp_demo_remove_message');





//LOGOUT

// logout redirect to new login 
function wpdemo_logout(){
	
	$new_login_page=get_home_url()."/login/";
	wp_redirect($new_login_page."?login=out");
	exit;
	
	
}

add_action('wp_logout','wpdemo_logout');


function wp_demo_verify_auth($user,$username,$password){
    
	if($username=="" or $password==""){
	$new_login_page=get_home_url()."/login/";
	wp_redirect($new_login_page."?login=empty");
	exit;		
	}
}

add_filter('authenticate','wp_demo_verify_auth',1,3);



function wp_demo_login_fail(){
	
$new_login_page=get_home_url()."/login/";
wp_redirect($new_login_page."?login=fail");
exit;	

}

add_action('wp_login_failed','wp_demo_login_fail');

function login_redirect(){

//old login page
$visitpage=basename($_SERVER["REQUEST_URI"],".php");


//if the user is on the old login page redirect them to the new login 
// test id the user is on the old login 
if($visitpage=='wp-login' and $_SERVER['REQUEST_METHOD'] == 'GET'){
	wp_redirect($new_login_page);	
	exit;
}

}


add_action('init','login_redirect');



function wpdemo_member_pay(){
//check if we are at members page 
if(is_page("member-pay-roll")){
//get the path of wordpress login to redirect

	// redirect users to the login page
	 $url=get_home_url();
	 if(!current_user_can("administrator")){
	 wp_redirect($url);
	 exit;
} //end of is_admin

}//end of is page	

}//end of function

add_action("get_header","wpdemo_member_pay");





//function to protect members page from them that not are logged on


function wpdemo_protect_member_page(){
//check if we are at members page 
if(is_page("Members")){
//get the path of wordpress login to redirect
$login=get_home_url()."/wp-login.php";


if (!is_user_logged_in()) {
	// redirect users to the login page
	 wp_redirect($login);
} //end of is_logged

}//end of is page	

}//end of function

add_action("get_header","wpdemo_protect_member_page");






function wpdemo_load_scripts(){

// function to load style stylesheet
wp_enqueue_style( 'default', get_stylesheet_directory_uri().'/css/themes/default/default.css');
//load the slider css file
wp_enqueue_style( 'nivocss', get_stylesheet_directory_uri().'/css/nivo-slider.css');
// load font-awesome to font awesome script
wp_enqueue_style( 'font-awesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');

// load the nivo slider plugiin code that needs jquery to run
wp_enqueue_script( 'nslider', get_stylesheet_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery'), '1.0.0', true );
//load the loadslider code that calls the function in the nivo slider code 
wp_enqueue_script( 'loadslider', get_stylesheet_directory_uri() . '/js/loadslider.js', array('nslider'), '1.0.0', true );
	
// datepicker


//css file  that wordpress provided
wp_enqueue_style( 'jqueryui','https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
// js file that wordpress provided
wp_enqueue_script( 'jquery-ui-datepicker');	
// datepicker script using the jquery-ui-datepicker 
wp_enqueue_script( 'datepicker', get_stylesheet_directory_uri() . '/js/datepicker.js', array('jquery-ui-datepicker'), '1.0.0', true );

}

add_action('wp_enqueue_scripts', 'wpdemo_load_scripts');
//contact the administrator when someone contacts
//the website

add_action('wpdemo_contact_submit','contact_admin');

function contact_admin(){

$admin_email=get_option( 'admin_email' );

//email,subject,message
//wp_mail( $admin_email, 'New Contact', 'website had been contacted');

}

//insert contact information into the database
function insert_contact_info(){

//get the five variables 
//prepare variables
//wp_strip_all_tags will remove spaces and illegal characters

 $fname =  wp_strip_all_tags($_POST['fname']);
 $lname =  wp_strip_all_tags($_POST['lname']);
 $email=   wp_strip_all_tags($_POST['email']);
 $phone=trim($_POST['phone']);
 // two parameters of any name of the filter and what you want to filter
 //define the filter
 
 $message= wp_strip_all_tags($_POST['message']);
 
 
 $fullname= $lname.' '.$fname;
 
 
 // Create post object
$contact_post = array(
  'post_title'    => $fullname,
  'post_status'   => 'publish',
  'post_type'     => 'contact',
);

// Insert the post into the wp_post table and get the id
$post_id=wp_insert_post($contact_post);


//Insert into the postmeta table
add_post_meta($post_id, 'first_name', $fname);
add_post_meta($post_id, 'last_name', $lname);
add_post_meta($post_id, 'email', $email);
add_post_meta($post_id, 'telephone',$phone);

$message=apply_filters('clean_message',$message);
add_post_meta($post_id, 'message', $message);

}

//hooking into the do_action on submit
add_action('wpdemo_contact_submit','insert_contact_info');








//REQUEST FORM
add_action('wpdemo_request_submit','contact_admin');

//insert contact information into the database
function insert_request_info(){

//get the five variables 
//prepare variables
//wp_strip_all_tags will remove spaces and illegal characters

 $fullname =  wp_strip_all_tags($_POST['fullname']);
 $phone=trim($_POST['phone']);
 $member= wp_strip_all_tags($_POST['member']);
 $experience= wp_strip_all_tags($_POST['experience']);
 $recentemployees= wp_strip_all_tags($_POST['recentemployees']);
 
 
 
 // Create post object
$request_post = array(
  'post_title'    => $fullname,
  'post_status'   => 'publish',
  'post_type'     => 'request',
);

// Insert the post into the wp_post table and get the id
$post_id=wp_insert_post($request_post);


//Insert into the postmeta table
add_post_meta($post_id, 'fullname', $fullname);
add_post_meta($post_id, 'phone',$phone);
add_post_meta($post_id, 'member', $member);
add_post_meta($post_id, 'experience', $experience);
add_post_meta($post_id, 'recentemployees', $recentemployees);

}

//hooking into the do_action on submit
add_action('wpdemo_request_submit','insert_request_info');




//to hook into the page with your own code
// just before the head tag finishes loading </head>

//first parameter is the name of the hook
//second parameter is the name of the function that 
//will execute (your code to be added just before the /head tag)

add_action('wp_head', 'add_fav_icon');
 
function add_fav_icon() {
//Check meta description is set or not
echo '<link rel="icon" type="image/x-icon" 
href="'.get_stylesheet_directory_uri().'/images/.ico" />';
}

add_action('wp_head', 'add_meta_desc');

function add_meta_desc() {

//Getting the blog description with the ACF function the_field
$desc = get_field('description');

//Check meta description is set or not
if(!empty($desc)){
echo '<meta name="description" content="' . $desc . '" />';
}

}








function show_contact_form($error="")
{ 

if($error!=""){
echo '<div class="alert alert-danger centered">'.$error.'</div>';
} ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm">
                <form class="form-horizontal" method="post" action="">
                    <fieldset>
                        <legend class="text-center header">Contact us</legend>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-8">
								<?php 
								if(isset($_POST['fname'])) 
								echo '<input id="fname" name="fname" type="text" value="'.$_POST['fname'].'" class="form-control">'; 
								else
								echo '<input id="fname" name="fname" type="text" placeholder="First Name" class="form-control">';
								?>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-8">
                                <?php 
								if(isset($_POST['lname'])) 
								echo '<input id="lname" name="lname" type="text" value="'.$_POST['lname'].'" class="form-control">'; 
								else
								echo '<input id="lname" name="lname" type="text" placeholder="Last Name" class="form-control">';
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-envelope-o bigicon"></i></span>
                            <div class="col-md-8">
								  <?php 
								if(isset($_POST['email'])) 
								echo '<input id="email" name="email" type="text" value="'.$_POST['email'].'" class="form-control">'; 
								else
								echo ' <input id="email" name="email" type="text" placeholder="Email Address" class="form-control">';
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-phone-square bigicon"></i></span>
                            <div class="col-md-8">
								 <?php 
								if(isset($_POST['phone'])) 
								echo '<input id="phone" name="phone" type="text" value="'.$_POST['phone'].'" class="form-control">'; 
								else
								echo '  <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control">';
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-pencil-square-o bigicon"></i></span>
                            <div class="col-md-8">
								 <?php 
								if(isset($_POST['message'])) 
								echo '<textarea class="form-control" id="message" name="message" rows="7">'.$_POST['message'].'</textarea>'; 
								else
								echo '<textarea class="form-control" id="message" name="message" placeholder="Enter your massage for us here. We will get back to you within 2 business days." rows="7"></textarea>';
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button name="contact-submit" type="submit" class="btn btn-primary btn-lg">
								Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
}




function show_request_form($error="")
{ 

if($error!=""){
echo '<div class="alert alert-danger centered">'.$error.'</div>';
} ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm">
                <form class="form-horizontal" method="post" action="">
                    <fieldset>
                        <legend class="text-center header">Request Form</legend>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-8">
								<?php 
								if(isset($_POST['fullname'])) 
								echo '<strong>Full Name:</strong> <input id="fullname" name="fullname" type="text" value="'.$_POST['fullname'].'" class="form-control">'; 
								else
								echo '<strong>Full Name:</strong> <input id="fullname" name="fullname" type="text" placeholder="full Name" class="form-control">';
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-phone-square bigicon"></i></span>
                            <div class="col-md-8">
								 <?php 
								if(isset($_POST['phone'])) 
								echo '<strong>Phone:</strong> <input id="phone" name="phone" type="text" value="'.$_POST['phone'].'" class="form-control">'; 
								else
								echo '<strong>Phone:</strong> <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control">';
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-pencil-square-o bigicon"></i></span>
                            <div class="col-md-8">
								 <?php 
								if(isset($_POST['member'])){
									if ($_POST['member']=="Yes"){							
										echo '<input type="checkbox" name="member" value="Yes" checked="checked">Yes<br>';
										echo '<input type="checkbox" name="member" value="No">No<br>';
										}
									else{
										echo '<strong>Member:</strong>  <input type="checkbox" name="member" value="Yes">Yes&nbsp';
										echo '<input type="checkbox" name="member" value="No" checked="checked">No';
									}
								}
								else{
									echo '<strong>Member:</strong> <input type="checkbox" name="member" value="Yes">Yes&nbsp';
									echo '<input type="checkbox" name="member" value="No">No'; 	
								} ?> <br><br>		

								<div class="form-group">
                            <i class="fa fa-pencil-square-o bigicon"></i></span>
                            <div class="col-md-8">
								 <?php 
								if(isset($_POST['experience'])) 
								echo '<strong>Experiences:</strong> <textarea class="form-control" id="experience" name="experience" rows="7">'.$_POST['experience'].'</textarea>'; 
								else
								echo '<strong>Experiences:</strong> <textarea class="form-control" id="experience" name="experience" placeholder="Enter your Experiences for us here. We will get back to you within 2 business days." rows="7"></textarea>';
								?>
                            </div>
                        </div><br>
							
							<div class="form-group">
                            <i class="fa fa-pencil-square-o bigicon"></i></span>
                            <div class="col-md-8">
								 <?php 
								if(isset($_POST['recentemployees'])) 
								echo '<strong>Recent Employees:</strong> <textarea class="form-control" id="recentemployees" name="recentemployees" rows="7">'.$_POST['recentemployees'].'</textarea>'; 
								else
								echo '<strong>Recent Employees:</strong> <textarea class="form-control" id="recentemployees" name="recentemployees" placeholder="Enter your recent employees so we will get back to you within 2 business days." rows="7"></textarea>';
								?>
                            </div>
                        </div>
							
							
								
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button name="request-submit" type="submit" class="btn btn-primary btn-lg">
								Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
}





function check_show_contact_form_error(){

//no errors to start
 $error="";
    
	//trim first name to remove spaces
	$fname=trim($_POST['fname']);
	
	if ($fname!= "") {
	    //santize to remove any illegal characters
        $fname = filter_var($fname, FILTER_SANITIZE_STRING);
	    //after the first name has been sanitized make sure 
		//it is not blank
		if ($fname == "") {
			$error .= 'Please enter a valid first name.<br/><br/>';
		}
	} else {
    $error .= 'Please enter your first name.<br/>';
	}
	
	
	//trim last name
	$lname=trim($_POST['lname']);
	
	if ($lname!= "") {
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);
	//after the last name has been sanitized make sure it is not blank
		if ($lname == "") {
			$error .= 'Please enter a valid first name.<br/><br/>';
		}
	} else {
    $error .= 'Please enter your last name.<br/>';
	}
	
	
	//trim email
	$email=trim($_POST['email']);
	//if not equal to a blank
	if ($email != "") {
	//remove any illegal characters
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
	//check if the email address is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error .= "$email is <strong>NOT</strong> a valid 
			email address.<br/><br/>";
		}
    } else {
    $error .= 'Please enter your email address.<br/>';
    }
	
	
	//phone number
	$phone=trim($_POST['phone']);
	//regular expression
	$regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";	
	
	if($phone != ''){
	  //validate the phone number
		if(!preg_match($regex, $phone)){
		$error .= 'Please enter a valid phone number.<br>';
		}
	} else {
		
	$error .= 'Please enter your phone number.<br/>';}
    
	
	
	//message
	$message=trim($_POST['message']);
	
	if ($message!= "") {
    $message = filter_var($message, FILTER_SANITIZE_STRING);
	//after the message has been sanitized make sure it is not blank
		if ($message == "") {
			$error .= 'Please enter a valid message.<br/><br/>';
		}
	} else {
    $error .= 'Please enter a message.<br/>';
	}
	
	
return $error;	

}


//request form
function check_show_request_form_error(){

//no errors to start
 $error="";
    
	//trim first name to remove spaces
	$fullname=trim($_POST['fullname']);
	
	if ($fullname!= "") {
	    //santize to remove any illegal characters
        $fullname = filter_var($fullname, FILTER_SANITIZE_STRING);
	    //after the first name has been sanitized make sure 
		//it is not blank
		if ($fullname == "") {
			$error .= 'Please enter a valid full name.<br/><br/>';
		}
	} else {
    $error .= 'Please enter your full name.<br/>';
	}
		
	//phone number
	$phone=trim($_POST['phone']);
	//regular expression
	$regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";	
	
	if($phone != ''){
	  //validate the phone number
		if(!preg_match($regex, $phone)){
		$error .= 'Please enter a valid phone number.<br>';
		}
	} else {
		
	$error .= 'Please enter your phone number.<br/>';}
    
	
	
	//message
	$member=trim($_POST['member']);
	
	if ($member!= "") {
    $member = filter_var($member, FILTER_SANITIZE_STRING);
	//after the message has been sanitized make sure it is not blank
		if ($member == "") {
			$error .= 'Please enter a valid member.<br/><br/>';
		}
	} else {
    $error .= 'Please enter a your member user .<br/>';
	}
	
	
	//message
	$experience=trim($_POST['experience']);
	
	if ($experience!= "") {
    $experience = filter_var($experience, FILTER_SANITIZE_STRING);
	//after the message has been sanitized make sure it is not blank
		if ($experience == "") {
			$error .= 'Please enter a valid experiences.<br/><br/>';
		}
	} else {
    $error .= 'Please enter a your experiences .<br/>';
	}
	
	
	//message
	$recentemployees=trim($_POST['recentemployees']);
	
	if ($recentemployees!= "") {
    $recentemployees = filter_var($recentemployees, FILTER_SANITIZE_STRING);
	//after the message has been sanitized make sure it is not blank
		if ($recentemployees == "") {
			$error .= 'Please enter a valid recent employee skills.<br/><br/>';
		}
	} else {
    $error .= 'Please enter a your recent employment.<br/>';
	}
	
	
return $error;	

}