<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    <div class="login-page">
        <div class="form">
            <h2>User Update Form</h2>
            @if ($user->profile_img)
                <img src="{{asset('images/'.$user->profile_img)}}" id="profileImgPreview" height="150" width="150" style="border-radius: 50%;">
            @else
                <img src="{{asset('default_img.jpg')}}" id="profileImgPreview" height="150" width="150" style="border-radius: 50%;">    
            @endif
            <form method="POST" enctype="multipart/form-data" id="updateUserForm">
                @csrf
                <input type="hidden" placeholder="First Name" name="user_id" value="{{$user->id}}" hidden/>
                <input type="text" placeholder="First Name" name="first_name" value="{{$user->first_name}}"/>
                <input type="text" placeholder="Last Name" name="last_name" value="{{$user->last_name}}"/>
                <input type="readonly" placeholder="Email Address" name="email" value="{{$user->email}}" readonly/>
                <input type="file" name="profile_img" id="profile_img" />
                <button type="submit">Update</button><br><br>
            </form>
            <a href="{{route('logout')}}">
                <button style="background-color: red;">Logout</button>
            </a>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $('#profile_img').change(function() {
            const file = this.files[0];
            $('#profileImgPreview').hide();
            if (file) {
                $('#profileImgPreview').show();
                let reader = new FileReader();
                reader.onload = function(event) {
                    console.log(event.target.result);
                    $('#profileImgPreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        $('#updateUserForm').validate({
            rules: {
                email: {
                    required: true,
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: '{{ route("user.update") }}', // Replace with your Laravel route URL
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        if (response.success) {
                            toastr.success(response.message)
                        } else {
                            toastr.error(response.message)
                        }
                    },
                });
            }
        });
    </script>
</body>

</html>
