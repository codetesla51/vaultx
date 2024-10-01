<div class="enctypted-files" id="keys">
      @if($keys->isEmpty())
        <x-empty 
            message="Nothing To See Here" 
            description="You haven't saved any keys yet."
        />
    @else
    <h3>Saved Keys</h3>
    @foreach($keys as $key)
        <div class="file">
                <div class="name" hidden>{{ $key->key }}</div>
<span>********</span>
            <div class="actions">
<a href="{{ route('decrypt.key', ['id' => $key->id]) }}">
                    <i class="icon-copy dw dw-eye" data-id="{{ $key->id }}"></i>
                </a>              
                <i class="icon-copy dw dw-trash" onclick="deleteKey({{ $key->id
                }})"></i>
            </div>
        </div>
        
    @endforeach
    @endif
</div>


<!-- Include Axios -->

<script>
function deleteKey(keyId) {
    if (confirm("Are you sure you want to delete this key?")) {
        axios.delete(`/keys/${keyId}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
        .then(response => {
            if (response.data.success) {
                alert('Key deleted successfully');
                // Reload the page after deletion
                location.reload();
            } else {
                alert('Error deleting key');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the key.');
        });
    }
}
</script>
