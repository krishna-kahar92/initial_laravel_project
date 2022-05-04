@extends('layouts.admin')
@section('content')
<div class="content">
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                 data-target="#addRestaurant">
                    {{ trans('global.restaurant.fields.add') }}
                </a>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.restaurant.fields.view') }} 
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th width="10">
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Code
                                    </th>
                                    <th>
                                        Phone
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Images
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurants as $key => $restaurant)
                                    <tr class="table-record-{{ $restaurant->id }}" data-record-id="{{ $restaurant->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $restaurant->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->code ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->phone ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->description ?? '' }}
                                        </td>
                                        <td>
                                            <img width="60" src="{{asset('restaurant')}}/img/{{ $restaurant->getImage->image ?? '' }}" />
                                        </td>
                                        <td>

                                        <!-- <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $restaurant->id) }}">
                                            {{ trans('global.edit') }}
                                        </a> -->

                                                
                                            <button class="btn btn-xs btn-info  editRestaurantBtn"  title="Delete Record"  data-id="{{ $restaurant->id}}" 
                                            data-name="{{$restaurant->name}}"  data-code="{{$restaurant->code}}"  data-email="{{$restaurant->email}}"  
                                            data-phone="{{$restaurant->phone}}"  data-description="{{$restaurant->description}}" 
                                             data-image="{{asset('restaurant')}}/img/{{ $restaurant->getImage->image ?? '' }}"  
                                            data-url="{{route('admin.restaurants.update',$restaurant->id)}}" 
                                            data-old-image="{{$restaurant->getImage->image ?? ''}}" 
                                            data-backdrop="static" data-keyboard="false"
                                            > {{ trans('global.edit') }}
                                            </button>

                                            <button class="btn btn-xs btn-danger deleteRestaurantBtn"  title="Delete Record"
                                            data-id="{{ $restaurant->id}}" 
                                            data-url="{{route('admin.restaurants.update',$restaurant->id)}}" 
                                            data-backdrop="static" data-keyboard="false"
                                            > Delete
                                            </button>

                                            

                                                <!-- <form id="restaurantDeleteBtn"
                                                 action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure want to delete?');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" value="Delete">Delete</button>
                                                </form> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$(document).ready(function () {
   $('#addRestaurantForm').submit(function (e) { 
    e.preventDefault();
    $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            enctype: 'multipart/form-data',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                alert('Restaurant Data Saved...');
                  $("input[type=text], input[type=file], input[type=email], input[type=number], textarea").val("");
            }
        }
    );
});


$('.deleteRestaurantBtn').click(function () { 
    $("#deleteRestaurant").modal('show');
    $("#deleteRestaurantForm").attr('action',$(this).attr('data-url'));
});

   $('#deleteRestaurantForm').submit(function (e) { 
    e.preventDefault();
    $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            enctype: 'multipart/form-data',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                $('.table-record-'+data).remove();
                $("#deleteRestaurant").modal('hide');
            }
        }
    );
});

$('#editRestaurantForm').submit(function (e) { 
    e.preventDefault();
    $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            enctype: 'multipart/form-data',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                alert('Restaurant Data Updated...');
                //   $("input[type=text], input[type=file], textarea").val("");
            }
        }
    );
});

$('.editRestaurantBtn').click(function () { 
    $("#editRestaurant").modal('show');
    $("#editName").val($(this).attr('data-name'));
    $("#editCode").val($(this).attr('data-code'));
    $("#editEmail").val($(this).attr('data-email'));
    $("#editPhone").val($(this).attr('data-phone'));
    $("#imageUrl").attr('src',$(this).attr('data-image'));

    $("#oldImage").val($(this).attr('data-old-image'));
    
    $("#editDescription").text($(this).attr('data-description'));
    $("#editRestaurantForm").attr('action',$(this).attr('data-url'));
});

// $('#button1').on('click', function() {
//     $('#openModal').show();
// });


        $('.btn-close').click(function (e) { 
            location. reload();
        });
   });




   

</script>


<!-- Add Restaurant Modal -->
<div class="modal fade" id="addRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Add New Restaurant</h2>
        <button type="button" class="close  btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="addRestaurantForm" action="{{route('admin.restaurants.store')}}">
        @method('POST')
        @csrf
            <input type="text"  id="name" name="name" class="form-control" required placeholder="Restaurant Name" ><br>
            <input type="text"  id="code" name="code" class="form-control" required placeholder="Restaurant Code"><br>
            <input type="email"  id="email" name="email" class="form-control" required placeholder="Email Id"><br>
            <input type="number"  id="phone" name="phone"  class="form-control" required placeholder="Phone Number"><br>
            <label for="image">Restaurant Image</label>
            <input type="file" name="image" required /><br>
            <textarea  class="form-control"  id="description" name="description" required  placeholder="Restaurant Description"></textarea><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary  btn-close" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary formSubmitBtn">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Edit Restaurant Modal -->
<div class="modal fade" id="editRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Edit Restaurant Data</h2>
        <button type="button" class="close  btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="editRestaurantForm"
        action="">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="text"  id="editName" name="name" class="form-control" required placeholder="Restaurant Name" ><br>
            <input type="text"  id="editCode" name="code" class="form-control" required placeholder="Restaurant Code"><br>
            <input type="email"  id="editEmail" name="email" class="form-control" required placeholder="Email Id"><br>
            <input type="number"  id="editPhone" name="phone"  class="form-control" required placeholder="Phone Number"><br>
            <label for="Image">Restaurant Image</label>
            <input type="file" name="image" id="editImage"/><br>
            <input type="hidden" name="oldImage" id="oldImage" value=""/><br>
            <img src="" id="imageUrl" class="mb-3" name="image" width="80"/>
            <textarea  class="form-control"  id="editDescription" name="description" required  placeholder="Restaurant Description"></textarea><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary  btn-close" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary formSubmitBtn">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Delete Restaurant Modal -->
<div class="modal fade" id="deleteRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Are you sure want to delete this Restaurant?</h2>
        <button type="button" class="close  btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-footer">
        <form method="POST" enctype="multipart/form-data" id="deleteRestaurantForm"
        action="">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="button" class="btn btn-secondary  btn-close" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger formSubmitBtn">Delete</button>
      </form>

      </div>
    </div>
  </div>
</div>


<!-- Toast Message -->

@endsection