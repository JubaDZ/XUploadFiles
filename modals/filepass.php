<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>

            <tr>
			  <thead>
			    <td colspan="2" id="th_pass">
				<div id="fillpass">
				    <div class="ribbon dark"><span><?php echo $lang[37] ?></span></div>
					<div class="top70">
                      <div class="form-group">
                        <div class="input-group col-sm-12">
                          <span class="input-group-addon" style="min-width:50px;"><i class="glyphicon glyphicon-lock"></i></span>
                          <input id="FilePassword" name="password" placeholder="<?php echo $lang[37] ?>" class="form-control"  type="password">
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" onclick="confirmPasswordFile(<?php echo $DownloadID ?> )" class="btn btn-primary btn-block" value="<?php echo $lang[175] ?>" type="submit">
                      </div>
					  <div id="confirmPasswordDiv"></div>
					 </div>
				</div>	 
               </td>
			 </thead>
			</tr>
          
           
       