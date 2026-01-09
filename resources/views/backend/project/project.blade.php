@extends('backend.master')

@section('content')
<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1>Projects</h1>
           <button class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#projectModal">
    <i class="fas fa-plus"></i> Add New Project
</button>

        </div>
    </section>

    <!-- List -->
    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card card-outline card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Project List</h3>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Link</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($projects as $key => $project)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <img src="{{ asset('backend/images/projects/'.$project->image) }}"
                                         width="70" style="border-radius:8px">
                                </td>
                                <td>{{ $project->title }}</td>
                                <td>{{ strtoupper($project->category) }}</td>
                                <td>
                                    @if($project->project_url)
                                        <a href="{{ $project->project_url }}" target="_blank">Visit</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Project Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="projectModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ url('/admin/project/store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Add New Project</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Project Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control" required>
                            <option value="">Select</option>
                            <option value="webdesign">Web Design</option>
                            <option value="webdevelopment">Web Development</option>
                            <option value="graphics">Graphic</option>
                            <option value="digital_marketing">Digital Marketing</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Project URL</label>
                        <input type="url" name="link" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" id="projectImage" required>
                        <img id="imagePreview" class="mt-3" style="display:none;width:200px;border-radius:8px">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('projectImage').addEventListener('change', function(e){
    let file = e.target.files[0];
    if(file){
        let preview = document.getElementById('imagePreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>
@endpush
