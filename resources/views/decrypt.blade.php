<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>VaultX {{$file->encrypted_name}}</title>
  <link rel="stylesheet" href="{{ asset('Css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}">
</head>
<body>
  <div class="container">
         <x-loader></x-loader>

    <div class="logo">
      <h2>VaultX</h2>
      <h3>Advanced and Secure File Encryption</h3>
    </div>

    <form id="decryptForm" style="display: flex; flex-direction: column; align-items: center;">
      <div class="heading">
        <h2>Decrypt {{$file->encrypted_name}}</h2>
      </div>

      @csrf
            <select id="file" name="file" required class="form-control">
          <option value="{{ $file->encrypted_name }}" selected>{{$file->encrypted_name}}</option>
      </select>
      
      <div class="input-group">
        <input type="text" id="key" name="key" placeholder="Enter decryption key" required minlength="8" class="form-control">
      </div>

      <button type="button" class="btn btn-primary mt-3" id="decBut">Decrypt File</button>
    </form>
  </div>

  <script src="{{ asset('Js/sweetalert.min.js') }}"></script>
  <script src="{{ asset('Js/sweetalert.js') }}"></script>
  <script src="{{ asset('Js/axios.min.js') }}"></script>
  <script >document.getElementById("decBut").addEventListener("click", function (e) {
    e.preventDefault();

    const decryptForm = document.getElementById("decryptForm"); // Reference the correct form
    const formData = new FormData(decryptForm); // Collect form data from the correct form
    const loader = document.getElementById('loader'); // Ensure you have a loader if using one

    loader.classList.add("active"); // Show loader

    axios
        .post("/decrypt", formData, {
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(function (response) {
            loader.classList.remove("active"); // Hide loader

            // Show success message
            Swal.fire({
                icon: "success",
                title: "Success",
                text: response.data.success,
                confirmButtonColor: "#008afa"
            }).then(() => {
                // Download file after decryption is successful
                const downloadUrl = response.data.download_url;
                window.location.href = downloadUrl; // Trigger download
            });
        })
        .catch(function (error) {
            loader.classList.remove("active"); // Hide loader in case of error

            if (error.response && error.response.status === 422) {
                Swal.fire({
                    icon: "error",
                    title: "Decryption Error",
                    text: "Decryption failed. Check your key.",
                    confirmButtonColor: "#008afa"
                });
            } else if (error.response && error.response.status === 404) {
                Swal.fire({
                    icon: "error",
                    title: "File Error",
                    text: "The selected file does not exist.",
                    confirmButtonColor: "#008afa"
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    confirmButtonColor: "#008afa"
                });
            }
        });
});
</script>

  <script>
  </script>
</body>
</html>
