<?php
ob_get_contents();
ob_end_clean();

(isset($_GET['captcha'])) ? exit(require_once ('../includes/libraries/captcha.php')) : '';

require_once ( '../includes/config.php');
require_once ( '../includes/session.php');
require_once ( '../includes/functions.php');
/*-----------------------------------------------------------------*/
/*if(post_max_size_exceeded())
	IePrintArray((array('success' => false, 'msg' => 'your file is too big!'  ,'footerInfo'=> '' ))) ;*/
/*-----------------------------------------------------------------*/
require_once ( '../includes/connect.php');
require_once ( '../includes/language/'.LANG_FILE);
require_once ( '../includes/libraries/uploader.php'); //dirname(__FILE__) .
(thumbnail) ? require_once ( '../includes/libraries/thumbnail.php') : '';

(isGet('api') && !ApiStatus ) ?  IePrintArray(array('success' => false, 'msg' => 'ApiStatus => false' ,'footerInfo'=> FooterInfo('..'.folderupload) )) : '' ; 
(isGet('api') && isGet('uploadfile') && !ApiLogin && (isGet('username') && (strlen($_GET['username'])>0)  ) ) ? IePrintArray(array('success' => false, 'msg' => $lang[98],'footerInfo'=> FooterInfo('..'.folderupload) )) : '' ; 
(!isGet('api')) ?  AJAX_check() : '';
/*-----------------------------------------------------------------*/
(!Mysqli_IsConnect) ? PrintArray(array('error_msg'=> 'Mysqli '.$lang[179])) : '';

// get the current page or set a default
 
$currentpage = (isGet('currentpage') && is_numeric($_GET['currentpage'])) ? (int) $_GET['currentpage'] : 1;

/*-----------------------------------------------------------------*/


if(isGet('download'))
{

//$DownloadID       = (is_numeric($_GET['download'])) ? (int)$_GET['download'] : protect(Decrypt($_GET['download']));
//$DownloadID       =  protect(Decrypt($_GET['download']));
$referrer = (isGet('referrer') &&  !empty($_GET['referrer'])) ? protect(Decrypt($_GET['referrer'])) : '' ;/*stripslashes*/
$string   = (isGet('unq')) ? protect($_GET['unq']) : '' ;
	 
(!isset($_SESSION['settings']['files'][$DownloadID])) ? PrintArray(array('success_msg' => $lang[90])) : '';


if(isset($_SESSION['settings']['files'][$DownloadID]))
	( $_SESSION['settings']['files'][$DownloadID] !== $string ) ? PrintArray(array('success_msg' => $lang[90])) : '';


//$info     = Sql_Get_info($DownloadID);	
$filename = ($info['status']) ? '..'.$info["fullpath"] : '' ; 
$filesize = ($info['status']) ? $info["size"] : 0 ; 

($info['status']) ? Sql_Update_Count_Access( $info["id"] ) : '';
($info['status']) ? Sql_Insert_Stat( $info["id"] , $referrer) : ''; 


( $filename == "" )            ? PrintArray(array('success_msg' => $lang[115])) : ''; 
( ! file_exists( $filename ) ) ? PrintArray(array('success_msg' => $lang[46]))  : ''; 
	
	PrintArray(array('success_msg' =>    '<a  href="?file='.Encrypt($info["id"]).'&unq='.$string.'&'.szParameter.'='.$filesize.'"><i class="glyphicon glyphicon-download-alt"></i> '.$info["filename"].'</a>'       ));
}


/******************************************************/
(isGet('total_stats') )           ? PrintArray(array('downloads' => Sql_Get_Downloads_Count(true), 'users' => Sql_Get_Users_Count() ,'files' => Sql_Get_Files_Count(true) )) : '';
(isGet('getextensions') )         ? PrintArray(array('value' => extensionsStr(false))) : '';
(isGet('totalpages') && IsLogin ) ? PrintArray(array('value' => Sql_totalpages())) : '';
(isGet('getspace') && IsLogin )   ? PrintArray(array('free' => PercentageFree , 'used'=> PercentageUsed)) : '';
(isGet('top_downloads') )         ? PrintArray(Sql_Get_Top_Downloads()) : '';
/******************************************************/


