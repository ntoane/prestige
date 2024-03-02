<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="<?=base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?=base_url();?>assets/css/sb-admin.css" rel="stylesheet">
    <style type="text/css">
    .bg-login-image {
        background: url("<?=base_url() . 'assets/images/logo.jpeg';?>");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100%;
    }

    body {
        overflow: hidden;
    }

    .btn-primary {
        background-color: #485683;
        border: 1px solid #485683;
    }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="row" style="height: 300px; background-color: #f1592a; border-bottom: 20px solid #ffffff;">
        <div class="col-lg-12 pt-3">
            <h2 class="text-white text-center" style="text-transform: uppercase;"> P r e s t i g e <br /> P a y r o l
                l - S y s t e m</h2>
        </div>
    </div>
    <div class="row" style="border-top: 20px solid #485683;">
        <div class="col-lg-12">
            <div class="container" style="margin-top: -250px;">

                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                    <div class="col-lg-6">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                                <p class="mb-4">We get it, stuff happens. Just enter your email address
                                                    below and we'll send you your password!</p>
                                                <p class="text-danger">
                                                    <?php
if (!empty($this->session->flashdata())) {
    echo $this->session->flashdata('text');
}
?>
                                                </p>
                                            </div>
                                            <form class="user" action="<?=base_url() . 'login/send_password';?>"
                                                method="POST">
                                                <div class="form-group">
                                                    <input type="email" class="form-control form-control-user"
                                                        name="email" id="exampleInputEmail" aria-describedby="emailHelp"
                                                        placeholder="Enter Email Address..." required="">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Send Password
                                                </button>
                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                <a class="small" href="<?=base_url() . 'login';?>">Already have an
                                                    account? Login!</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url();?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>