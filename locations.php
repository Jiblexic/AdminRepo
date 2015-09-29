<?php
	require_once('core/init.php');
	
	$pageTitle = 'Locations';
	
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
	
    if(isset($_GET['delete']) && $_GET['delete'] == true && isset($_GET['locationid']) && is_numeric($_GET['locationid']))
    {
        try
        {
            $locationId = escape($_GET['locationid']);
            $leagueOptions->deleteLocation($locationId);

            Session::flash('deleted', 'Location Deleted Successfully');
            Redirect::to('locations.php');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    else
    {
        $locationResults = $leagueOptions->getLocations();
    }
    
    if(Input::exists())
    {
        if(Token::check(Input::get('token')))
        {
            $validate = new Validation();
	        $validation = $validate->check($_POST, array(
	            'GroundName' => array(
	                'name' => 'Ground Name',
                    'min' => 5,
                    'max' => 50,
	                'required' => true),
                'Town' => array(
                    'name' => 'Town',
                    'min' => 3,
                    'max' => 50),
                'PostCode' => array(
                    'name' => 'Postcode',
                    'min' => 3,
                    'max' => 10)));

            if($validation->passed())
            {
                
                try
                {
                    $leagueOptions->createLocation(array(
                        'GroundName' => Input::get('GroundName'),
                        'Town' => Input::get('Town'),
                        'PostCode' => Input::get('PostCode')));
	
                    Session::flash('locationCreation', 'Location created Successfully');
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
                    $errorDisplay = $errorDisplay . $error . "<br>";
                }

                echo $errorDisplay;
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
						View Locations
					</h1>
				</section>
				<!-- Main content -->
				<section class="content">
					<?php
						if(Session::exists('locationCreation'))
						{                  
						echo('<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
							' . Session::flash("locationCreation") . '</div>');
						}
                        
                        if(Session::exists('deleted'))
						{                  
						echo('<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
							' . Session::flash("deleted") . '</div>');
						}
                        if(Session::exists('LocationUpdated'))
						{                  
						echo('<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
							' . Session::flash("LocationUpdated") . '</div>');
						}
                        ?>
					<div class="row">

                    </div>
					<div class="row">
						<div class="col-md-6">
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">All Locations</h3>
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
												<th>Locations</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$confirmDelete = "'Are you sure you want to delete this location?'";
												
												foreach($locationResults as $result)
												{

                                                    echo('<tr><td>' . $result->GroundName . ', ' . $result->Town . ', ' . $result->PostCode . '</td><td><a href="update-location.php?locationid=' . $result->LocationId . '"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="locations.php?delete=1&locationid=' . $result->LocationId . '" style="color: #ff0000" onclick="return confirm(' . $confirmDelete . ');"><i class="fa fa-minus-circle"></i></a></td></tr>');
												
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
                                                <div class="col-md-6">
							<div class="box box-success">
								<div class="box-header">
									<h3 class="box-title">Add a Location</h3>
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
                                                    <input type="text" class="form-control" name="GroundName" id="GroundName" placeholder="Ground Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label>Town</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="Town" id="Town" placeholder="Town">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label>Post code</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-dot-circle-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="PostCode" id="PostCode" placeholder="Post code">
                                                </div>
                                            </div>
                                    <div class="col-md-12 pull-right" style="padding: 0px !important">
                                        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Add Location</button>
                                    </div>
                                    </form>
                                </div>


                            </div>
                        </div>
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
			  var oTable = $('#example2').dataTable({
			    "bPaginate": true,
			    "bLengthChange": false,
			    "bFilter": false,
			    "bSort": true,
			    "bInfo": true,
			    "bAutoWidth": false,
                 "iDisplayLength": 20,
                 "order": [[ 0, "asc" ]]
			  });
			});
		</script>
	</body>
</html>