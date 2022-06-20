<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Room Stream</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Room Stream</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="float-right">
                <button class="btn btn-success btn-sm btn-round has-ripple" onclick="addRoom()"><i class="feather icon-plus-circle"></i> New Room</button>
            </div>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="table" class="table mb-0 dataTable no-footer ">
                    <thead>
                        <tr>
                            <th>Room Name</th>
                            <th>Youtube Stream Key</th>
                            <th>Status</th>
                            <th>Last Update</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- modals -->
<div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="form" enctype="multipart/form-data">
                    <input type="hidden" value="" name="id" />
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Name">Room Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder=" " required>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Name">Stream Key URI</label>
                                <input type="text" name="stream_key" class="form-control" id="stream_key" placeholder=" " required>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-dange" data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table;
    var save_method;
    $(document).ready(function() {
        table = $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('dashboard/room_list') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [-1],
                "orderable": false,
            }, ],
        });
    });

    function addRoom() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal-link').modal('show');
        $('.modal-title').text('Create Stream Room');
    }

    $('#form').submit(function(e) {
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('dashboard/room_add') ?>";
            notify('Room stream created', 'inverse');
        } else {
            url = "<?php echo site_url('dashboard/room_page') ?>";
            notify('Room stream updated', 'inverse');
        }
        e.preventDefault();
        $.ajax({
            "url": url,
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                $('#form')[0].reset();
                $('#modal-link').modal('hide');
                reload_table();

            }

        });
    });

    function reload_table() {
        table.ajax.reload();
    }

    function roomEdit(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();


        $.ajax({
            url: "<?php echo site_url('dashboard/room_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id_room);
                $('[name="name"]').val(data.name);
                $('[name="stream_key"]').val(data.stream_key);
                $('#modal-link').modal('show');
                $('.modal-title').text('Update Room Stream');

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function updateMenit(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();


        $.ajax({
            url: "<?php echo site_url('dashboard/room_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="menit"]').val(data.quiz_time);
                $('.modal-title').text('Update Waktu Quiz');

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function roomActive(id) {

        swal({
                title: "Active this room!",
                text: "Active this room stream ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                cancelButtonText: "Cancel",
                confirmButtonText: "Active",
                closeOnConfirm: true,
                closeOnCancel: true
            },

            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo site_url('dashboard/room_aktif') ?>/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(result) {
                            if (result.status == true) {
                                reload_table();
                                swal("Success", "Room has been active", "success");
                            } else {
                                swal("Cancel", "Cancel", "error");
                            }
                        },
                        error: function(err) {
                            swal("Error", "Failed", "error");
                        }
                    });
                } else {
                    swal("Error", "Failed", "error");
                }
            });
    }

    function roomDeactive(id) {

swal({
        title: "Deactive this room!",
        text: "Deactive this room stream ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        cancelButtonText: "Cancel",
        confirmButtonText: "Deactive",
        closeOnConfirm: true,
        closeOnCancel: true
    },

    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "<?php echo site_url('dashboard/room_mati') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(result) {
                    if (result.status == true) {
                        reload_table();
                        swal("Success", "Room has been deactive", "success");
                    } else {
                        swal("Cancel", "Cancel", "error");
                    }
                },
                error: function(err) {
                    swal("Error", "Failed", "error");
                }
            });
        } else {
            swal("Error", "Failed", "error");
        }
    });
}

    function deleteRoom(id) {

        swal({
                title: "Are you sure ?",
                text: "Delete this Room",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonText: "Cancel",
                confirmButtonText: "Delete",
                closeOnConfirm: true,
                closeOnCancel: true
            },

            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo site_url('dashboard/room_delete') ?>/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(result) {
                            if (result.status == true) {
                                reload_table();
                                swal("Success", "Room delete success", "success");
                            } else {
                                swal("Cancel", "Room undelete", "error");
                            }
                        },
                        error: function(err) {
                            swal("Error", "Room delete failed", "error");
                        }
                    });
                } else {
                    swal("Error", "Room delete failed", "error");
                }
            });
    }
</script>