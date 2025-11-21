<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
	<!--begin::Row-->

    <div class="row gx-5 gx-xl-10 mb-xl-10">
         <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
        <!--begin::Card widget 16-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 h-md-100 mb-3 mb-xl-6 shadow-sm">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                 <!--begin::Amount-->
                <div class="fs-1 fw-bold text-dark me-2 lh-1 ls-n2"><i class="fa-solid <?= (salamWaktu()->dark == true) ? 'fa-cloud-moon' : 'fa-cloud-sun'; ?>"></i> <?= salamWaktu()->message; ?> <span class="text-primary"><?= $_SESSION[WEB_NAME.'_name']; ?></span></div>
                <!--end::Amount-->
                <span class="text-dark opacity-50 pt-1 mt-3 fw-semibold fs-6">Selamat datang di Website Pendataan dan Perhitungan Moving Avarage</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->
    </div>
    
    <div class="row gx-5 gx-xl-10 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5">
        <!--begin::Card widget 16-->
        <div class="card card-custom bgi-no-repeat gutter-b card-stretch border-0 h-md-100 mb-5 mb-xl-10 shadow-sm bgi-size-contain bgi-position-x-center" style="background-position: right top; background-size: 30% auto; background-image: url(<?= assets_url('admin/svg/abstract.svg') ?>);background-color: var(--bs-primary);">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                 <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"><?= (isset($jml_news) && $jml_news) ? number_format($jml_news,0,',','.') : 0 ?></span>
                <!--end::Amount-->
                <span class="text-white opacity-50 pt-1 mt-3 fw-semibold fs-6">Total Produk</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->

        
        <!--begin::Col-->
        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5">
        <!--begin::Card widget 16-->
        <div class="card card-custom bgi-no-repeat gutter-b card-stretch border-0 h-md-100 mb-5 mb-xl-10 shadow-sm bgi-size-contain bgi-position-x-center" style="background-position: calc(100% + 20px) calc(0% + 10px);background-size: 30% auto; background-image: url(<?= assets_url('admin/svg/database.svg') ?>);">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                  <!--begin::Amount-->
                <span class="fw-bold text-primary me-2 lh-1 ls-n2" style="font-size : 25px;"><?= (isset($jml_trx) && $jml_trx) ? number_format($jml_trx,0,',','.') : 0 ?></span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-dark opacity-50 pt-1 mt-3 fw-semibold fs-6">Total Transaksi</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5">
        <!--begin::Card widget 16-->
        <div class="card card-custom bgi-no-repeat gutter-b card-stretch border-0 h-md-100 mb-5 mb-xl-10 shadow-sm bgi-size-contain bgi-position-x-center" style="background-position: calc(100% + 20px) calc(0% + 10px);background-size: 30% auto; background-image: url(<?= assets_url('admin/svg/users.svg') ?>);">
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-center py-7 flex-column">
                  <!--begin::Amount-->
                <span class="fw-bold text-primary me-2 lh-1 ls-n2" style="font-size : 25px;"><?= (isset($jml_admin) && $jml_admin) ? number_format($jml_admin,0,',','.') : 0 ?></span>
                <!--end::Amount-->
                <!--begin::Subtitle-->
                <span class="text-dark opacity-50 pt-1 mt-3 fw-semibold fs-6">Total User / Admin</span>
                <!--end::Subtitle-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 16-->
        </div>
        <!--end::Col-->

    </div>
    <!--end::Row-->
    
    <div class="row gx-5 gx-xl-10 mb-xl-10">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 h-md-100 mb-3 mb-xl-6 shadow-sm" >
                <div class="card-header px-4">
                    <div class="card-title">
                        <h4 class="text-primary">Grafik Transaksi</h4>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-center py-7 flex-column">
                    <div id="chart_dashboard" style="width: 100%;height : 400px;"></div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 16-->
        </div>
    </div>
</div>
<!--end::Container-->



<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- TRANSAKSI -->
<?php include 'grafik/transaksi.php'; ?>

