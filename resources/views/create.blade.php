@section('title', 'Create new')

@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<!-- DataTales Example -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h1 class="m-0 font-weight-bold text-primary">Create New Type</h1>
			</div>
		</div>
        <div class="p-2">
            <form class="user" action="" id="typeForm" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="nameType">Title:</label>
                        <input type="text" class="form-control form-control-user" name="title" id="tile" >
                        <p></p>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="nameType">Thumbnail:</label>
                        <input type="text" class="form-control form-control-user" name="thumbnail" id="thumbnail" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Author:</label>
                        <input type="text" class="form-control form-control-user" name="author" id="author" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Publihser:</label>
                        <input type="text" class="form-control form-control-user" name="publisher" id="publisher" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Publication:</label>
                        <input type="date" class="form-control form-control-user" name="publication" id="publication" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Price:</label>
                        <input type="number" class="form-control form-control-user" name="price" id="price" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Quantity:</label>
                        <input type="number" class="form-control form-control-user" name="quantity" id="quanity" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Category:</label>
                        <select name="category_id" id="" class="form-select">
                            @foreach ($categories as $item )
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <p></p>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-user btn-block">Create Type</button>
            </form>
        </div>
	</div>

@endsection

@section('customeJS')
<script>
    $(document).ready(function() {
       
        $("#typeForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);
            $.ajax({
                url: '{{ route('book.store') }}', // Replace with your route
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    // $("button[type=submit]").prop('disabled',false);
                    if(response['status'] == true){
                        window.location.href="{{route('list')}}"
                    }                        
                }
            })
        })
    });
</script>   
@endsection