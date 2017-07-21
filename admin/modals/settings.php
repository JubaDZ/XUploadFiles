<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
 
 <!-- SettingsModal -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#setting" data-toggle="tab"><?php echo $lang[29] ?></a></li>
	  <li><a href="#permissions" data-toggle="tab"><?php echo $lang[250] ?></a></li>
	  <li><a href="#maxi" data-toggle="tab"><?php echo $lang[24] ?></a></li>
      <li><a href="#terms" data-toggle="tab"><?php echo $lang[152].' ...' ?></a></li>
	  <li><a href="#style" data-toggle="tab"><?php echo $lang[70] ?></a></li>
	  <li><a href="#closesite" data-toggle="tab"><?php echo $lang[64] ?></a></li>
    </ul>
    
	<form id="settings_form" role="form" onsubmit="return false;" class="tab-content">
	
	 <div id="SettingsResults"> </div>
	 
      <div class="well tab-pane active in" id="setting">
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[72] ?></span>
        <input name="sitename" type="text"  maxlength="255" class="form-control" value="<?php echo sitename ?>" style="text-align: left;direction: ltr;" placeholder="<?php echo $lang[72] ?>">
    </div>
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[112] ?></span>
        <input name="rtlsitename" type="text" maxlength="255" class="form-control" value="<?php echo rtlsitename ?>" placeholder="<?php echo $lang[112] ?>">
    </div>

    <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[18] ?></span>
        <input name="siteurl" type="text" maxlength="255" class="form-control" value="<?php echo siteurl ?>" style="text-align: left;direction: ltr;" placeholder="<?php echo $lang[18] ?>">
    </div>
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[40] ?></span>
        <input type="text"  name="sitemail" maxlength="255" class="form-control" value="<?php echo sitemail ?>" style="text-align: left;direction: ltr;" placeholder="<?php echo $lang[40] ?>">
    </div>
	<div class="input-group">
      <span class="input-group-addon hidden-sml"> <?php echo $lang[63] ?> </span>
        <input type="text"  name="folderupload" maxlength="255" class="form-control" value="<?php echo folderupload ?>" style="text-align: left;direction: ltr;" placeholder="<?php echo $lang[63] ?>">
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[68] ?></span>
	  
	  <select  name="language" class="selectpicker" data-live-search="true"  data-width="100%"  title="<?php echo $lang[68] ?>">
	    <!--<option value="<?php echo InterfaceLanguage ?>" selected><?php echo GetLanguageCode(InterfaceLanguage)  ?></option>-->
		<option value="<?php echo language ?>" selected><?php echo $lang[113] ?></option>	
        <option value="ar">العربية</option>
		<option value="en">English</option>
		<option value=""><?php echo $lang[114] ?></option>
      </select>
	  
    </div>
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[66] ?></span>
	  <select name="time_zone" class="selectpicker" data-live-search="true"  data-width="100%"  title="<?php echo $lang[66] ?>">
	    <option selected><?php echo time_zone ?></option>
        <?php echo LoadTimeZones(); ?>
      </select>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[67] ?></span>
        <input type="text"  maxlength="30" name="prefixname" value="<?php echo prefixname ?>" class="form-control" style="text-align: left;direction: ltr; " placeholder="<?php echo $lang[67] ?>">
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[25] ?></span>
        <input type="text" maxlength="1000" name="extensions" value="<?php echo extensions ?>" class="form-control" placeholder="<?php echo $lang[25] ?>" data-role="tagsinput" >
    </div>

	</div> <!-- tab-settings -->
	
		<div class="well tab-pane fade" id="permissions">
	 
	 <div class="input-group">
      <span class="input-group-addon"><?php echo $lang[172] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[172] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="thumbnail" class="settings" type="checkbox" <?php if(thumbnail) echo ' checked' ?>> </span>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[55] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[55] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="register" class="settings" type="checkbox" <?php if(register) echo ' checked' ?>></span>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[65] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[65] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="enable_userfolder" class="settings" type="checkbox" <?php if(enable_userfolder) echo ' checked' ?>></span>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[149] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[1].' / '.$lang[149] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="authorized" class="settings" type="checkbox" <?php if(authorized) echo ' checked' ?>></span>
    </div>
	
	<div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[51] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[51] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="directdownload" class="settings" type="checkbox" <?php if(directdownload) echo ' checked' ?>></span>
    </div>
	
	<div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[26] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[26] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="deletelink" class="settings" type="checkbox" <?php if(deletelink) echo ' checked' ?>></span>
    </div>
	
	<div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[248] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[248] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="multiple" class="settings" type="checkbox" <?php if(multiple) echo ' checked' ?>></span>
    </div>
	
	
	<div class="input-group">
      <span class="input-group-addon"> <?php echo $lang[28] ?></span>
        <input type="text"  class="form-control hidden-sml" placeholder="<?php echo $lang[28] ?>" disabled>
		<span class="input-group-addon" style="min-width: 15px;text-align: left;"><input name="statistics" class="settings" type="checkbox" <?php if(statistics) echo ' checked' ?>></span>
    </div>
	
    </div> <!-- tab-permissions -->
	
	
	<div class="well tab-pane fade" id="maxi">
	
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[24] ?></span>
        <input type="text"  name="maxsize" maxlength="255" class="form-control" value="<?php echo nbrOnly(maxsize) ?>" placeholder="<?php echo $lang[24] ?>">
	  <?php echo OptionSizeHtml('format_maxsize',(maxsize))?>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[173] ?></span>
        <input type="text"  name="userspacemax" maxlength="255" class="form-control" value="<?php echo nbrOnly(userspacemax) ?>" placeholder="<?php echo $lang[173] ?>">
	  <?php echo OptionSizeHtml('format_userspacemax',(userspacemax))?>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[234] ?></span>
        <input type="text"  name="speed" maxlength="255" class="form-control" value="<?php echo nbrOnly(speed) ?>" placeholder="<?php echo $lang[234] ?>">
	  <?php echo OptionSizeHtml('format_speed',(speed))?>
    </div>
	
	 <div class="input-group">
      <span class="input-group-addon hidden-sml" ><?php echo $lang[236] ?></span>
        <input type="text"  name="days_older" value="<?php echo days_older ?>" class="form-control" placeholder="<?php echo $lang[236].' 30 '.$lang[222].' ...' ?>">
	  <span style="min-width: 60px;" class="input-group-addon" ><?php echo $lang[222] ?></span>
    </div>
	 
	 <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[78] ?></span>
        <input type="text"  name="Interval" value="<?php echo Interval ?>" class="form-control" placeholder="<?php echo $lang[78] ?>">
	  <span style="min-width: 60px;"class="input-group-addon"><?php echo $lang[216] ?></span>
    </div>
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml" ><?php echo $lang[237] ?></span>
        <input type="text"  name="maxUploads" value="<?php echo maxUploads ?>" class="form-control" placeholder="<?php echo $lang[237] ?>">
	  <span style="min-width: 60px;" class="input-group-addon" ><?php echo function_exists('ini_get') ? ini_get('max_file_uploads') : '' ?></span>
    </div>
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[69] ?></span>
        <input type="text"  name="rowsperpage" value="<?php echo rowsperpage ?>" class="form-control" placeholder="<?php echo $lang[249] ?>">
		<span style="min-width: 60px;" class="input-group-addon"><?php echo $lang[216] ?></span>
    </div>
	
	</div> <!-- tab-maxi -->
	
	
	
	
	
	<div class="well tab-pane fade" id="closesite">
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"> <?php echo $lang[64] ?> </span>
         <textarea maxlength="21844" class="editor form-control" rows="5" id="closemsg" name="closemsg"  placeholder="<?php echo $lang[64] ?>"><?php echo closemsg ?></textarea>
		 <span class="input-group-addon" style="min-width: 15px;text-align: left;"><input id="siteclose" name="siteclose" class="settings" type="checkbox" <?php if(siteclose) echo ' checked' ?>></span>
    </div>
	
	</div> <!-- tab-closesite -->
	
	
	<div class="well tab-pane fade" id="style">
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[191] ?> - Panel</span>
	  <input type="text" maxlength="7" name="PanelColor" id="PanelColorValue" class="colorselector form-control" value="<?php echo PanelColor ?>" >
	  <span class="input-group-addon" style="min-width: 15px;text-align: left;">
	    <select id="PanelColor">
          <option value="#3b3b3b" data-color="#3b3b3b"></option>
		  <option value="#3c3d41" data-color="#3c3d41"></option>   
		  <option value="#4A4F54" data-color="#4A4F54"></option>  
		  <option value="#4a5164" data-color="#4a5164"></option> 
		  <option value="#797979" data-color="#797979"></option> 
		  <!--  <option value="<?php echo PanelColor ?>" data-color="<?php echo PanelColor ?>" selected="selected"></option>  -->   		  
        </select>
	  </span>
	</div>
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[191] ?> - Code</span>
	  <input type="text" maxlength="7" name="CodeColor" id="CodeColorValue" class="colorselector form-control" value="<?php echo CodeColor ?>">
	  <span class="input-group-addon" style="min-width: 15px;text-align: left;">
	    <select id="CodeColor">
          <option value="#CF482E" data-color="#CF482E"></option>
		  <option value="#5ABBAC" data-color="#5ABBAC"></option>
		  <option value="#C95555" data-color="#C95555"></option>
		  <option value="#4d759b" data-color="#4d759b"></option>
		  <option value="#427FED" data-color="#427FED"></option>
		  <!--  <option value="<?php echo CodeColor ?>" data-color="<?php echo CodeColor ?>" selected="selected"></option>-->
        </select>
	  </span>
	</div>
	
	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[191] ?> - Body</span>
	  <input type="text" maxlength="7" name="BodyColor" id="BodyColorValue" class="colorselector form-control" value="<?php echo BodyColor ?>">
	  <span class="input-group-addon" style="min-width: 15px;text-align: left;">
	    <select id="BodyColor">
		  <option value="#c8c8c8" data-color="#c8c8c8"></option>
		  <option value="#ebebec" data-color="#ebebec"></option>
		  <option value="#e5e5e5" data-color="#e5e5e5"></option>
		  <option value="#ece9e0" data-color="#ece9e0"></option>
		  <!-- <option value="<?php echo BodyColor ?>" data-color="<?php echo BodyColor ?>" selected="selected"></option> -->
        </select>
	  </span>
	</div>
	
	</div> <!-- tab-style -->
	
	<div class="well tab-pane fade" id="terms">
  
  	<div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[152] ?></span>
	    <textarea maxlength="21844" class="editor form-control" rows="5" name="terms" id="editor" placeholder="<?php echo $lang[152] ?>"><?php echo terms ?></textarea>
    </div>
	
  
    <div class="input-group">
      <span class="input-group-addon hidden-sml"><?php echo $lang[153] ?></span>
	    <textarea maxlength="21844" class="editor form-control" rows="5" name="privacy" id="privacy" placeholder="<?php echo $lang[153] ?>"><?php echo privacy ?></textarea>
    </div>
	
	</div> <!-- tab-terms -->
	
	</form> <!-- tab-content -->


	<br>
  <div class="form-group">
     <button id="btn" type="submit" class="btn btn-primary btn-block" onclick="request('settings','SettingsResults','settings_form');"><?php echo $lang[71] ?></button>
  </div>