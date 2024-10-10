@extends('layouts.app')

@section('content')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex" style="justify-content: space-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Avatar</th>
                            <th>Avatar</th>
                            <th>Active</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Avatar</th>
                            <th>Intro</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if (Auth::user()->role == 'admin')
                            @foreach ($data as $item)
                                <tr>
                                    <td class="user_id">{{$item->id}}</td>
                                    <td><a href="" class="btn btn-infor btn-sm view_data" style="background: blanchedalmond">{{$item->name}}</a></td>
                                    <td><img src="{{ Storage::url($item->avatar) }}"  width="100"></td>
                                    @if ($item->role == 'admin')
                                        <td><a href="" class="btn btn-infor btn-sm view_data" style="background: rgb(227, 4, 4);color:white">{{$item->role}}</a></td>
                                    @else
                                        <td><a href="" class="btn btn-infor btn-sm view_data" style="background: rgb(198, 235, 80);color:white">{{$item->role}}</a></td>
                                    @endif
                                    {{-- <td>{{$item->genre->name}}</td> --}}
                                    <td class="text-center">
                                        @if ($item->active == 1)
                                            <a href="#" class="btn btn-success btn-circle btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown no-arrow">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                ...
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item " href="{{route('user.edit',$item->id)}}">Update</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="user_id">{{Auth::user()->id}}</td>
                                <td><a href="" class="btn btn-infor btn-sm view_data" style="background: blanchedalmond">{{Auth::user()->name}}</a></td>
                                <td><img src="{{ Storage::url(Auth::user()->avatar) }}"  width="100"></td>
                                @if (Auth::user()->role == 'admin')
                                    <td><a href="" class="btn btn-infor btn-sm view_data" style="background: rgb(227, 4, 4);color:white">{{Auth::user()->role}}</a></td>
                                @else
                                    <td><a href="" class="btn btn-infor btn-sm view_data" style="background: rgb(198, 235, 80);color:white">{{Auth::user()->role}}</a></td>
                                @endif  
                                {{-- <td>{{$item->genre->name}}</td> --}}
                                <td class="text-center">
                                    @if (Auth::user()->active == 1)
                                        <a href="#" class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            ...
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('user.changePass')}}" >Change password</a>
                                            <a class="dropdown-item " href="{{route('user.edit',Auth::user()->id)}}">Update</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Model --}}
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bookModalLabel">Detail Books </h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <div class="view_book_data">

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('customeJS')
<script>
          $(document).ready(function() {
            $('#mySelect').on('change', function() {
                $(this).closest('form').submit();
            });
            $('#orderby').on('change', function() {
                $(this).closest('form').submit();
            });


            $('.view_data').click(function(e) {
                e.preventDefault();
                var user_id = $(this).closest('tr').find('.user_id').text();                
                $.ajax({
                    method: "GET",
                    url: "{{ route('user.show', 'user_id') }}".replace('user_id', user_id),
                    success: function (data) {
                        console.log(data.avatar);
                        filename = data.avatar.split("/")[1]
                        var box = '<ul>';
                    box += '<li>' +
                                    '<strong>Name:</strong> ' + data.name + '<br>' +
                                    '<strong>Email:</strong> ' + data.email + '<br>' +
                                    '<strong>Role:</strong> ' + data.role + '<br>' +
                                    '<strong>Created at</strong> ' + data.created_at  + '<br>' +
                                    '<strong>Updated at</strong> ' + data.updated_at  + '<br>' +
                                    '<strong>Image:</strong><img src="' + "{{ Storage::url('user_images/')}}" + filename + '" alt="' + data.title + '" width="100"> '
                    +
                    '</li>';

                    box += '</ul>';
                        $('.view_book_data').html(box);
                        $('#bookModalLabel').html( 'Detail:'+' '+ data.title);
                        $('#bookModal').modal('show');
                    }
                });
            })
        });
</script>
@endsection
 