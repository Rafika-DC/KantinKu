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
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7" id="req_id_product">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Produk</label>
                                    <!--end::Label-->
                                    <select id="select_id_product" name="id_product" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Produk">
                                        <option value="">Pilih Produk</option>
                                        <?php if($product) : ?>
                                            <?php foreach($product as $row) : ?>
                                                <option value="<?= $row->id_product; ?>"><?= $row->title;?></option>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    </select>
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
                                <h1 class="d-flex text-dark fw-bold m-0 fs-3">Tabel Laporan Moving Avarage</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">
                                        <a class="text-gray-600 text-hover-primary">Laporan</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-gray-600">Moving Avarage</li>
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
                            </div>
                        </div>
                        
                        
                    </div>
                    <!--begin::Body-->
                        <!--begin::Card body-->
                    <div class="card-body table-responsive pt-4">
                        <!--begin::Table-->
                        <table class="table align-middle table-striped table-bordered fs-6 gy-5" id="table_ma" data-url="<?= base_url('table/ma'); ?>">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px pe-2 align-middle" data-orderable="false" data-searchable="false">No</th>
                                    <th class="min-w-15s0px align-middle">Tanggal</th>
                                    <th class="min-w-200px align-middle">Produk</th>
                                    <th class="min-w-200px align-middle">Qty</th>
                                    <th class="min-w-200px align-middle">MA (3 Hari)</th>
                                    <th class="min-w-200px align-middle">Perkiraan stok besok</th>
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

