<script>
    var BASE_URL = "<?= base_url('',true);?>";
    var hostUrl = "<?= assets_url('admin/');?>";
    var css_btn_confirm = 'btn btn-primary';
    var css_btn_cancel = 'btn btn-danger';
    var base_foto = "<?= image_check('notfound.jpg','default');?>";
    var user_base_foto = "<?= image_check('user.jpg','default');?>";
    var div_loading = '<div class="logo-spinner-parent">\
                    <div class="logo-spinner">\
                        <div class="logo-spinner-loader"></div>\
                    </div>\
                    <p id="text_loading">Tunggu sebentar...</p>\
                </div>';
    addEventListener('keypress', function(e) {
        if (e.keyCode === 13 || e.which === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="<?= assets_url('public/plugins/global/plugins.bundle.js');?>"></script>
<script src="<?= assets_url('public/js/scripts.bundle.js');?>"></script>
<!--end::Global Javascript Bundle-->
<!--end::Vendors Javascript-->
<script src="<?= assets_url('public/plugins/custom/datatables/datatables_id.bundle.js');?>"></script>
<script src="<?= assets_url('public/plugins/custom/vis-timeline/vis-timeline.bundle.js');?>"></script>
<!--end::Vendors Javascript-->

<script src="<?= assets_url('public/js/mekanik.js');?>"></script>
<script src="<?= assets_url('public/js/function.js');?>"></script>
<script src="<?= assets_url('public/js/global.js');?>"></script>
<script src="<?= assets_url('public/js/custom-datatable.js');?>"></script>

<?php

if (isset($js) && is_array($js)) {
    foreach ($js as $jss) {
        echo $jss;
    }
} else {
    echo (isset($js) && ($js != "") ? $js : "");
}

?>