<!--begin::Container-->
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start mt-10 pt-10 container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Layout-->
        <form method="POST" action="<?= base_url('dashboard/insert_transaction') ?>" id="form_transaction" class="d-flex flex-column flex-xl-row">
            <!--begin::Content-->
            <div class="d-flex flex-row-fluid me-xl-9 mb-10 mb-xl-0">
                <!--begin::Pos food-->
                <div class="card shadow-none card-flush card-p-0 bg-transparent border-0 w-100">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="w-100 row">
                            <?php if(isset($result) && $result) : ?>
                                <?php foreach($result AS $row) : ?>
                                <label for="choose-product-<?= $row->id_product; ?>" class="col-md-4 col-xl-4 col-sm-6 d-flex justify-content-center align-items-center">
                                    <input type="checkbox" name="id_product[]" value="<?= $row->id_product; ?>" data-title="<?= $row->title; ?>" data-image="<?= image_check($row->image,'product'); ?>" data-price="<?= $row->price; ?>" data-stock="<?= $row->sisa_stock; ?>" onchange="trx_product(this)" id="choose-product-<?= $row->id_product; ?>" class="d-none">
                                    <!--begin::Card-->
                                    <div class="card cursor-pointer card-flush flex-row-fluid p-6 pb-5 mw-100" style="height : 280px;" id="card-product-<?= $row->id_product; ?>">
                                        <!--begin::Body-->
                                        <div class="card-body text-center d-flex justify-content-start align-items-center flex-column">
                                            <?php
                                                $class="primary";
                                                if ($row->sisa_stock <= 0) {
                                                    $class="danger";
                                                }else if($row->sisa_stock > 0 && $row->sisa_stock <= 10){
                                                    $class="warning";
                                                }
                                            ?>
                                            <div class="mb-1 badge badge-<?= $class; ?>">Stok : <?= ($row->sisa_stock <= 0) ? 0 : $row->sisa_stock; ?> Unit</div>
                                            <!--begin::Food img-->
                                            <div class="background-partisi rounded-3 mb-4 w-125px h-125px w-xxl-175px h-xxl-175px" style="background-image : url('<?= image_check($row->image,'product'); ?>')"></div>
                                            <!--end::Food img-->
                                            <!--begin::Info-->
                                            <div class="mb-2">
                                                <!--begin::Title-->
                                                <div class="text-center">
                                                    <span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-6 fs-xl-4 mb-1"><?= short_text($row->title,25); ?></span>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7 mt-1"><?= short_text($row->category,15); ?></span>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Total-->
                                            <span class="text-success text-end fw-bold fs-4">Rp. <?= number_format($row->price,0,',','.') ?></span>
                                            <!--end::Total-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Card-->
                                </label>
                                <?php endforeach;?>
                            <?php else : ?>
                                <div class="col-md-12">
                                    <div class="w-100 d-flex justify-content-center align-items-center flex-column">
                                        <div class="background-partisi-contain" style="background-image : url('<?= image_check('empty.svg','default') ?>');width : 250px;height : 250px;"></div>
                                        <h3 class="text-primary fs-3 fw-bold text-center">Tidak Ada data produk</h3>
                                        <p class="text-muted fs-8 fw-semibold text-center mw-300px">Tidak ada produk yang siap di jual! Silahkan tambahkan produk atau hubungi admin jika terjadi kesalahan</p>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <!--end: Card Body-->
                    
                </div>
                <!--end::Pos food-->
                <?php if($total > 0): ?>
                <nav class="d-flex mt-5" aria-label="pagination">
                    <ul class="pagination pagination-alt">
                        <?php if ($offset > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url('news',true); ?>?offset=<?= $offset - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true"><i class="fa-solid fa-arrow-left"></i></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total; $i++) { ?>
                            
                            <li class="page-item <?= $i == $offset ? 'active' : '' ?>"><a class="page-link" href="<?= base_url('news',true); ?>?offset=<?= $i ?>"><?= $i;?></a></li>
                        <?php } ?>

                        <?php if ($offset < $total): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url('news',true); ?>?offset=<?= $offset + 1 ?>" aria-label="Next">
                                <span aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        
                    </ul>
                    <!-- /.pagination -->
                </nav>
                <?php endif;?>
            </div>
            <!--end::Content-->
            <!--begin::Sidebar-->
            <div class="flex-row-auto w-xl-450px">
                <!--begin::Pos order-->
                <div class="card card-flush bg-body" id="kt_pos_form">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <h3 class="card-title fw-bold text-primary fs-4">Form Pemesanan</h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive mb-8" style="margin-top : -30px">
                            <!--begin::Table-->
                            <table class="table align-middle gs-0 gy-4 my-0">
                                <!--begin::Table head-->
                                <thead>
                                    <tr>
                                        <th class="min-w-175px"></th>
                                        <th class="w-125px"></th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody id="display_order">
                                    
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                        <!--begin::Summary-->
                        <div class="d-flex flex-stack bg-success rounded-3 p-6 mb-11">
                            <!--begin::Content-->
                            <div class="fs-6 fw-bold text-white">
                                <span class="d-block fs-2qx lh-1">Total</span>
                            </div>
                            <!--end::Content-->
                            <!--begin::Content-->
                            <div class="fs-6 fw-bold text-white text-end">
                                <span class="d-block fs-2qx lh-1">Rp. <span id="display_total_order">0</span></span>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Summary-->
                        <button type="button" data-loader="big" onclick="submit_form(this,'#form_transaction')" id="button_transaction" class="btn btn-lg btn-primary mt-4 w-100">Simpan</button>
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::Pos order-->
            </div>
            <!--end::Sidebar-->
        </form>
        <!--end::Layout-->
    </div>
    <!--end::Post-->
</div>
<!--end::Container-->