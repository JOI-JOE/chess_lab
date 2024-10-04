@extends('layouts.app')

@section('content')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex" style="justify-content: space-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            {{-- <a href="{{route('create')}}" class="btn btn-success active" data-mdb-ripple-init role="button" aria-pressed="true">ADD NEW</a> --}}
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Poster</th>
                            <th>Intro</th>
                            <th>Genre</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Poster</th>
                            <th>Intro</th>
                            <th>Genre</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($movies as $item)
                            <tr>
                                <td class="user_id">{{$item->id}}</td>
                                <td><a href="" class="btn btn-infor btn-sm view_data" style="background: blanchedalmond">{{$item->title}}</a></td>
                                <td><img src="{{ Storage::url('images/movie/' . $item->poster) }}" alt="{{ $item->title }}" width="100"></td>
                                <td>{{$item->intro}}</td>
                                <td>{{$item->genre->name}}</td>
                                <td>
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            ...
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a href="#" class="dropdown-item" id="btn-delete" onclick="deleteData({{$item->id}})">Delete</a>
                                            <a class="dropdown-item " href="{{route('movie.edit',$item->id)}}">Update</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
                    url: "{{ route('movie.show', 'user_id') }}".replace('user_id', user_id),
                    success: function (data) {
                        console.log(data);
                    //     console.log(data);
                        var box = '<ul>';
                    box += '<li>' +
                                    '<strong>Title:</strong> ' + data.title + '<br>' +
                                    '<strong>Intro:</strong> ' + data.intro + '<br>' +
                                    '<strong>Release_date:</strong> ' + data.release_date + '<br>' +
                                    '<strong>Genre:</strong> ' + data.genre.name  + '<br>' +
                                    '<strong>Image:</strong><img src="' + "{{ Storage::url('images/movie/')}}" + data.poster + '" alt="' + data.title + '" width="100"> '
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
<script>
    function deleteData(id){
			var url = '{{route("movie.destroy","ID")}}';
			// Test
			var newUrl = url.replace("ID",id);
			if(confirm("Are you sure you want to delete")) {
				$.ajax({
					url: newUrl,
					type: 'delete',
					data: {},
					dataType: 'json',
					headers: {
					'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						if (response['status']) {
                            window.location.href = "{{route('movie.list')}}";
						}
					}
				})
			}
    	}
</script>
@endsection
 