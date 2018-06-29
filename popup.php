
<script type="text/javascript">    
    function iframeLoad(){ 
        jQuery('.loader').hide();
    }
</script>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">         
        <h2></h2><div class="loader"></div>
        <button type="button" class="btn btn-danger close-modal" data-dismiss="modal">Close</button> 
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <iframe id="group-detail-iframe" onload="iframeLoad()"></iframe>
      </div>
 
    </div>
  </div>
</div>

<script>
    jQuery(document).ready(function(){ 
        jQuery('.group-detail-toggle').click(function(){  
            var url = jQuery(this).attr('data-href');
            jQuery('#group-detail-iframe').attr('src', url);
            jQuery('.modal-header h2').html(jQuery(this).attr('data-title'));
            jQuery('.loader').show();
        });

        jQuery('.close-modal').click(function(){
            jQuery('#group-detail-iframe').attr('src', '');
            
            if(jQuery(this).attr('data-reload') == '1'){
                location.reload();
            }
        });
    });
</script>