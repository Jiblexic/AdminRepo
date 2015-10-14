<?php
	require_once('core/init.php');
	
	$pageTitle = 'View Fixtures';
	
	$user = new User();
	
	if(!$user->isLoggedIn())
	{
	    Redirect::to('login.php');
	}
	
	// Defaults
	$style = '';
	$displayErrors = "none";
	$errorDisplay = "";
	
	$fixture = new Fixture();
	
	if(isset($_GET['team']) && is_numeric($_GET['team']))
	{
	    $teamId = escape($_GET['team']);
	    $fixtures = $fixture->getAllMatches($teamId);
	    
	    if(!$fixtures->count())
	    {
	         $teamName = "";
	         $errorMessage = "No fixtures to display, <a href='add-fixture.php'>Click here to add a fixture</a>";
	    }
	    else
	    {
	        $teamName = " - " . $fixtures->first()->Name;
	        $fixtures = $fixtures->results();
	    }
	}
    else if(isset($_GET['delete']) && $_GET['delete'] == true && isset($_GET['matchid']) && is_numeric($_GET['matchid']))
    {
        try
        {
            $matchId = escape($_GET['matchid']);
            $fixture->delete($matchId);

            Session::flash('deleted', 'Fixture Deleted Successfully');
            Redirect::to('fixtures.php');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

	else
	{
	    $fixtures = $fixture->getAllMatches()->results();
	    $teamName = "";
	}
	
	
	?>
<!DOCTYPE html>
<html>
	<?php include_once('includes/htmlhead.php')?>
	<body class="skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include_once('includes/header.php')?>
			<?php include_once('includes/sidebar.php')?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						View Fixtures
					</h1>
				</section>
				<!-- Main content -->
				<section class="content">
					<?php
						if(Session::exists('success'))
						{                  
						echo('<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
							' . Session::flash("success") . '</div>');
						}
                        
                        if(Session::exists('deleted'))
						{                  
						echo('<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
							' . Session::flash("deleted") . '</div>');
						}
                        if(Session::exists('fixtureUpdated'))
						{                  
						echo('<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
							' . Session::flash("fixtureUpdated") . '</div>');
						}
                        ?>
					<div class="row">
                        <div class="col-md-3">
							<div class="info-box bg-green">
								<a href="fixtures.php"><span class="info-box-icon" style="font-size: 30px; width:  100%; color: #fff">All</span></a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="info-box bg-red">
								<a href="fixtures.php?team=1"><span class="info-box-icon" style="font-size: 30px; width:  100%; color: #fff">1st's</span></a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="info-box bg-blue">
								<a href="fixtures.php?team=2"><span class="info-box-icon" style="font-size: 30px; width:  100%; color: #fff">2nd's</span></a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">Fixtures & Results <?php echo($teamName);?></h3>
								</div>
								<div class="box-body">
									<?php if(isset($errorMessage) && strlen($errorMessage)) 
										{ 
										    echo( $errorMessage); 
										} 
										else 
										{
                                    ?>
									<table class="table table-bordered table-hover" id="example2" style="border:  none">
										<thead>
											<tr>
												<th>Competition</th>
												<th>Date</th>
												<th>Fixture</th>
												<th>Location</th>
                                                <th>Result</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$confirmDelete = "'Are you sure you want to delete this fixture?'";
												
												foreach($fixtures as $fixtureDisplay)
												{
												    if(strlen($fixtureDisplay->Score))
												    {
												        $scoreOrVs = " " . $fixtureDisplay->Score . " ";
												    }
                                                    else
                                                    {
                                                        $scoreOrVs = " vs ";
                                                    }

                                                    switch($fixtureDisplay->Result)
                                                    {
                                                        case "win":
                                                            $result = '<span class="badge bg-green">Won</span>';
                                                        break;
                                                        case "lose":
                                                            $result = '<span class="badge bg-red">Lost</span>';
                                                        break;
                                                        case "draw":
                                                            $result = '<span class="badge bg-yellow">Drew</span>';
                                                        break;
                                                        default:
                                                            $result = '<span class="badge bg-blue">Fixture</span>';
                                                        break;
                                                    }

												
												    $cleanDate = strtotime($fixtureDisplay->Date);
												    $date = date("d-m-Y", $cleanDate);
												    $time = $fixtureDisplay->KickOff;
												
												    
												    if($fixtureDisplay->HomeGame == "TRUE")
												    {
												        echo('<tr><td>' . $fixtureDisplay->CompetitionName . '</td><td>' . $date . ' | ' . $time . '</td><td>' .  $fixtureDisplay->Name . $scoreOrVs . $fixtureDisplay->OpponentName . '</td><td>' . $fixtureDisplay->GroundName . ', ' . $fixtureDisplay->Town . ', ' . $fixtureDisplay->Postcode . '</td><td>' . $result . '</td><td><a href="update-fixture.php?matchId=' . $fixtureDisplay->MatchId . '"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="fixtures.php?delete=1&matchid=' . $fixtureDisplay->MatchId . '" style="color: #ff0000" onclick="return confirm(' . $confirmDelete . ');"><i class="fa fa-minus-circle"></i></a></td></tr>');
												    }
												    else
												    {
												        echo('<tr><td>' . $fixtureDisplay->CompetitionName . '</td><td>' . $date . ' | ' . $time . '</td><td>' .  $fixtureDisplay->OpponentName . $scoreOrVs . $fixtureDisplay->Name . '</td><td>' . $fixtureDisplay->GroundName . ', ' . $fixtureDisplay->Town . ', ' . $fixtureDisplay->Postcode . '</td><td>' . $result . '</td><td><a href="update-fixture.php?matchId=' . $fixtureDisplay->MatchId . '"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="fixtures.php?delete=1&matchid=' . $fixtureDisplay->MatchId . '" style="color: #ff0000" onclick="return confirm(' . $confirmDelete . ');"><i class="fa fa-minus-circle"></i></a></td></tr>');
												    }
												
												}
												?>
										</tbody>
									</table>
									<?php } ?>
									<!-- /.col -->
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		</div>
		</form>
		</section>
		</div>
		<!-- /.content-wrapper -->
		<?php include_once('includes/footer.php') ?>
		</div>
		<!-- ./wrapper -->
		<!-- jQuery 2.1.4 -->
		<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.2 JS -->
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<!-- FastClick -->
		<script src='plugins/fastclick/fastclick.min.js'></script>
		<!-- AdminLTE App -->
		<script src="dist/js/app.min.js" type="text/javascript"></script>
		<!-- Sparkline -->
		<script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
		<!-- jvectormap -->
		<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
		<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
		<!-- SlimScroll 1.3.0 -->
		<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<!-- ChartJS 1.0.1 -->
		<script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>
		<!-- bootstrap time picker -->
		<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<!-- bootstrap time picker -->
		<script src="plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
		<!-- Bootstrap time Picker -->
		<link href="plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
		<!-- DATA TABES SCRIPT -->
		<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function () {
			    //Datepicker
			    $("#datepicker").datepicker({ format: 'dd/mm/yyyy' });
			
			    //Timepicker
			    $(".timepicker").timepicker({ showMeridian: false  });
			});
			
			
		</script>
		<script type="text/javascript">
			$(function () {
			  $("#example1").dataTable();
			  $('#example2').dataTable({
			    "bPaginate": true,
			    "bLengthChange": false,
			    "bFilter": false,
			    "bSort": false,
			    "bInfo": true,
			    "bAutoWidth": false
			  });
			});
		</script>
	</body>
</html>