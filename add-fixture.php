<?php
   require_once('core/init.php');
   
   $pageTitle = 'Add a Fixture';
   
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


if(Input::exists())
{
    if(Token::check(Input::get('token')))
    {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'cheritonTeam' => array(
                'name' => 'Team',
                'required' => true),
            'competition' => array(
                'name' => 'Competition',
                'required' => true),
            'opponent' => array(
                'name' => 'Opponent',
                'required' => true),
            'homegame' => array(
                'name' => 'Home or Away',
                'required' => true),
            'location' => array(
                'name' => 'Location',
                'required' => true),
            'date' => array(
                'name' => 'Date',
                'required' => true),
            'kickoff' => array(
                'name' => 'Kick Off Time',
                'required' => true)));

        if($validation->passed())
        {
            $dateClean = str_replace('/', '-', Input::get('date'));
            $date =  date('Y-m-d', strtotime($dateClean));
            
            $isHomeGame = false;
            $kickOff = Input::get('kickoff');

            if(Input::get('homegame') == "true")
            {
                $isHomeGame = true;
            }
            if(strlen(Input::get('kickoff')))
            {
                $kickOff = Input::get('kickoff');
            }
                   
            try
            {
                $fixture->create(array(
                    'TeamId' => Input::get('cheritonTeam'),
                    'CompetitionId' => Input::get('competition'),
                    'LocationId' => Input::get('location'),
                    'OpponentId' => Input::get('opponent'),
                    'HomeGame' => $isHomeGame,
                    'Date' => $date,
                    'KickOff' => $kickOff));

                Session::flash('success', 'Fixture Added Successfully');
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
else
{
   $teams = $fixture->getMyTeams();
   $competitions = $fixture->getCompetitions();
   $opponents = $fixture->getOpponents();
   $locations = $fixture->getLocations();
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
                  Add a Fixture
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
                              <h3 class="box-title">Add a Fixture</h3>
                           </div>
                           <div class="box-body">
                               <p style="color: #ff0000; display: <?php echo $displayErrors?>"><?php echo $errorDisplay ?></p>
                              <div class="form-group">
                                 <label>Pick a Team</label>
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-futbol-o"></i>
                                    </div>
                                    <select class="form-control" name="cheritonTeam" id="cheritonTeam">
                                    <?php
                                       foreach($teams as $team)
                                       {
                                           echo('<option value="' . $team->TeamId. '">' . $team->Name . '</option>');
                                       }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Competition</label>
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-trophy"></i>
                                    </div>
                                    <select class="form-control" name="competition" id="competition">
                                    <?php
                                       foreach($competitions as $competition)
                                       {
                                           echo('<option value="' . $competition->CompetitionId. '">' . $competition->CompetitionName . '</option>');
                                       }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Opponent</label>
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-users"></i>
                                    </div>
                                    <select class="form-control" name="opponent" id="opponent">
                                    <?php
                                       foreach($opponents as $opponent)
                                       {
                                           echo('<option value="' . $opponent->OpponentId. '">' . $opponent->OpponentName . '</option>');
                                       }
                                       ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Home or Away</label>
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-home"></i>
                                    </div>
                                    <select class="form-control" name="homegame" id="homegame">
                                       <option value="true">Home</option>
                                       <option value="false">Away</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Location</label>
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-map-marker"></i>
                                    </div>
                                    <select class="form-control" name="location" id="location">
                                    <?php
                                       foreach($locations as $location)
                                       {
                                           echo('<option value="' . $location->LocationId. '">' . $location->GroundName . ', ' . $location->Town . ', ' . $location->PostCode . '</option>');
                                       }
                                       ?>
                                    </select>
                                 </div>
                              </div>


                              <!-- date Picker -->
                              <div class="bootstrap-datepicker">
                                 <div class="form-group">
                                    <label>Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar-o"></i>
                                       </div>
                                       <input type="text" class="form-control" data-date-format="mm/dd/yyyy" id="datepicker" name="date" />

                                    </div>
                                    <!-- /.input group -->
                                 </div>
                                 <!-- /.form group -->
                              </div>


                  <!-- time Picker -->
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Kick Off:</label>
                      <div class="input-group">
                                                  <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" class="form-control timepicker" id="kickoff" name="kickoff" />

                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>

                              <div class="col-xs-12 pull-right" style="padding: 0px !important">
                                 <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                                 <button type="submit" class="btn btn-primary btn-block btn-flat">Add Fixture</button>
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