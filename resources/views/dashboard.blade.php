@extends('layout.app')
@section('body')

<!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">Invoice<span class="font-weight-normal text-muted ml-2">Dashboard</span></h4>
        </div>
        <div class="page-rightheader ml-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <div class="d-flex">
                    <div class="header-datepicker mr-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="feather feather-calendar"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" placeholder="19 Feb 2020" type="text">
                        </div>
                    </div>
                    <div class="header-datepicker mr-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">img
                                    <i class="feather feather-clock"></i>
                                </div>
                            </div><!-- input-group-prepend -->
                            <input id="tpBasic" type="text" placeholder="09:30am" class="form-control input-small">
                        </div>
                    </div><!-- wd-150 -->
                </div>
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#clockinmodal">Clock In</button>
                        <button class="btn btn-light" data-toggle="tooltip" data-placement="top" title="E-mail"> <i
                                class="feather feather-mail"></i> </button>
                        <button class="btn btn-light" data-placement="top" data-toggle="tooltip" title="Contact"> <i
                                class="feather feather-phone-call"></i> </button>
                        <button class="btn btn-primary" data-placement="top" data-toggle="tooltip" title="Info"> <i
                                class="feather feather-info"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Page header-->


    <!--Row-->
    <div class="row">
        <div class="col-xl-9 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Total
                                            Invoice</span>
                                        <h3 class="mb-0 mt-1 mb-2">{{ $invoiceCount }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-success my-auto  float-right"> <i
                                            class="feather feather-users"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Department</span>
                                        <h3 class="mb-0 mt-1 mb-2">124</h3>
                                        <span class="text-muted">
                                            <span class="text-danger fs-12 mt-2 mr-1"><i
                                                    class="feather feather-arrow-down-left mr-1 bg-danger-transparent p-1 brround"></i>13</span>
                                            for last month
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary my-auto  float-right"> <i class="feather feather-box"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Expenses</span>
                                        <h3 class="mb-0 mt-1  mb-2">$2,7853</h3>
                                    </div>
                                    <span class="text-muted">
                                        <span class="text-danger fs-12 mt-2 mr-1"><i
                                                class="feather feather-arrow-up-right mr-1 bg-danger-transparent p-1 brround"></i>21.1%
                                        </span>
                                        for last month
                                    </span>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-secondary brround my-auto  float-right"> <i
                                            class="feather feather-dollar-sign"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header border-0 responsive-header">
                            <h4 class="card-title">Overview</h4>
                            <div class="card-options">
                                <div class="btn-list">
                                    <a href="#"
                                        class="btn  btn-outline-light text-dark float-left d-flex my-auto"><span
                                            class="dot-label bg-light4 mr-2 my-auto"></span>Employees</a>
                                    <a href="#"
                                        class="btn  btn-outline-light text-dark float-left d-flex my-auto"><span
                                            class="dot-label bg-primary mr-2 my-auto"></span>Budget</a>
                                    <a href="#" class="btn btn-outline-light" data-toggle="dropdown"
                                        aria-expanded="false"> Year <i class="feather feather-chevron-down"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li><a href="#">Monthly</a></li>
                                        <li><a href="#">Yearly</a></li>
                                        <li><a href="#">Weekly</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartLine"></canvas>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    @endsection
