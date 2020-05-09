<?php if(!isset($connection)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<!-- <p><?php echo SiteName() ?></p> -->   

<form id="delete_files_form" role="form" onsubmit="return false;">  
<div class="table-responsive">      
  <table class="table table-bordered">
    <thead>
      <tr>
	    <th><span id="span_select_all"><input id="select_all" type="checkbox" class="selectall" /></span></th>
        <th><a href="javascript:void(0)" onclick="orderTable('userId','files');"><?php echo $lang[35]?></a></th>
        <th><a href="javascript:void(0)" onclick="orderTable('filename','files');"><?php echo $lang[36]?></a></th>
		<th><a href="javascript:void(0)" onclick="orderTable('fileSize','files');" ><?php echo $lang[42]?></a></th>
		<th class="hidden-xs"><a href="javascript:void(0)" onclick="orderTable('totalDownload','files');"><i class="glyphicon glyphicon-download-alt"></i></a></th>
		<th class="hidden-xs"><i class="glyphicon glyphicon-flag"></i></th>
		<th class="hidden-xs"><i class="glyphicon glyphicon-comment"></i></th>
        <th class="hidden-xs"><a href="javascript:void(0)" onclick="orderTable('uploadedDate','files');"><?php echo $lang[33]?></th>
		<th><a href="javascript:void(0)" onclick="orderTable('id','files');"><?php echo $lang[43]?></a></th>
      </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
	<tr id="button-selection"><td colspan="9"><button id="button_1" type="submit" class="btn btn-primary btn-block" onclick="confirm_request('delete_selected','DeleteSelectedResults','delete_files_form');"><?php echo $lang[32] ?></button></td></tr>
	<tr id="result-selection"><td id="DeleteSelectedResults" colspan="9"></td></tr>
  </table>
 </div> 
</form>     
    <div id="page-selection"></div>