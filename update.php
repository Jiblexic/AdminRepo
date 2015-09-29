<?php
   require_once('core/init.php');
   
   $pageTitle = 'Update your account';
   
   $user = new User();
   
   if(!$user->isLoggedIn())
   {
       Redirect::to('login.php');
   }
   
   // Defaults
   $style = '';
   $displayErrors = "none";
   $errorDisplay = "";
   
   // Permissions
   if($user->data()->Group == 123)
   {
       $style = 'style="display: none;"';
   }
   
   if(Input::exists())
   {
       if(Token::check(Input::get('token')))
       {
           $validate = new Validation();
           $validation = $validate->check($_POST, array(
               'name' => array(
                   'name' => 'Name', 
                   'required' => true,
                   'min' => 5,
                   'max' => 50)));
           
           if($validation->passed())
           {
               try
               {
                   $user->update(array(
                   'Name' => Input::get('name')));
   
                   Session::flash('home', 'User updated successfully.');
                   Redirect::to('index.php');
               }
               catch(Exception $e)
               {
                   die($e->getMessage());
               }
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
                  Update your account
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
                              <h3 class="box-title">Update your account details</h3>
                           </div>
                           <div class="box-body">
                              <p style="color: #ff0000; display: <?php echo $displayErrors?>"><?php echo $errorDisplay ?></p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo escape($user->data()->Username);?>" disabled />
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo escape($user->data()->Name);?>" />
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php if(isset($user->data()->Email)) {echo escape($user->data()->Email);}?>" />
                                 </div>
                              </div>
                              <div class="col-xs-12 pull-right" style="padding: 0px !important">
                                 <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                                 <button type="submit" class="btn btn-primary btn-block btn-flat">Update Account</button>
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
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="dist/js/demo.js" type="text/javascript"></script>
   </body>
</html>