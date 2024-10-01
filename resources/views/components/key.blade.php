<form id="keyForm">
    @csrf
    <div class="heading">
        <h2>Create Key</h2>
    </div>
    <div class="input-group">
        <input type="text" name="key" id="nkey" class="form-control" minlength="8" required>
    </div>
    <div class="input-group">
        <button class="but" onclick="generateKey()" type="button">Generate Key</button>
    </div>
    <button type="button" class="login-btn" onclick="uploadKey()">Enter Key</button>
</form>
