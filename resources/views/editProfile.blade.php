@extends('layout.layout')

@section('content')
<div class="container">
    <hr>
    <div class="row">
        <div class="col-md-12 personal-info">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h3>Update Profile</h3>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="row">
                    
                    <!-- Profile Picture Upload -->
                    <div class="col-md-3 text-center">
                        @if ($user->profile_pic)
                        <img src="{{ $user->profile_pic }}" 
                             class="avatar img-circle mb-3" alt="avatar">
                        @else
                        <img src="https://png.pngitem.com/pimgs/s/150-1503945_transparent-user-png-default-user-image-png-png.png" 
                             class="avatar img-circle mb-3" alt="avatar">
                        @endif

                        <h6>Upload a different photo...</h6>
                        <input type="file" class="form-control mt-2" name="profile_pic">
                    </div>
                    <!-- Form Inputs -->
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Username:</label>
                            <div class="col-md-9">
                                <input class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Email:</label>
                            <div class="col-md-9">
                                <input class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Password:</label>
                            <div class="col-md-9">
                                <input class="form-control" name="password" type="password" placeholder="Leave blank to keep current password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Confirm Password:</label>
                            <div class="col-md-9">
                                <input class="form-control" name="password_confirmation" type="password">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Changes Button -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>
<style>
.avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-bottom: 10px;
}

.form-horizontal .form-group {
    margin-bottom: 20px;
}

.btn-primary {
    padding: 10px 20px;
    font-size: 16px;
}
</style>
@endsection
