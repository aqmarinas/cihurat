<div class="mb-3">
    <p class="mb-1"><strong>{{ $title }}</strong></p>
    @if (is_array($files) && count($files) > 0)
        @foreach ($files as $index => $file)
            <button type="button" class="btn btn-primary btn-sm mt-1" data-bs-toggle="modal"
                data-bs-target="#viewFileModal" data-title="{{ $title }} {{ $index + 1 }}"
                data-file="{{ asset('storage/' . $file) }}">
                Lihat {{ $title }} {{ $index + 1 }}
            </button>
        @endforeach
    @else
        <p class="text-muted">Tidak ada file tersedia.</p>
    @endif
</div>
