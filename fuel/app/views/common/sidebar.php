<?php
    $controller = Uri::segment(1);
    $method = strlen(Uri::segment(2))?Uri::segment(2):"index";
    //print_r($controller."/".$method);
?>
<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li class="<?php if($controller == 'home') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::base(); ?>"><i class="fa fa-home"></i> <span class="name">Home</span></a>
        </li>
        <li class="<?php if($controller == 'user') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('user'); ?>"><i class="fa fa-users"></i> <span class="name">Users</span></a>
        </li>
        <!--li class="<?php if($controller == 'employer') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('employer'); ?>"><i class="fa eicon-vcard"></i> <span class="name">Employers</span></a>
        </li-->
        <li class="<?php if($controller == 'employee') { ?>active<?php } else { ?>panel<?php } ?>">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#employee-collapse">
                <i class="fa eicon-users"></i> <span class="name">Employees</span>
            </a>
            <ul id="employee-collapse" class="panel-collapse<?php if($controller == 'employee') { ?> open in<?php } else {?> collapse<?php } ?>">
                <li <?php if($controller == 'employee' && ($method == 'index' || $method == 'view')) { ?>class="active"<?php } ?>>
                    <a href="<?php echo Uri::create('employee'); ?>">All</a>
                </li>
                <li <?php if($controller == 'employee' && $method == 'staffPicks') { ?>class="active"<?php } ?>>
                    <a href="<?php echo Uri::create('employee/staffPicks'); ?>">Staff Picks</a>
                </li>
            </ul>
        </li>
        <li class="<?php if($controller == 'job') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('job'); ?>"><i class="fa fa-briefcase"></i> <span class="name">Jobs</span></a>
        </li>
        <li class="<?php if($controller == 'payment') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('payment'); ?>"><i class="fa fa-barcode"></i> <span class="name">Payments</span></a>
        </li>
        <li class="<?php if($controller == 'blog') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('blog'); ?>"><i class="fa fa-rss"></i> <span class="name">Blogs</span></a>
        </li>
        <li class="<?php if($controller == 'news') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('news'); ?>"><i class="fa eicon-newspaper"></i> <span class="name">News</span></a>
        </li>
        <li class="<?php if($controller == 'client') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('client'); ?>"><i class="fa fa-smile-o"></i> <span class="name">Clients</span></a>
        </li>
        <li class="<?php if($controller == 'help') { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Uri::create('help'); ?>"><i class="fa fa-question-circle"></i> <span class="name">Helps</span></a>
        </li>
    </ul>
</nav>