<?php

/*
Check Password strength
Check for password strength, password should be at least n characters,
contain at least one number, contain at least one lowercase letter, contain at least one uppercase letter,
 contain at least one special character.
*/

function password_strength($password) {

	$password_length = 8;
	$returnVal = True;

	if ( strlen($password) < $password_length ) {
		$returnVal = False;
	} else if ( !preg_match("#[0-9]+#", $password) ) {
		$returnVal = False;
	} else if ( !preg_match("#[a-z]+#", $password) ) {
		$returnVal = False;
	}else if ( !preg_match("#[A-Z]+#", $password) ) {
		$returnVal = False;
	}else if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) ) {
		$returnVal = False;
	}

	return $returnVal;
}

?>