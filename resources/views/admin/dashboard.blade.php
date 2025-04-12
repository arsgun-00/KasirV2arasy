@extends('admin.template.master')
@section('title')
    SAPRAS | Dashboard
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Row-->

                <div class="row g-5 g-xl-8 mt-1">
                    <div class="col-xl-4">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #15406a">
                            <!--begin::Body-->

                            <div class="card-body">
                                <i class="fas fa-box text-gray-100 fs-2x ms-n1"></i>
                                <div class=" fw-bold fs-2 mb-2 mt-5 text-white"></div>
                                <div class="fw-semibold  text-white">Total Barang Keseluruhan</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #15406a">
                            <!--begin::Body-->

                            <div class="card-body">
                                <i class="fas fa-file-alt text-gray-100 fs-2x ms-n1"></i>
                                <div class=" fw-bold fs-2 mb-2 mt-5 text-white"></div>
                                <div class="fw-semibold  text-white">Total Laporan Kerusakan</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #15406a">
                            <!--begin::Body-->

                            <div class="card-body">
                                <i class="fas fa-building text-gray-100 fs-2x ms-n1"></i>
                                <div class=" fw-bold fs-2 mb-2 mt-5 text-white"></div>
                                <div class="fw-semibold  text-white">Total Keseluruhan Ruangan</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>

                </div>
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-12">
                        <!--begin::Statistics Widget 5-->
                        <div class="card hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div id="container" style="width:100%;height:500px;"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Statistics Widget 5-->
                    </div>



                </div>
                <div class="row g-5 g-xl-8 mt-1">
                    <div class="col-xl-4">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #007bff">
                            <!--begin::Body-->

                            <div class="card-body">
                                <i class="fas fa-check-circle text-gray-100 fs-2x ms-n1"></i>
                                <div class=" fw-bold fs-2 mb-2 mt-5 text-white"></div>
                                <div class="fw-semibold  text-white">Total Barang Baik</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #fd7e14">
                            <!--begin::Body-->

                            <div class="card-body">
                                <i class="fas fa-exclamation-triangle text-gray-100 fs-2x ms-n1"></i>
                                <div class=" fw-bold fs-2 mb-2 mt-5 text-white"></div>
                                <div class="fw-semibold  text-white">Total Barang Kurang Baik</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color:#dc3545;">
                            <!--begin::Body-->

                            <div class="card-body">
                                <i class="fas fa-times-circle text-gray-100 fs-2x ms-n1"></i>
                                <div class=" fw-bold fs-2 mb-2 mt-5 text-white"></div>
                                <div class="fw-semibold  text-white">Total Barang Rusak Berat</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>

                </div>
            </div>
        </div>
    @endsection