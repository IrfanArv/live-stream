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
    <link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" rel="stylesheet" />
    <link href="<?php echo base_url("assets/css/") ?>game.css?t=<?php echo time() ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/") ?>lead.css?t=<?php echo time() ?>" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

</head>
<!-- video player -->
<div class="container-fluid" style="padding: 0!important;">
    <div class="row no-gutters">

        <div class="col-12 d-flex justify-content-center">
            <div id="player"></div>
        </div>
    </div>
</div>
<!-- show quiz here -->
<div id="div_result"></div>
<div id="div_vote"></div>
<!-- if stream is empty -->
<div id="stream_empty" style="display: none;">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-6 mx-auto">
                <div class="jumbotron text-center">
                    <h4 class="mb-3">No streaming at this time!</h4>
                    <lottie-player src="https://assets10.lottiefiles.com/private_files/lf30_iHPAva.json" background="transparent" speed="1" style="height: 250px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 justify-content-center title text-center judul pb-3 pt-3" id="vote_peserta" style="display: none;">
</div>

<!-- leadboard -->
<div class="container text-center mt-3" id="score_lead">
    <div class="lead col-lg-8 mx-auto">
        <div class="lead-title mb-2">
        </div>
        <table class="table table-borderless">
            <tbody class="show_score">
            </tbody>
        </table>
    </div>
</div>

<!-- Selesai jawab quiz -->
<div class="modal fade" id="selesai" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="quiztimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-cent">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Is Done !</h5>
                    <lottie-player src="https://assets3.lottiefiles.com/datafiles/s2s8nJzgDOVLOcz/data.json" background="transparent" speed="1" style="height: 150px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- waktu habis -->
<div class="modal fade" id="waktu_habis" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="quiztimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-cent">
            <div class="modal-body">
                <div class="text-center">
                    <lottie-player src="https://assets4.lottiefiles.com/private_files/lf30_cUAsuu.json" background="transparent" speed="1" style="height: 150px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- quiz run -->
<div class="modal fade" id="quiztime" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="quiztimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                <div class="text-center">
                    <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_z35UZP.json" background="transparent" speed="1" style="height: 150px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal welcome -->
<div class="modal fade" id="modalwelcome" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="quiztimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                <div class="text-center">
                    Hello <?php echo $full_name; ?>, Selamat Datang 👋
                </div>
                <div class="modal-gambar text-center">
                    <img src="<?php echo base_url('assets/images/banner/' . $banner) ?>" alt="" class="img-fluid" />
                    <a href="javascript:void(0)" data-dismiss="modal"><i class="fas fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- vote modal -->
<div class="modal fade" id="votetime" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="votetimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                <div class="text-center">
                    <lottie-player src="https://assets7.lottiefiles.com/datafiles/XGThiDa8TMFKz4PQOmjgGqMzfFP2LYWX6bjHNVNm/Vote/data.json" background="transparent" speed="1" style="height: 150px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- vote selesai -->
<div class="modal fade" id="vote_selesai" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="quiztimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-cent">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Thank you!</h5>
                    <lottie-player src="https://assets3.lottiefiles.com/datafiles/s2s8nJzgDOVLOcz/data.json" background="transparent" speed="1" style="height: 150px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
