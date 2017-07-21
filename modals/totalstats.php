<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<div id="total_stats" class="top20">
<div class="row">
        <!-- Boxes de Acoes -->
    	<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="glyphicon glyphicon-download-alt"></i></div>
					<div class="info">
						<h4 class="title"><?php echo $lang[245]?></h4>
						<h2 id="download-count">0</h2>  
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
			
        <div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="glyphicon glyphicon-cloud-upload"></i></div>
					<div class="info">
						<h4 class="title"><?php echo $lang[246]?></h4>
    					<h2 id="file-count">0</h2>   
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
			
        <div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="glyphicon glyphicon-user"></i></div>
					<div class="info">
						<h4 class="title"><?php echo $lang[247]?></h4>
						<h2 id="user-count">0</h2>  
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>		    
		<!-- /Boxes de Acoes -->
	</div>
  
</div>