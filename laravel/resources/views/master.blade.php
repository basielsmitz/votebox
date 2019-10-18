
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ URL::asset('css/plugins/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom Backoffice CSS -->
    <link href="{{ URL::asset('css/backoffice.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/back.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
            {{--</button>--}}
            <a class="navbar-brand" href="/">
                <img height="100%" src="{{ URL::asset('images/logo.svg') }}">
            </a>
        </div>
        <!-- Top Menu Items -->
        @include('partials.navRight')
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        @include('partials.nav')
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    @yield('breadcrumb')
                    <h1 class="page-header">
                        @yield('title')
                    </h1>

                </div>
            </div>
            <!-- /.row -->

            @yield('content')
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{ URL::asset('js/jquery.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{ URL::asset('js/plugins/morris/raphael.min.js') }}"></script>
<script src=" {{ URL::asset('js/plugins/morris/morris.min.js') }}"></script>
<script src=" {{ URL::asset('js/plugins/morris/morris-data.js') }}"></script>

@yield('scripts')

</body>

</html>
