<?php
/**
 * Extracts and validates various global variables
 *
 * Explicitly define and validate the variables that we expect to exist.  This
 * prevents the creation of extraneous variables through register_globals() and
 * other methods.  It is a security feature.  This page needs to be included
 * after the variable array has been defined and as close to the beginning of the
 * script execution as possible.
 *
 * The name of the variable holding the array is important.  It must be in the
 * form of
 *
 * 	'$expected_' + [the predefined global variable that is to be searched]
 *
 * example:  to list all of the expected variables that we wish to allow from
 * $_POST we would say something like:
 *
 * 		variable_name			variable definition
 * 		-------------			-------------------
 *
 * $expected_post = array(
 * 		'session_id' => 	array('type' => 'string', 'min_length' => 2, 'max_length' => 255),
 * 		'name' => 			array('type' => 'string', 'min_length' => 1, 'max_length' => 50),
 * 		'age' => 			array('type' => 'integer', 'min' => 1, 'max' => 120),
 * 		'grade' => 			array('type' => 'float', 'min' => 55.5, 'max' => 100),
 * 		'enrolled' => 		array('type' => 'boolean'),
 * 		'email' => 			array('type' => 'email', 'allow_intranet' => ALLOW_INTRANET_EMAIL),
 * 		'homepage' => 		array('type' => 'url', 'allow_intranet' => ALLOW_INTRANET_WEBSITE),
 * 		'phone' =>			array('type' => 'phone', 'format' => 'usa'),
 * 		'zip' =>			array('type' => 'zip', 'format' => 'usa'),
 * 		'read_tos' =>		array('type' => 'checkbox'),
 * 		'option' =>			array('type' => 'radio'),
 * 		'submit' =>			array('type' => 'submit')
 * );
 *
 * this would create variables $session_id, $name, $age, $grade, etc... and validate
 * them against the criteria in the definition.
 *
 * Note:  ALLOW_INTRANET_EMAIL and ALLOW_INTRANET_WEBSITE are bool true/fales values.
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 * @param array $predefined			the global array that we are going to search
 * @param string $key				the name of the new variable
 * @param array $def				the definition of the variable used to create
 * 									and validate it.
 * @param validator $val			object of class 'validator'.  Performs the
 */
function extract_vars($predefined,$key,$def=false,$val)
{
	/**
	 * If the value is empty, set the variable to FALSE.
	 */
	if(empty($predefined[$key]))
	{
		return false;
	}

	if(isset($def))
	{
		switch ($def['type'])
		{
			/**
			 * Validates a string returning the value if it validates and boolean FALSE
			 * if it doesn't.
			 */
			case 'string':
				if($val->validateString($predefined[$key],$def['min_length'],$def['max_length']))
				{
					return (string) $predefined[$key];
				}
				else
				{
					return false;
				}
				break;
			/**
			 * Validates an integer returning the value if it validates and boolean FALSE
			 * if it doesn't.
			 */
			case 'integer':
				if($val->validateInteger($predefined[$key], (int) $def['min'], (int) $def['max']))
				{
					return (int) $predefined[$key];
				}
				else
				{
					return false;
				}
				break;
			/**
			 * Validates a float returning the value if it validates and boolean FALSE
			 * if it doesn't.
			 */
			case 'float':
				if($val->validateFloat($predefined[$key], (float) $def['min'], (float) $def['max']))
				{
					return (float) $predefined[$key];
				}
				else
				{
					return false;
				}
				break;
			/**
			 * Validates an email address returning the value if it validates and boolean FALSE
			 * if it doesn't.
			 */
			case 'email':
				if($val->validateEmail($predefined[$key], $def['allow_intranet']))
				{
					return strtolower(trim($predefined[$key]));
				}
				else
				{
					return false;
				}
				break;
			/**
			 * Validates a boolean returning the value if it validates and boolean FALSE
			 * if it doesn't.
			 */
			case 'boolean':
				return ($val->validateBoolean($predefined[$key]));
				break;
			/**
			 * Validate a URL returning the value if it validates and boolean FALSE
			 * if it doesn't.
			 */
			case 'url':
				if($val->validateURL($predefined[$key], $def['allow_intranet']))
				{
					return $val->safeURI($predefined[$key]);
				}
				else
				{
					return false;
				}
				break;
			/**
			 * Validate a phone number returning the value if it validates and
			 * boolean FALSE if it doesn't.
			 */
			case 'phone':
				if($val->validatePhone($predefined[$key], $def['country_code']))
				{
					return strtolower(trim($predefined[$key]));
				}
				else
				{
					return false;
				}
				break;
			/**
			 * Checks if various form elements are set.
			 */
			case 'checkbox':
				return (($predefined[$key] == 1) || ($predefined[$key] == 'on') || (isset($predefined[$key]))) ? 1 : 0;
				break;
			case 'radio':
				return (isset($predefined[$key])) ? $predefined[$key] : false;
				break;
			case 'select':
				return (isset($predefined[$key])) ? $predefined[$key] : false;
				break;
			case 'submit':
				return (isset($predefined[$key])) ? $predefined[$key] : false;
				break;
			/**
			 * No validation requested for this variable
			 */
			default:
				break;
		}
	}
	return strtolower(trim($predefined[$key]));
}

/**
 * Loop through each of the arrays to create and validate the variables
 */
if(isset($expected_get))
{
	foreach($expected_get as $key => $def) { ${$key} = extract_vars($_GET,$key,$def,$val); }
}

if(isset($expected_post))
{
	foreach($expected_post as $key => $def) { ${$key} = extract_vars($_POST,$key,$def,$val); }
}

if(isset($expected_cookie))
{
	foreach($expected_cookie as $key => $def) { ${$key} = extract_vars($_COOKIE,$key,$def,$val); }
}

if(isset($expected_files))
{
	foreach($expected_files as $key => $def) { ${$key} = extract_vars($_FILES,$key,$def,$val); }
}

if(isset($expected_request))
{
	foreach($expected_request as $key => $def) { ${$key} = extract_vars($_REQUEST,$key,$def,$val); }
}

/**
 * We've taken what we need, now free up some memory and prevent bugs!
 */
unset (
	$predefined,
	$key,
	$def,
	$_GET,
	$_POST,
	$_FILES,
	$_REQUEST,
	$HTTP_GET_VARS,
	$HTTP_POST_FILES,
	$HTTP_POST_VARS
);
?>