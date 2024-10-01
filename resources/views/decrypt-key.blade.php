<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>VaultX Show Key</title>
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
        <h2>View Key</h2>
      </div>

      @csrf
      <input type="hidden" name="keyId" value="{{ $key->id }}">
      <div class="input-group">
        <input type="password" id="password" name="password" placeholder="Enter your password" required minlength="8" class="form-control">
      </div>

      <button type="button" class="login-btn" id="decBut">Verify Password</button>
    </form>

    <!-- Decrypted Key will be shown here -->
    <p id="decrypted-key" style="display: none;" class="mt-3  text-center"></p>
  </div>

  <!-- Include SweetAlert and Axios -->
  <script src="{{ asset('Js/sweetalert.min.js') }}"></script>
  <script src="{{ asset('Js/axios.min.js') }}"></script>

  <script>
    document.getElementById('decBut').addEventListener('click', function() {
      const password = document.getElementById('password').value;
      const keyId = document.querySelector('input[name="keyId"]').value;
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const loader = document.getElementById('loader'); // Ensure you have a loader if using one

    loader.classList.add("active");
      // Clear previous success/error messages
      document.getElementById('decrypted-key').style.display = 'none';

      // Validate the password length
      

      // Send the request via Axios
      axios.post('{{ route('decrypt-key') }}', {
          password: password,
          keyId: keyId,
          _token: csrfToken
      })
      .then(function(response) {
        if (response.data.status === 'success') {
          // Show the decrypted key in the <p> tag
          const decryptedKeyElement = document.getElementById('decrypted-key');
          decryptedKeyElement.textContent = `Your  Key Is: ${response.data.decryptedKey}`;
          decryptedKeyElement.style.display = 'block';
            loader.classList.remove("active"); // Hide loader in case of error

          // Show SweetAlert success message
          swal("Success", "Key decrypted successfully!", "success");
        }
      })
      .catch(function(error) {
        let errorMessage = 'Something went wrong.';
                    loader.classList.remove("active"); // Hide loader in case of error

        if (error.response && error.response.data.message) {
          errorMessage = error.response.data.message;
        }

        // Show SweetAlert error message
        swal("Error", errorMessage, "error");
      });
    });
  </script>
</body>
</html>
