<!--begin::Container-->
<div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin:::Tabs-->
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a onclick="set_url_params('umum')" class="nav-link text-active-primary d-flex align-items-center pb-5 <?= (!$page || $page == 'umum') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#general_pane">
                    <i class="ki-duotone ki-home fs-2 me-2"></i>Umum</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a onclick="set_url_params('seo')" class="nav-link text-active-primary d-flex align-items-center pb-5 <?= ($page == 'seo') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#seo_pane">
                    <i class="fa-brands fa-searchengin fs-2 me-2"></i>
                    </i>SEO</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a onclick="set_url_params('sosmed')" class="nav-link text-active-primary d-flex align-items-center pb-5  <?= ($page == 'sosmed') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#sosmed_pane">
                    <i class="fa-solid fa-hashtag fs-2 me-2"></i>
                    </i>Sosial Media</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="tab_pane">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade <?= (!$page || $page == 'umum') ? 'show active' : ''; ?>" id="general_pane" role="tabpanel">
                    <?php include 'partials/logo.php'; ?>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade <?= ($page == 'seo') ? 'show active' : ''; ?>" id="seo_pane" role="tabpanel">
                    <?php include 'partials/seo.php'; ?>
                </div>
                <!--end:::Tab pane-->

                <!--begin:::Tab pane-->
                <div class="tab-pane fade <?= ($page == 'sosmed') ? 'show active' : ''; ?>" id="sosmed_pane" role="tabpanel">
                    <?php include 'partials/sosmed.php'; ?>
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->

            
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->


<div class="modal fade" id="kt_modal_sosmed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_modal_sosmed" data-title="Tambah Sosial Media|Edit Sosmed"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="form_sosmed" class="form" action="<?= base_url('pengaturan/tambah_sosmed',true) ?>" method="POST" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column me-n7 pe-7" id="#">
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_sosmed_icon">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Icon</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="icon" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Kode Icon" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <input type="hidden" name="id_sosmed">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="req_sosmed_name">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Nama</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Nama" autocomplete="off" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" id="submit_sosmed" data-loader="big" onclick="submit_form(this,'#form_sosmed',1)" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>