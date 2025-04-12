<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
<div id="kt_header" style="" class="header align-items-stretch">
    <div class="header-brand text-white" style="background-color: var(--secondary-color);">
        <a href="#">
            <span class="text-uppercase text-white fw-bold" style="font-size: 25px;">KASIR</span>
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-minimize" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <i class="ki-duotone ki-entrance-right fs-1 me-n1 minimize-default text-white">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <i class="ki-duotone ki-entrance-left fs-1 minimize-active text-white">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1 text-white">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
    </div>
    <div class="toolbar d-flex align-items-stretch">
        <div class="container-xxl py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
            <div class="page-title d-flex justify-content-center flex-column me-5">
                <!--begin::Title-->
                <h1 class="d-flex flex-column text-gray-900 fw-bold fs-3 mb-0">{{ $main }}</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="index.html" class="text-muted text-hover-primary">{{ $main }}</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ $sub }}</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>

        </div>
    </div>
</div>