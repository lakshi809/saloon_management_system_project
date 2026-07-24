        <!-- ===========================
             CSS Stylesheets
             =========================== -->

        <!-- Bootstrap CSS Framework -->
        <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Icon Library -->
        <link href="{{ URL::asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">

        <!-- Main Application Stylesheet -->
        <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

        <!-- ===========================
             Custom Page Styles
             =========================== -->
        <style>
            /* Allow vertical scrolling for the content area */
            .content-page {
                overflow-y: auto !important;
                overflow-x: hidden !important;
                height: auto !important;
            }

            /* Allow the wrapper to expand based on page content */
            #wrapper {
                overflow: visible !important;
                height: auto !important;
            }
        </style>

    </head>

    <!-- Apply fixed left sidebar layout -->
    <body class="fixed-left">

        <!-- Include the left sidebar navigation -->
        @include('includes/leftbar')

        <!-- Include the top navigation bar -->
        @include('includes/topbar')