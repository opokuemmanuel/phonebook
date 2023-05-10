<!DOCTYPE html>
<html lang="en">
@include('partials.head')
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: white">
<div class="wrapper ml-xl-5 mr-xl-5" style="background-color: whitesmoke; text-align: center;">
     <div class="card-body mt-5">
       <div><h1><i class="fa fa-address-book"></i> Phone Book App</h1></div>
         <div class="row mb-3">
             <div class="col-md-4">
                 <h1>Contacts</h1>
             </div>
             <div class="col-md-4">
             </div>
             <div class="col-md-4">
                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saveContactModal" ><i class="fa fa-plus"></i> Add Contact</button>&nbsp;
                 <a href="{{route('dashboard')}}" id="refresh" class="btn btn-primary refresh"><i class="fa fa-refresh"></i>Refresh</a>
             </div>
         </div>
         <form method="get" action="{{route('dashboard')}}">
             <div class="form-group input-group search">
                 {{--             <i class="fa fa-search"></i>--}}
                     <input type="text" name="search_contact" class="form-control" placeholder="Search for contact by last name...........">
                     <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i></button>
             </div>
         </form>

         @foreach($phone_book_contacts as $contact)
         <div class="row col-md-12 table-bordered" style="background-color: white;">
             <div class="col-md-4" >
                 <div class="card-body">
                     <span >{{$contact->firstname." ".$contact->lastname}}</span><br>
                     <span style="color: #a19e9e"><i class="fa fa-phone"></i> {{$contact->contact}}</span>
                 </div>
             </div>
             <div class="col-md-4" >
             </div>
             <div class="card-body col-md-4" >
                 <a data-id="{{$contact->id}}" class="btn btn-danger btn btn-sm" data-toggle="modal" data-target="#deleteContactModal"><i class="fa fa-trash"></i></a> <a data-id="{{$contact->id}}" data-firstname="{{$contact->firstname}}" data-contact="{{$contact->contact}}" data-lastname="{{$contact->lastname}}" class="btn btn-success btn btn-sm" data-toggle="modal" data-target="#editContactModal"><i class="fa fa-edit"></i></a>
             </div>
         </div>
         @endforeach
     </div>

</div>

<div class="modal fade" id="editContactModal" tabindex="-1" role="dialog" aria-labelledby="editContactModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">First Name:</label>
                            <input type="text" class="form-control" id="edit_firstname" name="edit_firstname">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Last Name:</label>
                            <input class="form-control" type="text" id="edit_lastname" name="edit_lastname">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Phone Number:</label>
                            <input class="form-control" type="text" id="edit_contact" name="edit_contact">
                            <input class="form-control" type="hidden" id="contact_id" name="contact_id">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_modal" data-dismiss="modal">Close</button>
                    <button type="button" onclick="updateContact()" class="btn btn-primary">Save Contact</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteContactModal" tabindex="-1" role="dialog" aria-labelledby="deleteContactModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteContactModal">Delete Contact ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <input id="delete_contact_id" type="hidden" name="delete_contact_id">
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="deleteContact()" class="btn btn-danger" data-dismiss="modal">Yes</button>
                    <button type="button" class="close_modal btn btn-secondary">No</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="saveContactModal" tabindex="-1" role="dialog" aria-labelledby="saveContactModal" aria-hidden="true">
    <form>
        @csrf
               <div class="modal-dialog" role="document">
                     <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Last Name:</label>
                        <input class="form-control" type="text" name="lastname" id="lastname">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Phone Number:</label>
                        <input class="form-control" type="text" name="phone_number" id=phone_number">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="close_modal btn btn-secondary" data-dismiss="modal">Close</button>
                <a onclick="save_contact()" id="save_contact" class="btn btn-primary">Save Contact</a>
            </div>
        </div>
              </div>
    </form>
</div>
<!-- ./wrapper -->
@include('partials.script')
<script>
    $('#editContactModal').on('show.bs.modal', e => {
        var button = $(e.relatedTarget);
        $('#edit_firstname').val(button.data('firstname'));
        $('#edit_lastname').val(button.data('lastname'));
        $('#edit_contact').val(button.data('contact'));
        $('#contact_id').val(button.data('id'));
    });
    $('#deleteContactModal').on('show.bs.modal', e => {
        var button = $(e.relatedTarget);
        $('#delete_contact_id').val(button.data('id'));
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function save_contact(){
        $.ajax({
            type:'POST',
            url: "{{ route('add_new_contact') }}",
            data: $('form').serialize(),
            success:function (data) {
                if (data['success'] === 'true'){
                    Swal.fire(
                        'Information Saved Successfully!',
                        '',
                        'success'
                    ).then(function () {
                        $(".close_modal").trigger("click");
                       location.href="{{route('dashboard')}}";
                    });
                }
                else if (data['success'] === 'false'){
                    Swal.fire(
                        'Fill all the blank spaces!',
                        '',
                        'error'
                    );
                }
                // console.log(data);
            },
            error: function(data){
                console.log(data);
            }
        });
    }

    function updateContact(){
        $.ajax({
            type:'POST',
            url: "{{ route('update_contact') }}",
            data: $('form').serialize(),
            success:function (data) {
                if (data['success'] === 'true'){
                    Swal.fire(
                        'Update Successful!',
                        '',
                        'success'
                    ).then(function () {
                        $(".close_modal").trigger("click");
                        location.href="{{route('dashboard')}}";
                    });
                }
                else if (data['success'] === 'false'){
                    Swal.fire(
                        'Fill all the blank spaces!',
                        '',
                        'error'
                    );
                }
                // console.log(data);
            },
            error: function(data){
                console.log(data);
            }
        });
    }

    function deleteContact(){
        $.ajax({
            type:'POST',
            url: "{{ route('delete_contact') }}",
            data: $('form').serialize(),
            success:function (data) {
                if (data['success'] === 'true'){
                    Swal.fire(
                        'Contact Deleted Successful!',
                        '',
                        'success'
                    ).then(function () {
                        $(".close_modal").trigger("click");
                        location.href="{{route('dashboard')}}";
                    });
                }
                else if (data['success'] === 'false'){
                    Swal.fire(
                        'Fill all the blank spaces!',
                        '',
                        'error'
                    );
                }
                // console.log(data);
            },
            error: function(data){
                console.log(data);
            }
        });
    }
</script>
</body>
</html>
