<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="DayOne - It is one of the Major Dashboard Template which includes - HR, Employee and Job Dashboard. This template has multipurpose HTML template and also deals with Task, Project, Client and Support System Dashboard." name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="keywords" content="admin dashboard, dashboard ui, backend, admin panel, admin template, dashboard template, admin, bootstrap, laravel, laravel admin panel, php admin panel, php admin dashboard, laravel admin template, laravel dashboard, laravel admin panel"/>

		<!-- Title -->
		<title>Task</title>

        <!--Favicon -->
		<link rel="icon" href="{{asset('assets')}}/images/brand/favicon.ico" type="image/x-icon"/>

		<!-- Bootstrap css -->
		<link href="{{asset('assets')}}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

		<!-- Style css -->
		<link href="{{asset('assets')}}/css/style.css" rel="stylesheet" />
		<link href="{{asset('assets')}}/css/dark.css" rel="stylesheet" />
		<link href="{{asset('assets')}}/css/skin-modes.css" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{asset('assets')}}/plugins/animated/animated.css" rel="stylesheet" />

		<!--Sidemenu css -->
        <link  href="{{asset('assets')}}/css/sidemenu.css" rel="stylesheet">

		<!-- P-scroll bar css-->
		<link href="{{asset('assets')}}/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{asset('assets')}}/plugins/icons/icons.css" rel="stylesheet" />

		<!---Sidebar css-->
		<link href="{{asset('assets')}}/plugins/sidebar/sidebar.css" rel="stylesheet" />

		<!-- Select2 css -->
		<link href="{{asset('assets')}}/plugins/select2/select2.min.css" rel="stylesheet" />


		<!--- INTERNAL jvectormap css-->
		<link href="{{asset('assets')}}/plugins/jvectormap/jqvmap.css" rel="stylesheet" />

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets')}}/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

		<!-- INTERNAL Time picker css -->
		<link href="{{asset('assets')}}/plugins/time-picker/jquery.timepicker.css" rel="stylesheet" />

		<!-- INTERNAL jQuery-countdowntimer css -->
		<link href="{{asset('assets')}}/plugins/jQuery-countdowntimer/jQuery.countdownTimer.css" rel="stylesheet" />


        <!-- INTERNAL Switcher css -->
		<link href="{{asset('assets')}}/switcher/css/switcher.css" rel="stylesheet"/>
		<link href="{{asset('assets')}}/switcher/demo.css" rel="stylesheet"/>

        @yield('css')
	</head>

	<body class="app sidebar-mini" id="index1">

        <!---Global-loader-->
		<div id="global-loader" >
			<img src="{{ asset('assets') }}/images/svgs/loader.svg" alt="loader">
		</div>

        <div class="page">
			<div class="page-main">
