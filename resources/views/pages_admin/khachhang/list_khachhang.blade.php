@extends('admin.layout_admin')
@section('home')
<h2>DANH SÁCH KHÁCH HÀNG</h2>
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-right">
<a class="btn btn-success mb-2" id="new-user" data-toggle="modal">Thêm khách hàng</a>
</div>
</div>
</div>

<table class="table table-bordered data-table" >
<thead>
<tr id="">
<th width="4%">No</th>
<th width="4%">Id</th>
<th width="16%">Name</th>
<th width="18%">Email</th>
<th width="12%">Phone</th>
<th width="16%">Tổng giao dịch</th>
<th width="20%">Action</th>
</tr>
</thead>
<tbody>
</tbody>
</table>



<!-- Add and Edit customer modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true" >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="userCrudModal"></h4>
</div>
<div class="modal-body">
<form name="userForm" action="{{ route('users.store') }}" method="POST">
<input type="hidden" name="user_id" id="user_id" >
@csrf
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Name: (*)</strong>
<input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="validate()">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Email: (*)<span class="text-danger"></span></strong>
<span class="text-danger" id="error_email"></span>
<input type="email" name="email" id="email" class="form-control" placeholder="Email" onchange="validate()" onblur="checkEmail()">

</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Phone: (*)<span class="text-danger"></span></strong>
<span class="text-danger" id="error_sdt"></span>
<input type="text" name="sdt" id="sdt" class="form-control" placeholder="Phone" onchange="validate()" onblur="checkPhone()">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
<a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a>
</div>
</div>
</form>
</div>
</div>
</div>
</div>

<!-- Show user modal -->
<div class="modal fade" id="crud-modal-show" aria-hidden="true" >
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="userCrudModal-show"></h4>
</div>
<div class="modal-body">
<div class="container">
<div class="row"> 
<!-- <div class="col-xs-2 col-sm-2 col-md-2"></div>
 --><div class="col-xs-10 col-sm-10 col-md-10 ">

<table class="table-responsive ">
<tr height="50px"><td><strong>Name:</strong></td><td id="sname"></td></tr>
<tr height="50px"><td><strong>Email:</strong></td><td id="semail"></td></tr>
<tr height="50px"><td><strong>Phone:</strong></td><td id="ssdt"></td></tr>
    
<!-- <table class="table table-bordered data-table" >
<thead>
<tr id="">
<th width="4%">Id</th>
<th width="12%">Name</th>
<th width="12%">Email</th>
<th width="12%">Phone</th>

</tr>
</thead>
<tbody>
</tbody>
</table> -->



<tr><td></td><td style="text-align: right "><a href="{{ route('users.index') }}" class="btn btn-danger">OK</a> </td></tr>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- .. -->

<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('users.index') }}", //list
columns: [
{data: 'DT_RowIndex', name: 'DT_RowIndex'},
{data: 'id', name: 'id'},
{data: 'name', name: 'name'},
{data: 'email', name: 'email'},
{data: 'sdt', name: 'sdt'},
{data: 'tonggd', name: 'tonggd'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New customer button */
$('#new-user').click(function () {
$('#btn-save').val("create-user");
$('#user').trigger("reset");
$('#userCrudModal').html("Add New User");
$('#crud-modal').modal('show');
});

//
    



/* Edit customer */
$('body').on('click', '#edit-user', function () {
var user_id = $(this).data('id');
$.get('users/'+user_id+'/edit', function (data) {
$('#userCrudModal').html("Edit User");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal').modal('show');
$('#user_id').val(data.id);
$('#name').val(data.name);
$('#email').val(data.email);
$('#sdt').val(data.sdt);


})
});
/* Show customer */
$('body').on('click', '#show-user', function () {
var user_id = $(this).data('id');
$.get('users/'+user_id, function (data) {
$('#sname').html(data.name);
$('#semail').html(data.email);
$('#ssdt').html(data.sdt);





})
$('#userCrudModal-show').html("User Details");
$('#crud-modal-show').modal('show');
});

/* Delete customer */
$('body').on('click', '#delete-user', function () {
var user_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
confirm("Bạn chắc chắn xóa ?");

$.ajax({
type: "DELETE",
url: "http://localhost:8000/users/"+user_id,
data: {
"id": user_id,
"_token": token,
},
success: function (data) {

// $('#msg').html('Customer entry deleted successfully');
// $("#customer_id_" + user_id).remove();
table.ajax.reload();
},
error: function (data) {
console.log('Error:', data);
}
});
});

});

</script>
@endsection