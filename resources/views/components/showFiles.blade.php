<div class="enctypted-files" id="files">
      @if($files->isEmpty())
        <x-empty 
            message="Nothing To See Here" 
            description="You haven't encrypted any files yet."
        />
    @else
    <h3>Encrypted Files</h3>
    @foreach($files as $file)
        <div class="file">
                <div class="name">{{ $file->encrypted_name }}</div>

                <div class="actions">
                    <a href="{{ route('enc.download', ['file' => $file->encrypted_name]) }}">
                        <i class="icon-copy dw dw-download"></i>
                    </a>
                    <i class="icon-copy dw dw-share-11" onclick="copyShareLink('{{ $file->encrypted_name }}')"></i>
                    <i class="icon-copy dw dw-trash" onclick="deleteFile('{{ $file->encrypted_name }}')"></i>
                </div>
        </div>
        
    @endforeach
    @endif
</div>
