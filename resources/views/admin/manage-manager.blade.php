@extends('layout/admin-layout')

@section('space-work')
<div class="card">
  <div class="card-header">All Managers <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addmodal">Add New</button></div>
  <div class="card-body">
     {{-- these two spans will display flash messages --}}
     <span class="alert alert-success" id="alert-success" style="display: none;"></span>
     <span class="alert alert-danger" id="alert-danger" style="display: none;"></span>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @if (count($all_managers) > 0)
              @foreach ($all_managers as $item)
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$item->first_name}} {{$item->middle_name}} {{$item->last_name}}</td>
                      <td>{{$item->email}}</td>
                      <td>{{$item->phone_number}}</td>
                      <td><button class="btn btn-primary btn-sm editBtn" data-id="{{$item->user_id}}" data-fname="{{$item->first_name}}"  data-mname="{{$item->middle_name}}" data-lname="{{$item->last_name}}" data-phone="{{$item->phone_number}}" data-email="{{$item->email}}" data-bs-toggle="modal" data-bs-target="#editModal">edit</button></td>
                      <td><button class="btn btn-danger btn-sm deleteBtn" data-id="{{$item->user_id}}" data-name="{{$item->name}}" data-bs-toggle="modal" data-bs-target="#deleteModal">delete</button></td>
                  </tr>
              @endforeach
          @else
              <tr>
                <td colspan="4">No data found!</td>
              </tr>
          @endif
      </tbody>
  </table>
  </div>
</div>
{{-- add modal start here --}}
<div class="modal fade" id="addmodal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register New Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- No Labels Form -->
         <form class="row g-3" id="addManager">
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your First Name" name="fname">
            <span id="fname_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your Middle Name" name="mname">
            <span id="mname_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your Last Name" name="lname">
            <span id="lname_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <span id="email_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Phone number" name="phone">
            <span id="phone_error" class="text-danger"></span>
          </div>
        <!-- End No Labels Form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary addBtn">Save changes</button> 
        {{-- make sure the button type attribute is submit --}}
     
      </div>
    </form>
    </div>
  </div>
</div>
{{-- ends here --}}

{{-- edit modal start here --}}
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- No Labels Form -->
         <form class="row g-3" id="editManagerForm">
          {{-- this is a hidden manager_id --}}
          <input type="hidden" name="manager_id" id="manager_id"> 
          {{-- this input will be hidden, but used to carry the managers user_id --}}
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your First Name" name="fname" id="fname">
            <span id="fname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your Middle Name" name="mname" id="mname">
            <span id="mname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder="Your Last Name" name="lname" id="lname">
            <span id="lname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email">
            <span id="email_edit_error" class="text-danger"></span> 
            {{-- this span for showing validation errors is differet from those from add form also the jquery function for display validation errors is different--}}
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Phone number" name="phone" id="phone">
            <span id="phone_edit_error" class="text-danger"></span>
          </div>
        <!-- End No Labels Form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary editBTN">Save changes</button> 
        {{-- make sure the button type attribute is submit --}}
     
      </div>
    </form>
    </div>
  </div>
</div>
{{-- ends here --}}

