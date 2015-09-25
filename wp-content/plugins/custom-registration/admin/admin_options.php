<?php

//hook to add menu to settings in dashboard
add_action('admin_menu', 'custom_registration_admin');

function custom_registration_admin() {

/***Parameters***/
//basic title
//name that appears in the settings menu
//capability - manage options means the user can change options
//get the location of the current page  __FILE__  
//function to process the option page actions
	
add_options_page('CustomRegistration','Custom Registration','manage_options',__FILE__ ,'custom_registration_process');

}

//function to process our form when submitted
function custom_registration_process(){ ?>

<?php 
//check to see if the form has been submitted
if(isset($_POST["Submit"])){
	$selected=$_POST["framegroup"];
	update_option("framework",$selected);
//insert users selection into the options table
}
else{
//default value if the form has not been submitted
	
	//check to see if option exists
	$existing=get_option("framework");
	
	if(empty($existing)){
	$selected="html5";
	//insert user selection into the database
	add_option("framework",$selected);
    }
	else{$selected=$existing;}

} //end not submitted

?>


<h1>Choose a Framework</h1>
<form name="registration_options" action="" method="post" >
<label for="html5">HTML 5</label> 
<input type="radio" name="framegroup" id="html5" value="html5" <?php if($selected=="html5"){echo 'checked="checked"';} ?> /><br>
<label for="bootstrap">Bootstrap</label> 
<input type="radio" name="framegroup" id="bootstrap" value="bootstrap" <?php if($selected=="bootstrap"){echo 'checked="checked"';} ?> /><br>
<label for="bootstrap">Foundation</label> 
<input type="radio" name="framegroup" id="foundation" value="foundation" <?php if($selected=="foundation"){echo 'checked="checked"';} ?> /><br>
<input type="submit" name="Submit" value="Submit" />
</form>

<?php } ?>

