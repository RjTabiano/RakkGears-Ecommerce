@extends('layout.layout')

@section('content')
<div class="container">
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="https://png.pngitem.com/pimgs/s/150-1503945_transparent-user-png-default-user-image-png-png.png" 
                     class="avatar img-circle" alt="avatar">
                <h6>Upload a different photo...</h6>
                <input type="file" class="form-control">
            </div>
        </div>
        
        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h3>Personal info</h3>
            <form method="POST" action="{{ route('profile.update') }}" class="form-horizontal" role="form">
                @csrf
                <div class="form-group">
                    <label class="col-md-3 control-label">Username:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="password" type="password" placeholder="Leave blank to keep current password">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="password_confirmation" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 offset-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>
@endsection
