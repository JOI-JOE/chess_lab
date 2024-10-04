@section('title', 'Update Movie')

@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<!-- DataTales Example -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h1 class="m-0 font-weight-bold text-primary">Update - {{$movie->title}}</h1>
			</div>
		</div>
        <div class="p-2">
            <form class="user" id="movieForm">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="nameType">Title:</label>
                        <input type="text" class="form-control form-control-user" name="title" id="tile" value="{{$movie->title}}">
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Intro:</label>
                        <input type="text" class="form-control form-control-user" name="intro" id="intro" value="{{$movie->intro}}">
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="release_date">Release Date:</label>
                        <input type="date" class="form-control form-control-user" name="release_date" id="release_date" value="{{date('Y-m-d', strtotime($movie->release_date))}}" >
                        <p></p>
                    </div>

                    <div class="col-sm-6">
                        <label for="nameType">Genre:</label>
                        <select name="genre_id" id="" class="form-select">
                            @foreach ($genres as $item )
                            <option value="{{$item->id}}" @if ($movie->genre_id == $item->id) selected @endif>
                                {{$item->name}}
                            </option>
                            @endforeach
                        </select>
                        <p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <input type="file" 
                            class="feature_image"
                            name="poster"   
                            data-max-file-size="3MB"
                             />
                    </div>
                    <div class="col-lg-6 cart">
                        <img src="{{ Storage::url('images/movie/' . $movie->poster) }}" alt="{{ $item->title }}" width="200">
                    </div>
                </div>
                
                
                <button type="submit" class="btn btn-primary btn-user btn-block m-3">Create Type</button>
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
            url: '{{ route('movie.update',$movie->id) }}', // Replace with your route
            type: 'Put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response) {
                if(response['status']){
                    console.log('Hello world')
                    console.log(response['data'])
                    window.location.href="{{route('movie.edit',$movie->id)}}"
                }
            }
        })
    })
    </script>
@endsection