if(isGet('stats'))
{
    
    $id                    = (int)$_GET['id'];
	$nb_total              = num_rows(Sql_query("SELECT 1 FROM `stats` WHERE `file_id` = '$id'")) ;
	$nb_country            = num_rows(Sql_query("SELECT distinct(`country_code`) FROM `stats` WHERE `file_id` = '$id'")); 
	$nb_browser            = num_rows(Sql_query("SELECT distinct(`browser`) FROM `stats` WHERE `file_id` = '$id'")) ;
	$nb_platform           = num_rows(Sql_query("SELECT distinct(`platform`) FROM `stats` WHERE `file_id` = '$id'")) ;
	$nb_referrer           = num_rows(Sql_query("SELECT distinct(`referrer`) FROM `stats` WHERE `file_id` = '$id' AND `referrer` <> ''")) ;//AND `referrer` <> ''
	$nb_dates              = num_rows(Sql_query("SELECT distinct(FROM_UNIXTIME(`date`,'%Y-%m-%d')) FROM `stats` WHERE `file_id` = '$id'"));
	
    $countries_totalpages  = ceil( $nb_country / rowsperpage); 
	$browsers_totalpages   = ceil( $nb_browser / rowsperpage); 
	$platforms_totalpages  = ceil( $nb_platform / rowsperpage); 
	$referrers_totalpages  = ceil( $nb_referrer / rowsperpage); 
	$dates_totalpages      = ceil( $nb_dates / rowsperpage); 
	
    $countries   = '';
	$browsers    = '';
	$platforms   = '';
	$referrers   = '';
	$dates       = '';
	/*-----------Charts---------*/
    $chart_dates_labels='';
	$chart_dates_data  = '';
	
    $chart_countries_labels ='';
    $chart_countries_data ='';
	
	$chart_browsers_labels ='';
    $chart_browsers_data ='';
	
	$chart_platforms_labels ='';
    $chart_platforms_data ='';
	
	$chart_referrers_labels ='';
    $chart_referrers_data ='';
	
	$currentpage = ($currentpage < 1) ?  1 : $currentpage;
	$offset = ($currentpage - 1) * rowsperpage;

    $result = Sql_query("SELECT distinct(`country_code`), count(`country_code`) as nb_country FROM `stats` WHERE `file_id` = '$id' GROUP BY `country_code` ORDER BY `nb_country` DESC LIMIT $offset, ".rowsperpage) ;  
	while ($data = mysqli_fetch_array($result)) 
	{	
        $chart_countries_labels.=GetCountryName($data['country_code']).',';
		$chart_countries_data.=$data['nb_country'].','; 
    	$countries.= '<tr><td><i class="famfamfam-flag-'.strtolower($data['country_code']).'"></i> '.GetCountryName($data['country_code']).'</td> <td><code>'.$data['nb_country'].'</code></td><td>'.percent($data['nb_country']/$nb_total).'</td></tr>';
    }
	
	$result = Sql_query("SELECT distinct(`browser`), count(`browser`) as `nb_browser` FROM `stats` WHERE `file_id` = '$id' GROUP BY `browser` ORDER BY `nb_browser` DESC LIMIT $offset, ".rowsperpage) ; 
	while ($data = mysqli_fetch_array($result)) 
	{
		$chart_browsers_labels.=$data['browser'].',';
		$chart_browsers_data.=$data['nb_browser'].','; 
		$browsers.= '<tr><td><i class="platforms platforms-'.strtolower($data['browser']).'"></i> '.$data['browser'].'</td> <td><code>'.$data['nb_browser'].'</code></td><td>'.percent($data['nb_browser']/$nb_total).'</td></tr>';
	}
    	
 
	$result = Sql_query("SELECT distinct(`platform`), count(`platform`) as `nb_platform` FROM `stats` WHERE `file_id` = '$id' GROUP BY `platform` ORDER BY `nb_platform` DESC LIMIT $offset, ".rowsperpage) ; 
	while ($data = mysqli_fetch_array($result)) 
	{
		$chart_platforms_labels.=$data['platform'].',';
		$chart_platforms_data.=$data['nb_platform'].','; 
		$platforms.= '<tr><td><i class="platforms platforms-'.strtolower($data['platform']).'"></i> '.$data['platform'].'</td> <td><code>'.$data['nb_platform'].'</code></td><td>'.percent($data['nb_platform']/$nb_total).'</td></tr>';
	}
    	
	
		$result = Sql_query("SELECT distinct(`referrer`), count(`referrer`) as `nb_referrer` FROM `stats` WHERE `file_id` = '$id' AND `referrer` <> '' GROUP BY `referrer` ORDER BY `nb_referrer` DESC LIMIT $offset, ".rowsperpage) ; 
	while ($data = mysqli_fetch_array($result)) if($data['referrer']!=='')
	{
		$chart_referrers_labels.=GetUrlHost($data['referrer']).',';
		$chart_referrers_data.=$data['nb_referrer'].','; 
		$referrers.= '<tr><td><a target="_blank" href="'.html_decoder($data['referrer']).'">'.html_decoder($data['referrer']).'</a></td> <td><code>'.$data['nb_referrer'].'</code></td><td>'.percent($data['nb_referrer']/$nb_referrer).'</td></tr>';
	}
    	
	
	
	   $result = Sql_query("SELECT distinct(FROM_UNIXTIME(`date`,'%Y-%m-%d')) as `_date_` , count(FROM_UNIXTIME(`date`,'%Y-%m-%d')) as `_count_` FROM `stats` WHERE `file_id` = '$id' GROUP BY `_date_` ORDER BY `_count_` DESC LIMIT $offset, ".rowsperpage);
	while ($data = mysqli_fetch_array($result))
	{
		$chart_dates_labels.=$data['_date_'].',';
		$chart_dates_data.=$data['_count_'].','; 
		$dates.='<tr><td>'.$data['_date_'].'</td> <td><code>'.$data['_count_'].'</code></td><td>'.percent($data['_count_']/$nb_total).'</td></tr>'; 
	}
	
	
 //'%Y-%m-%d %H:%i:%s'	
 //SELECT * FROM `stats` WHERE FROM_UNIXTIME(`date`) like '%2016-10-24 17%' 
 //SELECT `date` ,count(`date`) as `date_2` FROM `stats` WHERE FROM_UNIXTIME(`date`) like '%2016-10-24 17%' 
 //SELECT `date` ,count(`date`) as `ddd` ,(select `date` from `files` where `id` = '14') as `enddate` FROM `stats` WHERE FROM_UNIXTIME(`date`) like '%2016-10-24 17%' 
 //SELECT FROM_UNIXTIME(`date`,'%Y-%m-%d %H') ,count(`date`) as `ddd` ,(select `date` from `files` where `id` = '14') as `enddate` FROM `stats` WHERE FROM_UNIXTIME(`date`) like '%2016-10-24 17%' 
 
$data['platforms'] = $platforms;		
$data['browsers']  = $browsers;	
$data['countries'] = $countries;
$data['referrers'] = $referrers;
$data['dates']     = $dates;
/*------------------------------------------------------------*/
$data['chart_platforms_labels'] = $chart_platforms_labels;
$data['chart_platforms_data']   = $chart_platforms_data;
/*------------------------------------------------------------*/
$data['chart_dates_labels']     = $chart_dates_labels;
$data['chart_dates_data']       = $chart_dates_data;
/*------------------------------------------------------------*/
$data['chart_browsers_labels']  = $chart_browsers_labels;
$data['chart_browsers_data']    = $chart_browsers_data;
/*------------------------------------------------------------*/
$data['chart_countries_labels'] = $chart_countries_labels;
$data['chart_countries_data']   = $chart_countries_data;
/*------------------------------------------------------------*/
$data['chart_referrers_labels'] = $chart_referrers_labels;
$data['chart_referrers_data']   = $chart_referrers_data;
/*------------------------------------------------------------*/
$data['countries_totalpages'] = $countries_totalpages;
$data['browsers_totalpages']  = $browsers_totalpages;
$data['platforms_totalpages'] = $platforms_totalpages;
$data['referrers_totalpages'] = $referrers_totalpages;
$data['dates_totalpages']     = $dates_totalpages;
/*------------------------------------------------------------*/
$data['status'] = true;

mysqli_free_result($result);
mysqli_close($conn);
PrintArray($data);


}



