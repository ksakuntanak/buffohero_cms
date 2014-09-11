<html>
<head>
    <title>Buffo Hero CMS - <?php echo $current_menu; ?></title>
    <link href="<?php echo Fuel\Core\Uri::base(); ?>public/assets/css/application.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo Fuel\Core\Uri::base(); ?>public/assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
</head>
<body class="">
<div class="logo">
    <h4><a href="<?php echo Fuel\Core\Uri::base(); ?>">BuffoHero <strong>CMS</strong></a></h4>
</div>
<?php echo $partials['sidebar']; ?>
<div class="wrap">
    <header class="page-header">
        <div class="navbar">
            <ul class="nav navbar-nav navbar-right pull-right">
                <li class="hidden-xs"><a href="#"><i class="fa fa-user"></i></a></li>
                <li class="hidden-xs"><a href="<?php echo Fuel\Core\Uri::base(); ?>user/logout"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
    </header>
    <div class="content container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title"><?php echo $current_menu; ?> <small><?php echo $current_menu_desc; ?></small></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $partials['content']; ?>
            </div>
        </div>
    </div>
</div>

<!-- jquery and friends -->
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/jquery/jquery-2.0.3.min.js"></script>


<!-- jquery plugins -->
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/parsley/parsley.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/icheck.js/jquery.icheck.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/select2.js"></script>


<!--backbone and friends -->
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/backbone/underscore-min.js"></script>

<!-- bootstrap default plugins -->
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/transition.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/collapse.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/alert.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/tooltip.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/popover.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/button.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/dropdown.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap/modal.js"></script>

<!-- bootstrap custom plugins -->
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap-datepicker.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap-select/bootstrap-select.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/wysihtml5/wysihtml5-0.3.0_rc2.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/lib/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<!-- basic application js-->
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/js/app.js"></script>
<script src="<?php echo Fuel\Core\Uri::base(); ?>public/assets/js/settings.js"></script>

<!-- page specific -->

<script type="text/javascript">
    $(document).ready(function(){

    });
</script>
</html>

