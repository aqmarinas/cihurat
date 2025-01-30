<div class="mb-3">
    <p class="mb-1"><strong>{{ $title }}</strong></p>
    @php
        $filePath = asset('storage/' . $file);
        $isPdf = pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
    @endphp

    @if ($isPdf)
        <a href="{{ $filePath }}" target="_blank" class="btn btn-primary btn-sm mt-1">
            Lihat {{ $title }}
        </a>
    @else
        <button type="button" class="btn btn-primary btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#viewFileModal"
            data-title="{{ $title }}" data-file="{{ $filePath }}">
            Lihat {{ $title }}
        </button>
    @endif
</div>
