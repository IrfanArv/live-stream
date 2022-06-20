<?php
error_reporting(0);

?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Hai <?php echo $this->session->userdata('fullName'); ?> ,
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $Hour = date('G');
                        if ($Hour >= 00 && $Hour <= 11) {
                            echo "Selamat Pagi";
                        } else if ($Hour >= 12 && $Hour <= 15) {
                            echo "Selamat Siang";
                        } else if ($Hour >= 16 && $Hour <= 18) {
                            echo "Selamat Sore";
                        } else if ($Hour >= 19 || $Hour <= 23) {
                            echo "Selamat Malam";
                        }
                        ?>
                        👋
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if ($stream_status == !1) { ?>
        <div class="col-md-6">
            <div class="card user-card2 quiz_card">
                <div class="card-body text-center">
                    <h6 class="m-b-15">Session Quiz</h6>
                    <div id="title">
                        <h6 class="m-b-10 m-t-10"><?= $title_quiz; ?></h6>
                    </div>
                    <div class="row text-center" id="countdown">
                        <div class="col">
                            <h4 class="m-0" id="minutes"><?= $quiz_time; ?></h4>
                            <span>Menit</span>
                        </div>
                        <div class="col">
                            <h4 class="m-0" id="seconds">0</h4>
                            <span>Detik</span>
                        </div>
                    </div>
                    <div class="row justify-content-center m-t-10 b-t-default m-l-0 m-r-0">
                        <div class="col m-t-15 b-r-default">
                            <h6><?php echo $total_quiz; ?> Pertanyaan</h6>
                        </div>
                    </div>
                </div>
                <div id="button">
                    <?= $button_quiz ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <div class="col-md-6">
            <div class="card user-card2 vote_card">
                <div class="card-body text-center">
                    <h6 class="m-b-15">Session Voting</h6>
                    <div id="title_vote">
                        <h6 class="m-b-10 m-t-10"><?= $title_vote; ?></h6>
                    </div>
                    <div class="row text-center" id="countdown_vote">
                        <div class="col">
                            <h4 class="m-0" id="minutes_vote"><?= $vote_time; ?></h4>
                            <span>Menit</span>
                        </div>
                        <div class="col">
                            <h4 class="m-0" id="seconds_vote">0</h4>
                            <span>Detik</span>
                        </div>
                    </div>
                </div>
                <div id="button_vote">
                    <?= $button_vote ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-warning btn-block mb-5" onclick="reset_quiz()"> Reset Quiz</button>
        </div>
</div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js" integrity="sha512-ju6u+4bPX50JQmgU97YOGAXmRMrD9as4LE05PdC3qycsGQmjGlfm041azyB1VfCXpkpt1i9gqXCT6XuxhBJtKg==" crossorigin="anonymous"></script>

        <script>
            $('document').ready(function() {
                // on reload or refresh
                var waktu_quiz = "<?= $quiz_time_general; ?>"
                countDown = new Date(waktu_quiz).getTime();
                console.log(countDown);
                if (waktu_quiz == "") {
                    console.log("waktu kosong");
                } else {
                    const second = 1000,
                        minute = second * 60,
                        hour = minute * 60,
                        day = hour * 24;

                    var selesai = waktu_quiz,
                        countDown = new Date(selesai.replace(' ', 'T')).getTime(),
                        x = setInterval(function() {
                            var now = new Date().getTime(),
                                distance = countDown - now;
                            document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                                document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
                            if (distance < 0) {
                                clearInterval(x);
                                var status_quiz = "<?= $status_quiz; ?>"
                                if (status_quiz == 1) {
                                    $.ajax({
                                        url: "<?php echo site_url('dashboard/stop_quiz') ?>",
                                        type: "POST",
                                        dataType: "JSON",
                                        success: function(data) {
                                            refresh_card();
                                            console.log('update quiz');
                                        }
                                    });
                                }
                                var countdown = document.getElementById("countdown");
                                countdown.style.display = "none";
                                refresh_card();
                                clearInterval(x);
                            }
                        }, 0)

                }

            });

            $('document').ready(function() {
                // on reload or refresh
                var waktu_vote = "<?= $vote_time_general; ?>"
                countDown_vote = new Date(waktu_vote).getTime();

                if (waktu_vote == "") {
                    console.log("waktu vote kosong");
                } else {
                    const second = 1000,
                        minute = second * 60,
                        hour = minute * 60,
                        day = hour * 24;

                    var selesai_vote = waktu_vote,
                    countDown_vote = new Date(selesai_vote.replace(' ', 'T')).getTime(),
                        x = setInterval(function() {
                            var now_vote = new Date().getTime(),
                                distance = countDown_vote - now_vote;
                                document.getElementById("minutes_vote").innerText = Math.floor((distance % (hour)) / (minute)),
                                document.getElementById("seconds_vote").innerText = Math.floor((distance % (minute)) / second);
                            if (distance < 0) {
                                clearInterval(x);
                                var countdown_vote = document.getElementById("countdown_vote");
                                countdown_vote.style.display = "none";
                                refresh_card();
                                clearInterval(x);
                            }
                        }, 0)

                }

            });

            function refresh_card() {
                $("#title").load(window.location.href + " #title");
                $("#button").load(window.location.href + " #button");
                $("#title_vote").load(window.location.href + " #title_vote");
                $("#button_vote").load(window.location.href + " #button_vote");
            }


            function quiz_jalan() {
                swal({
                        title: "Jalankan Session quiz!",
                        text: "Session quiz hanya dapat berjalan satu kali! Lanjutkan ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        cancelButtonText: "Batal",
                        confirmButtonText: "Lanjutkan",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },

                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "<?php echo site_url('dashboard/jalan_quiz') ?>",
                                type: "POST",
                                dataType: "JSON",
                                success: function(data) {
                                    if (data.status == true) {
                                        swal("Berhasil", "Session quiz berhasil dijalankan", "success");
                                        refresh_card();

                                        var waktu_quiz = data.waktu_quiz;
                                        const second = 1000,
                                            minute = second * 60,
                                            hour = minute * 60,
                                            day = hour * 24;
                                        var selesai = waktu_quiz,
                                            countDown = new Date(selesai.replace(' ', 'T')).getTime(),
                                            x = setInterval(function() {

                                                var now = new Date().getTime(),
                                                    distance = countDown - now;
                                                document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                                                    document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
                                                if (distance < 0) {
                                                    clearInterval(x);
                                                    $.ajax({
                                                        url: "<?php echo site_url('dashboard/stop_quiz') ?>",
                                                        type: "POST",
                                                        dataType: "JSON",
                                                        success: function(data) {
                                                            refresh_card();
                                                        }
                                                    });
                                                    console.log('waktu habis ini fungsi setelah dijalankan quiz');
                                                    // refresh_card();
                                                    var countdown = document.getElementById("countdown");
                                                    countdown.style.display = "none";
                                                    window.location.reload();
                                                    clearInterval(x);
                                                }
                                            }, 0)
                                    } else {
                                        swal("Error", "Ada masalah", "error");
                                    }
                                }
                            });
                        } else {
                            swal("Ga Jadi", "Session quiz tidak jadi dijalankan", "success");
                        }
                    });
            }

            function reset_quiz() {
                swal({
                        title: "Reset Quiz",
                        text: "Reset Quiz ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        cancelButtonText: "Batal",
                        confirmButtonText: "Reset",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },

                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "<?php echo site_url('dashboard/reset_quiz') ?>",
                                type: "POST",
                                dataType: "JSON",
                                success: function(data) {
                                    if (data.status == true) {
                                        swal("Berhasil", "Quiz sudah di reset", "success");
                                        window.location.reload();
                                    } else {
                                        swal("Error", "Ada masalah", "error");
                                    }
                                }
                            });
                        } else {
                            swal("Ga Jadi", "Batal", "success");
                        }
                    });
            }

            // vote
            function vote_jalan() {
                swal({
                        title: "Jalankan Session Voting!",
                        text: "Session voting hanya dapat berjalan satu kali! Lanjutkan ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        cancelButtonText: "Batal",
                        confirmButtonText: "Lanjutkan",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },

                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "<?php echo site_url('dashboard/jalan_vote') ?>",
                                type: "POST",
                                dataType: "JSON",
                                success: function(data) {
                                    if (data.status == true) {
                                        swal("Berhasil", "Session vote berhasil dijalankan", "success");
                                        refresh_card();

                                        var waktu_vote = data.waktu_vote;
                                        const second = 1000,
                                            minute = second * 60,
                                            hour = minute * 60,
                                            day = hour * 24;
                                        var selesai = waktu_vote,
                                            countDown = new Date(selesai.replace(' ', 'T')).getTime(),
                                            x = setInterval(function() {

                                                var now = new Date().getTime(),
                                                    distance = countDown - now;
                                                document.getElementById("minutes_vote").innerText = Math.floor((distance % (hour)) / (minute)),
                                                    document.getElementById("seconds_vote").innerText = Math.floor((distance % (minute)) / second);
                                                if (distance < 0) {
                                                    clearInterval(x);
                                                    console.log('waktu habis ini fungsi setelah dijalankan vote');
                                                    // refresh_card();
                                                    var countdown = document.getElementById("countdown_vote");
                                                    countdown.style.display = "none";
                                                    window.location.reload();
                                                    clearInterval(x);
                                                }
                                            }, 0)
                                    } else {
                                        swal("Error", "Ada masalah", "error");
                                    }
                                }
                            });
                        } else {
                            swal("Ga Jadi", "Session vote tidak jadi dijalankan", "success");
                        }
                    });
            }
        </script>