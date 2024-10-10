<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register -- @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container w-50">
        <h2 class="mt-5 mb-3">Register</h2>

        <form action="{{ route('postRegister') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="" class="form-label">Username</label>
                <input type="text" name="name" id="" class="form-control">
            </div>
            @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" id="" class="form-control">
            </div>
            @error('email')
                <span class="text-danger">{{$message}}</span>
            @enderror
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
                <label for="" class="form-label">Role</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" checked name="role" id="user" value="user">
                    <label class="form-check-label" for="user">
                        User
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="admin" value="admin">
                    <label class="form-check-label" for="admin">
                        Admin
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Avatar</label>
                <input type="file" name="avatar" id="avatar" class="form-control">
            </div>
            @error('avatar')
                <span class="text-danger">{{$message}}</span>
            @enderror

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Register</button>
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            </div>
        </form>
    </div>
</body>

</html>