<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php
$pathInfo = pathinfo($_SERVER['PHP_SELF']); 
define('_dirname_', $pathInfo['dirname'] );
?>
<script type="text/JavaScript">
document.write('<style type="text/css">body {visibility: visible;}</style>');
</script>
<style>
	@media (min-width: 979px) {
    body {
		padding-top: 60px; 
	}
	.container {
  		width: 540px;
  	}
}

.vtexIdUI-page {
	box-shadow: 0 0 3px #ccc;
}


.vtexIdUI-email-field input {
    font-size: 18px;
    height: 40px;
    line-height: 120%;
}

.info-code {margin-bottom: 4px;}

.vtexIdUI-auth-code input {
    font-size: 40px;
    height: 54px;
    padding-top: 3px;
    line-height: 120%;
    text-align: center;
	margin-bottom: 2px;
}

.vtexIdUI-code-field {
	margin: 0 auto;
	width: 30%; 
	margin-bottom: 10px;
}



.alert-general {
    border-radius: 0;
    border-width: 1px 0 1px 0;
    margin-bottom: 0;
}
.alert-modal-body {padding-top: 15px;}
</style>

  </head>
  <body>
<div class="container">
  
    <div class="vtexIdUI-403 vtexIdUI-page" id="vtexIdUI-no-permission">
      <div class="modal-header">
        <h4><span class="vtexIdUI-heading"><?php echo $lang[168] ?></span> <small class="pull-<?php directionDiv(); ?>"><?php echo $lang[14]?> 403</small></h4>
      </div>
      
      <div class="alert alert-info alert-general alert-modal-body clearfix">
        <i class="icon-frown icon-4x pull-<?php directionDiv(); ?>"></i>
        <p><?php echo $lang[170]?> <strong><?php echo _dirname_ ?></strong> <?php echo $lang[171]?><br>
          <small><?php echo $lang[169]?></small>
        </p>
      </div>
      
        <div class="modal-footer">
          <a class="vtexIdUI-back-link pull-<?php directionDiv(); ?> dead-link" href="./" ><i class="icon-arrow-<?php directionDiv(); ?>"></i> <?php echo $lang[156] ?></a>
          <button class="btn pull-<?php directionDiv(true); ?> btn-large" type="submit" disabled><?php echo $lang[27] ?></button>
        </div>

    </div>
  
</div>