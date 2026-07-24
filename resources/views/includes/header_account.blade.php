<!DOCTYPE html>
<html>
    <head>
        <!-- Character encoding -->
        <meta charset="utf-8" />

        <!-- Internet Explorer compatibility -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Responsive viewport settings -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

        <!-- Page description -->
        <meta content="Admin Dashboard" name="description" />

        <!-- Author information -->
        <meta content="Themesbrand" name="author" />

        <!-- Browser compatibility -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- Website favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="{{ URL::asset('assets/images/favicon.ico')}}">

        <!-- Browser tab title -->
        <title>Saloon Management System</title>

        <!-- ===========================
             CSS Stylesheets
             =========================== -->

        <!-- Bootstrap CSS -->
        <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Icon library -->
        <link href="{{ URL::asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">

        <!-- Main application stylesheet -->
        <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- ===========================
             Page Preloader
             Displays a loading animation
             while the page is loading.
             =========================== -->
        <div id="preloader">
            <div id="status">
                <div class="spinner"></div>
            </div>
        </div>