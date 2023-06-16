<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    <div class="login-page">
        <div class="form">
            <h2>Registeration Form</h2>
            <img src="" id="profileImgPreview" height="150" width="150" style="display:none;">
            <form method="POST" enctype="multipart/form-data" id="registerForm">
                @csrf
                <input type="text" placeholder="First Name" name="first_name" />
                <input type="text" placeholder="Last Name" name="last_name" />
                <input type="email" placeholder="Email Address" name="email" />
                <input type="password" placeholder="password" name="password" />
                <input type="file" name="profile_img" id="profile_img" />
                <button type="submit">create</button>
                <p class="message">Already registered? <a href="{{ route('login') }}">Sign In</a></p>
            </form>
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
                    $('#profileImgPreview').css('border-radius', "50%");
                    $('#profileImgPreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        $('#registerForm').validate({
            rules: {
                password: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ route('unique.email') }}",
                        type: "get",
                        data: {
                            email: function() {
                                return $('#registerForm :input[name="email"]').val();
                            }
                        },
                    },
                },
            },
            messages: {
                password: {
                    required: 'Password Field Is Required.',
                },
                email: {
                    required: 'Email Field Is Required.',
                    remote: "This email is already taken.",
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: '{{ route("user.register") }}', // Replace with your Laravel route URL
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        if (response.success) {
                            toastr.success(response.message)
                            setTimeout(function(){
                                window.location.href = "{{route('login')}}"
                            }, 3000);
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
