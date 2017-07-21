<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>

<form id="profile_form" role="form" onsubmit="return false;" class="<?php echo ClassAnimated ?> zoomIn">
	   	
  <ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#profilehome"><?php echo $lang[105] ?></a></li>
	<li><a data-toggle="tab" href="#profileedit"><?php echo $lang[187] ?></a></li>
  </ul>

<div class="tab-content">
  <div id="profilehome" class="tab-pane fade in active">
  
 <div class="well">
 
 <div class="form-group">
    <label for="username"><?php echo $lang[35] ?></label>
    <input type="text" class="form-control" value="<?php  echo defined('UserName') ? UserName : '' ?>" disabled>
  </div>
 
  <div class="form-group">
    <label for="user_level"><?php echo $lang[58] ?> </label>
    <input type="text" class="form-control" value="<?php echo user_level(IsAdmin) ?>" disabled>
  </div>
  
  <div class="form-group">
    <label for="user_plan"><?php echo $lang[229] ?></label>
    <input type="text" class="form-control" value="<?php  echo user_plan(PlanId) ?>" disabled>
  </div>
  
   <div class="form-group">
    <label for="key"><?php echo $lang[255] ?></label>
	<div class="input-group" style="margin: 0px;">
        <input type="text" id="key" name="key" class="form-control" readonly value="<?php echo Encrypt(TwoWayEncrypt(UserEmail,RegisterDate)) ?>" placeholder="<?php echo $lang[255]?>" >
	        <span class="input-group-btn">
			    <button class="btn btn-primary" onclick="CopyLink('key')" type="button"><?php echo $lang[146] ?></button>
		    </span>
	</div>
	 </div>
	 
   <div class="form-group"><!--.' / '.FileSizeConvert(UserSpace)."-".FileSizeConvert(user_space_max)  -->
    <label for="user_Space"><?php echo $lang[173] ?> </label>
	<table class="table table-bordered">
	   <tr class="active">
	     <td style="width:<?php echo PercentageUsed ?>%"><?php echo FileSizeConvert( $_SESSION['login']['user_space_used']) ?></td>
		 <td style="width:<?php echo PercentageFree ?>%"><?php echo FileSizeConvert( user_space_max) ?></td>
	   </tr>
	</table>

     <div class="progress">
       <div class="progress-bar progress-bar-danger" role="progressbar" id="progressUsed" style="width:<?php echo PercentageUsed ?>%">
	   <?php echo PercentageUsed ?>%
	   </div>
	   <div class="progress-bar progress-bar-success" role="progressbar" id="progressFree" style="width:<?php echo PercentageFree ?>%">
	   <?php echo PercentageFree ?>%
	   </div>
     </div>
  </div>
 </div> <!-- well -->
</div><!-- tab home -->
  
  
  <div id="profileedit" class="tab-pane fade">
  <div class="well">
  <div class="form-group" id="ProfileResults"> </div>
 
   <div class="form-group">
    <label for="password"><?php echo $lang[37] ?></label>
    <input type="password" name="password" class="form-control" maxlength="20"  placeholder="<?php echo $lang[37]?>" required>
  </div>
  
  
   <div class="form-group">
    <label for="email"><?php echo $lang[40] ?> </label>
    <input type="text" name ="email" class="form-control" maxlength="40" placeholder="<?php echo $lang[40]?>" value="<?php echo defined('UserEmail') ? UserEmail : ''  ?>" required>
  </div>
  
 
 <?php if(EnableCaptcha){?>
   <div class="form-group">
    <img id="captcha_4" src="ajax/index.php?captcha&background=<?php echo WellColor ?>" onclick="this.src='ajax/index.php?captcha&background=<?php echo WellColor ?>&' + Math.random();" alt="captcha" style="cursor:pointer;">
	<a href="javascript:void(0)" onclick="GenerateCaptcha('<?php echo WellColor ?>');"><span class="glyphicon glyphicon-refresh"></span></a>
	<input type="text" class="captcha form-control" maxlength="4" name="captcha" placeholder="<?php echo $lang[54] ?>">
   </div>
 <?php }?>
   <div class="form-group">
     <button type="button" class="btn btn-primary btn-block" onclick="request('edituser','ProfileResults','profile_form');"><?php echo $lang[79] ?></button>
   </div>
   
  </div><!-- tab  -->
 </div><!-- well -->
</div><!-- tab-content -->	

  
  </form>
  

       
		  

  