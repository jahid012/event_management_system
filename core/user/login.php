<?php  session_start();
include('./db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Event Management System</title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:user/dashboard");

?>

</head>

<body style="background-color: #508bfc;">
  <section class="vh-50" >
  <div class="container py-5 h-50">
    <div class="row d-flex justify-content-center align-items-center h-50">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
			<form id="login-form" >
				<h3 class="mb-5">Sign in</h3>

				<div data-mdb-input-init class="form-outline mb-4">
				<input type="email" name="email" placeholder="Email" id="typeEmailX-2" class="form-control form-control-lg" />
				</div>

				<div data-mdb-input-init class="form-outline mb-4">
				<input type="password" name="password" id="typePasswordX-2" placeholder="Password" class="form-control form-control-lg" />
				</div>

				<button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
				<p class="mt-2">Don't have an account? <a href="register">Register here.</a></p>
			</form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="submit"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'api?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="submit"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='/user/dashboard';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>