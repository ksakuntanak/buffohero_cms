<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li class="<?php if ($current_menu == "Home") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>"><i class="fa fa-home"></i> <span class="name">Home</span></a>
        </li>
        <li class="<?php if ($current_menu == "Users") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>user"><i class="fa fa-users"></i> <span class="name">Users</span></a>
        </li>
        <!--li class="<?php if ($current_menu == "Employers") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>employer"><i class="fa eicon-vcard"></i> <span class="name">Employers</span></a>
        </li-->
        <li class="<?php if ($current_menu == "Employees") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>employee"><i class="fa eicon-users"></i> <span class="name">Employees</span></a>
        </li>
        <li class="<?php if ($current_menu == "Jobs") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>job"><i class="fa fa-briefcase"></i> <span class="name">Jobs</span></a>
        </li>
        <li class="<?php if ($current_menu == "Payments") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>payment"><i class="fa fa-barcode"></i> <span class="name">Payments</span></a>
        </li>
        <li class="<?php if ($current_menu == "Blogs") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>blog"><i class="fa fa-rss"></i> <span class="name">Blogs</span></a>
        </li>
        <li class="<?php if ($current_menu == "News") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>news"><i class="fa eicon-newspaper"></i> <span class="name">News</span></a>
        </li>
        <li class="<?php if ($current_menu == "Clients") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>client"><i class="fa fa-smile-o"></i> <span class="name">Clients</span></a>
        </li>
        <li class="<?php if ($current_menu == "Helps") { ?>active<?php } else { ?>panel<?php } ?>">
            <a href="<?php echo Fuel\Core\Uri::base(); ?>help"><i class="fa fa-question-circle"></i> <span class="name">Helps</span></a>
        </li>
    </ul>
</nav>