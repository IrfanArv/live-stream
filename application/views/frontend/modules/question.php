<div class="col-12 justify-content-center p-0">
  <div class="title text-center judul">
    Trivia Quiz
  </div>
</div>
<!-- time -->
<div id="question-page">
  <div class="trivia-timer" id="countdown">
    <div class="row">
      <div class="col text-right">
        <div id="minutes"></div>
      </div>
      <div class="col text-left">
        <div id="seconds"></div>
      </div>
    </div>
  </div>

  <div class="question-card">
    <div class="question-title mb-4">
      <?php if ($question->image != NULL || $question->image != "") { ?>
        <img style="width:200px" src="<?php echo base_url('assets/img/games/trivia/' . $question->image) ?>" alt="" class="mb-3  img-question img-blur" /><br>
      <?php } ?>
      <?php echo $question->title ?>
    </div>


    <?php foreach ($question_detail as $qd) { ?>
      <div class="question-answer" answer-id="<?php echo $qd->id ?>">
        <?php echo $qd->answer_choice ?>
      </div>
    <?php } ?>

    <div class="text-center text-muted mt-4" id="checking-answer" style="display:none">
      <div class="spinner-border spinner-border-sm mr-2 mb-1"></div>Loading...
    </div>
  </div>

</div>

<script type="text/javascript">
  var dataurl = "<?php base_url('room'); ?>"
  $(document).ready(function() {
    $(".question-answer").on('click', function() {
      var answer_id = $(this).attr('answer-id');
      $(this).addClass("set");
      $("#checking-answer").show();
      $(".question-answer").addClass("inactive");
      $.post("<?php echo base_url("check_answer") ?>", {
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
          qid: <?php echo $question->id ?>,
          answer: answer_id,
          trivia_id: <?php echo $trivia_id ?>
        })
        .done(function(data) {
          cekData()
        });
    });

    function cekData() {
      $.ajax({
        url: "<?php echo site_url('cek_quiz') ?>",
        type: "GET",
        dataType: "JSON",
        success: function(result) {
          if (result.pertanyaan_habis == 1) {
            $('#selesai').modal('show');
            setTimeout(function() {
              $('#selesai').modal('hide');
              // location.href = dataurl
              $("#div_result").html("");
                show_score();
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
            }, 3000);
          } else {
            $("#div_result").html(result.loadView);
          }
        }
      });
    }
    var waktu_quiz = "<?= $quiz_time_general; ?>"
    if (waktu_quiz == "") {
      console.log("waktu kosong");
    } else {
      // (function() {
      const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

        var total_waktu = waktu_quiz,
        countDown = new Date(total_waktu.replace(' ', 'T')).getTime(),
        x = setInterval(function() {
          var now = new Date().getTime(),
            distance = countDown - now;
            document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
          if (distance < 0) {
            clearInterval(x);
              $.ajax({
                url: "<?php echo site_url('end_quiz') ?>",
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                  $.post("<?php echo base_url("check_answer") ?>", {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    qid: <?php echo $question->id ?>,
                    answer: 0,
                    trivia_id: <?php echo $trivia_id ?>
                  });
                  $(".question-answer").addClass("inactive");
                  $('#waktu_habis').modal('show');
                  $("#question-page").hide();
                  setTimeout(function() {
                    $('#waktu_habis').modal('hide');
                    // location.href = dataurl
                    $("#div_result").html(" ");
                    show_score();
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
                  }, 1000);
                }
              });
            var countdown = document.getElementById("countdown");
             countdown.style.display = "none";
             var qwst = document.getElementById("question-page");
             qwst.style.display = "none";
             $(".question-answer").addClass("inactive");
                  $('#waktu_habis').modal('show');
                  $("#question-page").hide();
                  setTimeout(function() {
                    $('#waktu_habis').modal('hide');
                    // location.href = dataurl
                    $("#div_result").html(" ");
                    show_score();
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
                  }, 1000);
            clearInterval(x);
          }
        }, 0)
      // }());
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

  });

  
</script>