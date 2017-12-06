<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../../"><b>Seven Contract LLC.</b></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="signout.php"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"><i class="fa fa-table fa-fw"></i> Main Section<span class="fa arrow"></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="worksheet.php"><i class="fa fa-table fa-fw"></i> Worksheet</a>
                        </li>
                        <?php
                            if (isset($_SESSION['isadmin']))
                            if ($_SESSION['isadmin'] > 0) {
                                echo '
                                    <li>
                                        <a href="worksheet_add.php"><i class="fa fa-edit fa-fw"></i> Add Worksheet</a>
                                    </li>
                                    <li>
                                        <a href="view_estimate.php"><i class="fa fa-table fa-fw"></i> View Estimate</a>
                                    </li>
                                    <li>
                                        <a href="estimate_info.php"><i class="fa fa-edit fa-fw"></i> Make Estimate</a>
                                    </li>
                                ';
                                if ($_SESSION['isadmin'] == 2) {
                                    echo '
                                        <li>
                                            <a href="price_detail.php"><i class="fa fa-table fa-fw"></i> Payment History</a>
                                        </li>
                                    ';        
                                }
                            }
                        ?>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="../../"><i class="fa fa-files-o fa-fw"></i> Back To Main</a>
                </li>
            </ul>
            <!-- nav-bar -->
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>