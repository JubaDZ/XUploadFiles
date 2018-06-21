<?php
/* Check if session exist then return user id*/
function get_session($hash){

    dbconnect();

    $hash = mysql_real_escape_string($hash);


    $ip = implode('.', array_slice(explode('.', $_SERVER['REMOTE_ADDR']), 0, 4 - 1));
    $newidhash = md5($_SERVER['HTTP_USER_AGENT'] . $ip);

    $query = "SELECT * FROM session WHERE sessionhash = '".$hash."' LIMIT 1";
    $result = mysql_query($query);   

    if(mysql_num_rows($result) > 0){
        $row = mysql_fetch_array($result);

        $sessionhash = $row['sessionhash'];
        $idhash = $row['idhash'];
        $userid = $row['userid'];
        $lastactive = $row['lastactivity'];

        return ($idhash == $newidhash && (time() - $lastactive) < 900) ? $userid : false;
    }
    return false;   
}
//Check cookie values in database:

function get_cookie($id, $pass){

    dbconnect();

    $id = mysql_real_escape_string($id);

    $query = "SELECT * FROM user WHERE userid = ".$id." LIMIT 1";
    $result = mysql_query($query);  

    if(mysql_num_rows($result) > 0){
        $row = mysql_fetch_array($result);
        $dbpass = $row['password'];

        // vb might change the salt from time to time. can be found in the /includes/functions.php file
        if(md5($dbpass . '0d582e0835ec6697262764ae6cb467fb') == $pass){
            return $id;
        }
    }
    return false;   
}

//Wrap it all up to determine if user is logged:

function check_login(){
    if(isset($_COOKIE['bb_userid']) && isset($_COOKIE['bb_password'])){
        if(get_cookie($_COOKIE['bb_userid'], $_COOKIE['bb_password'])){
            return $_COOKIE['bb_userid'];
        }
    }
    if(isset($_COOKIE['bb_sessionhash'])){
        if(get_session($_COOKIE['bb_sessionhash'])){
            return get_session($_COOKIE['bb_sessionhash']);
        }
    }
    return false;
}

//Retrieve user info to be displayed:

function user_info($id){
    dbconnect();
    $result = mysql_query("SELECT * FROM user WHERE userid = ".mysql_real_escape_string($id)." LIMIT 1";);
    return mysql_fetch_array($result);
}

//And to conclude, use the above functions somewhere. Like this:

if($li = check_login()){
    dbconnect();
    $uinfo = user_info($li);

    $q_lastactivity = "UPDATE user SET lastactivity = '".time()."' WHERE userid = ".$li." LIMIT 1";
    mysql_query($q_lastactivity);

    if((time() - $uinfo['lastactivity']) > 900){
        $q_lastvisit = "UPDATE user SET lastvisit = '".$uinfo['lastactivity']."' WHERE userid = ".$li." LIMIT 1";
        mysql_query($q_lastvisit);  }
}
?>