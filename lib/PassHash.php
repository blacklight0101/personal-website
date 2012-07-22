<?


//Clase para encriptar PW

class PassHash {  
  
    // blowfish  
    private static $algo = '$2a';  
  
    // cost parameter  
    private static $cost = '$10';  
  
    // mainly for internal use  
    public static function unique_salt() {  
        return substr(sha1(mt_rand()),0,22);  
    }  
  
    // this will be used to generate a hash  
    public static function hash($password) {  
  
        return crypt($password,  
                    self::$algo .  
                    self::$cost .  
                    '$' . self::unique_salt());  
  
    }  
  
    // this will be used to compare a password against a hash  
    public static function check_password($hash, $password) {  
  
        $full_salt = substr($hash, 0, 29);  
  
        $new_hash = crypt($password, $full_salt);  
  
        return ($hash == $new_hash);  
  
    }  
  
} 

?> 


/*
USO:

Here is the usage during user registration:
view plaincopy to clipboardprint?
// include the class  
require ("PassHash.php");  
  
// read all form input from $_POST  
// ...  
  
// do your regular form validation stuff  
// ...  
  
// hash the password  
$pass_hash = PassHash::hash($_POST['password']);  
  
// store all user info in the DB, excluding $_POST['password']  
// store $pass_hash instead  
// ...  
And here is the usage during a user login process:
view plaincopy to clipboardprint?
// include the class  
require ("PassHash.php");  
  
// read all form input from $_POST  
// ...  
  
// fetch the user record based on $_POST['username']  or similar  
// ...  
  
// check the password the user tried to login with  
if (PassHash::check_password($user['pass_hash'], $_POST['password']) {  
    // grant access  
    // ...  
} else {  
    // deny access  
    // ...  
}  

*/
