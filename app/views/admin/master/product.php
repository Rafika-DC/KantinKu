<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 pt-10">
                <div class="card mb-5 mb-xl-8 mt-10">
                    <div class="d-flex flex-stack flex-wrap ms-10 mt-10">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start">
                            <!--begin::Title-->
                            <h1 class="d-flex text-dark fw-bold m-0 fs-3">Data Produk</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">
                                    <a class="text-gray-600 text-hover-primary">Master</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-gray-600">Produk</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--begin::Body-->
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" class="form-control form-control-solid w-250px ps-12 search-datatable" placeholder="Cari"  />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end me-3">
                                <!--begin::Filter-->
                                <button type="button" class="btn btn-sm btn-secondary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Penyaringan
                                </button>
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Pilih Penyaringan</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Separator-->
                                    <!--begin::Content-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <label class="form-label fs-6 fw-semibold">Status</label>
                                            <select id="filter_status" class="form-select form-select-solid filter-input table-filter" data-control="select2" data-placeholder="Pilih Status">
                                                <option value="all">Semua</option>
                                                <option value="Y">Aktif</option>
                                                <option value="N">Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold">Kategori</label>
                                            <select id="filter_category" class="form-select form-select-solid filter-input table-filter" data-control="select2" data-placeholder="Pilih Kategori">
                                                <option value="all">Semua</option>
                                                <?php if($category) : ?>
                                                    <?php foreach($category AS $row): ?>
                                                        <option value="<?= $row->id_category; ?>"><?= $row->name ?></option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button" onclick="filter_apply()" class="btn btn-primary fw-semibold px-6">Terapkan</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Filter-->  
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Add Produk-->
                             <button type="button" class="btn btn-sm btn-primary" onclick="tambah_data()" data-bs-toggle="modal" data-bs-target="#kt_modal_product">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Produk</button>
                            <!--end::Add Produk-->
                        </div>
                    </div>
                    <!--end::Header-->
                     <!--begin::Card body-->
                    <div class="card-body table-responsive pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_product" data-url="<?= base_url('table/product',true); ?>">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px pe-2" data-orderable="false" data-searchable="false">No</th>
                                    <th class="min-w-100px" data-orderable="false" data-searchable="false">Gambar / Media</th>
                                    <th class="min-w-150px">Judul</th>
                                    <th class="min-w-100px">Kategori</th>
                                    <th class="min-w-100px">Harga</th>
                                    <th class="min-w-100px">Stock</th>
                                    <th class="min-w-100px">Transaksi</th>
                                    <th class="min-w-100px text-center">Status</th>
                                    <th class="text-end min-w-70px" data-orderable="false" data-searchable="false">Aksi</th>
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

<!-- Modal Tambah product -->
<div class="modal fade" id="kt_modal_product"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal" data-title="Edit Produk|Tambah Produk"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_product" class="form" action="<?= base_url('master/insert_product',true) ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        
                        <div id="lead"></div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 d-flex justify-content-center align-items-center flex-column">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Foto</label>
                            <!--end::Label-->
                            <!--begin::Image input-->
                            <div class="image-input background-partisi" data-kt-image-input="true" style="background-image: url('<?= image_check('user.jpg','default') ?>')">
                                <!--begin::Image preview wrapper-->
                                <div id="display_image" class="image-input-wrapper w-250px h-125px background-partisi" style="background-image: url('<?= image_check('user.jpg','default') ?>')"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Data">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file"  id="product_file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Batal">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow hps_image" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Data">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Tipe: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_title">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Judul Produk</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Judul Produk" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        
                        <input type="hidden" name="name_image">
                        <input type="hidden" name="id_product">
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_id_category">
                            <!--begin::Label-->
                            <label id="label_id_category" class="id_category required fw-semibold fs-6 mb-2">Kategori</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select id="select_id_category" name="id_category" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kategori Produk">
                                <option value="">Pilih Kategori Produk</option>
                                <?php if($category) : ?>
                                    <?php foreach($category as $row) : ?>
                                        <option value="<?= $row->id_category; ?>" <?= ($row->status == 'N') ? 'disabled' : ''; ?>><?= $row->name;?></option>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_stock">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Stok Awal</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="stock" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Stok Awal" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_price">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Harga</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <!--begin::Input-->
                            <div class="input-group">
                                <span class="input-group-text" id="rupiah-crime">Rp. </span>
                                <input type="text" id="siuang" onkeyup="matauang(this,'#real_value')" class="form-control mb-3 mb-lg-0" placeholder="Masukkan Harga" autocomplete="off" aria-describedby="rupiah-crime"/>
                            </div>
                            <input type="hidden" name="price" id="real_value">
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_product" onclick="submit_form(this,'#form_product')" class="btn btn-primary">
                            <span class="indicator-label">Kirim</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah stock -->
<div class="modal fade" id="kt_modal_stock"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Manajemen Stock <span class="text-primary" id="display_product_name"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <div class="d-flex flex-column me-n7 pe-7" id="#">
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr> 
                                <th>Tanggal Masuk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="display_list_stock">

                        </tbody>
                    </table>
                </div>
                <!--end::Scroll-->
            </div>
            <div class="modal-footer">
                <form id="form_stock" action="<?= base_url('master/insert_stock',true) ?>" method="POST" enctype="multipart/form-data" class="w-100 row">
                    <div class="col-9">
                        <!--begin::Input group-->
                        <input type="hidden" name="id_product">
                        <div class="fv-row mb-7" id="req_add_qty">
                            <!--begin::Input-->
                            <input type="number" name="qty" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Stok" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="col-3">
                        <button type="button" id="submit_stock" onclick="submit_form(this,'#form_stock',0, '', false,false,'Tunggu...')" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
