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
            <form class="user" id="movieForm" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="nameType">Title:</label>
                        <input type="text" class="form-control form-control-user" name="title" id="tile" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Intro:</label>
                        <input type="text" class="form-control form-control-user" name="intro" id="intro" >
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="release_date">Release Date:</label>
                        <input type="date" class="form-control form-control-user" name="release_date" id="release_date" >
                        <p></p>
                    </div>

                    <div class="col-sm-6">
                        <label for="nameType">Genre:</label>
                        <select name="genre_id" id="" class="form-select">
                            @foreach ($genres as $item )
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <p></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <input type="file" 
                        class="feature_image"
                        name="poster"   
                        data-max-file-size="3MB"
                         />
                </div>
                
                <button type="submit" class="btn btn-primary btn-user btn-block">Create Type</button>
            </form>
        </div>
	</div>

@endsection

@section('customeJS')
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            server: {
                process: '{{ route('upload_image') }}',
                revert: '{{route('delete_image')}}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>
    <script>
        $("#movieForm").submit(function (event) {
        event.preventDefault();
        var element = $(this);
        $.ajax({
            url: '{{ route('movie.store') }}', // Replace with your route
            type: 'POST',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response) {
                if(response['status']){
                    console.log('Hello world')
                    console.log(response['data'])
                    window.location.href="{{route('movie.list')}}"
                }
            }
        })
    })
    </script>
@endsection