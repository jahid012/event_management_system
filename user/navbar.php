
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		background: url(assets/uploads/1602641160_JSAV-multiscreen_3ddbdd40-38d9-4b64-9cf2-5d0ef356f29c.jpg) !important
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
				<a href="index.php?page=events" class="nav-item nav-events"><span class='icon-field'><i class="fa fa-calendar"></i></span> Manage Events</a>
				<a href="index.php?page=audience_report" class="nav-item nav-events"><span class='icon-field'><i class="fa fa-calendar"></i></span> Audience Report</a>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
