<?php

//patient.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">patient Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">patient List</h6>
                                </div>
                                <div class="col" align="right">
                                    <button type="button" name="add_patient" id="add_patient" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="patient_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Patient Id</th>
                                            <th>Email Address</th>
                                            <th>Password</th>
                                            <th>patient Name</th>
                                            <th>patient Phone No.</th>
                                            <th>patient Gender</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>

<div id="patientModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="patient_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add patient</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>patient Email Address <span class="text-danger">*</span></label>
                                <input type="text" name="patient_email_address" id="patient_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>patient Password <span class="text-danger">*</span></label>
                                <input type="password" name="patient_password" id="patient_password" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>patient Name <span class="text-danger">*</span></label>
                                <input type="text" name="patient_name" id="patient_name" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>patient Phone No. <span class="text-danger">*</span></label>
                                <input type="text" name="patient_phone_no" id="patient_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>patient Address </label>
                                <input type="text" name="patient_address" id="patient_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>patient Date of Birth </label>
                                <input type="text" name="patient_date_of_birth" id="patient_date_of_birth" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                   <!--  <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>patient Degree <span class="text-danger">*</span></label>
                                <input type="text" name="patient_degree" id="patient_degree" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>patient Speciality <span class="text-danger">*</span></label>
                                <input type="text" name="patient_expert_in" id="patient_expert_in" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->
                   <!--  <div class="form-group">
                        <label>patient Image <span class="text-danger">*</span></label>
                        <br />
                        <input type="file" name="patient_profile_image" id="patient_profile_image" />
                        <div id="uploaded_image"></div>
                        <input type="hidden" name="hidden_patient_profile_image" id="hidden_patient_profile_image" />
                    </div> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">View patient Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="patient_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    var dataTable = $('#patient_table').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
            url:"patient_action.php",
            type:"POST",
            data:{action:'fetch'}
        },
        "columnDefs":[
            {
                "targets":[0, 1, 2, 4, 5, 6, 7],
                "orderable":false,
            },
        ],
    });

    $('#patient_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $('#add_patient').click(function(){
        
        $('#patient_form')[0].reset();

        $('#patient_form').parsley().reset();

        $('#modal_title').text('Add patient');

        $('#action').val('Add');

        $('#submit_button').val('Add');

        $('#patientModal').modal('show');

        $('#form_message').html('');

    });

    $('#patient_form').parsley();

    $('#patient_form').on('submit', function(event){
        event.preventDefault();
        if($('#patient_form').parsley().isValid())
        {  

         // echo "TESSS";


            $.ajax({
                url:"patient_action.php",
                method:"POST",
                data: new FormData(this),
                dataType:'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend:function()
                {
                    $('#submit_button').attr('disabled', 'disabled');
                    $('#submit_button').val('wait...');
                },
                success:function(data)
                {
                    $('#submit_button').attr('disabled', false);
                    if(data.error != '')
                    {
                        $('#form_message').html(data.error);
                        $('#submit_button').val('Add');
                    }
                    else
                    {
                        $('#patientModal').modal('hide');
                        $('#message').html(data.success);
                        dataTable.ajax.reload();

                        setTimeout(function(){

                            $('#message').html('');

                        }, 5000);
                    }
                }
            })
        }
    });

    $(document).on('click', '.edit_button', function(){

        var patient_id = $(this).data('id');

        $('#patient_form').parsley().reset();

        $('#form_message').html('');

        $.ajax({

            url:"patient_action.php",

            method:"POST",

            data:{patient_id:patient_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {

                $('#patient_id').val(data.patient_id);

                $('#patient_email_address').val(data.patient_email_address);
                $('#patient_password').val(data.patient_password);
                $('#patient_name').val(data.patient_first_name);
                // $('#uploaded_image').html('<img src="'+data.patient_profile_image+'" class="img-fluid img-thumbnail" width="150" />');
                // $('#hidden_patient_profile_image').val(data.patient_profile_image);
                $('#patient_phone_no').val(data.patient_phone_no);
                $('#patient_address').val(data.patient_address);
                $('#patient_date_of_birth').val(data.patient_date_of_birth);
                $('#patient_gender').val(data.patient_gender);
                // $('#patient_expert_in').val(data.patient_expert_in);

                $('#modal_title').text('Edit patient');

                $('#action').val('Edit');

                $('#submit_button').val('Edit');

                $('#patientModal').modal('show');

                $('#hidden_id').val(patient_id);

            }

        })

    });

    $(document).on('click', '.status_button', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        var next_status = 'Active';
        if(status == 'Active')
        {
            next_status = 'Inactive';
        }
        if(confirm("Are you sure you want to "+next_status+" it?"))
        {

            $.ajax({

                url:"patient_action.php",

                method:"POST",

                data:{id:id, action:'change_status', status:status, next_status:next_status},

                success:function(data)
                {

                    $('#message').html(data);

                    dataTable.ajax.reload();

                    setTimeout(function(){

                        $('#message').html('');

                    }, 5000);

                }

            })

        }
    });

    $(document).on('click', '.view_button', function(){
        var patient_id = $(this).data('id');

        $.ajax({

            url:"patient_action.php",

            method:"POST",

            data:{patient_id:patient_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                // html += '<tr><td colspan="2" class="text-center"><img src="'+data.patient_profile_image+'" class="img-fluid img-thumbnail" width="150" /></td></tr>';

                html += '<tr><th width="40%" class="text-right">patient Email Address</th><td width="60%">'+data.patient_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">patient Password</th><td width="60%">'+data.patient_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">patient Name</th><td width="60%">'+data.patient_first_name+ ' '+data.patient_last_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">patient Phone No.</th><td width="60%">'+data.patient_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">patient Address</th><td width="60%">'+data.patient_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">patient Date of Birth</th><td width="60%">'+data.patient_date_of_birth+'</td></tr>';
                // html += '<tr><th width="40%" class="text-right">patient Qualification</th><td width="60%">'+data.patient_degree+'</td></tr>';

                // html += '<tr><th width="40%" class="text-right">patient Speciality</th><td width="60%">'+data.patient_expert_in+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#patient_details').html(html);

            }

        })
    });

    $(document).on('click', '.delete_button', function(){

        var id = $(this).data('id');

        if(confirm("Are you sure you want to remove it?"))
        {

            $.ajax({

                url:"patient_action.php",

                method:"POST",

                data:{id:id, action:'delete'},

                success:function(data)
                {

                    $('#message').html(data);

                    dataTable.ajax.reload();

                    setTimeout(function(){

                        $('#message').html('');

                    }, 5000);

                }

            })

        }

    });



});
</script>