if(isGet('uploadfile'))
{

//(isset($_FILES["uploadfile"]["size"]) && ($_FILES["uploadfile"]["size"]>MaxFileSize)) ? IePrintArray((array('success' => false, 'msg' => 'your file is too big!'  ,'footerInfo'=> '' ))) : '';

(!IsLogin && !ApiLogin  && authorized) ? IePrintArray(array('success' => false, 'msg' => $lang[98] ,'footerInfo'=> FooterInfo('..'.folderupload) )) : '' ; 
	//(!ApiLogin && authorized) ? IePrintArray(array('success' => false, 'msg' => $lang[98] ,'footerInfo'=> FooterInfo('..'.folderupload) )) : '' ; 

(!file_exists('..'.uploadDir )) ? @mkdir('..'.uploadDir , 0777, true) : '';
(function_exists('ini_set'))    ? @ini_set('max_execution_time', 0) : '';
/*
Copyright 2012-2016 LPology, LLC
*/		
$Upload          = new FileUpload('uploadfile');

$ext             = $Upload->getExtension(); // Get the extension of the uploaded file
$_UploadFileName = _Upload_name().$ext;
$extensions      = explode(",",extensions);
/*(isset($_FILES["uploadfile"]["name"])) ? protect(basename($_FILES["uploadfile"]["name"])) : '';*/
$orgfilename     = protect($Upload->getFileName()); 
$passwordfile    = (isPost('passwordfile')) ? protect($_POST['passwordfile']) : '';
$code            = (isPost('code')) ? protect($_POST['code']) : '' ;
$ispublic        = (isPost('ispublic') && (IsLogin||ApiLogin) ) ? (int)$_POST['ispublic'] : 1 ;

(defined('HashCode') && HashCode !== $code && !isGet('api') ) ? IePrintArray(array('success' => false, 'msg' => $lang[103].' / HashCode' ,'footerInfo'=> FooterInfo('..'.folderupload) )) : '' ;  
((IsLogin) && (UserSpaceLeft<=0))   ? IePrintArray(array('success' => false, 'msg' => $lang[173].' / '.$lang[117] ,'footerInfo'=> FooterInfo('..'.folderupload) )) : '' ;  


//if(Sql_file_exsist($_UploadFileName))
	if(file_exists('..'. uploadDir.'/'.$_UploadFileName))
	{
		sleep(1); // sleep for 1 second
		$_UploadFileName = _Upload_name().$ext;
	}
	
$Upload->Language    = $lang;
$Upload->sizeLimit   = MaxFileSize;
$Upload->newFileName = $_UploadFileName ; /*_Upload_name().$ext;*/

if($Upload->getFileSize()>=MaxFileSize) 
	IePrintArray(array('success' => false, 'msg' => $lang[110] .' : '.FileSizeConvert(MaxFileSize) ,'footerInfo'=> FooterInfo('..'.folderupload) )) ; 
 
$result = $Upload->handleUpload('..'.uploadDir, $extensions);


if (!$result) 
    IePrintArray(array('success' => false, 'msg' => $Upload->getErrorMsg() ,'footerInfo'=> FooterInfo('..'.folderupload) )) ;   
 else 
 {
	 $RandomString = GenerateRandomString(); 
	 $String       = GenerateRandomString(); 
	 $ThumbnailDir = (thumbnail) ? uploadDir.'/_thumbnail/'.get_thumbnail($Upload->getFileName()) : ''; 
	 $filename     = '..'.uploadDir.'/'.$Upload->getFileName();
	 $filesize     = $Upload->getFileSize() ; /*file_exists($filename) ? filesize($filename) : 0;*/
	 
	
	 
	if(thumbnail)
	{
		if (!file_exists('..'.uploadDir.'/_thumbnail')) 
		{
			@mkdir('..'.uploadDir.'/_thumbnail' , 0777, true);
			WriteHtaccessThumbnailFolder('..'.uploadDir.'/_thumbnail');
		}
	 
		 
	 $tg = new thumbnailGenerator;
	 $ThumbnailDir = ($tg->generate($filename, 100, 100, '..'.$ThumbnailDir)) ? $ThumbnailDir : '';
	
	} 
	 
     Sql_File_Insert($Upload->getFileName(),$filesize,$RandomString,$passwordfile,$orgfilename,$ispublic,FolderUploadId);
	 
	 $id  = Sql_Last_query_id(); 
	 
	 $_SESSION['settings']['files'][$id] = $String;	
	 
	 if(IsLogin)
	 {
		$_SESSION['login']['user_space_used'] = (int)$_SESSION['login']['user_space_used']+$filesize ;
		$_SESSION['login']['user_space_left'] = user_space_max-(int)$_SESSION['login']['user_space_used']; 
	 }
	 
	 (function_exists('ini_set') && function_exists('ini_get')) ? @ini_set('max_execution_time', @ini_get('max_execution_time')) : '';

     IePrintArray(array('success' => true,
	                  'FileName' => $Upload->getFileName() ,
					  'originalFilename'=> $orgfilename ,
					  'Icon' => iconClass($Upload->getFileName()) ,
					  'Size' => $filesize ,
					  'SavedFile' => $Upload->getSavedFile() ,
					  'Extension' => $Upload->getExtension() ,
					  'DeleteId' => $RandomString ,
					  'DownloadId' => $String ,
					  'ID'=> $id ,
					  'cryptID'=> Encrypt($id ),
					  'UploadDir'=> uploadDir ,
					  'ThumbnailDir'=> $ThumbnailDir , 
					  'IsLogin'=> (IsLogin || ApiLogin) ,  					  
					  'footerInfo'=> FooterInfo('..'.folderupload) ) ) ;
				
 }
}

