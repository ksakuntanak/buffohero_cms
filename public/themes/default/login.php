<!DOCTYPE html>
<html>
<head>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <title>Buffo Hero CMS - <?php echo $current_menu; ?></title>
    <link href="<?php echo Fuel\Core\Uri::base(); ?>public/assets/css/application.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo Fuel\Core\Uri::base(); ?>public/assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <script src="<?php echo Uri::create('public/assets/lib/jquery/jquery-2.0.3.min.js'); ?>"> </script>
    <script src="<?php echo Uri::create('public/assets/lib/backbone/underscore-min.js'); ?>"></script>
    <script src="<?php echo Uri::create('public/assets/js/settings.js'); ?>"> </script>
</head>

<body class="">
    <div class="single-widget-container">
        <section class="widget login-widget">
            <header class="text-align-center">
                <h4>BuffoHero CMS</h4>
            </header>
            <div class="body">
                <?php echo Form::open(array("class" => "no-margin")); ?>

                    <fieldset>
                        <div class="form-group no-margin">
                            <label for="email">Username</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="eicon-user"></i>
                                </span>
                                <input id="username" name="username" type="text" class="form-control input-lg" placeholder="Your Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <input id="password" name="password" type="password" class="form-control input-lg" placeholder="Your Password">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-actions" style="padding:20px 15px;">
                        <button type="submit" class="btn btn-block btn-lg btn-danger">
                            <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                            <small>เข้าสู่ระบบ</small>
                        </button>
                    </div>

                <?php echo Form::close(); ?>
            </div>
        </section>
    </div>
</body>
</html>