@extends('layouts.admin')
@section('content')
<div class="content">
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" data-toggle="modal" data-target="#addRestaurant">
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
                                    <tr data-entry-id="{{ $restaurant->id }}">
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
                                            @can('user_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $restaurant->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                            @can('user_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $restaurant->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan
                                            @can('user_delete')
                                                <form id="restaurantDeleteBtn"
                                                 action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure want to delete?');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                                </form>

                                                
                                                <button class="btn btn-sm btn-danger del-modal float-left"  title="Delete Record"  data-id="{{ $restaurant->id}}" 
                                                data-title="{{ $restaurant->title}}"  data-toggle="modal" data-target="#delete-restaurant-modal"><i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endcan
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
                $("input, textarea").val('');
            }
        }
    );
});
   });


//    $(".del-modal").click(function(){
//     var delete_id = $(this).attr('data-id');
//     var data_title = $(this).attr('data-title');
//     $('.delete-form').attr('action','/admin/post/'+ delete_id);
//     $('.delete-title').html(data_title);
//   });  


   

</script>


<!-- Add Restaurant Modal -->
<div class="modal fade" id="addRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Add New Restaurant</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="addRestaurantForm" action="{{route('admin.restaurants.store')}}">
        @csrf('POST')
            <input type="text"  id="name" name="name" class="form-control" required placeholder="Restaurant Name" ><br>
            <input type="text"  id="code" name="code" class="form-control" required placeholder="Restaurant Code"><br>
            <input type="email"  id="email" name="email" class="form-control" required placeholder="Email Id"><br>
            <input type="number"  id="phone" name="phone"  class="form-control" required placeholder="Phone Number"><br>
            <label for="image">Restaurant Image</label>
            <input type="file" name="image" ><br>
            <textarea  class="form-control"  id="description" name="description" required  placeholder="Restaurant Description"></textarea><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary formSubmitBtn">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Modal -->


<div class="modal fade" id="delete-restaurant-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-footer justify-content-between d-block ">
            <form class="delete-form float-right" action="" method="POST">
                    @method('DELETE')
                    @csrf

              <h4 class="modal-title pull-left">Are you sure you want to delete it?</h4>
              <button type="button" class="btn btn-default mr-4" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger float-right btnDelPost" title="Delete Record"><i class="fas fa-trash-alt"></i> Delete</button>
              <button type="button" class="btn btn-danger float-right btnDelPost deleting"
                style="display:none" disabled="true" title="Deleting..."><i class="fas fa-trash-alt"></i> Deleting...</button>

            </form>
            </div>
          </div>
        </div>
      </div>


@endsection