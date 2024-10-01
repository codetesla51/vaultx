        <form action="" method="POST" id="decrypt">
          <div class="heding">    <h2>Decrypt a File</h2>
</div>
      @csrf
       <div class="input-group">
      <select id="file" name="file" required class="form-control">
        <option value="" disabled selected>Select a file</option>
        @foreach ($files as $file)
          <option value="{{ $file->encrypted_name }}">{{ $file->original_name }}</option>
        @endforeach
      </select>
</div>
           <div class="input-group">
      <input type="text" id="key" name="key" placeholder="Enter decryption key"
      required minlength="8" class="form-control">
</div>
      <button class="login-btn" id="decBut">Decrypt File</button>
    </form>

{{$slot}}