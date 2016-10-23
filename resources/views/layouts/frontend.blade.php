<!DOCTYPE html>
<html lang="en" ng-app="frontend">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TRPZ') }}</title>

    <!-- Styles -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="/css/frontend.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
    <div id="sideNavigation">
      <div id="exit_nav" class="transition"><i class="fa fa-times transition" onclick="hideSidebar()"></i></div>
      <nav class="menu-mobile-menu-container">
        <ul>
          <li class="menu-item"><a href="{{url('/')}}">Home</a></li>
          <li class="menu-item"><a href="#">About</a></li>
          <li class="menu-item"><a href="#">Featured Trips</a></li>
          <li class="menu-item"><a href="#">Other Deals</a></li>
          @if(Auth::guard('customer')->check())
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >
                    {!! Auth::guard('customer')->user()->getFullName(); !!}
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Cart: 1 <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                    <li><a href="{{ url('/customer/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                             Log Out <i class="fa fa-power-off" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
              </li>
              <form id="logout-form" action="{{ url('/customer/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>    
            @else
            <li>
               <a href="{{ url('/customer/login') }}">
                    Login <i class="fa fa-sign-in" aria-hidden="true"></i>
              </a>
            </li>
              <li>
                  <a href="{{ url('/customer/register') }}">Sign Up <i class="fa fa-user-plus" aria-hidden="true"></i></a> 
              </li>
        @endif
        </ul>
      </nav>
    </div>
    <div id="full-page-cover"></div>
    <div id="full-page">
      <div class="container-full blue-container">
          <nav class="navbar main-navbar" role="navigation">
              <div class="container-fluid">
                <div class="navbar-header">
                      <button type="button" class="navbar-toggle" onclick="showSidebar()">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="{{url('/')}}"><img src="{{ url('img/TRPZ-logo.png') }}"/></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav main-nav">
                        <li class="active"><a href="{{url('/')}}">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Featured Trips</a></li>
                        <li><a href="#">Other Deals</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                            @if(Auth::guard('customer')->check())
                            <li><a href="#">Cart: 1 <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                             <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >
                                    {!! Auth::guard('customer')->user()->getFullName(); !!}
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/customer/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                             Log Out <i class="fa fa-power-off" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                              </li>
                              <form id="logout-form" action="{{ url('/customer/logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>    
                            @else
                              <li>
                                <a href="{{ url('/customer/login') }}">
                                      Login <i class="fa fa-sign-in" aria-hidden="true"></i>
                                </a>
                              </li>
                              <li>
                                  <a href="{{ url('/customer/register') }}">Sign Up <i class="fa fa-user-plus" aria-hidden="true"></i></a> 
                              </li>
                            @endif
                    </ul>
                </div>
              </div>
          </nav>
                    
        </div>
          
      </div>
      @yield('content')
      <div class="container-full blue-container footer">
        <div class="container">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"><img src="{{ url('img/TRPZ-logo.png') }}"/></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/js/frontend.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
</body>
</html>
