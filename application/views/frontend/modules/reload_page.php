<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webstream</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="Webstream">
    <meta name="keywords" content="Webstream" />
    <meta property="og:title" content="Webly" />
    <meta property="og:url" content="<?php echo current_url(); ?>" />
    <meta property="og:site_name" content="Webly" />
    <meta property="og:image" content="<?php echo base_url(); ?>assets/images/icon_w.png" />
    <meta property="og:description" content="Webly" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/icon_w.png" sizes="32x32" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/icon_w.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/icon_w.png" />
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/images/icon_w.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,600;0,700;0,800;1,200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/") ?>game.css?t=<?php echo time() ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/") ?>lead.css?t=<?php echo time() ?>" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

</head>

<!-- Selesai jawab quiz -->
<div class="modal fade" id="reload_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="reload_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-cent">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Opps ada masalah !</h5>
                    <p>Silahkan tutup halaman ini, lalu buka kembali</p>
                    <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_tjnaltsv.json" background="transparent" speed="1" style="height: 250px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
<script>
    $('document').ready(function() {
      $('#reload_modal').modal('show');
    });
</script>


</html>