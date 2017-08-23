<div class="col-md-8" id="left-content">
    <div class="tse-scrollable wrapper">
        <div class="tse-content">
        </div>
    </div>
</div>


<script>
"use strict";
$(function(){

	 $.get(CONFIG.base_url + 'api/recipies/'+CONFIG.category.main_dish, function(data){
		 	var data = JSON.parse(data);
        	if(Object.keys(data).length) {
        		$.each(data, function(k,v){
        			$('#left-content .tse-content').append(_template(v));
        		})
        	}else{
        		$('#left-content').html('<h2 class="text-center">'+CONFIG.empty_record+'</h2>')
        	}

    	});

})

</script>