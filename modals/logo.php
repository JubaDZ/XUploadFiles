<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php if(EnableLogo) {?>
<div class="col-sm-12 col-md-12 logo <?php echo ClassAnimated ?> bounceInDown" id="logo">
    <div class="row"> 
        <a href="./" >
	        <img class="img-responsive" alt="logo" src="<?php echo siteurl ?>/assets/css/images/logo<?php echo (IsRtl()) ? 'ar' : ''; ?>.png" >
	    </a>
    </div>
</div>
 <?php } ?>