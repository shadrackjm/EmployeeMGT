@extends('layout/manager-layout')

@section('space-work')
<div class="card">
  <div class="card-header">All Employees <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addmodal">Add New</button></div>
  <div class="card-body">
     {{-- these two spans will display flash messages --}}
     <span class="alert alert-success" id="alert-success" style="display: none;"></span>
     <span class="alert alert-danger" id="alert-danger" style="display: none;"></span>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Job Title</th>
          <th>Department</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Country</th>
          <th>State</th>
          <th>City</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @if (count($all_employees) > 0)
              @foreach ($all_employees as $item)
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$item->first_name}} {{$item->middle_name}} {{$item->last_name}}</td>
                      <td>{{$item->job_title}}</td>
                      <td>{{$item->department_name}}</td>
                      <td>{{$item->email}}</td>
                      <td>{{$item->phone_number}}</td>
                      <td>{{$item->country_name}}</td> 
                      {{-- if it were name for the three it was confusing and only country name would be displayed here!! --}}
                      <td>{{$item->state_name}}</td>
                      <td>{{$item->city_name}}</td>
                      <td><button class="btn btn-primary btn-sm editBtn" data-id="{{$item->user_id}}" data-fname="{{$item->first_name}}"  data-mname="{{$item->middle_name}}" data-lname="{{$item->last_name}}" data-phone="{{$item->phone_number}}" data-email="{{$item->email}}" data-job="{{$item->job_title}}" data-country="{{$item->country_id}}" data-state="{{$item->state_id}}" data-city="{{$item->city_id}}" data-department_name="{{$item->department_name}}" data-department_id="{{$item->department_id}}" data-bs-toggle="modal" data-bs-target="#editModal">edit</button></td>
                      <td><button class="btn btn-danger btn-sm deleteBtn" data-id="{{$item->user_id}}" data-name="{{$item->name}}" data-bs-toggle="modal" data-bs-target="#deleteModal">delete</button></td>
                  </tr>
              @endforeach
          @else
              <tr>
                <td colspan="10">No data found!</td>
              </tr>
          @endif
      </tbody>
  </table>
  </div>