/*----------------------------------------------------------*/

if(isGet('ispublic'))
{
	
$file_id = (int)$_GET['ispublic'];	
$info = Sql_Get_info($file_id);
$ispublic = !$info['public'];
Sql_query("UPDATE `files` SET `isPublic` = '$ispublic' WHERE `id` = '$file_id' AND `userId` = '".UserID."'");  
(!affected_rows()) ? PrintArray(array('icon' => '<i class="glyphicon glyphicon-alert text-muted"></i>')) : '';
PrintArray(array('icon' => glyphiconIsPublic($ispublic) ));
}


if(isGet('deletecomment'))
{
	
$id = (int)$_GET['deletecomment'];	
(IsAdmin) ? Sql_query( "DELETE FROM `comments`  WHERE `id`= '$id'" ) : Sql_query( "DELETE FROM `comments`  WHERE `id`= '$id' AND `user_id` = '".UserID."'" ) ;	
PrintArray(array('icon' => glyphiconOk(affected_rows()) ));
}


if(isGet('report'))
{
	
$file_id = (int)$_GET['report'];	
$reason_id = (int)$_GET['reason'];	

$info = Sql_Get_info($file_id);

(!$info['status']) ? PrintArray(array('success_msg' => $lang[46])) : '';

if(num_rows(Sql_query("SELECT 1 FROM `reports` WHERE `file_id`='$file_id' and `user_id`='".UserID."'"))==0) 
{
	$ip= iplong();
	$date = timestamp();
	Sql_query("INSERT INTO `reports` (`user_id`, `file_id`, `date`, `ip` , `reason` , `status` ) VALUES ( '".UserID."', '$file_id', '$date', '$ip' , '$reason_id' , '0');");
	PrintArray(array('success_msg' => $lang[86]));
} else  PrintArray(array('success_msg' => $lang[85]));
	

	
}
/*-----------------------------------------------------------------*/
if(isGet('confirm'))
{
	
$file_id = (int)$_GET['confirm'];	
$password= protect($_GET['password']);
	
$info = Sql_Get_info($file_id);
if($info['password']==$password)
{
	$data['success_msg'] = $lang[104];
	$data['status'] = true;
	$_SESSION['settings']['passwordfiles'][$file_id] = $password;
} else
{
	$data['success_msg'] = $lang[14];
	$data['status'] = false;
}

 
	
PrintArray($data);
	
}
/*-----------------------------------------------------------------*/
if(isGet('contact'))
{
	
$username = protect($_POST['name']);
$message = $_POST['message'];
$email    = protect($_POST['email']);
if(EnableCaptcha && $_POST['captcha']!==$_SESSION['settings']['code']){$data['error_msg']=error($lang[90]);}
elseif(empty($username) or empty($message) or empty($email)) { $data['error_msg'] = error($lang[91]); }
elseif(!isValidUsername($username)) { $data['error_msg'] = error($lang[92]); }
elseif(!isValidEmail($email)) { $data['error_msg'] = error($lang[93]); }
else {

$subject = $username.'- ( '.SiteName().' )';
$headers = "From: $email \r\n"; 

// Always set content-type when sending HTML email
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
$headers .= "Reply-To: $email \r\n" .
$headers .= 'X-Mailer: PHP/' . phpversion();

@mail(sitemail,$subject,$message,$headers);
	$data['success_msg'] = success($lang[89]);
	
}

PrintArray($data);
}

