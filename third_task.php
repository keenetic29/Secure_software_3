<?php
if( isset( $_GET[ 'Login' ] ) ) {
	// Get username
	$user = $_GET[ 'username' ];
	// Get password
	$pass = $_GET[ 'password' ];
	$pass = password_hash( $pass, PASSWORD_BCRYPT );
	// Check the database
	if(preg_match("[a-z]*",$pass) and preg_match("([a-z]|[0-9])*",$username) and !mysqli_query($GLOBALS["__mysql_ston"], "SELECT ban FROM `users` WHERE user = $_GET[ 'username' ];")){
        	$query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
        	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
        	if( $result && mysqli_num_rows( $result ) == 1 ) {
            		// Get users details
            		$row    = mysqli_fetch_assoc( $result );
            		$avatar = $row["avatar"];
            		// Login successful
            		$html .= "<p>Welcome to the password protected area {$user}</p>";
            		$html .= "<img src=\"{$avatar}\" />";
        	}
	}
	else {
	    if(!(preg_match("[a-z]*",$pass) and preg_match("([a-z]|[0-9])*",$username)))
	    {
	        $html .= "<pre><br />Username and/or password incorrect.</pre>";
	    }
	    else
	    {
            	// Login failed
            	$html .= "<pre><br />Username and/or password incorrect. </pre>";
            	//sleep(rand(100, 600));
            	mysqli_query($GLOBALS["__mysql_ston"], "UPDATE `users` SET count = count+1 WHERE user = $_GET[ 'username' ];");
            	if(mysqli_query($GLOBALS["__mysql_ston"], "SELECT count FROM `users` WHERE user = $_GET[ 'username' ];")>5){
                	mysqli_query($GLOBALS["__mysql_ston"], "UPDATE `users` SET ban = True WHERE user = $_GET[ 'username' ];");
            }
		}
	}
	((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
}
?>