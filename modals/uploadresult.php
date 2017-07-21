<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>  
  <div id="alert" class="<?php echo ClassAnimated ?> bounceInDown">
       <div class="row"> 	  
            <div class="col-xs-12" id="msg"> 		
			<?php 
		    if(GetIsEmpty && defined('Extensions_Str'))
			{
				echo "<div class='visible-xs'><div class='alert alert-info' id='extensions_mobile'>".Extensions_Str."</div></div>" ;
				echo (file_exists('./install/')) ? error($lang[108].' ( <a href="./install/?unlink">'.$lang[32].'</a> )') : '';
			}
            ?>
			</div>
          </div>
  </div>	<!--div alert -->
  <div id="upresult" class="<?php echo ClassAnimated ?> bounceInDown">
          <div class="row"> 	 
           <div class="ribbon orange"><span><?php echo $lang[8] ?> : </span><span id="queue"></span></div>		  
             <div id="wrap" class="top60 col-xs-12">     
			   <!--60px -->
	           <div id="progressWrap" class="progress-wrap top10"></div>
			   <!--10px -->
			   <ul id="msgBox" class="list-group top10">  </ul>		  
            </div>
          </div>
		  
   </div> <!--div upresult -->