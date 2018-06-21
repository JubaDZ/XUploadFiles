<?php
require_once ('../includes/config.php');	
require_once ('../includes/session.php');	
require_once ('../includes/functions.php');
require_once ('../includes/connect.php');
require_once ('../includes/language/'.LANG_FILE);
require_once ('../includes/csscolorgenerator.php');
(!defined('Extensions_Str')) ? define('Extensions_Str' , extensionsStr() ) : '' ;
(!defined('footerTxt'))      ? define('footerTxt',FooterInfo('.'.folderupload)) : '' ;
header("Content-type: text/javascript; charset: UTF-8");
echo "
var IsLogin     = Boolean('".(bool)IsLogin."'),
    IsAdmin     = Boolean('".(bool)IsAdmin."'),
    IsClose     = Boolean('".(bool)(siteclose && !isGet('login'))."'),
	IsRtL       = Boolean('".(bool)IsRtL()."'),
	IsDirect    = Boolean('".(bool)directdownload."'),
	IsDeleteLink= Boolean('".(bool)deletelink."'),
	IsThumbnail = Boolean('".(bool)thumbnail."'),
	IsAnimated  = Boolean('".(bool)animated."'),
	IsFooterInfo= Boolean('".(bool)FooterInfo."'),
	IsMultiple  = Boolean('".(bool)multiple."'),
	IsGetEmpty  = Boolean('".(bool)GetIsEmpty."'),
	IsCaptcha   = Boolean('".(bool)EnableCaptcha."'),
	DirectoryChanged  = Boolean('".(bool)DirectoryChanged."'),
    UpdateBrowser  = Boolean('".(bool)UpdateBrowser."'),
	IsGetFiles     = Boolean('".(bool)(isGet('files'))."'),
	IsGetProfile   = Boolean('".(bool)(isGet('profile'))."'),
	IsGetDownload  = Boolean('".(bool)(isGet('download'))."'),
	IsGetRegister  = Boolean('".(bool)(isGet('register'))."'),
	IsGetAbout     = Boolean('".(bool)(isGet('about'))."'),
	IsGetAuth      = Boolean('".(bool)(isGet('authorized'))."'),
	IsGetLogin     = Boolean('".(bool)(isGet('login'))."'),
	IsGetForgot    = Boolean('".(bool)(isGet('forgot'))."'),
	IsGetContact   = Boolean('".(bool)(isGet('contact'))."'),
	extensions_str = '".(defined('Extensions_Str') ? Extensions_Str : '')."',

	
	filetypes   = [ "."'".implode(explode(",",extensions),"','")."'"."],   
    configSize  = parseInt('".(MaxFileSize /1024)."'),
    TimeLoading = parseInt('".Interval."'),
	maxUploads  = parseInt('".maxUploads."'),
	directionDiv= '".directionDiv2()."',
	DateLbl     = '".$lang[84]."',
	siteurl     = '".str_replace("/modals","",SERVER_HOST)."',
	_path_      = '".siteurl."',
	SELF        = '".str_replace("modals/jsvariables.php","index.php",SELF)."',
	QUERY       = '".QUERY."',
	HashCode    = '".HashCode."',
	Language    = '".InterfaceLanguage."',
	Loading     = '".$lang[45]."',
	confirmMsg  = '".$lang[154]."',
	ErrorMsg    = '".$lang[14]."',
	PleaseWait  = '".$lang[102]."',
	ErrorSending= '".$lang[103]."',
	UploadingMsg= '".$lang[11]." ..',
	ChooseOMsg  = '".$lang[13]."',
	DragMsg     = '".$lang[7]."',
	DownloadWait= '".$lang[76]." <code id=".'"'.'time'.'"'.">5</code> ".$lang[77]."',
    uploadDir   = '".uploadDir.'/'."',
	ErrorHMsg   = '".$lang[17]."',
	UnableMsg   = '".$lang[15]."',
	UploadedMsg = '".$lang[16]."',
	ExtErrMsg   = '".$lang[120]."',
	FilesMsg    = '".$lang[109]."',
	ErrorSzMsg  = '".$lang[110]."', 
	ErrorAborted= '".$lang[233]."', 
	ExtensionsSt= '".extensions ."',
	FooterTxt   = '".footerTxt ."',
	UrlMsg      = '".$lang[18]."', 
	TitleClsMsg = '".$lang[64]."', 	
	UrlDeltMsg  = '".$lang[26]."', 
	UrlViewMsg  = '".$lang[164]."', 
	UrlthumMsg  = '".$lang[172]."', 
	DownLoadMsg = '".$lang[184]."', 
	ActionLabel = '".$lang[43]."',
	CopyLabel   = '".$lang[146]."', 
	UrlDrktMsg  = '".$lang[51]."',
	BrowserUpd  = '".$lang[163]."',
	UrlChanged  = '".$lang[195]."',
	RefLabel    = '".$lang[161]."',
	PassLabel   = '".$lang[37]."',
	queueLabel  = '".$lang[180]."',
	deleteLabel = '".$lang[32]."',
	Numberlbl   = '".$lang[157]."',
	_Yes        = '".$lang[104]."',
	_No         = '".$lang[156]."',
	PublicLbl   = '".$lang[176]."',
	PrivateLbl  = '".$lang[177]."',
	LblSuccessDeleted = '".$lang[197]."',
	WellColor   = '".(defined('WellColor') ? WellColor : 'ffffff')."',
	MainColor   = '".MainColor."',
    _maxVisible = 10,	
	FilesTotal  = 0,
	LoadJsCheckbox = false,
	myChart     = null;
	
if (IsLogin) { 		
var currentpage = parseInt('".$currentpage."') ,
    totalpages  = parseInt('".$totalpages."') ,
	rowsperpage = parseInt('".rowsperpage."') ; 
} 
";
?>
