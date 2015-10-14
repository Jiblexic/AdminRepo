<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<!-- search form -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search..."/>
				<span class="input-group-btn">
				<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">Navigation</li>
			<li>
				<a href="index.php">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
				<i class="fa fa-envelope"></i>
				<span>Message Board</span>
				<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i>General</a></li>
					<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Firsts</a></li>
					<li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i>Seconds</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
				<i class="fa fa-bars"></i>
				<span>Teams</span>
				<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="add-fixture.php"><i class="fa fa-circle-o"></i>Add a team</a></li>
					<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Manage a team</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>View teams</a></li>
				</ul>
			</li>
            <li class="treeview">
				<a href="#">
				<i class="fa fa-users"></i>
				<span>Players</span>
				<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="add-fixture.php"><i class="fa fa-circle-o"></i>Add a player</a></li>
					<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Edit a player</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>View players</a></li>
				</ul>
			</li>
			<li class="treeview" <?php echo $style;?>>
				<a href="#">
				<i class="fa fa-futbol-o"></i>
				<span>Fixtures</span> 
				<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="add-fixture.php"><i class="fa fa-circle-o"></i>Add a fixture</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>View fixtures<i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="fixtures.php"><i class="fa fa-circle-o"></i>All Fixtures</a></li>
                        <li><a href="fixtures.php?team=1"><i class="fa fa-circle-o"></i>1st Team</a></li>
                        <li><a href="fixtures.php?team=2"><i class="fa fa-circle-o"></i>2nd Team</a></li>
                    </ul>
                    </li>
				</ul>
			</li>
            <li class="treeview">
				<a href="#">
				<i class="fa fa-trophy"></i>
				<span>League Control</span>
				<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="opponents.php"><i class="fa fa-circle-o"></i>Opponents</a></li>
					<li><a href="locations.php"><i class="fa fa-circle-o"></i>Locations</a></li>
                    			<li><a href="competitions.php"><i class="fa fa-circle-o"></i>Competitions</a></li>
				</ul>
			</li>
            <li class="treeview">
				<a href="#">
				<i class="fa fa-calendar"></i>
				<span>Events</span>
				<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="opponents.php"><i class="fa fa-circle-o"></i>Opponents</a></li>
					<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Locations</a></li>
                    			<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Competitions</a></li>
				</ul>
			</li>
			</li>
			<li class="header">User Control</li>
				<li><a href="manage.php"><i class="fa fa-circle-o text-yellow"></i> <span>Manager Users</span></a></li>
				<li><a href="update.php"><i class="fa fa-circle-o text-aqua"></i> <span>Update Account</span></a></li>
				<li><a href="logout.php"><i class="fa fa-circle-o text-red"></i> <span>Logout</span></a></li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>