{{-- delete modal start here --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="card-title text-danger">Are you sure you want to delete this data? </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary deleteBTN">Save changes</button> 
      </div>
    </div>
  </div>
</div>
{{-- ends here --}}

{{-- our scripts starts here --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
  $(document).ready(function(){
    // on submit of the form
    $('#addManager').submit(function(e){
                e.preventDefault();
                let formData = $(this).serialize(); //get all form details
                console.log(formData);
                $.ajax({
                    url: '{{ route("RegisterManager")}}', //this is our submission route
                    type: 'GET',
                    data: formData,
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        $('.addBtn').prop('disabled', true); //here we disable the save button
                    },
                    complete: function(){
                        $('.addBtn').prop('disabled', false); // here we enable it again
                    },
                    success: function(data){
                        if(data.success == true){
                            //close modal
                            $('#addmodal').modal('hide');
                            // print success message
                            printSuccessMsg(data.msg);
                            var reloadInterval = 5000; //page reload delay duration
                        // Function to reload the whole page
                        function reloadPage() {
                            location.reload(true); // Pass true to force a reload from the server and not from the browser cache
                        }
                        // Set an interval to reload the page after the specified time
                        var intervalId = setInterval(reloadPage, reloadInterval);
                        }else if(data.success == false){
                            printErrorMsg(data.msg);
                        }else{
                            printValidationErrorMsg(data.msg);
                        }
                    }
                });
                return false;
                
            });
            // here i declare the user_id
            var user_id = 0;
            // here delete functionality
            $('.deleteBtn').on('click',function(){
                 user_id = $(this).attr('data-id');
                var fname = $(this).attr('data-fname');
                // delete any car name
                $('#first_name').html('');
                // then add the new one..
                $('#first_name').html(fname);
            });

            $('.deleteBTN').on('click',function(){
                var url = "{{ route('deleteManager','user_id')}}";
                url = url.replace('user_id',user_id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        $('.deleteBTN').prop('disabled', true);
                    },
                    complete: function(){
                        $('.deleteBTN').prop('disabled', false);
                    },
                    success: function(data){
                        // leave it as it is..
                        if(data.success == true){
                            // this is the correct way to close modal
                            $('#deleteModal').modal('hide');
                            printSuccessMsg(data.msg);
                            var reloadInterval = 5000; //page reload delay duration
                        // Function to reload the whole page
                        function reloadPage() {
                            location.reload(true); // Pass true to force a reload from the server and not from the browser cache
                        }
                        // Set an interval to reload the page after the specified time
                        var intervalId = setInterval(reloadPage, reloadInterval);
                        }else{
                            printErrorMsg(data.msg);
                        }
                        // this is because in delete functionality we don't have validations..
                    }
                });

            });
            // edit car functionality..
            $('.editBtn').on('click',function(){
                // get all car data that we passed on the edit button
                var manager_id = $(this).attr('data-id'); //this is our user_id
                var fname = $(this).attr('data-fname');
                var mname = $(this).attr('data-mname');
                var lname = $(this).attr('data-lname');
                var phone = $(this).attr('data-phone');
                var email = $(this).attr('data-email');

                // then display them in a edit form
                $('#fname').val(fname);
                $('#mname').val(mname);
                $('#lname').val(lname);
                $('#phone').val(phone);
                $('#email').val(email);
                $('#manager_id').val(manager_id);

                // but here we miss the email field because we don't have the email field from managers table so to achieve this
                // join managers table and users table to get email also and add it in our form
               
            });

             // then submit the form
             $('#editManagerForm').submit(function(e){
                    e.preventDefault();
                    let formData = $(this).serialize();

                    $.ajax({
                        url: '{{ route("editManager")}}',
                        data: formData,
                        type: 'GET',
                        contentType: false,
                        processData:false,
                        beforeSend:function(){
                            $('.editButton').prop('disabled', true);
                        },
                        complete: function(){
                            $('.editButton').prop('disabled', false);
                        },
                        success: function(data){
                            if(data.success == true){
                                $('#editModal').modal('hide');
                                printSuccessMsg(data.msg);
                                var reloadInterval = 5000; //page reload delay duration
                            // Function to reload the whole page
                            function reloadPage() {
                                location.reload(true); 
                            }
                            // Set an interval to reload the page after the specified time
                            var intervalId = setInterval(reloadPage, reloadInterval);
                            }else if(data.success == false){
                                printErrorMsg(data.msg);
                            }else{
                                printEditValidationErrorMsg(data.msg);
                            }
                    }
                    });
                });
                function printEditValidationErrorMsg(msg){
                  $.each(msg, function(field_name, error){
                      // this will find a input id for error 
                      $(document).find('#'+field_name+'_edit_error').text(error);
                  });
                }
                function printValidationErrorMsg(msg){
                  $.each(msg, function(field_name, error){
                      // this will find a input id for error 
                      $(document).find('#'+field_name+'_error').text(error);
                  });
                }
                function printErrorMsg(msg){
                  $('#alert-danger').html('');
                  $('#alert-danger').css('display','block');
                  $('#alert-danger').append(''+msg+'');
                }
                function printSuccessMsg(msg){
                  $('#alert-success').html('');
                  $('#alert-success').css('display','block');
                  $('#alert-success').append(''+msg+'');
                  // if form successfully submitted reset form
                  document.getElementById('addManager').reset();
                }
  });
</script>
@endsection