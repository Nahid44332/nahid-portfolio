@extends('backend.master')

@section('content')
    <div class="content-wrapper">

        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">Projects</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
                    <i class="fas fa-plus"></i> Add New Project
                </button>
            </div>
        </section>

        <!-- Content -->
        <section class="content">
            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Project List</h3>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($projects as $key => $project)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <img src="{{ asset('backend/images/projects/' . $project->image) }}"
                                                onerror="this.src='{{ asset('backend/images/no-image.png') }}'"
                                                width="70" class="rounded">
                                        </td>

                                        <td>{{ $project->title }}</td>

                                        <td>
                                            <span class="badge bg-info text-dark">
                                                {{ strtoupper($project->category) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($project->link)
                                                <a href="{{ $project->link }}" target="_blank">Visit</a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-primary editBtn" data-id="{{ $project->id }}"
                                                data-title="{{ $project->title }}" data-category="{{ $project->category }}"
                                                data-link="{{ $project->link }}"
                                                data-image="{{ asset('backend/images/projects/' . $project->image) }}">
                                                Edit
                                            </button>

                                            <form action="{{ url('/admin/project/delete/' . $project->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')"
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No Project Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- ================= Add Modal ================= -->
    <div class="modal fade" id="projectModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ url('/admin/project/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Add New Project</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Project Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select</option>
                                <option value="web design">Web Design</option>
                                <option value="web development">Web Development</option>
                                <option value="graphics">Graphic</option>
                                <option value="digital marketing">Digital Marketing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project URL</label>
                            <input type="url" name="link" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="projectImage" required>
                            <img id="imagePreview" class="mt-3 rounded" style="display:none;width:200px">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= Edit Modal ================= -->
    <div class="modal fade" id="editProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf

                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Edit Project</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" id="edit_category" class="form-select">
                                <option value="web design">Web Design</option>
                                <option value="web development">Web Development</option>
                                <option value="graphics">Graphic</option>
                                <option value="digital marketing">Digital Marketing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project URL</label>
                            <input type="url" name="link" id="edit_link" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image (optional)</label>
                            <input type="file" name="image" class="form-control">
                            <img id="edit_image_preview" class="mt-2 rounded" style="width:120px">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
   <script>
    /* Image Preview (Add) */
    document.getElementById('projectImage').addEventListener('change', e => {
        let file = e.target.files[0];
        if (file) {
            let preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });

    /* Edit Modal */
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function () {

                document.getElementById('edit_title').value = this.dataset.title;
                document.getElementById('edit_category').value = this.dataset.category;
                document.getElementById('edit_link').value = this.dataset.link;
                document.getElementById('edit_image_preview').src = this.dataset.image;

                document.getElementById('editForm').action =
                    "{{ url('/admin/project/update') }}/" + this.dataset.id;

                let modal = new bootstrap.Modal(
                    document.getElementById('editProjectModal')
                );
                modal.show();
            });
        });

    });

    /* Auto hide alert */
    setTimeout(() => {
        document.querySelector('.alert')?.remove();
    }, 3000);
</script>
@endpush
