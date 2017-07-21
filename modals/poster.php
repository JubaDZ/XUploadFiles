<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>  
<?php 
$info             = IsGet('download') ? Sql_Get_info(protect(Decrypt($_GET['download']))) : array('status'=>false);
$publicity        = Sql_Get_publicity($ads_page); 
$ads_google       = ($ads_page == 'ads_google')  ? true : false ;
$ads_download     = ($ads_page == 'ads_download')? true : false ;
$no_ads_title     = (empty($publicity['title'])) ? true : false ;
$file_status      = (IsGet('download')) ? $info['status'] : true;
$is_content_empty = (empty($publicity['content']) || $publicity['content'] =='<p><br></p>' || $publicity['content'] =='<p></p>') ? true : false ;
$is_deleteFile    = (IsGet('download') && ($_GET['download'] =='deleteFile')  && $ads_download ) ? true : false ;
if( display_ads && $publicity['status'] && !$is_content_empty && !$is_deleteFile  && ($file_status) )
{ 
     if($ads_google)
     { 
?>
<div>
<?php } else { ?>

 <div id="poster" class="<?php /*echo ($ads_download) ? 'top20 ' : '';*/  echo ClassAnimated ?> bounceInDown">
 <?php }  ?>
          <div class="row"> 	
<?php if( (!$no_ads_title) && (!$ads_google) ){ ?>		  
           <div class="ribbon orange"><span><?php echo $publicity['title'] ?> </span></div>		  
            <div class="top60 col-xs-12">  
              <?php } else { ?>		
              <div class="col-xs-12"> 
			  <?php } ?>			
	           <?php  echo $publicity['content']?>		
			  	  
              </div><!--div col-xs-12 -->
          </div><!--div row -->
	
 
 </div> <!--div poster -->
<?php } 
unset($publicity);
unset($info);
?>