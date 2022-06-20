<div id="vote-page">
  <div class="trivia-timer" id="countdown">
    <div class="row">
      <div class="col text-right">
        <div id="minutes_vote"></div>
      </div>
      <div class="col text-left">
        <div id="seconds_vote"></div>
      </div>
    </div>
  </div>

  <div class="question-card">
      <div class="question-answer" user-id="<?php echo @$this->session->is_user;?>">
        YES
      </div>
    <div class="text-center text-muted mt-4" id="checking-answer" style="display:none">
      <div class="spinner-border spinner-border-sm mr-2 mb-1"></div>Loading...
    </div>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".question-answer").on('click', function() {
      $(this).addClass("set");
      $("#checking-answer").show();
      $(".question-answer").addClass("inactive");
       $.post("<?php echo base_url("save_vote") ?>", {
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
          vote: 1
        })
        .done(function(data) {
          $('#vote_selesai').modal('show');
          setTimeout(function() {
              $('#vote_selesai').modal('hide');
              $("#div_vote").html("");
              $("#vote_peserta").show();
                show_vote();
                show_score();
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
              // location.reload();
            }, 3000);
        });
    });

    var waktu_vote = "<?= $end_time_vote; ?>"
    countDown = new Date(waktu_vote.replace(' ', 'T')).getTime();
    if (waktu_vote == "") {
      console.log("waktu vote kosong");
    } else {
      // (function() {
      const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

        var total_waktu = waktu_vote,
        countDown = new Date(total_waktu.replace(' ', 'T')).getTime(),
        x = setInterval(function() {
          var now = new Date().getTime(),
            distance = countDown - now;
            document.getElementById("minutes_vote").innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById("seconds_vote").innerText = Math.floor((distance % (minute)) / second);
          if (distance < 0) {
            clearInterval(x);
              $.ajax({
                url: "<?php echo site_url('end_vote') ?>",
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                  $(".question-answer").addClass("inactive");
                  $('#waktu_habis').modal('show');
                  $("#vote-page").hide();
                  setTimeout(function() {
                    $('#waktu_habis').modal('hide');
                    // location.reload();
                    $("#div_vote").html(" ");
                    $("#vote_peserta").show();
                    show_vote();
                    show_score();
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
                  }, 1000);
                }
              });
            var countdown = document.getElementById("countdown");
             countdown.style.display = "none";
             var qwst = document.getElementById("vote-page");
             qwst.style.display = "none";
             $(".question-answer").addClass("inactive");
                  $('#waktu_habis').modal('show');
                  $("#vote-page").hide();
                  setTimeout(function() {
                    $('#waktu_habis').modal('hide');
                    // location.reload();
                    $("#div_vote").html(" ");
                    $("#vote_peserta").show();
                    show_vote();
                    show_score();
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

  });

  
</script>