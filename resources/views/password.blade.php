<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VaultX Password</title>
    <link rel="stylesheet" href="{{ asset('Css/form.css') }}">
</head>
<body>
    <x-loader></x-loader>
    <div class="container">
        <div class="login-box">
            <div class="header">
                <h2>VaultX</h2>
                <h3>Set Your VaultX Password</h3>
            </div>
            <br/>
            <form id="passwordForm">
                @csrf
                <div class="input-group">
                    <label for="password">Enter Password</label>
                    <input type="password" id="password" placeholder="Enter your new password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" placeholder="Confirm your new password" name="password_confirmation" required>
                </div>
                <button type="button" id="updatePasswordBtn" class="login-btn">Update Password</button>
            </form>
        </div>
    </div>

    <!-- Include SweetAlert, Axios -->
    <script src="{{ asset('Js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('Js/axios.min.js') }}"></script>

    <script>
        document.getElementById('updatePasswordBtn').addEventListener('click', function () {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
const loader = document.getElementById('loader'); 
    loader.classList.add("active");
            if (password === "" || passwordConfirmation === "") {
                  loader.classList.remove("active");
                swal("Error", "Please fill out all fields", "error");
                return;
            }

            if (password !== passwordConfirmation) {
                                loader.classList.remove("active");

                swal("Error", "Passwords do not match", "error");
                return;
            }

            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      
            axios.post('/update-password', {
                password: password,
                password_confirmation: passwordConfirmation
            })
            .then(function (response) {
                                loader.classList.remove("active");

                swal("Success", response.data.message, "success").then(() => {
                    window.location.href = "/"; 
                });
            })
            .catch(function (error) {
                                loader.classList.remove("active");

                if (error.response && error.response.data) {
                    swal("Error", error.response.data.error || "Password update failed", "error");
                } else {
                    swal("Error", "Something went wrong. Please try again.", "error");
                }
            });
        });
    </script>
</body>
</html>