/*-----------------------------------------------------------------*/


if(isGet('forgot'))
{

$email = protect($_POST['email']);

$sql = Sql_query("SELECT 1 FROM `users` WHERE `email`='$email'");
if(EnableCaptcha && $_POST['captcha']!==$_SESSION['settings']['code']){$data['error_msg']=error($lang[90]);}
elseif(empty($email)) { $data['error_msg'] = error($lang[91]); }
elseif(!isValidEmail($email)) { $data['error_msg'] = error($lang[93]); }
elseif(num_rows($sql)==0) {$data['error_msg'] = error($lang[130]);}
else
{
$time    = 	timestamp();
$ip      = 	iplong();
Sql_query("UPDATE `users` SET `last_visit` = '$time' , `last_ip` ='$ip' WHERE `email`='$email';");	
$code    =	Encrypt($time);
$message = siteurl.'/index.php?reset='.$code;
$subject = $lang[41].' - ( '.SiteName().' )';;
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
$headers .= 'Reply-To: '.sitemail . "\r\n" .
$headers .= 'X-Mailer: PHP/' . phpversion();

@mail($email,$subject,$message,$headers);	
	$data['success_msg'] = success($lang[89]);
		
}

PrintArray($data);

}


if(isGet('login'))
{

$username = protect($_POST['Email']);
$password = protect($_POST['Password']);
$md5pass  = md5($password);

$sql = Sql_query("SELECT * FROM `users` WHERE `username`='$username' and `password`='$md5pass'");
if(EnableCaptcha && $_POST['captcha']!==$_SESSION['settings']['code']){ $data['error_msg'] = error($lang[90]);}
elseif(empty($username) or empty($password)) { $data['error_msg'] = error($lang[91]); }
elseif(num_rows($sql)>0) {
	$row = mysqli_fetch_array($sql);
	if($row['status'] == 2) {
		$data['error_msg'] = error($lang[94]);
	} else {
		$_SESSION['login']['username']   = $row['username'];
		//$_SESSION['login']['password']   = ($row['password']);
		$_SESSION['login']['user_id']    = $row['id'];
		$_SESSION['login']['plan_id']    = $row['plan_id'];
		$_SESSION['login']['status']     = true;
		$_SESSION['login']['user_level'] = $row['level']; //(bool)
		$_SESSION['login']['user_status']= $row['status'];
		$_SESSION['login']['user_email'] = $row['email'];
		
		$_SESSION['login']['register_date']   = $row['register_date'];
		$_SESSION['login']['user_space_used'] = (int)Get_user_space_used($row['id']) ;
		$_SESSION['login']['user_space_left'] = user_space_max-(int)$_SESSION['login']['user_space_used'];
		if(enable_userfolder)
		{
			$_SESSION['login']['folder_id'] = (int)Get_folderId_By_UserId($row['id']);
			$_SESSION['login']['folder_name'] = Get_folderName_By_UserId($row['id']);
		}
		else
		{
			$_SESSION['login']['folder_id'] = (int)Get_folderId_By_UserId(0);
			$_SESSION['login']['folder_name'] = folderupload;
		}
		
		Sql_query("UPDATE `users` SET `last_visit` = '".timestamp()."', `last_ip` ='".iplong()."' WHERE `id` ='".$row['id']."';");	
		if($_SESSION['login']['user_level']==1)
		$data['admin_msg']      = $_SESSION['login']['user_level'];
		$data['success_msg'] = success($lang[88]);
	}
} else {
	$data['error_msg'] = error($lang[95]);
}

PrintArray($data);

}

/*-----------------------------------------------------------------*/

