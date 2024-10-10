<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container w-40">
        <h2 class="mt-5">Change Password</h2>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
       
        <form action="{{ route('postAlterPass') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" id="" class="form-control" value="{{Auth::user()->email}}" readonly>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" id="" class="form-control">
            </div>
            @error('password')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="mb-3">
                <label for="" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="" class="form-control">
            </div>
            @error('confirm_password')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Change Password</button>
                <a href="{{ route('user.list') }}" class="btn btn-info">Back to list</a>
            </div>

        </form>
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
</body>

</html>