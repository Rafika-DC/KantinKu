<!--begin::Head-->
<head>
    <base href="<?= base_url('',true);?>"/>
    <title><?= ucfirst($setting->meta_title);?><?= isset($title) ? ' | '.$title : '';?></title>
    <meta charset="utf-8" />		
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- UNTUK SEO -->
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!-- UNTUK SEO -->
    <link rel="icon" href="<?= image_check($setting->icon,'setting');?>?v=<?= time();?>" type="image/x-icon">

    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="<?= assets_url('public/plugins/custom/datatables/datatables.bundle.css');?>" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link rel="stylesheet" href="<?= assets_url('base_color/color.css');?>" />
    <link href="<?= assets_url('public/plugins/global/plugins.bundle.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?= assets_url('public/plugins/custom/vis-timeline/vis-timeline.bundle.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?= assets_url('public/css/style.bundle.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?= assets_url('public/css/custom_pribadi.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?= assets_url('public/css/loading_custom.css');?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script type="text/javascript" src="<?= assets_url('public/plugins/ckeditor5/ckeditor.js');?>"></script>
    <script>
        var CKEditor_tool = [
            "heading", 
            "|", 
            "fontSize", "fontFamily", "fontColor", "fontBackgroundColor", 
            "|", 
            "bold", "italic", "underline", "strikethrough", "subscript", "superscript", 
            "|", 
            "alignment", 
            "|", 
            "bulletedList", "numberedList", "todoList", 
            "|", 
            "outdent", "indent", 
            "|", 
            "blockQuote", "insertTable", "codeBlock", 
            "|", 
            "horizontalLine", "specialCharacters", "pageBreak", 
            "|", 
            "undo", "redo", "selectAll", "removeFormat"
        ];

        var font_color =  [
            {
                color: 'hsl(0, 0%, 0%)',
                label: 'Black'
            },
            {
                color : 'hsl(0, 0%, 100%)',
                label : 'White'
            },
            {
                color: 'hsl(0, 75%, 60%)',
                label: 'Red'
            },
            {
                color: 'hsl(120, 75%, 60%)',
                label: 'Green'
            },
            {
                color: 'hsl(240, 75%, 60%)',
                label: 'Blue'
            },
            {
                color: 'hsl(60, 75%, 60%)',
                label: 'Yellow'
            },
            {
                color: 'hsl(235, 85%, 35%)',
                label : 'Primary'
            }
        ];
    </script>
    <style>
        .cursor-pointer{
            cursor: pointer !important;
        }
        .cursor-disabled{
            cursor: not-allowed !important;
        }
        .cursor-scroll{
            cursor: all-scroll;
        }
        /* .form-control,
        .form-select{
            border : 1px solid var(--bs-gray-300) !important;
        } */
        .menu-accordion.active{
            color : #FF286B !important;
        }
        .swal2-textarea{
            color : #FFFFFF !important;
        }

        .background-partisi{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :cover !important;
        }

        .background-partisi-contain{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :contain !important;
        }
        .swal2-textarea {
            color : black !important;
        }
    </style>

    <?php
    if (isset($css) && is_array($css)) {
        foreach ($css as $cs) {
            echo $cs;
        }
    } else {
        echo (isset($css) && ($css != "") ? $css : "");
    }
    ?>
</head>
<!--end::Head-->