if(isGet('register'))
{
	
$username = protect($_POST['Username']);
$password = protect($_POST['Password']);
$md5pass  = md5($password);
$email    = protect($_POST['Email']);

$check_usern = Sql_query("SELECT * FROM `users` WHERE `username`='$username'");
$check_email = Sql_query("SELECT * FROM `users` WHERE `email`='$email'");
if(EnableCaptcha && $_POST['captcha']!==$_SESSION['settings']['code']){$data['error_msg']=error($lang[90]);}
elseif(empty($username) or empty($password) or empty($email)) { $data['error_msg'] = error($lang[91]); }
elseif(num_rows($check_usern)>0) { $data['error_msg'] = error($lang[96]); }
elseif(!isValidUsername($username)) { $data['error_msg'] = error($lang[92]); }
elseif(num_rows($check_email)>0) { $data['error_msg'] = error($lang[97]); }
elseif(!isValidEmail($email)) { $data['error_msg'] = error($lang[93]); }
else { /*strtotime(date('Y-m-d H:i:s')*/
	$insert_user   = Sql_query("INSERT INTO `users` (`username`, `password`, `email`, `level`, `last_visit`,`register_date`, `last_ip`) VALUES ( '$username', '$md5pass', '$email', '0', '".timestamp()."','".timestamp()."','".iplong()."');");
	$insert_id     = Sql_Last_query_id();
	$insert_dir    = folderupload .'/'.$username;
	$insert_folder = Sql_query("INSERT INTO `folders` (`userId`, `folderName`, `isPublic`, `accessPassword`, `date_added`) VALUES ( '$insert_id', '$insert_dir', '1', '', '".timestamp()."');");
	if($insert_user && $insert_folder)
	{
	$data['success_msg'] = success($lang[87]);
	$_SESSION['login']['username']   = $username;
	//$_SESSION['login']['password']   = $password;
	$_SESSION['login']['user_id']    = $insert_id;
	$_SESSION['login']['status']     = true;
	$_SESSION['login']['user_level'] = '0'; 
	$_SESSION['login']['user_status']= '1';
	$_SESSION['login']['plan_id']    = '0';
	$_SESSION['login']['user_email'] = $email;
	$_SESSION['login']['user_space_used'] = 0 ;
	$_SESSION['login']['user_space_left'] = user_space_max;
	if(enable_userfolder)
	{
		$_SESSION['login']['folder_id'] = (int) Get_folderId_By_UserId($insert_id);
		$_SESSION['login']['folder_name'] = $insert_dir ;
	}
	else
	{
		$_SESSION['login']['folder_id'] = (int)Get_folderId_By_UserId(0);
		$_SESSION['login']['folder_name'] = folderupload;
	}
	
	if(enable_userfolder)
		if (!file_exists('..'.$insert_dir)) 
			@mkdir('..'.$insert_dir, 0777, true);

	}	
}

PrintArray($data);
}


/*-----------------------------------------------------------------*/

if (isGet('comments')){
	
$file_id = protect(Decrypt($_GET['comments']));
// find out total pages
$total = num_rows(Sql_query("SELECT * FROM `comments` WHERE `status` = '1' AND `file_id`='$file_id'"));
$totalpages = ceil( $total / rowsperpage);
$count = 0;
$currentpage = ($currentpage > $totalpages) ? $totalpages : $currentpage;
$currentpage = ($currentpage < 1) ? 1 : $currentpage;
$totalpages  = ($totalpages < 1) ? 1 :$totalpages;

$offset = ($currentpage - 1) * rowsperpage;

$html='';
$sql="SELECT * FROM `comments` WHERE `status` = '1' AND `file_id`='$file_id' ORDER BY `id` DESC LIMIT $offset, ".rowsperpage;

if ($result=Sql_query($sql))
	$num_rows =	num_rows($result);
  while($row = mysqli_fetch_assoc($result))
  { 

      $count++;
      $date   = time_elapsed_string(date('Y-m-d H:i:s',$row["date"])) ;
		  $html.= 
		       '  <div class="media">
                        <a class="pull-'.directionDiv2(true).'" href="#">
                            <i class="btn btn-default btn-circle btn-lg glyphicon glyphicon-user"></i>
                        </a>
                        <div class="media-body">
                            <div class="pull-'.directionDiv2().' small">'.$date.'</div>
                            <strong class="media-heading">'.Sql_Get_Username($row["user_id"]).'</strong>
                            <p>'.$row["comment"].'</p>';
		  if(IsAdmin)
		  $html.= 			'<a href="javascript:void(0)" onclick="deleteComment('.$row["id"].')"><code><i class="glyphicon glyphicon-remove"></i> '.$lang[32].'</code></a>';
							
          $html.=         '</div>
                    </div>';
  }
($total==0) ? $data['error_msg'] = $lang[111] : $data['success_msg'] = $html ;
$data['success_totalpages'] = $totalpages;
mysqli_free_result($result);
mysqli_close($conn);
PrintArray($data);

}

/*-----------------------------------------------------------------*/

if(!ApiLogin)
{	
(!isset($_SESSION['login'])) ? PrintArray(array('error_msg' => '<'.$lang[98].'>')) : '' ;
(!IsLogin)                   ? PrintArray(array('error_msg' => $lang[98])) : '';
}

