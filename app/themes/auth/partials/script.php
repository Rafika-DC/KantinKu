<script>
    var csrf_token = "<?= date('YmdHis'); ?>";
    var BASE_URL = "<?= base_url(); ?>";
    var hostUrl = "<?= base_url('assets') ?>";
    var css_btn_confirm = 'btn btn-primary';
    var css_btn_cancel = 'btn btn-danger';
    var image_default = "<?= base_url('assets/public/images/user.jpg');?>";
</script>

<script src="<?= base_url('assets/public/plugins/global/plugins.bundle.js'); ?>"></script>
<script src="<?= base_url('assets/public/js/scripts.bundle.js'); ?>"></script>
<script src="<?= base_url('assets/public/js/mekanik.js'); ?>"></script>
<script src="<?= base_url('assets/public/js/function.js'); ?>"></script>
<script src="<?= base_url('assets/public/js/global.js'); ?>"></script>
<script src="<?= base_url('assets/auth/js/script.js'); ?>"></script>
<script src="<?= base_url('assets/auth/js/modul/login.js'); ?>"></script>