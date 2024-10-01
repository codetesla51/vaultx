<form enctype="multipart/form-data" id="encrypt">
        @csrf
<div class="heding">    <h2>Encrypt a File</h2>
</div>
 <div class="input-group">

        <input class="form-control" type="file" name="file"></div>
 <div class="input-group">
   
          <input type="text" id="key" placeholder="Encryption Key"
          name="key" class="form-control"> 
          </div>
          <div class="input-group">          <button class="but" onclick="generateKey()" type="button">Generate key</button>
</div>
        <button type="button" class="login-btn" id="encBut">Encrypt File</button>
    </form>
{{$slot}}