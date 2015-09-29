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
            'username' => array(
                'name' => 'Username',
                'required' => true,
                'min' => 5,
                'max' => 20,
                'unique' => 'users'),
            'password' => array(
                'name' => 'Password',
                'required' => true,
                'min' => 6),
            'passwordrepeat' => array(
                'name' => 'Password',
                'required' => true,
                'matches' => 'password'),
            'email' => array(
                'name' => 'Email',
                'required' => true,
                'min' => 10,
                'max' => 50,
                'unique' => 'users'),
            'name' => array(
                'name' => 'Name',
                'required' => true,
                'min' => 5,
                'max' => 50)));

        if($validation->passed())
        {
            $user = new User();

            $salt = Hash::salt(32);

            try
            {
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 0,
                    'email' => Input::get('email')));

                Session::flash('home', 'You have been registered succesfully');
                Redirect::to('index.php');
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }

            $displayErrors = "none";
            Session::flash('success', 'You registered successfully!');
            header('Location: congratulations.php?registered=1');
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
    <title>AdminLTE 2 | Registration Page</title>
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
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="index2.html"><b>Cherries</b> Admin</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Register</p>
        <p style="color: #ff0000; display: <?php echo $displayErrors?>"><?php echo $errorDisplay ?></p>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Full name" name="name" id="name" value="<?php echo(escape(Input::get('name'))); ?>" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?php echo(escape(Input::get('username'))); ?>" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo(escape(Input::get('email'))); ?>" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Retype password" name="passwordrepeat" id="passwordrepeat" />
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
                <a href="login.html" class="text-center">I already have a membership</a>    
            </div><!-- /.col -->
            <div class="col-xs-4">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>        
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
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