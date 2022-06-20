<?php if ($this->session->flashdata('msg') == 'sukses') : ?>
    <script>
        $(window).on('load', function() {
            notify('Settings updated successfully', 'inverse');
        });
    </script>
<?php else : ?>
<?php endif; ?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Settings</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo base_url() . 'dashboard/setting_update' ?>" method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Quiz Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group fill">
                                    <label>Status</label>
                                    <input type="text" class="form-control" aria-describedby="emailHelp" value="<?php echo $quiz_status; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group fill">
                                    <label class="" for="Text">Waktu Mulai</label>
                                    <input type="text" class="form-control" value="<?php echo $started_quiz; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Waktu Selesai</label>
                                    <input type="text" class="form-control" value="<?php echo $ended_quiz; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Durasi Quiz (Dalam Menit)</label>
                                    <input type="number" class="form-control" name="quiz_time" value="<?php echo $quiz_time; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Vote Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group fill">
                                    <label>Status</label>
                                    <input type="text" class="form-control" aria-describedby="emailHelp" value="<?php echo $vote_status; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group fill">
                                    <label class="" for="Text">Waktu Mulai</label>
                                    <input type="text" class="form-control" value="<?php echo $started_vote; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Waktu Selesai</label>
                                    <input type="text" class="form-control" value="<?php echo $ended_vote; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Durasi Voting (Dalam Menit)</label>
                                    <input type="number" class="form-control" name="vote_time" value="<?php echo $vote_time; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-block btn-success float-right">Simpan</button>
    </div>
</form>