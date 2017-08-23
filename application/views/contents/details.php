<div id="full-content">
    <div class="tse-scrollable wrapper">
        <div class="tse-content">
        </div>
    </div>
</div>

<script>
"use strict";
$(function(){

	 $.get(CONFIG.base_url + 'api/recipe/<?= $id; ?>' , function(data){
		 	var data = JSON.parse(data);
        	if(Object.keys(data).length) {
    			$('#full-content .tse-content').append(_details_template(data));	
        	}else{
        		$('#left-content').html('<h2 class="text-center">'+CONFIG.empty_record+'</h2>')
        	}

    	});

})

</script>