	</div> <!-- content-body -->
<div class="clearfix"></div>
	<footer class="footer fixed-bottom text-center">
	  <div class="container">
		<ul class="footer-nav">
			<li><a href="<?= base_url(); ?>">Home</a></li>
			<?php foreach($categories as $category) { ?>
			<li><a href="<?= base_url(); ?>recipe/<?= $category->url; ?>"><?= $category->name; ?></a></li>
			<?php }  ?>
		</ul>
		<p>Recipes @<?= date("Y"); ?>, All Rigths Reserved.</p>
	  </div>
	</footer>
</div>
<script src="<?php echo base_url(); ?>assets/js/ie10-viewport-bug-workaround.js"></script>
<input type="hidden" id="base_url" value="<?= base_url(); ?>" />

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Category</h4>
      </div>
      <div class="modal-body" id="caterogy-buttons">
      		<?php foreach($categories as $category) { ?>
        	<a href="<?= base_url() .'recipe/add/'. $category->url; ?>" class="btn btn-primary"><?= $category->name; ?></a>

        	<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Globals -->
<script>

var CONFIG = {
	base_url : document.getElementById('base_url').value,
	empty_record : 'Recipe empty.',
	category_type : '<?= $this->uri->segment(3, 0); ?>',
	category : {
		appetizer : 1,
		soup : 2,
		main_dish : 3,
		dessert : 4
	}
}

var _template = function(data) {

	var	str = '<div class="panel panel-default" id="panel_'+data.id+'">\
				<div class="panel-body">\
					<div class="col-md-4 left image-container">\
						<img src="'+data.image+'" />\
					</div>\
					<div class="col-md-8 row right">\
						<div class="pull-right action-btn">\
							<a href="'+CONFIG.base_url+'recipe/update/'+(data.category_name.split(' ').join('_')).toLowerCase()+'/'+data.id+'"><span class="glyphicon glyphicon-pencil"></span></a>\
							<a href="javascript:void(0)" data-id="'+data.id+'" class="delete"><span class="glyphicon glyphicon-trash"></span></a>\
						</div>\
						<div id="title">'+data.name+'</div>\
						<div id="category">'+data.category_name+'</div>\
						<div id="ingredient">Ingredient</div>\
						<p id="ingredient-text">'+limitText(data.ingredients)+'</p>\
						<div id="read-more"><a href="<?= base_url() ?>recipe/details/'+data.id+'">Read More</a></div>\
					</div>\
				</div>\
			</div>';

	return str;
}

var _details_template = function(data) {

	 var str =   '<div class="panel panel-default">\
		            <div class="panel-body ">\
		                <div id="back-btn" class="pull-left" title="Go Back"></div>\
		                	<div class="image-container-details">\
		                 		<img src="'+data.image+'">\
		                 	</div>\
		                <div class="">\
		                    <h4 id="title">'+data.name+'</h4>\
		                    <div id="category">'+data.category_name+'</div>\
		                    <div id="ingredient">Preparation Time</div>\
		                    <p>'+data.preparation_time+'</p>\
		                    <div id="ingredient">Ingredient</div>\
		                    <p id="ingredient-text">'+data.ingredients+'</p>\
		                    <div id="ingredient">Directions</div>\
		                    <p id="ingredient-text">'+data.directions+'</p>\
		                </div>\
		            </div>\
		        </div>';
        return str;
}

var limitText = function(text) {	
	var limit = 260;
	if(text.length > limit) {
		return text.substring(0, limit) + ' ...';
	}else{
		return text;
	}
}

</script>
</body>
</html>