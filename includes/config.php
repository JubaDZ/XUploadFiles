<?php
define('dbhost','localhost'); 
define('dbuser','root'); 
define('dbpass',''); 
define('dbname','db_uploads'); 

define('FooterInfo',false); //false-true
define('EnableLogo',false); //false-true
define('UpdateBrowser',true); // ie8=< message
define('DirectoryChanged',false); // alert
define('ApiStatus',true); // api

/*define('MainTitle','اكتب هنا اسم موقعك');*/
$supportedLangs  = array('ar','en','') ;
$lang            = array();
$_plans          = array('0'=>'free','1'=>'premium','2'=>'gold','3'=>'register');
$currentpage     = 1 ;
$totalpages      = 1 ;
?>