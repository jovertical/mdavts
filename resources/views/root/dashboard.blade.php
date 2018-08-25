@extends('root.templates.master')

@section('content')
<!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Students</small></h6>
                                    <h4 class="m-t-0 text-info">900</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Candidates</small></h6>
                                    <h4 class="m-t-0 text-primary">25</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

<!-- Column -->
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-inverse card-success">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="icon-cloud-download"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Vote Count</h3>
                                        <h6 class="card-subtitle">As of: March  2017</h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 align-self-center">
                                        <h2 class="font-light text-white">465</h2>
                                    </div>
                                    <div class="col-8 p-t-10 p-b-20 text-right">
                                        <div class="spark-count" style="height:65px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div>
                                                <h3 class="card-title">Vote Overview</h3>
                                                <h6 class="card-subtitle">- Party vs. - Party</h6> </div>
                                            <div class="ml-auto">
                                                <ul class="list-inline">
                                                    <li>
                                                        <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Ample</h6> </li>
                                                    <li>
                                                        <h6 class="text-muted  text-info"><i class="fa fa-circle font-10 m-r-10"></i>Pixel</h6> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="amp-pxl" style="height: 360px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Vote Monitor </h3>
                                <h6 class="card-subtitle">Different Devices Used to Visit</h6>
                                <div id="visitor" style="height:290px; width:100%;"></div>
                            </div>
                            <div>
                                <hr class="m-t-0 m-b-0">
                            </div>
                            <div class="card-body text-center ">
                                <ul class="list-inline m-b-0">
                                    <li>
                                        <h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10 "></i>Mobile</h6> </li>
                                    <li>
                                        <h6 class="text-muted  text-primary"><i class="fa fa-circle font-10 m-r-10"></i>Desktop</h6> </li>
                                    <li>
                                        <h6 class="text-muted  text-success"><i class="fa fa-circle font-10 m-r-10"></i>Tablet</h6> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
@endsection