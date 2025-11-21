<?php
    $segment1 = uri_segment(0);
    $segment2 = uri_segment(1);
?>

<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->
    <div class="aside-logo flex-column-auto pt-10 pt-lg-10" id="kt_aside_logo">
        <a href="<?= base_url('dashboard');?>">
            <?php if(isset($setting->icon) && $setting->icon != '' && file_exists('./data/setting/'.$setting->icon)) : ?>
                <div class="background-partisi-contain" style="width : 60px;height : 60px;background-image : url('<?= image_check($setting->icon,'setting');?>')"></div>
            <?php endif;?>
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-menu flex-column-fluid pt-0 pb-7 py-lg-10 d-flex justify-content-start align-items-start" id="kt_aside_menu">
        <!--begin::Aside menu-->
        <div id="kt_aside_menu_wrapper" class=" w-100 hover-scroll-y scroll-lg-ms d-flex justify-content-start" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
            <div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-500 menu-arrow-gray-500 fw-semibold fs-6 my-auto" data-kt-menu="true">
                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Dashboard" class="menu-item <?= ($segment1 == 'dashboard') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('dashboard');?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-home-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Kasir" class="menu-item <?= ($segment1 == 'pos') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('pos');?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-cash-register fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item <?= ($segment1 == 'master') ? 'here show' : '';?> py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-abstract-26 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Master</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="<?= base_url('master/admin')?>" class="menu-link  <?= ($segment1 == 'master' && $segment2 == 'admin') ? 'active' : '';?>">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-users fs-4"></i>
                                </span>
                                <span class="menu-title">User</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="<?= base_url('master/category')?>" class="menu-link  <?= ($segment1 == 'master' && $segment2 == 'category') ? 'active' : '';?>">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-tags fs-4"></i>
                                </span>
                                <span class="menu-title">Kategori</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="<?= base_url('master/product')?>" class="menu-link  <?= ($segment1 == 'master' && $segment2 == 'product') ? 'active' : '';?>">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-newspaper fs-4"></i>
                                </span>
                                <span class="menu-title">Produk</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                 <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item <?= ($segment1 == 'report') ? 'here show' : '';?> py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-chart-simple fs-2x"></i>
                        </span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Laporan</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="<?= base_url('report/ma')?>" class="menu-link  <?= ($segment1 == 'report' && $segment2 == 'ma') ? 'active' : '';?>">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-scale-unbalanced-flip fs-4"></i>
                                </span>
                                <span class="menu-title">Moving Avarage</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a href="<?= base_url('report/transaction')?>" class="menu-link  <?= ($segment1 == 'report' && $segment2 == 'transaction') ? 'active' : '';?>">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-money-bills fs-4"></i>
                                </span>
                                <span class="menu-title">Transaksi</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Pengaturan" class="menu-item <?= ($segment1 == 'setting') ? 'here show' : '';?> py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('setting');?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-setting-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                
                
            </div>
        </div>
        <!--end::Aside menu-->
    </div>
    <!--end::Nav-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pb-5 pb-lg-10" id="kt_aside_footer">
        <!--begin::Menu-->
        <div class="d-flex flex-center w-100 scroll-px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Log Out">
            <a type="button" class="btn btn-custom" href="<?= base_url('logout');?>" onclick="confirm_alert(this, event, 'Are you sure you want to leave the system?')">
                <i class="ki-duotone ki-entrance-left fs-2x">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Footer-->
</div>
<!--end::Aside-->