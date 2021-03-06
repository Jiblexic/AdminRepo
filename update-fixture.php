<?php
	require_once('core/init.php');
	
	$pageTitle = 'Update a Fixture';
	
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
	
	if(isset($_GET['matchId']) && is_numeric($_GET['matchId']))
	{
	    $fixtures = $fixture->getMatch(escape($_GET['matchId']));
	    
	    if($fixtures->count())
	    {
	         $results = $fixture->getMatch(escape($_GET['matchId']))->results();
	    }
	    else
	    {
	        die("Match not found");
	    }
	}
	

	
	if(Input::exists())
	{
	 if(Token::check(Input::get('token')))
	 {
	     $validate = new Validation();
	     $validation = $validate->check($_POST, array(
	         'homeScore' => array(
	             'name' => 'Home Score',
	             'required' => true),
	         'awayScore' => array(
	             'name' => 'Away Score',
	             'required' => true),
	         'result' => array(
	             'name' => 'Result',
	             'required' => true)));
	
	     if($validation->passed())
	     {
             $score = Input::get('homeScore') . " - " . Input::get('awayScore');
	                
	         try
	         {
	             $fixture->update(array(
	                 'Score' => $score,
                     'Result' => Input::get('result')), Input::get('matchId'));
	
	             Session::flash('fixtureUpdated', 'Fixture Updated Successfully');
	             Redirect::to('fixtures.php');
	         }
	         catch(Exception $e)
	         {
	             die($e->getMessage());
	         }
	
	         $displayErrors = "none";
	
	     }
	     else
	     {
	         $errorDisplay = "";
	         $displayErrors = "block";
	         foreach($validation->errors() as $error)
	         {
	             $errorDisplay = $errorDisplay . $error . "<br>";
	         }
	     }
	 }
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
						Update a fixture
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Dashboard</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-6">
							<form action="" method="post">
								<div class="box box-primary">
									<div class="box-header">
										<h3 class="box-title">Update a Fixture</h3>
									</div>
									<div class="box-body">
										<?php
											foreach($results as $match)
											{
                                                echo('<input type="hidden" name="matchId" value="' .  $match->MatchId . '">');
											    /** Team **/
											    echo('<div class="form-group">
											            <label>Pick a Team</label>
											                <div class="input-group">
											                    <div class="input-group-addon">
											                        <i class="fa fa-futbol-o"></i>
											                    </div>');
											
											    echo('<select disabled class="form-control" name="cheritonTeam" id="cheritonTeam"><option value="">' . $match->Name . '</option></select>');
											    echo('</div>
											        </div>');
											    /** Team End **/
											
											    /** Competition **/
											    echo('<div class="form-group">
											            <label>Competition</label>
											                <div class="input-group">
											                    <div class="input-group-addon">
											                            <i class="fa fa-trophy"></i>
											                         </div>');
											
											    echo('<select disabled class="form-control" name="competition" id="competition"><option value="">' . $match->CompetitionName . '</option></select>');
											    echo('</div>
											        </div>');
											    /** Competition End **/
											
											
											    /** Opponent **/
											    echo('<div class="form-group">
											            <label>Opponent</label>
											                <div class="input-group">
											                    <div class="input-group-addon">
											                            <i class="fa fa-users"></i>
											                         </div>');
											
											    echo('<select disabled class="form-control" name="opponent" id="opponent"><option value="">' . $match->OpponentName . '</option></select>');
											    echo('</div>
											        </div>');
											    /** Opponent End **/
											                                  
											    if($match->HomeGame == "TRUE")
											    {
											        $home = "Home";
											    }
											    else
											    {
											        $home = "Away";
											    }
											
											                                     
											    /** Home **/
											    echo('<div class="form-group">
											            <label>Home or Away</label>
											                <div class="input-group">
											                    <div class="input-group-addon">
											                            <i class="fa fa-home"></i>
											                         </div>');
											
											
											    echo('<select disabled class="form-control" name="home" id="home"><option value="">' . $home . '</option></select>');
											    echo('</div>
											        </div>');
											          /** Home End **/
											
											                                     											    /** Home **/
											    echo('<div class="form-group">
											            <label>Home or Away</label>
											                <div class="input-group">
											                    <div class="input-group-addon">
											                            <i class="fa fa-map-marker"></i>
											                         </div>');
											
											
											    echo('<input type="text" disabled class="form-control" name="location" id="location" value="' . $match->GroundName . ', ' . $match->Town . ', ' . $match->Postcode . '">');
											    echo('</div>
											        </div>');
											          /** Home End **/
											}
											?>
										<div class="form-group">
											<label>Score</label>
											<div class="input-group">
												<?php 
													if($results{0}->HomeGame == "TRUE")
													{
													    echo($results{0}->Name . '&nbsp;&nbsp; <input type="number" min="0" style="width: 7% !important" name="homeScore">&nbsp;&nbsp; - &nbsp;&nbsp;<input type="number" min="0" style="width: 7% !important" name="awayScore"> &nbsp;&nbsp;' . $results{0}->OpponentName);
													}
													else
													{
													    echo($results{0}->OpponentName . ' &nbsp;&nbsp;<input type="number" min="0" style="width: 7% !important" name="homeScore">&nbsp;&nbsp; - &nbsp;&nbsp;<input type="number" min="0" style="width: 7% !important" name="awayScore"> &nbsp;&nbsp;' . $results{0}->Name);
													}
													
													?>

											</div>
										</div>
										<div class="form-group">
											<label>Result</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-check"></i>
												</div>
												<select class="form-control" name="result" id="result">
													<option value="win">Win</option>
													<option value="draw">Draw</option>
													<option value="lose">Lose</option>
												</select>
											</div>
										</div>
										<div class="col-xs-12 pull-right" style="padding: 0px !important">
											<input type="hidden" name="token" value="<?php echo Token::generate();?>">
											<button type="submit" class="btn btn-primary btn-block btn-flat">Update Fixture</button>
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
		<script type="text/javascript">
			$(function () {
			    //Datepicker
			    $("#datepicker").datepicker({ format: 'dd/mm/yyyy' });
			
			    //Timepicker
			    $(".timepicker").timepicker({ showMeridian: false, showInputs: false  });
			});
			
			
		</script>
	</body>
</html>