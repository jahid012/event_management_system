<?php session_start();
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
    if (isset($_SESSION['register_id']))
        header("location:/user/home");

    ?>

</head>

<body style="background-color: #508bfc;">
    <section class="vh-50" style="background-color: #508bfc;">
        <div class="container py-5 h-50">
            <div class="row d-flex justify-content-center align-items-center h-50">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form id="register-form">
                                <h3 class="mb-5">Register</h3>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" name="name" placeholder="Name" id="typeNameX-2" class="form-control form-control-lg" required />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" name="email" placeholder="Email" id="typeEmailX-2" class="form-control form-control-lg" required />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" name="phone" placeholder="phone" id="typePhoneX-2" class="form-control form-control-lg" required />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" name="password" id="typePasswordX-2" placeholder="Password" class="form-control form-control-lg" required />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" name="c_password" id="typePasswordX-2" placeholder="Confirm Password" class="form-control form-control-lg" required />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" name="address" id="typeAddressX-2" placeholder="Address" class="form-control form-control-lg" required />
                                </div>
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Register</button>
                                <p class="mt-2">Already have an account? <a href="login">Login here.</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




</body>
<script>
    $('#register-form').submit(function(e) {
        e.preventDefault()
        $('#register-form button[type="submit"]').attr('disabled', true).html('Registering...');
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'api?action=register',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                $('#register-form button[type="submit"]').removeAttr('disabled').html('Register');

            },
            success: function(resp) {
                $('#register-form button[type="submit"]').removeAttr('disabled').html('Register');

                if (resp == 1) {
                    location.href = '/user/dashboard';
                } else if (resp == 2) {

                    $('#register-form').prepend('<div class="alert alert-danger">Email or Phone already Exists.</div>')
                    $('#register-form button[type="button"]').removeAttr('disabled').html('Register');
                } else if (resp == 3) {

                    $('#register-form').prepend('<div class="alert alert-danger">Password didn\'t matched.</div>')
                    $('#register-form button[type="button"]').removeAttr('disabled').html('Register');
                } else {

                    $('#register-form').prepend('<div class="alert alert-danger">Something Went Wrong.</div>')
                    $('#register-form button[type="button"]').removeAttr('disabled').html('Register');
                }
            }
        })
    })
</script>

</html>