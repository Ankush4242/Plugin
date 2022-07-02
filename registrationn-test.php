<?php
/*
  Plugin Name: Custom Registration
  Plugin URI: https://ankush.com
  Description: Updates user rating based on number of posts.
  Version: 2.0
  Author: Ankush 
  Author URI: http://tech4sky.com*/
  
  
  function registration_form( $email, $first_name ) {
    echo '
    <style>
    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
    </style>
    ';
 
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data">
     
    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
    </div>
     
    <div>
    <label for="firstname">First Name</label>
    <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
    </div>
	
	 <div>
    <label for="fileupload">file upload</label>
    <input type="file" name="wp_custom_attachment" id="wp_custom_attachment" size="50" value="' . ( isset( $_POST['wp_custom_attachment']) ? $file : null ) . '" />
    </div>
    
    <input type="submit" name="submit" value="Register"/>
    </form>
    ';
	
	
	
}

function complete_registration() {
    global $email, $first_name;
    
        $userdata = array(
		
        'user_email'    =>   $email,
        'first_name'    =>   $first_name,
        
        );
        $user = wp_insert_user( $userdata );
		
		  echo 'Registration complete';
		} 
function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
      
         
        // sanitize user form input
        global $email, $first_name;
        $email      =   sanitize_email( $_POST['email'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );

        complete_registration(
        $email,
        $first_name
        );
    }
    registration_form(
        $email,
        $first_name
        );
}

// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
 
// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}