<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Gis - login</title>

    <!-- Bootstrap core CSS -->
    <link href="{{url('/template_content')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('/template_content')}}/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="{{url('/template_content')}}/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{url('/template_content')}}/css/style.css" rel="stylesheet">
    <link href="{{url('/template_content')}}/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
    <body class="login-body">
        <div class="container">
            <form class="form-signin" action="{{ url('/admin-login') }}" method="POST" autocomplete="off">
                <h2 class="form-signin-heading">
                    GIS
                </h2>
                <div class="login-wrap">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" name="email" value="admin@email.comn">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password" value="1234567">
                    </div>
                    <button class="btn btn-lg btn-login btn-block" type="submit">Ingresar</button>
                    @if(session()->has('error'))
                        <div class="alert alert-danger text-center">
                            {{ session()->get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                                <span aria-hidden="true">×</span> 
                            </button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger text-center">
                            {{ $errors->first() }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                                <span aria-hidden="true">×</span> 
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="{{url('/template_content')}}/js/jquery.js"></script>
        <script src="{{url('/template_content')}}/js/bootstrap.min.js"></script>
  </body>
</html>
