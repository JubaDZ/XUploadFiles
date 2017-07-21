<?php
$supportedLangs  = array('ar','en','') ;

define('sitename','File Sharing and Storage'); // موقعي للرفع
define('rtlsitename','مشاركة وتخزين الملفات');
define('sitemail','');
define('time_zone','Africa/Algiers');
define('Interval','0');
define('siteclose','0');
define('language','');
define('closemsg','Closed for maintenance'); //الموقع مغلق للصيانة
define('register','1');
define('enable_userfolder','0');
define('folderupload','/uploads');
define('prefixname','file_');
define('maxsize','20M');
define('extensions','gif,jpg,jpeg,png,zip,rar,pdf,doc,docx,flv,3gp,wmv,mp4,mp3');
define('rowsperpage','10');
define('style','styles.css');	
define('scriptversion','0.9');	
define('authorized','0');	
define('terms','');	
define('privacy','');
define('directdownload','0');
define('statistics','1');
define('userspacemax','500M');
define('speed','0');
define('thumbnail','1');
define('days_older','30');
define('maxUploads','1');
define('multiple','1');
define('deletelink','1');
define('EnableComments','1');
define('EnableCaptcha','0');
define('animated','1');

//define('dbprefix','db_');
(!defined('dbhost')) ? define('dbhost','localhost'): '';
(!defined('dbuser')) ? define('dbuser','root'): '';
(!defined('dbpass')) ? define('dbpass',''): ''; 
(!defined('dbname')) ? define('dbname','db_uploads'): ''; 

define('keywords','online storage,free storage,cloud Storage,collaboration,backup file Sharing,share Files,photo backup,photo sharing,ftp replacement,cross platform,remote access,mobile access,send large files,recover files,file versioning');	
define('description','free service that lets you put all your photos, documents, music, and video in a single place so you can access them anywhere and share them everywhere.');	
?>