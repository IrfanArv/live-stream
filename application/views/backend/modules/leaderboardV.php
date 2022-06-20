<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Leaderboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Leaderboard</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="table" class="table mb-0 dataTable no-footer ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Phone</th>
                            <th>Quiz Score</th>
                            <th>Play Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var table;
    $(document).ready(function() {
        table = $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('dashboard/lead_list') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [-1],
                "orderable": false,
            }, ],
        });
    });

   
</script>