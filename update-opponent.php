<?php
	require_once('core/init.php');
	
	$pageTitle = 'Update an Opponent';
	
	$user = new User();
	
	if(!$user->isLoggedIn())
	{
	    Redirect::to('login.php');
	}

    // Defaults
	$style = '';
	$displayErrors = "none";
	$errorDisplay = "";
	
	$leagueOptions = new League();
	
	if(isset($_GET['opponentId']) && is_numeric($_GET['opponentId']))
	{
	    $opponent = $leagueOptions->getOpponentById(escape($_GET['opponentId']));

	    if(!$opponent)
	    {
	         die("Opponent not found");
	    }
	    else
	    {
	        $results = $opponent;
	    }
	}
	

	
	if(Input::exists())
	{
	 if(Token::check(Input::get('token')))
	 {
	     $validate = new Validation();
	     $validation = $validate->check($_POST, array(
	         'OpponentName' => array(
	             'name' => 'Opponent',
                 'min' => 5,
                 'max' => 50,
	             'required' => true)));
	
	     if($validation->passed())
	     {               
	         try
	         {
	            $leagueOptions->updateOpponent(array(
	                'OpponentName' => Input::get('OpponentName')),
                    Input::get('OpponentId'));
	
	             Session::flash('OpponentUpdated', 'Opponent Updated Successfully');
	             Redirect::to('opponents.php');
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
						Update an Opponent
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
										<h3 class="box-title">Update an Opponent</h3>
									</div>
									<div class="box-body">
                                        <p style="color: #ff0000; display: <?php echo $displayErrors?>"><?php echo $errorDisplay ?></p>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>Opponent Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-futbol-o"></i>
                                                    </div>
                                                    <?php
                                                        foreach($results as $opponentResult)
                                                        {
                                                            echo('<input type="text" class="form-control" name="OpponentName" id="OpponentName" placeholder="Opponent" value="' . $opponentResult->OpponentName . '">');
                                                            echo('<input type="hidden" name="OpponentId" value="' . $opponentResult->OpponentId . '">');
                                                        }
                                                    ?>
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