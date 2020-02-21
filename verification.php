<?php

	if( isset($_SESSION['ip'] ) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] ) {
		// ok
	} else {
		header('Location: ./connexion.php');
	}

	// if( !isset( $_COOKIE['user'] ) ) {
	// 	header('Location: ./connexion.php');
	// }

?>