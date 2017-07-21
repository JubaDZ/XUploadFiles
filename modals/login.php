<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<form id="login_form" role="form" onsubmit="return false;" class="<?php echo ClassAnimated ?> zoomIn">
	   
	<div class="form-group" id="LoginResults"> </div>
	   
	  
  <div class="form-group">
    <label for="Email"><?php echo $lang[35] ?></label>
    <input type="text" id="login_username" class="form-control" name="Email" maxlength="15" placeholder="<?php echo $lang[35] ?>" required>
  </div>
  
  <div class="form-group">
    <label for="Password"><?php echo $lang[37] ?> ( <a href="?forgot" ><?php echo $lang[41] ?></a> )</a></label>
    <input type="password" class="form-control" maxlength="20" name="Password" placeholder="<?php echo $lang[37] ?>" required>
  </div>
  <?php if(EnableCaptcha){?>
    <div class="form-group">
    <img id="captcha_1" src="ajax/index.php?captcha&background=<?php echo MainColor ?>" onclick="this.src='ajax/index.php?captcha&background=<?php echo MainColor ?>&' + Math.random();" alt="captcha" style="cursor:pointer;">
	<a href="javascript:void(0)" onclick="GenerateCaptcha('<?php echo MainColor ?>');"><span class="glyphicon glyphicon-refresh"></span></a>
	<input type="text" class="captcha form-control" maxlength="4"  name="captcha" placeholder="<?php echo $lang[54] ?>">
  </div>
  <?php }?>
  <div class="form-group">
     <button type="submit" class="btn btn-primary btn-block" onclick="request('login','LoginResults','login_form');"><?php echo $lang[20] ?></button>	
  </div>
</form>
