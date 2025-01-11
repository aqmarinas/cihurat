@extends('admin.layouts.app')

@section('title', 'Course')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open the Modal -->
        <div class="d-flex justify-content-start mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                Tambah Data
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Kursus</h5>
                <div class="col-auto">
                    <input type="text" id="searchInput" class="form-control" style="width: 250px;"
                        placeholder="Cari Kursus...">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $hasCourses = false; // Flag untuk mengecek apakah ada kursus yang cocok
                        @endphp

                        @foreach ($courses as $course)
                            @if (Auth::user()->id == $course->admin_id)
                                @php
                                    $hasCourses = true;
                                @endphp
                                <tr>
                                    <td>
                                        <!-- Menampilkan Thumbnail dengan ukuran 100x100 -->
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->judul }}"
                                            style="width: 100px">
                                    </td>
                                    <td><strong>{{ $course->judul }}</strong></td>
                                    <td>{!! \App\Helpers\TextHelpers::splitText($course->deskripsi, 40) !!}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-edit me-2"
                                            data-slug="{{ $course->slug }}" data-judul="{{ $course->judul }}"
                                            data-deskripsi="{{ $course->deskripsi }}"
                                            data-thumbnail="{{ $course->thumbnail }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form id="delete-form-{{ $course->slug }}"
                                            action="{{ route('course.destroy', $course->slug) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('{{ $course->slug }}')">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @if (!$hasCourses)
                            <tr>
                                <td colspan="4" class="text-center">No data available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($courses instanceof \Illuminate\Pagination\LengthAwarePaginator && $courses->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
        <script>
            // Tunggu sampai DOM sepenuhnya dimuat
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil elemen input search dan tbody
                const searchInput = document.getElementById('searchInput');
                const tableBody = document.querySelector('tbody');
                const tableRows = tableBody.getElementsByTagName('tr');

                // Buat div untuk pesan "tidak ditemukan"
                const notFoundMessage = document.createElement('div');
                notFoundMessage.className = 'alert alert-info text-center mt-3';
                notFoundMessage.style.display = 'none';
                notFoundMessage.textContent = 'No matching courses found';
                document.querySelector('.table-responsive').after(notFoundMessage);

                // Fungsi untuk melakukan pencarian
                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    let matchFound = false;

                    // Loop melalui setiap baris tabel
                    Array.from(tableRows).forEach(row => {
                        // Skip baris "No data available"
                        if (row.cells.length === 1 && row.cells[0].textContent.trim() === 'No data available') {
                            return;
                        }

                        // Ambil teks dari kolom judul dan deskripsi
                        const title = row.cells[1].textContent.toLowerCase();
                        const description = row.cells[2].textContent.toLowerCase();

                        // Cek apakah searchTerm ada dalam title atau description
                        if (title.includes(searchTerm) || description.includes(searchTerm)) {
                            row.style.display = ''; // Tampilkan baris
                            matchFound = true;
                        } else {
                            row.style.display = 'none'; // Sembunyikan baris
                        }
                    });

                    // Tampilkan/sembunyikan pesan "tidak ditemukan"
                    if (searchTerm && !matchFound) {
                        notFoundMessage.style.display = 'block';
                    } else {
                        notFoundMessage.style.display = 'none';
                    }
                }

                // Event listener untuk input search
                searchInput.addEventListener('input', performSearch);
            });
        </script>
    </div>

    <!-- Modal for Adding Course -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('course.store') }}" method="post" enctype="multipart/form-data"
                        id="addCourseForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-judul">Judul <span
                                    style="color: red">*</span></label>
                            <input type="text" name="judul" class="form-control" id="basic-default-judul"
                                placeholder="Type your course title" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="desc">Deskripsi <span style="color: red">*</span></label>
                            <textarea name="deskripsi" id="desc" class="form-control" cols="30" rows="5"
                                placeholder="Type your course description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="thumbnail">Thumbnail <span style="color: red">*</span></label>
                            <input type="file" name="thumbnail" class="form-control" id="thumbnail" required
                                onchange="previewImage(event, 'add')" />
                        </div>
                        <div class="mb-3 text-center">
                            <img id="add-thumbnail-preview" src="" alt="Image Preview"
                                style="display: none; width:100%;" class="img-preview" />
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Course -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('course.update', ':id') }}" method="post" id="editCourseForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Make sure to use the PUT method for updates -->
                        <div class="mb-3">
                            <label class="form-label" for="edit-judul">Judul <span style="color: red">*</span></label>
                            <input type="text" name="judul" class="form-control" id="edit-judul"
                                placeholder="Type your course title" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-desc">Deskripsi <span style="color: red">*</span></label>
                            <textarea name="deskripsi" id="edit-desc" class="form-control" cols="30" rows="5"
                                placeholder="Type your course description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-thumbnail">Thumbnail (optional)</label>
                            <input type="file" name="thumbnail" class="form-control" id="edit-thumbnail"
                                onchange="previewImage(event, 'edit')" />
                        </div>
                        <div class="mb-3 text-center">
                            <img id="current-thumbnail" src="" alt="Image Preview"
                                style="display: none; width:100%;" class="img-preview" />
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to preview image
        function previewImage(event, modalType) {
            const preview = modalType === 'add' ? document.getElementById('add-thumbnail-preview') : document
                .getElementById('current-thumbnail');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Hide if no file is selected
            }
        }

        // Script for filling the edit modal
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.getAttribute('data-slug');
                const courseTitle = this.getAttribute('data-judul');
                const courseDescription = this.getAttribute('data-deskripsi');
                const courseThumbnail = this.getAttribute('data-thumbnail'); // Dapatkan path thumbnail

                // Replace URL in edit form action
                const form = document.getElementById('editCourseForm');
                form.action = form.action.replace(':id', courseId);

                // Isi field modal dengan data course
                document.getElementById('edit-judul').value = courseTitle;
                document.getElementById('edit-desc').value = courseDescription;

                // Set gambar thumbnail saat ini jika ada
                if (courseThumbnail) {
                    document.getElementById('current-thumbnail').src = "{{ asset('storage/') }}/" +
                        courseThumbnail;
                    document.getElementById('current-thumbnail').style.display =
                        'block'; // Tampilkan thumbnail
                } else {
                    document.getElementById('current-thumbnail').style.display =
                        'none'; // Sembunyikan jika tidak ada
                }

                // Tampilkan modal
                var editModal = new bootstrap.Modal(document.getElementById('editCourseModal'));
                editModal.show();
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will also delete all content related to this course!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
