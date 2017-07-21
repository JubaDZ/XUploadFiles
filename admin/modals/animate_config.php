<div class="container">
<form class="form-inline">
    <div class="form-group">
    <label>Entrances</label>
      <select class="form-control" id="entrance">
	  
	  </select>
   </div>
    <div class="form-group">
    <label>Exits</label>
      <select class="form-control" id="exit">
       
        
      </select>
   </div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
</form>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
function testAnim(x) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + x + '  animated');
};
$('#myModal').on('show.bs.modal', function (e) {
  var anim = $('#entrance').val();
      testAnim(anim);
})
$('#myModal').on('hide.bs.modal', function (e) {
  var anim = $('#exit').val();
      testAnim(anim);
})
</script>
   


  <select class="form-control" id="animate-config"></select>
   

  <script type="text/JavaScript">
  var animate_config = $('#animate-config');
  function OptionHtml(data)
  {
	  $.each(data, function(key, val){ 
        animate_config.append(' <option value="'+val+'">'+val+'</option>');
		
      })
  }
  
    
    $.getJSON('../includes/animate-config.json', function(data){
      animate_config.html('');
 
      $.each(data, function(key, val){ 
        animate_config.append('<optgroup label="'+key+'">');
		 OptionHtml(val);
		animate_config.append('</optgroup>');
      })
	  
    });
	
	 setTimeout(function() {
                	$('#entrance').html( animate_config.html() );
					$('#exit').html(animate_config.html());
         }, 1000);


	
	
  </script>