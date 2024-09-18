@section('title', 'Dashboard')

@extends('layouts.app')

@section('content')
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	</div>

<!-- Content Row -->
<h1>Top 8 Books By Max Price</h1>
<div class="row">
	<!-- Pending Requests Card Example -->
    @foreach ($maxBooks as $item)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{$item->title}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$item->author}}</div>
                        </div>
                        <div class="col-auto">
                            <span>{{$item->price}}$</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<h1>Top 8 Books By Min Price</h1>
<div class="row">
	<!-- Pending Requests Card Example -->
    @foreach ($minBooks as $item)
	<div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{$item->title}}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$item->author}}</div>
                    </div>
                    <div class="col-auto">
                        <span>{{$item->price}}$</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>


<!-- Content Row -->
@endsection