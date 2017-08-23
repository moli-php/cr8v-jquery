<script>
"use strict";
$(function(){

	$("form").submit(function(){

    var formData = new FormData(this);

	    $.ajax({
	        url: CONFIG.base_url + 'api/save/<?= $id ?>',
	        type: 'post',
	        data: formData,
	        // async: false,
	        dataType : 'json',
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function (data) {
	           if(data.status == 400) {
	           		$('#file_error').html(data.error);
	           }else if(data.status == 200) {
	           		alert('Recipe updated... Redireting');
	           		if(CONFIG.category_type){
                    window.location.href = CONFIG.base_url + 'recipe/' + CONFIG.category_type;
                }else{
                    window.location.href = CONFIG.base_url;
                }
	           }else {
	           		alert('Internal server error.');
	           }


	        },

	    });

	    return false;
	});




})


</script>

<div id="form-content" class="col-md-8 col-md-offset-2">
<h1 class="text-center" id="form-title"><?= $title; ?> Recipe</h1>
<?= form_open_multipart(base_url() .'api/save',['class' => 'form-horizontal', 'autocomplete'=> 'off'], ['category_id' => $category_id]); ?>

  <div class="form-group">
    <label class="control-label col-sm-3" for="name">Recipe <span class="required">*</span></label>
    <div class="col-sm-9">
    <?php $name = isset($name) ? $name : ''; ?>
    <?= form_input(['class' => 'form-control', 'id' => 'name', 'name' => 'name', 'placeholder' => 'Enter recipe name', 'required' => '', 'value' => $name]); ?>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3" for="ingredients">Ingredients <span class="required">*</span></label>
    <div class="col-sm-9"> 
    <?php $ingredients = isset($ingredients) ? $ingredients : ''; ?>
    <?= form_textarea(['class' => 'form-control', 'name' => 'ingredients', 'id' => 'ingredients', 'rows' => 6, 'placeholder' => 'Enter your ingredients', 'required' => '', 'value' => $ingredients]) ?>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-3" for="directions">Directions <span class="required">*</span></label>
    <div class="col-sm-9">
	<?php $directions = isset($directions) ? $directions : ''; ?>
     <?= form_textarea(['class' => 'form-control', 'name' => 'directions', 'id' => 'directions', 'rows' => 6, 'placeholder' => 'Enter directions', 'required' => '', 'value' => $directions]) ?>
    </div>
  </div>

  <div class="form-group">
  	 <label class="control-label col-sm-3" for="directions">Preparation time <span class="required">*</span></label>
  	 <div class="col-sm-9">
  	 <?php $preparation_time = isset($preparation_time) ? $preparation_time : ''; ?>
  	 <?= form_dropdown('preparation_time', $options, $preparation_time , ['class' => 'form-control', 'required' => '']); ?>
  	 </div>
  </div>

  <div class="form-group">
  	 <label class="control-label col-sm-3" for="directions">Upload recipe</span></label>
  	 <div class="col-sm-9">
				<span id="file_error"></span>
		  	 <div class="text-secondary"><i>Note : 2mb max size and dimension 1920 x 1920 max</i></div>
			<?= form_upload(['name'=> 'image', 'class' => 'form-control']); ?>
  	 </div>
  </div>
 
  <div class="form-group"> 
    <div class="col-sm-offset-9 col-sm-12">
      <button type="submit" class="btn btn-primary">Submit</button>
      <?= anchor(base_url(), 'Cancel', ['class' => 'btn btn-default']); ?>
    </div>
  </div>
</form>
    
</div>