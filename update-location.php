<?php
	require_once('core/init.php');
	
	$pageTitle = 'Update a Location';
	
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
	
	if(isset($_GET['locationid']) && is_numeric($_GET['locationid']))
	{
	    $location = $leagueOptions->getLocationById(escape($_GET['locationid']));

	    if(!$location)
	    {
	         die("Location not found");
	    }
	    else
	    {
	        $results = $location->results();
            $GroundName = $location->first()->GroundName;
            $Town = $location->first()->Town;
            $PostCode = $location->first()->PostCode;
            $LocationId = $location->first()->LocationId;
	    }
	}
	

	
if (Input::exists())
{
	if (Token::check(Input::get('token')))
	{
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'GroundName' => array(
				'name' => 'Ground Name',
				'min' => 5,
				'max' => 50,
				'required' => true
			) ,
			'Town' => array(
				'name' => 'Town',
				'min' => 3,
				'max' => 50
			) ,
			'PostCode' => array(
				'name' => 'Postcode',
				'min' => 3,
				'max' => 10
			)
		));
		if ($validation->passed())
		{
			try
			{
				$leagueOptions->updateLocation(array(
					'GroundName' => Input::get('GroundName') ,
					'Town' => Input::get('Town') ,
					'PostCode' => Input::get('PostCode')), 
                    Input::get('LocationId'));

				Session::flash('LocationUpdated', 'Locaion Updated Successfully');
				Redirect::to('locations.php');
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
				$errorDisplay = $errorDisplay . $error . "<br />";
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
                                            <label>Ground</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-home"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="GroundName" id="GroundName" placeholder="Ground Name" value="<?php if(isset($GroundName))  echo($GroundName); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label>Town</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="Town" id="Town" placeholder="Town" value="<?php if(isset($Town)) echo($Town);?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label>Post code</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-dot-circle-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="PostCode" id="PostCode" placeholder="Post code" value="<?php if(isset($PostCode)) echo($PostCode);?>">
                                                </div>
                                            </div>
                                    <div class="col-md-12 pull-right" style="padding: 0px !important">
                                        <input type="hidden" name="LocationId" id="LocationId" value="<?php echo($LocationId);?>">
                                        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Update Location</button>
                                    </div>
                                    </form>
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