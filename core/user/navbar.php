<nav id="sidebar" class='mx-lt-5 bg-dark'>
	<div class="sidebar-list">
		<a href="/user/dashboard" class="nav-item nav-dashboard"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
		<a href="/user/events" class="nav-item nav-events"><span class='icon-field'><i class="fa fa-calendar"></i></span> Manage Events</a>
		<a href="/user/audience_report" class="nav-item nav-audience_report"><span class='icon-field'><i class="fa fa-users"></i></span> Audience Report</a>
	</div>

</nav>
<script>
	$('.nav_collapse').click(function() {
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>