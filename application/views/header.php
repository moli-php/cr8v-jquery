<!DOCTYPE html>
<html>
<head>
	<title>Recipies | <?= $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie10-viewport-bug-workaround.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/trackpad-scroll-emulator.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.trackpad-scroll-emulator.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/script.js"></script>
</head>
<body data-title="<?= $title; ?>">

<div class="container">
	<div id="logo">
		<div>
			<a href="<?= base_url(); ?>"><img src="<?= base_url() ?>assets/img/logo.jpg" height="70"/></a>
		</div>
	</div>
	<nav class="navbar navbar-default">
			<div class="navbar-header">
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="<?php if($menu_active == "Home"){echo "active";}  ?>" ><a href="<?= base_url(); ?>">Home</a></li>
					<?php foreach($categories as $category) { ?>
					<li class="<?php if($category->url == $menu_active){echo "active";} ?>"><a href="<?= base_url(); ?>recipe/<?= $category->url; ?>"><?= $category->name; ?></a></li>
					<?php } ?>
				</ul>
			</div>
	</nav>
	<div class="col-md-12" id="content-body">