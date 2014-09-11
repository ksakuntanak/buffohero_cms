<!DOCTYPE html>
<html><head>
    <title>Light Blue - Admin Template</title>
    <link href="<?php echo Uri::base()?>public/assets/css/application.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo Uri::base()?>public/assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <script src="<?php echo Uri::base()?>public/assets/lib/jquery/jquery-2.0.3.min.js"> </script>
    <script src="<?php echo Uri::base()?>public/assets/lib/backbone/underscore-min.js"></script>
    <script src="<?php echo Uri::base()?>public/assets/js/settings.js"> </script>
</head>
<body style="" class="background-dark">
<div class="single-widget-container">
    <section class="widget login-widget">
        <header class="text-align-center">
            <h4>Login to your account</h4>
        </header>
        <div class="body">
            <form class="no-margin" action="index.html" method="get">
                <fieldset>
                    <div class="form-group no-margin">
                        <label for="email">Email</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="eicon-user"></i>
                                </span>
                            <input id="email" type="email" class="form-control input-lg" placeholder="Your Email">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                            <input id="password" type="password" class="form-control input-lg" placeholder="Your Password">
                        </div>

                    </div>
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="btn btn-block btn-lg btn-danger">
                        <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                        <small>Sign In</small>
                    </button>
                    <div class="forgot"><a class="forgot" href="#">Forgot Username or Password?</a></div>
                </div>
            </form>
        </div>
        <footer>
            <div class="facebook-login">
                <a href="<?php echo Uri::base()?>auth/oauth/facebook"><span><i class="fa fa-facebook-square fa-lg"></i> LogIn with Facebook</span></a>
            </div>
        </footer>
    </section>
</div>

</body></html>