</div>
{{-- add modal start here --}}
<div class="modal  fade" id="addmodal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- here i added larger property  --}}
    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register New Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- No Labels Form -->
         <form class="row g-3" id="addEmployee">
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder=" First Name" name="fname">
            <span id="fname_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder=" Middle Name" name="mname">
            <span id="mname_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" placeholder=" Last Name" name="lname">
            <span id="lname_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <span id="email_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Job Title" name="job_title">
            <span id="job_title_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <select name="department_id" id="department_id" class="form-select">
                <option value="">Select Department</option>
                @foreach ($all_departments as $item)
                  <option value="{{$item->id}}">{{$item->department_name}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Phone Number" name="phone">
            <span id="phone_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <select name="country" id="country_name" class="form-select">
              {{-- here we displayed the countries in a dropdown also what i add 
                is a dependent dropdown functionality here..
                as you've seen on change of country dropdown activate the state dropdown 
                and i fetched only states found on that specific country
                and lastly on change of a state call the cities found on that specific state
                meaning that we will have the following path
                country > state > city

                now let me show you how i did it in a quick way..
                --}}
                <option value="">select country</option>
                @foreach ($all_countries as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <span id="country_error" class="text-danger"></span>
          </div>
          {{-- these two select tags will be filled according to country selected --}}
          
          <div class="col-md-6">
            <select name="state" id="state_name" class="form-select">
            </select>
            <span id="state_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <select name="city" id="city_name" class="form-select">
            </select>
            <span id="city_error" class="text-danger"></span>
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
        <h5 class="modal-title">Edit Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <!-- No Labels Form -->
         <form class="row g-3" id="editEmployeeForm">
          {{-- this is a hidden manager_id --}}
          <input type="hidden" name="employee_id" id="employee_id"> 
           {{--here was a challenge i changed the attributes to employee_id but in jquery i didn't so it was sending request to server without employee_id  --}}
          {{-- this input will be hidden, but used to carry the managers user_id --}}
          <div class="col-md-12">
            <input type="text" class="form-control" name="fname" id="fname">
            <span id="fname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control"  name="mname" id="mname">
            <span id="mname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control" name="lname" id="lname">
            <span id="lname_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" name="email" id="email">
            <span id="email_edit_error" class="text-danger"></span> 
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" name="phone" id="phone">
            <span id="phone_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" name="job_title" id="job">
            <span id="job_title_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <select name="country" id="country_name_edit" class="form-select">
            </select>
            <span id="country_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <select name="department_id" id="department_name_edit" class="form-select">
            </select>
            <span id="department_id_edit_error" class="text-danger"></span>
          </div>
          {{-- these two select tags will be filled according to country selected --}}
          <div class="col-md-6">
            <select name="state" id="state_name_edit" class="form-select">
            </select>
            <span id="state_edit_error" class="text-danger"></span>
          </div>
          <div class="col-md-6">
            <select name="city" id="city_name_edit" class="form-select">
            </select>
            <span id="city_edit_error" class="text-danger"></span>
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
    $('#addEmployee').submit(function(e){
                e.preventDefault();
                let formData = $(this).serialize(); //get all form details
                console.log(formData);
                $.ajax({
                    url: '{{ route("RegisterEmployee")}}', //this is our submission route
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
                        console.log(data);
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
                var url = "{{ route('deleteEmployee','user_id')}}";
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
                            var reloadInterval = 1000; //page reload delay duration
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
            // edit employee functionality..
            $('.editBtn').on('click',function(){
                // get all employee data that we passed on the edit button
                var employee_id = $(this).attr('data-id'); //this is our user_id
                var department_id = $(this).attr('data-department_id');
                var department_name = $(this).attr('data-department_name');
                var fname = $(this).attr('data-fname');
                var mname = $(this).attr('data-mname');
                var lname = $(this).attr('data-lname');
                var phone = $(this).attr('data-phone');
                var email = $(this).attr('data-email');
                var job_title = $(this).attr('data-job');
                var country = $(this).attr('data-country');
                var state = $(this).attr('data-state');
                var city = $(this).attr('data-city');
                // here we get all countries ,states and cities then
                //check if there is a match with the employee country_id
                $.ajax({
                    url: '{{ route("getCountries")}}',
                    type: "GET",
                    success:function(data){
                        if (data.success == true) {
                            var country_data = data.data;
                            // console.log(country);
                            $('#country_name_edit').html('');
                            // here we need to loop on each data that will be returned
                            $.each(country_data,function(key,value){
                                // this add all countries to country_name_edit dropdown
                                $('#country_name_edit').append('<option value="'+value.id+'">'+value.name+'</option>');
                                if (value.id == country) {
                                  // get the exact match with our employee country_id
                                // make it selected by default
                                    var match = value.id;
                                    $('#country_name_edit').append('<option value="'+match+'" selected>'+value.name+'</option>');
                                }
                            });
                        }else{
                            alert(data.msg);
                        }
                    }
                });

                // get the departments here
                 $.ajax({
                    url: '{{ route("getDepartments")}}',
                    type: "GET",
                    success:function(data){
                        if (data.success == true) {
                            var department_data = data.data;
                            $('#department_name_edit').html('');
                            // here we need to loop on each data that will be returned
                            $.each(department_data,function(key,value){
                                // this add all department_data to department_data_edit dropdown
                                $('#department_name_edit').append('<option value="'+value.id+'">'+value.department_name+'</option>');
                                if (value.id == department_id) { //also make sure here we check the department_id
                                // make it selected by default
                                    var match = value.id;
                                    $('#department_name_edit').append('<option value="'+match+'" selected>'+value.department_name+'</option>');
                                }
                            });
                        }else{
                            alert(data.msg);
                        }
                    }
                });
                // after reflecting the country as default and selected in an edit form i also perform a dependent dropdown feature..
                // onchange of country will trigger cities and states dropdowns ..
                // then display them in a edit form
                $('#fname').val(fname);
                $('#mname').val(mname);
                $('#lname').val(lname);
                $('#phone').val(phone);
                $('#email').val(email);
                $('#employee_id').val(employee_id);
                $('#job').val(job_title);
                // also add this
               
                
            });

             // then submit the form
             $('#editEmployeeForm').submit(function(e){
                    e.preventDefault();
                    let formData = $(this).serialize();

                    $.ajax({
                        url: '{{ route("editEmployee")}}',
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
                                var reloadInterval = 1000; //page reload delay duration
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

                // fill the dropdowns accordingly
                $('#country_name').on('change',function(){
                        // on change get the id of a country and send it to database to query states
                        var country_id = $('#country_name').val();
                        console.log(country_id);
                        // create route variable
                        var url = '{{ route("getStates","country_id")}}';
                        url = url.replace('country_id',country_id);

                        $.ajax({
                            url: url,
                            type: "GET",
                            success:function(data){
                                if (data.success == true) {
                                    var cities_data = data.data; //here get all data return from controller
                                    $('#state_name').html('<option >Select State</option>');
                                    // here we need to loop on each data that will be returned
                                    $.each(cities_data,function(key,value){
                                      // append each data to the state dropdown
                                        $('#state_name').append('<option value="'+value.id+'">'+value.name+'</option>');
                                    });
                                }else{
                                    alert(data.msg);
                                    // else show an error message
                                }
                            }
                        });
                    });

                    $('#country_name_edit').on('change',function(){
                        // on change get the id of a country and send it to database to query cities
                        var country_id = $('#country_name_edit').val();
                        console.log(country_id);
                        // create route variable
                        var url = '{{ route("getStates","country_id")}}';
                        url = url.replace('country_id',country_id);

                        $.ajax({
                            url: url,
                            type: "GET",
                            success:function(data){
                                if (data.success == true) {
                                    var cities_data = data.data;
                                    // here we need to loop on each data that will be returned
                                    $.each(cities_data,function(key,value){
                                        $('#state_name_edit').append('<option value="'+value.id+'">'+value.name+'</option>');
                                    });
                                }else{
                                    alert(data.msg);
                                }
                            }
                        });
                    });

                    $('#state_name').on('change',function(){
                        // on change get the id of a country and send it to database to query cities
                        var state_id = $('#state_name').val();
                        // console.log(country_id);
                        // create route variable
                        var url = '{{ route("getCities","state_id")}}';
                        url = url.replace('state_id',state_id);

                        $.ajax({
                            url: url,
                            type: "GET",
                            success:function(data){
                                if (data.success == true) {
                                    var cities_data = data.data;
                                    $('#city_name').html('<option value="0">Select City</option>');
                                    // here we need to loop on each data that will be returned
                                    $.each(cities_data,function(key,value){
                                        $('#city_name').append('<option value="'+value.id+'">'+value.name+'</option>');
                                    });
                                }else{
                                    alert(data.msg);
                                }
                            }
                        });
                    });

                    $('#state_name_edit').on('change',function(){
                        // on change get the id of a country and send it to database to query cities
                        var state_id = $('#state_name_edit').val();
                        // console.log(country_id);
                        // create route variable
                        var url = '{{ route("getCities","state_id")}}';
                        url = url.replace('state_id',state_id);

                        $.ajax({
                            url: url,
                            type: "GET",
                            success:function(data){
                                if (data.success == true) {
                                    var cities_data = data.data;
                                    // here we need to loop on each data that will be returned
                                    $.each(cities_data,function(key,value){
                                        $('#city_name_edit').append('<option value="'+value.id+'">'+value.name+'</option>');
                                    });
                                }else{
                                    alert(data.msg);
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
                //   document.getElementById('addManager').reset();
                }
  });
</script>
@endsection