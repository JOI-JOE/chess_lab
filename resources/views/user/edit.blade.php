@section('title', 'Update Movie')

@extends('layouts.app')

@section('content')
	<div class="container-fluid">
        @session('error')
            <div class="alert alert-alert">
                {{ session('error') }}
            </div>
        @endsession

        @session('success')
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endsession
		<!-- DataTales Example -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h1 class="m-0 font-weight-bold text-primary">Update - {{$data->id}} - {{$data->name}}</h1>
			</div>
		</div>
        <div class="p-2">
            <form class="user" id="movieForm" action="{{route('user.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')  
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="nameType">Name:</label>
                        <input type="text" class="form-control form-control-user" name="name" id="name" value="{{$data->name}}">
                        <p></p>
                    </div>
                    <div class="col-sm-6">
                        <label for="nameType">Email:</label>
                        <input type="email" class="form-control form-control-user" name="email" id="email" value="{{$data->email}}">
                        <p></p>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="nameType" >Role:</label>
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="user" value="user" @if ($data->role == 'user') checked @endif>
                            <label class="form-check-label" for="user">
                                User
                            </label>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="admin" value="admin" @if ($data->role == 'admin') checked @endif>
                                <label class="form-check-label" for="admin">
                                    Admin
                                </label>
                            </div>
                        @endif
                    </div>
                    @if (Auth::user()->role == 'admin')
                        <label for="nameType" >Active:</label>
                        <div class="ml-2">
                            <select name="active" id="active" class="form-select">
                                <option value="1" @if ($data->active == 1) selected @endif>Action</option>
                                <option value="0" @if ($data->active == 0) selected @endif>Non-Action</option>
                            </select>
                        </div>
                        @endif
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        {{-- <input type="file" 
                            class="feature_image"
                            name="avatar"   
                            data-max-file-size="3MB"
                             /> --}}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="avatar">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                    <div class="col-lg-6 cart">
                        <label for="nameType" >Avatar:</label>

                        <img src="{{ Storage::url($data->avatar) }}" width="200">
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block m-3">Update user</button>
                    <a href="{{route('user.list')}}" class="btn btn-primary btn-user btn-block m-3">Back to list</a>
            </form>
        </div>
	</div>

@endsection
