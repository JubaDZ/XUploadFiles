<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php

	$nb_total              = num_rows(Sql_query("SELECT 1 FROM `stats`")) ;
	$nb_total = ($nb_total==0) ? 1 : $nb_total;
	
	$nb_dates              = num_rows(Sql_query("SELECT distinct(FROM_UNIXTIME(`date`,'%Y-%m-%d')) FROM `stats`"));	

	$dates_totalpages      = ceil( $nb_dates / rowsperpage);
	$dates       = '';
	$uploadsdates= '';
	
	
		   $result = Sql_query("SELECT distinct(`country_code`) as `_country_code_` , count(`country_code`) as `_count_` FROM `stats` GROUP BY `_country_code_` ORDER BY `_country_code_` DESC LIMIT 15");
	while ($data = mysqli_fetch_array($result))
	{
		$chart_countries_labels.=$data['_country_code_'].',';
		$chart_countries_data.=$data['_count_'].','; 
		$dates.='<tr><td>'.$data['_country_code_'].'</td> <td><code>'.$data['_count_'].'</code></td><td>'.percent($data['_count_']/$nb_total).'</td></tr>'; 
	}
	
	   $result = Sql_query("SELECT distinct(FROM_UNIXTIME(`date`,'%Y-%m-%d')) as `_date_` , count(FROM_UNIXTIME(`date`,'%Y-%m-%d')) as `_count_` FROM `stats` GROUP BY `_date_` ORDER BY `date` DESC LIMIT 15");
	while ($data = mysqli_fetch_array($result))
	{
		$chart_dates_labels.=$data['_date_'].',';
		$chart_dates_data.=$data['_count_'].','; 
		$dates.='<tr><td>'.$data['_date_'].'</td> <td><code>'.$data['_count_'].'</code></td><td>'.percent($data['_count_']/$nb_total).'</td></tr>'; 
	}
	
		$result = Sql_query("SELECT distinct(FROM_UNIXTIME(`uploadedDate`,'%Y-%m-%d')) as `_date_` , count(FROM_UNIXTIME(`uploadedDate`,'%Y-%m-%d')) as `_count_` FROM `files` GROUP BY `_date_` ORDER BY `uploadedDate` DESC LIMIT 15");
	while ($data = mysqli_fetch_array($result))
	{
		$chart_uploads_labels.=$data['_date_'].',';
		$chart_uploads_data.=$data['_count_'].','; 
		$uploadsdates.='<tr><td>'.$data['_date_'].'</td> <td><code>'.$data['_count_'].'</code></td><td>'.percent($data['_count_']/$nb_total).'</td></tr>'; 	
	}
	
	    $disk_free_space = function_exists('disk_free_space') ? round(@disk_free_space("/") / pow(1024,2), 2) : 0 ;
		$disk_total_space = function_exists('disk_total_space') ? round(@disk_total_space("/") / pow(1024,2), 2) : 0 ;

	?>

 <ul class="ds-btn">
   <div class="row">
        <li class="col-xs-12 col-md-3">
             <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./?users">
             <i class="cpanelIcon glyphicon glyphicon-user pull-left"></i><span><span id="t_users"><?php echo t_users ?></span><hr><small class="text-color"><?php echo $lang[73]?></small></span></a>   
        </li>
		
		<li class="col-xs-12 col-md-3">
             <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./?files">
             <i class="cpanelIcon glyphicon glyphicon-file pull-left"></i><span><span id="t_files"><?php echo t_files ?></span><hr><small class="text-color"><?php echo $lang[109]?></small></span></a> 
        </li>
		
		<li class="col-xs-12 col-md-3">
             <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./?reports">
             <i class="cpanelIcon glyphicon glyphicon-flag pull-left"></i><span><span id="t_reports"><?php echo t_reports ?></span><hr><small class="text-color"><?php echo $lang[101]?></small></span></a> 
        </li>
		
        <li class="col-xs-12 col-md-3">
            <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./?folders">
            <i class="cpanelIcon glyphicon glyphicon-folder-close pull-left"></i><span><span id="t_folders"><?php echo t_folders ?></span><hr><small class="text-color"><?php echo $lang[74]?></small></span></a>    
        </li>
		
		
	</div>
	<div class="row">
        <li class="col-xs-12 col-md-3">
             <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./?statistics">
             <i class="cpanelIcon glyphicon glyphicon-stats pull-left"></i><span><span id="t_statistics"><?php echo t_statistics ?></span><hr><small class="text-color"><?php echo $lang[28]?></small></span></a> 
        </li>
		
		<li class="col-xs-12 col-md-3">
		      <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./?comments">
		      <i class="cpanelIcon glyphicon glyphicon-comment pull-left"></i><span><span id="t_comments"><?php echo t_comments ?></span><hr><small class="text-color"><?php echo $lang[240]?></small></span></a>
        </li>
       
		<li class="col-xs-12 col-md-3">
		      <a class="cpanelBtn btn btn-lg btn-primary btn-block" href="./">
		      <i class="cpanelIcon glyphicon glyphicon-hdd pull-left"></i><span><span id="t_size"><?php echo t_size ?></span><hr><small class="text-color"><?php echo $lang[42]?></small></span></a>
        </li>
		
		<li class="col-xs-12 col-md-3">

        </li>
	</div>	
  </ul>


  

    
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[105] ;?></div>
	    <div class="panel-body">
   
   
   
     <div class="col-xs-12">
	 
	 <div class="table-responsive">
	 <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
		<th><?php echo $lang[194]?></th>
      </tr>
    </thead>
    <tbody>
	
	  <tr>
        <td>upload_max_filesize</td>
		<td><code><?php echo function_exists('ini_get') ? FileSizeConvert(return_bytes(@ini_get('upload_max_filesize'))) : '' ?></code></td>
      </tr>
	  
	   <tr>
        <td>post_max_size</td>
		<td><code><?php echo function_exists('ini_get') ? FileSizeConvert(return_bytes(@ini_get('post_max_size'))) : '' ?></code></td>
      </tr>
	  
	  <tr>
        <td>memory_limit</td>
		<td><code><?php echo function_exists('ini_get') ? (@ini_get('memory_limit').' '.$lang[216]) : '' ?></code></td>
      </tr>
	  
	   <tr>
        <td>max_execution_time</td>
		<td><code><?php echo function_exists('ini_get') ? (@ini_get('max_execution_time').' '.$lang[216]) : '' ?></code></td>
      </tr>
	  
	  <tr>
        <td>max_input_time</td>
		<td><code><?php echo function_exists('ini_get') ? (@ini_get('max_input_time').' '.$lang[216]) : '' ?></code></td>
      </tr>
	  
	   <tr>
        <td>max_file_uploads</td>
		<td><code><?php echo function_exists('ini_get') ? (@ini_get('max_file_uploads').' '.$lang[109]) : '' ?></code></td>
      </tr>
	  
	   <tr>
        <td>phpversion</td>
		<td><code><?php echo function_exists('phpversion') ? phpversion() : '' ?></code></td>
      </tr>
	  
	  <tr>
        <td>mysqlversion</td>
		<td><code><?php echo mysqlversion() ?></code></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[243] ?></td>
		<td><code><?php echo function_exists('disk_free_space') ? FileSizeConvert(@disk_free_space("/")):'-' ?></code></td>
      </tr>
	  
	  <tr>
        <td><?php echo $lang[242] ?></td>
		<td><code><?php echo function_exists('disk_total_space') ? FileSizeConvert(@disk_total_space("/")):'-' ?></code></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[193] ?></td>
		<td><a target="_blank" href="<?php echo siteurl ?>"><?php echo SiteName() ?></a></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[252] ?></td>
		<td><code><?php echo installdate ?></code></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[5] ?></td>
		<td><code><?php echo scriptversion ?></code></td>
      </tr>
	  
	  <tr>
        <td><?php echo $lang[12] ?></td>
		<td><code id="author"><?php echo 'onexite' ?></code></td>
      </tr>

	  
    </tbody>
  </table>
</div>
	 
	 </div>
  </div>
  </div>
 </div>
 
  <?php if( function_exists('disk_total_space') && function_exists('disk_free_space') ){ ?>
   <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[173] ;?></div>
	       <div class="panel-body" id="DivChartSpace">
              <canvas class="col-xs-12" style="margin-top:60px;" id="ChartSpace"></canvas>
           </div>
    </div>
 </div>
  <?php }?>
  
   <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[128] ;?></div>
	       <div class="panel-body" id="DivWorldMap">
		      <div class="col-xs-12" style="margin-top:60px;" id="WorldMap"></div>
           </div>
    </div>
  </div>

  
  <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[128] ;?></div>
	    <div class="panel-body" id="DivChartDates">
           <canvas class="col-xs-12" style="margin-top:60px;" id="ChartDates"></canvas>
        </div>
    </div>
  </div>
 
 
 <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[174] ;?></div>
	       <div class="panel-body" id="DivChartUploads">
              <canvas class="col-xs-12" style="margin-top:60px;" id="ChartUploads"></canvas>
           </div>
    </div>
 </div>

