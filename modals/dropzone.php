<?php if(!isset($connection)) die('<title>Access Denied</title><i>This page cannot be accessed directly</i>'); ?>
<?php (!defined('Extensions_Str')) ? define('Extensions_Str' , extensionsStr() ) : '' ;
      (!defined('IsAdminPage')) ? define('IsAdminPage',false) : '';  ?>
       <div class="extensions <?php echo ClassAnimated ?> bounceInDown">
	   <?php /* , '.$lang[106]. ' <code>'.gmdate("H:i:s", MaxFileSize).'</code> ,';*/
       echo (GetIsEmpty || IsAdminPage) ? '<span id="extensions_not_mobile" class="hidden-xs">'.Extensions_Str.'</span>' : '' ;
	   ?>
       </div>
	   
       <div class="upload-drop-zone" id="dropzone" >
	   
	        <a href="javascript:void(0)" id="uploadBtn" >
		        <span id="uploadIcon"><i class="icon-upload-cloud uploadIcon"></i></span>
				<br>
			    <span id="uploadLabel"><?php echo $lang[6] ?></span>
			</a> 
			
			<span id="dragLabel">
			  <?php echo $lang[7] ?>
			</span>
			
			
	   </div>
	   <div class="UploadOptions">
	   <input type="hidden" id="File_Password" value="">
	   <?php if(IsLogin) { ?>
	   <input id="isPublic" type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="<?php echo $lang[176]?>" data-off="<?php echo $lang[177]?>">&nbsp;
	   <?php } ?>
	   <span><i  class="glyphicon glyphicon-lock"></i>  <a href="javascript:void(0)" onclick="FileSetPassword()" id="SetPassword"><?php echo $lang[37]?></a></span>
	   </div>
	   <?php !IsAdminPage ? Get_Ads('ads_google' ) : '' ; ?>