/*-----------------------------------------------------------------*/
if (isGet('addcomment')){
	if(EnableCaptcha && $_POST['captcha']!==$_SESSION['settings']['code']){$data['error_msg']=error($lang[90]);}
	else
	{
	   $file_id = protect(Decrypt($_POST['file_id']));
	   $comment = protect($_POST['comment']);
	   Sql_query("INSERT INTO `comments` (`file_id`, `user_id`, `date`, `status`, `comment`) VALUES ('$file_id', '".UserID."', '".timestamp()."', '1', '$comment');");	
	   $data['success_msg']=success($lang[178]);
	}
	
	PrintArray($data);
}
/*-----------------------------------------------------------------*/

if (isGet('files')){
	
// find out total pages
$total = Sql_Get_Files_Count();
$totalpages = ceil( $total / rowsperpage);
$count = 0;
$currentpage = ($currentpage > $totalpages) ? $totalpages : $currentpage;
$currentpage = ($currentpage < 1) ? 1 : $currentpage;
$totalpages  = ($totalpages < 1) ? 1 :$totalpages;

$offset = ($currentpage - 1) * rowsperpage;

$html='';
$sql="SELECT * FROM `files` WHERE `userId`='".UserID."' ORDER BY `id` DESC LIMIT $offset, ".rowsperpage;

if ($result=Sql_query($sql))
	$num_rows =	num_rows($result);
  while($row = mysqli_fetch_assoc($result))
  { 

      $count++;
      $_originalFilename = "'".$row["originalFilename"]."'";
	  $_Filename         = "'".$row["filename"]."'";
	  $_file_id          = $row["id"];
	  $_crypt_id         = "'".Encrypt($_file_id)."'";
	  $_deleteHash       = "'".$row["deleteHash"]."'";
	  $folder            = Sql_Get_folder($row['folderId']);
	  
	  $_thumbnaildir     = (ext_is_image('..'.$folder.'/'.$row["filename"]) && file_exists('..'.$folder.'/_thumbnail/'.get_thumbnail($row["filename"]))) ? ($folder.'/_thumbnail/'.get_thumbnail($row["filename"])):'';
	   
	  $css    = (empty($row["accessPassword"]))                          ? ' text-muted' : '' ;
	  $dcss   = ($row["totalDownload"]==0)                               ? ' text-muted' : '' ;
	  $onclick= (($row["totalDownload"]==0) && (IsAdmin || statistics))  ? '' : 'StatsFile('.$_file_id.','.$_originalFilename.')';
	  $size   = FileSizeConvert($row["fileSize"]);
      $date   = (date('Y-m-d H:i:s',$row["uploadedDate"])) ;

		  $html.= (file_exists('..'.$folder.'/'.$row["filename"])) ? '<tr id="file_'.$_file_id.'">' : '<tr id="file_'.$_file_id.'" class="danger">';
/*title="'.$row["originalFilename"].'"'.icon($row["filename"]).' */
		  $html.= 
		       '<td><input value="'.$_file_id.'" id="checkbox_'.$_file_id.'" type="checkbox"  name="files[]" onclick="calcItems('.$_file_id.')" class="checkbox" /></td>
		        <td><input style="display:none" value="'.$row["deleteHash"].'" type="checkbox" id="deletehash_'.$_file_id.'" class="deletehash hidden" name="deletehash[]"/>
				     <a href="javascript:void(0)" rel="tooltip" id="fileInfo_'.$count.'"
					 data-numrows="'.$num_rows.'" 
					 data-fileid="'.$_file_id.'" 
					 data-date="'.time_elapsed_string($date).'" 
					 data-size="'.$size.'" 
					 data-folder="'.$folder.'" 
					 data-filename="'.$row["filename"].'" 
					 data-orgfilename="'.$row["originalFilename"].'" 
					 data-downurl="/?download='.Encrypt($_file_id).'"
					 data-downtotal="'.$row["totalDownload"].'" 
					 data-deletehash="'.$_deleteHash.'" 
					 data-cryptid="'.Encrypt($_file_id).'" 
					 data-thumbnaildir="'. $_thumbnaildir .'"
					 href="javascript:void(0)" onclick="FileInfoModal('.$count.')">'.$row["filename"].'</a>
				</td>
				<td class="hidden-xs">'.$size.'</td>
				<td class="hidden-xs"><span class="badge">'.$row["totalDownload"].'</span></td>
				<td class="hidden-xs"><span class="badge">'.Sql_Get_Comments_Count($_file_id).'</span></td>
				<td class="hidden-xs">'.$date.'</td>
				<td class="small">
				 <a href="javascript:void(0)" rel="tooltip" title="'.$lang[32].'" onclick="deleteFile('.$_file_id.','.$_deleteHash.','.$currentpage.','.$_Filename.')"><i class="glyphicon glyphicon-trash"></i></a> 
				 <a href="javascript:void(0)" rel="tooltip" title="'.$lang[37].'" onclick="passwordFile('.$_file_id.','."'".$row["accessPassword"]."'".','.$currentpage.')"><span id="isPassword_'.$_file_id.'"><i class="glyphicon glyphicon-lock'.$css.'"></i></span></a>
				 <a href="javascript:void(0)" rel="tooltip" title="'.$lang[28].'" onclick="'.$onclick.'"><i class="glyphicon glyphicon-stats'.$dcss.'"></i></a>
				 <a href="javascript:void(0)" rel="tooltip" title="'.$lang[176].'/'.$lang[177].'" onclick="isPublicFile('.$_file_id.')"><span id="isPublic_'.$_file_id.'" >'.glyphiconIsPublic($row["isPublic"]).'</span></a>
				</td>
				</tr>';
  }
($total==0) ? $data['error_msg'] = $lang[111] : $data['success_msg'] = $html ;
$data['success_totalpages'] = $totalpages;
mysqli_free_result($result);
mysqli_close($conn);
PrintArray($data);

}
/*------------------------------------------------------------------*/
if(isGet('filepass'))
{
 
	$password = protect($_GET['filepass']);
	$id       = (int)$_GET['id'];
	Sql_query("UPDATE `files` SET `accessPassword` = '$password' WHERE `id` = '$id' AND `userId` = '".UserID."'");
	(!affected_rows()) ? PrintArray(array('icon' => '<i class="glyphicon glyphicon-alert text-muted"></i>')) : '';
	
	$css = empty($password) ? '<i class="glyphicon glyphicon-lock text-muted"></i>' : '<i class="glyphicon glyphicon-lock"></i>';
	PrintArray(array('icon' => $css ));
}
/*-----------------------------------------------------------------*/
if(isGet('delete'))
{
	 
	$info = Sql_Get_info($_GET['id'],'..');
    if( $info['status'] && $info['deleteHash'] == $_GET['delete'] )
	{
	(file_exists('..'. $info["fullpath"] ))	     ? @unlink('..'. $info["fullpath"] ) : '';
	(file_exists('..'. $info["thumbnail_dir"] )) ? @unlink('..'. $info["thumbnail_dir"]  ) : '';
	
	Sql_Delete_File($_GET['id']);
	Sql_Delete_Stat_File_Id($_GET['id']);
	Sql_Delete_Report_File_Id($_GET['id']);
	Sql_Delete_Comment_Id($_GET['id']);
	IsLogin ? $_SESSION['login']['user_space_used'] = (int)Get_user_space_used() : '';
	IsLogin ? $_SESSION['login']['user_space_left'] = user_space_max-(int)$_SESSION['login']['user_space_used'] : '';
	PrintArray(array( 'status'=> true , 'success_msg' => $lang[178]));
	} else PrintArray(array( 'status'=> false ,'success_msg' => $lang[179]));
	
}


