<?php 

require_once "common.inc.php";
if (isset($_GET["username"])) {
	$username = isset($_GET["username"]) ? $_GET["username"] : "";
	if(Member::getByUsername($username)) {
		echo "This username already exists";
	} else {
		echo "";
	}
} elseif (isset($_GET["email"])) {
	$email = isset($_GET["email"]) ? $_GET["email"] : "";
	if(Member::getByEmailAddress($email)) {
		echo "This email already exists";
	} else {
		echo "";
	}
} else {
	echo "error in checkUserNEmail.php";
}

?>
