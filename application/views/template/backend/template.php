<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title><?php echo $pagetitle; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Webly" />
    <link rel="icon" href="<?= base_url(); ?>assets/images/icon_w.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/plugins/sw/sweetalert.css">
    
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/plugins/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js" integrity="sha512-laacsEF5jvAJew9boBITeLkwD47dpMnERAtn4WCzWu/Pur9IkF0ZpVTcWRT/FUCaaf7ZwyzMY5c9vCcbAAuAbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</head>

<body class="">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <?= $_header; ?>
    <?= $_sidebar; ?>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
        <?= $_content; ?>
        </div>
    </div>


    <script src="<?= base_url(); ?>assets/backend/js/vendor-all.min.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/plugins/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/ripple.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/pcoded.min.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/plugins/bootstrap.min.js"></script>
    
    <script src="<?= base_url(); ?>assets/backend/js/plugins/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/plugins/dataTables.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/backend/js/plugins/bootstrap-notify.min.js"></script>
    <script src="<?= base_url(); ?>assets/backend/plugins/sw/sweetalert.js"></script>
    
    
    <script>
        function notify(message, type) {
            $.notify({
                message: message
            }, {
                type: type,
                allow_dismiss: false,
                label: 'Cancel',
                className: 'btn-xs btn-inverse',
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
                delay: 2500,
                animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
                },
                offset: {
                    x: 30,
                    y: 30
                }
            });
        };
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

</body>

</html>