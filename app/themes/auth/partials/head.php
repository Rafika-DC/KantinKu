<head>
    <base href="<?= base_url(); ?>"/>
    <title><?= (isset($setting->meta_title)) ? ucwords($setting->meta_title) : ''; ?><?= (isset($title)) ? ' | '.$title : ''; ?></title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />

    

    <!-- UNTUK SEO -->
    <link rel="icon" href="<?- image_check($setting->icon,'setting');?>" type="image/x-icon">

    <link href="<?= base_url('assets/public/plugins/global/plugins.bundle.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/public/css/style.bundle.css'); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/base_color/color.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/auth/css/style.css'); ?>" type="text/css"/>
    <link href="<?= base_url('assets/public/css/custom_pribadi.css');?>" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/c772e3a5a0.js" crossorigin="anonymous"></script>
</head>
