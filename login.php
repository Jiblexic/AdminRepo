<?php

require_once('core/init.php');

$user = new User();

if($user->isLoggedIn())
{
    Redirect::to('index.php');
}

$displayErrors = "none";
$errorDisplay = "";

if(Input::exists())
{
    if(Token::check(Input::get('token')))
    {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array('name' => 'Username', 'required' => true),
            'password' => array('name' => 'Password', 'required' => true)));
        
        if($validation->passed())
        {
            $user = new User();
            $remember = (Input::get('remember') === 'on') ? true : false;

            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login)
            {
                Redirect::to('index.php');
            }
            else
            {

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
  <head>
    <meta charset="UTF-8">
    <title>Cheriton Fitzpaine FC | Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Cherries</b> Login</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
        <p style="color: #ff0000; display: <?php echo $displayErrors?>"><?php echo $errorDisplay ?></p>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="username" id="username" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label for="remember">
                  <input type="checkbox" name="remember" id="remember"> Remember Me
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <input type="hidden" name="token" value="<?php echo Token::generate();?>">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="register.php" class="text-center">Not got an account? Register here</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>