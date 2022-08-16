<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Gis - Index</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/template_content/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/template_content/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('/template_content/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('/template_content/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('/template_content/css/owl.carousel.css') }}" type="text/css">

    <!--right slidebar-->
    <link href="{{ asset('/template_content/css/slidebars.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="{{ asset('/template_content/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/template_content/css/style-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('/leaflet/leaflet.css') }}" rel="stylesheet" />
    <link href="{{ asset('/leaflet/leaflet-geoman.css') }}" rel="stylesheet" />



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
     <style>
          .card-body-table{
               background: #fff;
              padding: 20px;
              border-radius: 7px;
          }
     </style>  
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <i class="fa fa-bars"></i>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo">Flat<span>lab</span></a>
            <!--logo end-->
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="{{ asset('/template_content/img/avatar1_small.jpg') }}">
                            <span class="username">Admin</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li>
                            	<a href="#"><i class=" fa fa-suitcase"></i>Salir</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      	<aside>
          	<div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              	<ul class="sidebar-menu" id="nav-accordion">
                  	<li>
                      	<a class="" href="{{ url('/admin/home') }}">
                          	<i class="fa fa-dashboard"></i>
                          	<span>Inicio</span>
                      	</a>
                  	</li>
                    <li>
                        <a class="" href="{{ url('/admin/cable-templates') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>Plantillas de cable</span>
                        </a>
                    </li>
                   {{--  @php
                        $redes = DB::table('redes')->get();
                    @endphp
                    @foreach($redes as $i => $red)
                      	<li class="sub-menu">
                          	<a href="javascript:;" class="item_load {{ $i === 0 ? 'active' : '' }}" data-id="{{ $red->id }}">
                              	<i class="fa fa-laptop"></i>
                              	<span>{{ $red->nombre }}</span>
                          	</a>
                          	<ul class="sub">
                              <li><a  href="#">Prueba funcionalidad</a></li>
                          	</ul>
                      	</li>
                    @endforeach --}}
              	</ul>
              <!-- sidebar menu end-->
          	</div>
      	</aside>
      <!--sidebar end-->
      <!--main content start-->
      	<section id="main-content">
          	<section class="wrapper">
              	@yield('body')
          	</section>
      	</section>
      <!--main content end-->

      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2013 &copy; FlatLab by VectorLab.
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ asset('/template_content/js/jquery.js') }}"></script>
    <script src="{{ asset('/template_content/js/bootstrap.min.js') }}"></script>
    <script class="include" type="text/javascript" src="{{ asset('/template_content/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('/template_content/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('/template_content/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/template_content/js/jquery.sparkline.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/template_content/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
    <script src="{{ asset('/template_content/js/owl.carousel.js') }}" ></script>
    <script src="{{ asset('/template_content/js/jquery.customSelect.min.js') }}" ></script>
    <script src="{{ asset('/template_content/js/respond.min.js') }}" ></script>

    <!--right slidebar-->
    <script src="{{ asset('/template_content/js/slidebars.min.js') }}"></script>

    <!--common script for all pages-->
    <script src="{{ asset('/template_content/js/common-scripts.j') }}s"></script>

    <!--script for this page-->
    <script src="{{ asset('/template_content/js/sparkline-chart.js') }}"></script>
    <script src="{{ asset('/template_content/js/easy-pie-chart.js') }}"></script>
    <script src="{{ asset('/template_content/js/count.js') }}"></script>
    <script src="{{ asset('/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('/leaflet/leaflet-geoman.min.js') }}"></script>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(window).on("resize",function(){
          var owl = $("#owl-demo").data("owlCarousel");
          owl.reinit();
      });

  </script>
  @yield('scripts')
  </body>
</html>
