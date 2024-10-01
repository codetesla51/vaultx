<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VaultX</title>
        <link rel="stylesheet" href="{{ asset('Css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Css/app.css') }}">
        <link rel="stylesheet" href="{{
        asset('vendors/styles/icon-font.min.css') }}">
</head>
<body>
     <x-loader></x-loader>
<div class="nav-bar">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" >
      @csrf
<button class="button">
  Logout
  <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
    <path
      clip-rule="evenodd"
      d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
      fill-rule="evenodd"
    ></path>
  </svg>
</button>
</form>
  <div class="side">  
  <button class="button" onclick="toggleTheme()">Dark Mode</button>
  </div>
</div>
    <div class="container">

             
       <div class="logo">
      <h2>VaultX</h2>
      <h3> Advanced And Secure File Encryption</h3>
    </div>
<div class="tabs">
  <div class="tab active" id="encryptTab">Encrypt File</div>
  <div class="tab" id="decryptTab">Decrypt File</div>
  <div class="tab" id="KeyTab">Stored Keys</div>
</div>

<!-- Encrypt Form -->
<x-encrypt></x-encrypt>
<!-- Decrypt Form -->
<x-decrypt :files="$files"></x-decrypt:files>
<!-- Key Form -->
<x-key></x-key>
<x-showFiles :files="$files"></x-showFiles>
<x-ShowKeys :keys="$keys"></x-ShowKeys>
<!-- Slot for additional content -->
<!-- Slot for additional content -->

</div>
     <script src="{{ asset('Js/sweetalert.min.js') }}"></script>
         <script src="{{ asset('Js/sweetalert.js') }}"></script>
        <script src="{{ asset('Js/axios.min.js') }}"></script>
        <script src="{{ asset('Js/app.js') }}"></script>
        <script src="{{ asset('Js/encrypt.js') }}"></script>
        <script src="{{ asset('Js/bootstrap.bundle.min.js') }}"></script>
</script>
</body>
</html>

