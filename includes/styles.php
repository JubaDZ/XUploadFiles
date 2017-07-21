<?php
require_once ('config.php');
//require_once ('session.php');
define('PlanId',0 );
define('UserID',0 );
require_once ('functions.php');
$conn=mysqliconnect();
// Change character set to utf8
//$conn ? mysqli_set_charset($conn,"utf8") : '';
/*
Sql_query("SET NAMES 'utf8'");
Sql_query("SET CHARACTER SET utf8");*/
Loadconfig();
require_once ('csscolorgenerator.php');
//require_once ('connect.php');
(!defined('IsAdminPage')) ? define('IsAdminPage',false) : '';
header("Content-type: text/css; charset: UTF-8");
echo'
.progress-bar-success{background-color: '.PanelColor.';border-color: #d4dae8;}
.modal-header,.footer .text-muted {color: #fff;}
.btn-primary,.btn-primary:focus,.btn-primary.focus,.btn-primary:hover,.btn-primary:active,.btn-primary.active,.btn-primary:active:hover,.btn-primary.active:hover {color: #fff;background-color: '.PanelColor.';border-color: '.PanelColor.';}
.btn-primary.disabled:hover,.btn-primary[disabled]:hover,fieldset[disabled] .btn-primary:hover,.btn-primary.disabled:focus,.btn-primary[disabled]:focus,fieldset[disabled] .btn-primary:focus,.btn-primary.disabled.focus,.btn-primary[disabled].focus,fieldset[disabled] .btn-primary.focus {background-color: '.PanelColor.';border-color: '.PanelColor.';}
.footer,.sidenav,.label-info,.modal-header {background-color: '.PanelColor.';border-color: '.PanelColor.';	}
.upload-drop-zone.drop {border: 4px solid '.PanelColor.';}
.pagination li.active a ,.pagination li.active a:hover,.pagination li.active a:focus{background-color: '.PanelColor.';border-color: '.PanelColor.';}
.uploadIcon,.pagination li a{color: '.PanelColor.';	}
body {background-color:'.BodyColor.';}
/*body {background-image: url("../assets/css/images/wood.jpg") no-repeat right top;}*/
.se-pre-con {background-color:'.BodyColor.'!important;}
.sidenav .active,.sidenav a:hover,.sidenav a:active, .offcanvas a:focus{background-color: '.BodyColor.';border-color: '.PanelColor.';}
.sidenav a:focus{/*border-color: '.PanelColor.';background-color: '.BodyColor.';*/}
.sidenav .closebtn:hover {background-color: '.PanelColor.';border-color: '.PanelColor.';}
#extensions_mobile,#extensions_not_mobile{word-wrap: break-word;white-space: normal;}
code { color: '.CodeColor.';}
.progress{/*background-color: '.BodyColor.';	*/}
.list-group-item-danger,.alert-danger,.list-group-item-success ,.alert-info, .alert-success {background-color: #fff;}
#msgBox .list-group-item-danger,#msgBox .alert-danger,#msgBox .list-group-item-success ,#msgBox .alert-info, #msgBox .alert-success {background-color: #F2F2F2;}
.modal-body{text-decoration: none; }
.sidenav .closebtn:hover {background: '.PanelColor.';color:'.BodyColor.';}
div.background{background-color:'.BodyColor.';}
.modal-header {border-bottom: 3px solid '.CodeColor.';}
.next_previous.left {border-left: 3px solid '.CodeColor.' !important;}
.next_previous.right {border-right: 3px solid '.CodeColor.' !important;}
.ribbon.orange { background: '.CodeColor.';border-left: 5px solid '.CodeColor.';}
.ribbon.orange:before {border-top: 27px solid '.CodeColor.';}
.ribbon.orange:after { border-bottom: 27px solid '.CodeColor.';}

.ribbon.dark { background: '.PanelColor.';border-left: 5px solid '.PanelColor.';}
.ribbon.dark:before {border-top: 27px solid '.PanelColor.';}
.ribbon.dark:after { border-bottom: 27px solid '.PanelColor.';}

.text-color {color: '.BodyColor.';}
.btn-twitter,.btn-facebook ,.btn-gplus {color: '.CodeColor.';background-color: '.BodyColor.';border-color: '.BodyColor.';}
.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover{background-color: '.PanelColor.';border-color: '.PanelColor.';}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {background-color: #'.WellColor.';}
.well{background-color: #'.WellColor.';}
.dropdown-menu > li > a:hover{background: '.PanelColor.';color:'.BodyColor.';}
.upload-drop-zone {border: 4px dashed '.PanelColor.';}
.colorIcon{color:'.PanelColor.'}
.corneRribbon-inner{background-color: '.PanelColor.';}
/*.corneRribbon-inner:before,.corneRribbon-inner:after{border-color: #'.PanelColorBorder.';}*/
.box > .icon > .image {background: '.PanelColor.';}
a hr {border-top: 1px solid'.CodeColor.';}
.cpanelBtn{background-color: #'.PanelColorBorder.';border-color: #'.PanelColorBorder.';}
#file-count,#user-count,#download-count,.cpanelIcon,.modal-header a{color: '.CodeColor.';}
#plans .panel.panel-success>.panel-heading {color: #fff;background-color: '.PanelColor.';border-color: '.PanelColor.';}
#plans .panel.panel-success {border-color: '.PanelColor.';}
#plans .panel.panel-info>.panel-heading {color: #fff;background-color: '.CodeColor.';border-color: '.CodeColor.';}
#plans .panel.panel-info {border-color: '.CodeColor.';}
#plans .panel.panel-warning>.panel-heading {color: #fff;background-color: '.BodyColor.';border-color: '.BodyColor.';}
#plans .panel.panel-warning {border-color: '.BodyColor.';}
';

echo 
"\r\n";

echo IsRtL() ?  '.ribbon.dark{border-right: 5px solid #'.PanelColorBorder.'!important;}' : '.ribbon.dark{border-left: 5px solid #'.PanelColorBorder.'!important;}';
echo IsRtL() ?  '#extensions_mobile {border-right: 3px solid '.PanelColor.' !important;}':'#extensions_mobile {border-left: 3px solid '.PanelColor.' !important;}';
echo IsRtL() ?  '#total_stats,#comments,#logo,#poster,#upresult,#main,#sidenav_admin,.img-thumbnail,.input-group .form-control,.note-editor.note-frame,.footer,.panel.panel-default,.navbar-default{border-right: 3px solid '.CodeColor.';} .ribbon.orange{border-right: 5px solid #'.CodeColorBorder.';}' : '#total_stats,#comments,#logo,#poster,#upresult,#main,#sidenav_admin,.img-thumbnail,.input-group .form-control,.note-editor.note-frame,.footer,.panel.panel-default,.navbar-default{border-left: 3px solid '.CodeColor.';} .ribbon.orange{border-left: 5px solid #'.CodeColorBorder.';}';
echo (IsIeBrowser()) ? '.se-pre-con,.modal-loader {transform: none; margin: 0; position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;background: url('.siteurl.'/assets/css/images/preloader.gif) center no-repeat #fff;}.se-pre-con:before,.modal-loader:before {content:normal}' : '.loading-spin {-moz-animation: spin 0.7s infinite linear;-o-animation: spin 0.7s infinite linear;-webkit-animation: spin 0.7s infinite linear;animation: spin 0.7s infinite linear;display: inline-block;}';
echo (IsIeBrowser()) ? '.icon-spin6 {position: relative;left: 0px;top: 0px;width: 100%;height: 100%;background: url('.siteurl.'/assets/css/images/preloader.gif) center no-repeat #fff;}.icon-spin6:before {content:normal}' : '';
echo (IsIeBrowser()) ? '.icon-spin4 {position: relative;left: 0px;top: 0px;width: 16px;height: 16px;background: url('.siteurl.'/assets/css/images/iconloading.gif) center no-repeat #fff;}.icon-spin4:before {content:normal}' : '';
echo (IsIeBrowser()) ? '.ribbon:before, .ribbon:after {content: none;}' : '';
if(IsRtL())
echo (IsIeBrowser()) ? "body {font-family: Georgia,'Droid Arabic Kufi', sans-serif;font-size: 12px;}" : "body {font-family: 'Droid Arabic Kufi', sans-serif;font-size: 12px;}";
echo (IsIeBrowser()) ? '.corneRribbon{display:none;}' :'';
echo (!IsAdminPage)  ? '.input-group .form-control {border: 1px solid #ccc;}':'';
echo 
"\r\n";
mysqliClose_freeVars();
foreach (array_keys(get_defined_vars()) as $var) 
	        unset($$var);
unset($var);
/* Tahoma, Geneva, sans-serif*/
?>