<script>
    $('document').ready(function() {
        $.ajax({
            url: "<?php echo site_url('cek_quiz') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(result) {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                }
                // quiz belum dimulai
                if (result.status == 0) {
                    $("#div_result").html(" ");
                    $('#modalwelcome').modal('show');
                } else if (result.status == 1) {
                    $("#div_result").html(result.loadView);
                } else if (result.status == 2) {
                    $("#div_result").html(" ");
                    load_vote();
                    reload_vote();
                    show_score();
                    reload_lead();
                }
                // pertanyaan habis
                if (result.pertanyaan_habis == 1 && result.userStatus == 1) {
                    $("#div_result").html(" ");
                    load_vote();
                    reload_vote();
                    show_score();
                    reload_lead();
                }
            }
        });


        // phuser quiz
        // Pusher.logToConsole = true;
        var pusher = new Pusher('579d64e9c5fbacc17651', {
            cluster: 'ap1',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            if (data.message === 'push_quiz') {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                }
                $('#modalwelcome').modal('hide');
                $('#quiztime').modal('show');
                setTimeout(function() {
                    $('#quiztime').modal('hide');
                }, 3000);
                $("#div_result").html(data.getView);
            }
        });
        // end pusher quiz
        // vote 
        var pusher_vote = new Pusher('579d64e9c5fbacc17651', {
            cluster: 'ap1',
            forceTLS: true
        });

        var channel_vote = pusher_vote.subscribe('vote-chanel');
        channel_vote.bind('vote-event', function(data) {
            if (data.message === 'push_vote') {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                }
                $('#modalwelcome').modal('hide');
                $('#votetime').modal('show');
                setTimeout(function() {
                    $('#votetime').modal('hide');
                }, 5000);
                $("#div_result").html(" ");
                $("#score_lead").html(" ");
                $("#div_vote").html(data.getView);
            }
        });

        function load_vote() {
            $.ajax({
                url: "<?php echo site_url('cek_voting') ?>",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.user_vote == 1 && data.status_vote == 1) {
                        $("#div_vote").html(" ");
                        $("#vote_peserta").show();
                        show_vote();
                    }
                    if (data.status_vote == 1 && data.user_vote == 0) {
                        $("#div_result").html(" ");
                        $("#div_vote").html(data.loadView);
                        // $("#score_lead").html(" ");
                    } else if (data.status_vote == 2) {
                        $("#vote_peserta").show();
                        show_vote();
                    }
                }
            });
        }

        function show_score() {
            $.ajax({
                url: '<?php echo site_url("get_score"); ?>',
                type: 'GET',
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var count = 1;
                    var i;
                    for (i = 0; i < data.length; i++) {

                        html += '<tr>' +
                            '<td><div class="rank">' + count++ + '</div></td>' +
                            '<td><div class="name">' + data[i].full_name + '</div></td>' +
                            '<td class="point">' + data[i].game_1_score + ' <img src="<?php echo base_url(); ?>assets/images/coin.png" class="img-fluid coin" alt="" ></div>' +
                            '</tr>';
                    }
                    $('.lead-title').html('Leaderboard');
                    $('.show_score').html(html);
                }
            });
        }

        function show_vote() {
            $.ajax({
                url: '<?php echo site_url("get_vote"); ?>',
                type: 'GET',
                async: true,
                dataType: 'json',
                success: function(data) {
                    $('#vote_peserta').html(data + ' Voters');
                }
            });
        }

        function reload_lead() {
            var pusher = new Pusher('579d64e9c5fbacc17651', {
                cluster: 'ap1',
                forceTLS: true
            });

            var channel = pusher.subscribe('channel-lead');
            channel.bind('event-lead', function(data) {
                if (data.message === 'push_lead') {
                    show_score();
                }
            });
        }
        function reload_vote() {
            var pusher = new Pusher('579d64e9c5fbacc17651', {
                cluster: 'ap1',
                forceTLS: true
            });

            var channel = pusher.subscribe('channel-vote');
            channel.bind('event-vote', function(data) {
                if (data.message === 'push_vote') {
                    show_score();
                }
            });
        }
    });
    // youtube stream
    var streamID = "<?php echo $data_stream; ?>"
    if (streamID !== "") {
        var tag = document.createElement("script");
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName("script")[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        function onYouTubeIframeAPIReady() {
            player = new YT.Player("player", {
                videoId: streamID,
                playerVars: {
                    rel: 0,
                    autoplay: 1,
                    enablejsapi: 1,
                    disablekb: 1,
                    showinfo: 0,
                    controls: 1,
                    fs: 1,
                },
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            event.target.playVideo();
        }
        var done = false;

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.ENDED) {
                stopVideo();
            }
        }

        function stopVideo() {
            player.stopVideo();
        }
    } else {
        $("#stream_empty").show();
    }

    // fullscreen browser
    // if (!document.fullscreenElement) {
    //     document.documentElement.requestFullscreen();
    // }
</script>


</html>