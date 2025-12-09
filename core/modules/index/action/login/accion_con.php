<?php

if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""){
		print "<script>window.location='index.php?view=index';</script>";
}

?>
<body class="hold-transition login-page" style="background-image: url('storage/iconos/fondo1.jpg');">
    <div class="login-box">
      <div style="color:#FF7800" class="login-logo">
        <b>VALOR CONTABLE</b>
        <center><img src="storage/iconos/logo.png"class="img-responsive" style="margin: 20px; border: 30px;" alt="User Image" width="204"> </center>
      </div>
      <div class="box box-danger">
      <div class="login-box-body">
        <p class="login-box-msg"><i class="glyphicon glyphicon-user icon-title"></i> Ingreso solo Personal Autorizado</p>
        <form action="index.php?action=processlogin" method="POST">
          <div class="form-group has-feedback has-warning">
           <input type="text" class="form-control" name="email" placeholder="Ingrese su Usuario o Correo Electronico" required autofocus="autofocus" autocomplete="off">
            <span class="fa fa-user-secret form-control-feedback" id="exampleInputEmail1"></span>
          </div>
          <div class="form-group has-feedback has-warning">
            <input type="password" class="form-control" name="password" placeholder="Ingrese su Password" required="">
            <span class="fa fa-expeditedssl form-control-feedback"></span>
          </div>
          <br/>
		  
          <div class="row">
		  
		  
		    <div class="g-recaptcha" data-sitekey="6LcdipMbAAAAAMVNizP7MwBCRWJAJV16FO27YAqR"></div>
		  
            <div class="col-xs-12">
              <input type="submit" class="btn btn-warning btn-lg btn-block btn-flat" name="login" value="Ingresar" id="hablar" />
            </div><!-- /.col -->
            <script src="script.js"></script>
			
			  <script src='https://www.google.com/recaptcha/api.js'></script>
			
			  <script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
			
			
          </div>
        </form>
      </div>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
  </body>