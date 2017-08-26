$(function() {

	window.getFeature = function(){ 
   		
			 $.get(CONFIG.base_url + 'api/feature', function(data){
			 	var data = JSON.parse(data);
			 	// console.log(Object.keys(data).length);
	        	if(Object.keys(data).length) {
	        		$('#feature_img').show();
	        		$('#feature_img').attr('src', data.image)
	        		$('#feature_img').attr('data-id', data.id)
	        		$('#feature_title h3').text(data.name);
	        	}else{
	        		$('#feature_img').hide();
	        		$('#feature_title h3').text("Empty record.");
	        	}
	    	});
	}

	var _getLatest = function() {

		return  $.get(CONFIG.base_url + 'api/latest', function(data){
		 	var data = JSON.parse(data);
        	return data;

    	});


	}


	window.getLatest = function(){ 

		 $.get(CONFIG.base_url + 'api/latest', function(data){
		 	var data = JSON.parse(data);

        	if(Object.keys(data).length) {

        		$.each(data, function(k,v){
        			$('#left-content .tse-content').append(_template(v));
        		})
        		
        	}else {
                 $('#left-content').html('<h2 class="text-center">'+CONFIG.empty_record+'</h2>');
            }

    	});


	}


	$(document).on('click', '.delete', function(e) {
			var objElm = $(e.currentTarget);
			var id = objElm.data('id');
			var del = confirm('Do you really want to delete this recipe?');
			var feature_id = $('#feature_img').attr('data-id');
			var page = $('body').data('title');

			if(del) {
				$.ajax({
					url : CONFIG.base_url + 'api/delete/'+id,
					type : 'delete',
					success : function(data) {

						if(data == 1){
							// Animate and remove content
							$('#panel_'+id).slideUp("slow", function(){
								$(this).remove();

								var count_recipies = $('.tse-content .panel').length;
								// check if content on the page is already empty
								if(count_recipies == 0) {
									$('#left-content').html('<h2 class="text-center">'+CONFIG.empty_record+'</h2>')
								}

								if(page === 'Home') {

									_getLatest().success(function(data){
										var data = JSON.parse(data);
										if(Object.keys(data).length == 3) {
											$(_template(data[2])).appendTo('#left-content .tse-content')
										}
									})
								}

								// if feature layout is the same you are deleting
								if(id == feature_id) {
									getFeature();
								}

							});
												

						} else {
							alert('Internal error.')
						}
						
					}
				})
				
				
			}

			
	});

	

	$(document).on('click', '#back-btn', function(){
		window.history.back();
	})

	$('.wrapper').TrackpadScrollEmulator();
})
