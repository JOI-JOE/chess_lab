@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <form action="{{ route('list') }}" method="GET" id="filterForm">
        <select name="select_cate" id="mySelect" class="form-select">
            <option value="">Select All</option>
            @foreach ($categories as $category)
                <option @if ($checked == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    
        <select name="orderby" id="orderby" class="orderby" aria-label="Đơn hàng của cửa hàng">
            <option value="date">Mới nhất</option>
        </select>
    </form>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex" style="justify-content: space-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <a href="{{route('create')}}" class="btn btn-success active" data-mdb-ripple-init role="button" aria-pressed="true">ADD NEW</a>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($books as $item)
                            <tr>
                                <td class="user_id">{{$item->id}}</td>
                                <td><a href="" class="btn btn-infor btn-sm view_data" style="background: blanchedalmond">{{$item->title}}</a></td>
                                <td><img src="{{$item->thumbnail}}" alt="" width="50"></td>
                                <td>{{$item->author}}</td>
                                <td>{{$item->category->name}}</td>
                                <td>
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            ...
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a href="#" class="dropdown-item" id="btn-delete" onclick="deleteData({{$item->id}})">Delete</a>
                                            <a class="dropdown-item " href="{{route('book.edit',$item->id)}}">Update</a>
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
        	function deleteData(id){
			var url = '{{route("book.delete","ID")}}';
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
                            window.location.href = "{{route('list')}}";
						}
					}
				})
			}
    	}
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
                    url: "{{ route('detail', 'user_id') }}".replace('user_id', user_id),
                    success: function (data) {
                        console.log(data);
                        var box = '<ul>';
// Duyệt qua từng cuốn sách trong dữ liệu
                    box += '<li>' +
                                    '<strong>Title:</strong> ' + data.title + '<br>' +
                                    '<strong>Author:</strong> ' + data.author + '<br>' +
                                    '<strong>Publisher:</strong> ' + data.publisher + '<br>' +
                                    '<strong>Publication:</strong> ' + data.publication + '<br>'+
                                    '<strong>Price:</strong> ' + data.price +'$' +'<br>'+
                                    '<strong>Quantity:</strong> ' + data.quantity + '<br>'+
                                    '<strong>Category:</strong> ' + data.category.name 
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
 