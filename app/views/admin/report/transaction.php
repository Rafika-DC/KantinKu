<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!-- FILTER -->
            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10 mb-xl-10">
                <div class="card mb-5 mt-10">
                    <!--begin::Card body-->
                    <div class="card-body table-responsive pt-4">
                        <div class="row w-100 pt-5">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_start_date">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Tanggal Mulai</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" id="start_date" value="<?= $start_date; ?>" class="form-control form-control-solid mb-3 mb-lg-0 filter-input table-filter" placeholder="Masukkan Tanggal Mulai" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_end_date">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Tanggal Akhir</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" id="end_date" value="<?= $end_date; ?>" class="form-control form-control-solid mb-3 mb-lg-0 filter-input table-filter" placeholder="Masukkan Tanggal Akhir" autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end align-items-center">
                                <button class="btn btn-primary" type="button" onclick="filter_apply(this)" style="min-width : 100px">Filter</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <!--end::Row-->
            <!-- TABLE -->
            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10 mb-xl-10">
                <div class="card mb-5 mb-xl-8 mt-3">
                    <div class="row ms-10 mt-10">
                        <div class="col-md-8 col-lg-8 col-sm-12 ps-0 ms-0">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column align-items-start">
                                <!--begin::Title-->
                                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Tabel Laporan Transaksi</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">
                                        <a class="text-gray-600 text-hover-primary">Laporan</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="d-flex justify-content-center align-items-center">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1 me-2">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" class="form-control form-control-solid ps-12 search-datatable h-100" placeholder="Cari"  />
                                </div>
                                <form id="form_cetak_excel" action="<?= base_url('report/print_transaction') ?>" method="POST">
                                    <input type="hidden" name="start_date" value="<?= $start_date; ?>">
                                    <input type="hidden" name="end_date" value="<?= $end_date; ?>">
                                    <input type="hidden" name="type">
                                    <!--end::Search-->
                                    <button type="submit" class="btn btn-sm h-100 btn-success" style="min-width : 100px"><i class="fa-solid fa-file-excel fs-2"></i> Export</button>
                                </form>
                                
                            </div>
                        </div>
                        
                        
                    </div>
                    <!--begin::Body-->
                        <!--begin::Card body-->
                    <div class="card-body table-responsive pt-4">
                        <!--begin::Table-->
                        <table class="table align-middle table-striped table-bordered fs-6 gy-5" id="table_transaction" data-url="<?= base_url('table/transaction'); ?>">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px pe-2 align-middle" data-orderable="false" data-searchable="false">No</th>
                                    <th class="min-w-15s0px align-middle">Tanggal</th>
                                    <th class="min-w-200px align-middle">Pembuat</th>
                                    <th class="min-w-100px align-middle" data-orderable="false" data-searchable="false">Produk</th>
                                    <th class="min-w-100px align-middle" data-orderable="false" data-searchable="false">Harga</th>
                                    <th class="min-w-100px align-middle" data-orderable="false" data-searchable="false">Total Harga</th>
                                    <th class="min-w-100px align-middle">Total Bayar</th>
                                </tr>
                            </thead>

                            <tbody class="fw-semibold text-gray-600">
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