if(isGet('delete_selected'))
{
	
	
	
	if(isPost('files'))
	{
	 $result = array();
     foreach (array_combine($_POST['files'], $_POST['deletehash'] ) as $id => $deletehash ) {
		    $id         =(int)$id;
		    $deletehash = protect($deletehash);
			
		    $info = Sql_Get_info($id,'..');

			if((isset($deletehash)) && ($info['deleteHash'] !== $deletehash)) continue ;
			if(!$info["status"]) continue ;	
			(file_exists('..'. $info["fullpath"] ))	     ? @unlink('..'. $info["fullpath"] ) : '';
	        (file_exists('..'. $info["thumbnail_dir"] )) ? @unlink('..'. $info["thumbnail_dir"]  ) : '';
			if(Sql_Delete_File($id))
				if(Sql_Delete_Report_File_Id($id))
					if(Sql_Delete_Stat_File_Id($id))
						if(Sql_Delete_Comment_Id($id))
							$result[]=  $id ;
			}
	PrintArray(array('success_msg' => $result ,'success_totalpages' => Sql_totalpages() ));	
	}
}
/*-----------------------------------------------------------------*/
if(isGet('logout')){
	
if(isset($_SESSION['login'])) //['status']
{
//@session_destroy();	
unset($_SESSION['login']);
PrintArray(array('success_msg' => $lang[104]));
} else PrintArray(array('success_msg' => $lang[14]));
}

if(isGet('edituser')){
	

$password = protect($_POST['password']);
$md5pass  = md5($password);
$email    = protect($_POST['email']);
$id       = (int) UserID ;

$check_email = Sql_query("SELECT * FROM `users` WHERE `email`='$email' AND `id` != '$id'");

if(EnableCaptcha && $_POST['captcha']!==$_SESSION['settings']['code']){$data['error_msg']=error($lang[90]);}
elseif(empty($password) or empty($email) or ($id < 1) ) { $data['error_msg'] = error($lang[91]); }
elseif(num_rows($check_email)>0) { $data['error_msg'] = error($lang[97]); }
elseif(!isValidEmail($email)) { $data['error_msg'] = error($lang[93]); }
elseif(isset($_SESSION['login'])) //['status']
{
Sql_query("UPDATE `users` SET `password` = '$md5pass' , `email` = '$email' WHERE `id` ='$id';");
$data['success_msg'] = success($lang[178]);
unset($_SESSION['login']);		
} else $data['error_msg'] = error($lang[179]);	
	


PrintArray($data);
} 



?>