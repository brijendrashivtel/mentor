<!doctype html>
<html  class="no-js" lang="en"  ng-app="myApp" ng-controller="loginController" ng-cloak>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("script-head.php"); ?>
   <link rel="stylesheet" href="<?php echo base_url("plugin/assets/css/styles.css"); ?>?v=0.4">
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
		<?php include_once('alert_message.php');?>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="post">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">UserName</label>
                            <input type="text" ng-model="formdata.username" autocomplete="off" required id="exampleInputEmail1">
                            <i class="ti-email"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" ng-model="formdata.pwd"  autocomplete="off"  required >
                            <i class="ti-lock"></i>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="button" ng-click="getLoginCheck(formdata);">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
  <?php include("footer.php"); ?>
</body>

</html>