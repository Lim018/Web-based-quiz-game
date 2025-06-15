@extends('layouts.admin')
@section('title', 'Bagikan Kuis')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card text-center">
            <div class="card-header">
                <h4>Bagikan Kuis untuk Mode Bebas</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $quiz->title }}</h5>
                <p>Gunakan link di bawah ini untuk mengundang orang bermain kuis ini kapan saja.</p>
                <div class="input-group mb-3">
                    <input type="text" id="shareableLink" class="form-control" value="{{ $shareUrl }}" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="copyBtn">Salin</button>
                </div>
                <div id="copy-success" class="text-success d-none">Link berhasil disalin!</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('copyBtn').addEventListener('click', function() {
    var copyText = document.getElementById('shareableLink');
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(copyText.value).then(function() {
        var successMessage = document.getElementById('copy-success');
        successMessage.classList.remove('d-none');
        setTimeout(function() {
            successMessage.classList.add('d-none');
        }, 2000);
    });
});
</script>
@endpush