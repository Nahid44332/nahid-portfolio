@extends('backend.master')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 mt-5">About Sections
 
    </h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Years</th>
                        <th>Features</th>
                        <th>Happy Clients</th>
                        <th>Projects</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $abouts->title }}</td>
                        <td>{{ $abouts->years }}</td>
                        <td>
                            @if($abouts->features)
                                <ul class="mb-0">
                                    @foreach($abouts->features as $f)
                                        <li>{{ $f }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>{{ $abouts->happy_clients }}</td>
                        <td>{{ $abouts->projects_completed }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn"
                                data-id="{{ $abouts->id }}"
                                data-title="{{ $abouts->title }}"
                                data-years="{{ $abouts->years }}"
                                data-description="{{ $abouts->description }}"
                                data-happy_clients="{{ $abouts->happy_clients }}"
                                data-projects_completed="{{ $abouts->projects_completed }}"
                                data-features='@json($abouts->features)'>
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ url('/admin/about/store') }}" method="POST" enctype="multipart/form-data" id="aboutForm">
            @csrf
            <input type="hidden" name="id" id="about_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add / Edit About Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Years</label>
                            <input type="text" name="years" id="years" class="form-control">
                        </div>
                        <div class="col-12">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Happy Clients</label>
                            <input type="number" name="happy_clients" id="happy_clients" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Projects Completed</label>
                            <input type="number" name="projects_completed" id="projects_completed" class="form-control">
                        </div>

                        <!-- Features Dynamic -->
                        <div class="col-12">
                            <label>Features</label>
                            <div id="feature-area">
                                <div class="feature-item d-flex mb-2">
                                    <input type="text" name="features[]" class="form-control me-2" placeholder="Enter feature">
                                    <button type="button" class="btn btn-danger remove-feature">x</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="add-feature">+ Add More</button>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Image One</label>
                            <input type="file" name="image_one" class="form-control">
                            <img src="{{ asset('backend/images/about/'.$abouts->image_one) }}" alt="" height="100" width="100">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Image Two</label>
                            <input type="file" name="image_two" class="form-control">
                            <img src="{{ asset('backend/images/about/'.$abouts->image_two) }}" alt="" height="100" width="100">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS for Add More & Edit -->
<script>
document.getElementById('add-feature').addEventListener('click', function() {
    let div = document.createElement('div');
    div.classList.add('feature-item', 'd-flex', 'mb-2');
    div.innerHTML = `<input type="text" name="features[]" class="form-control me-2" placeholder="Enter feature">
                     <button type="button" class="btn btn-danger remove-feature">x</button>`;
    document.getElementById('feature-area').appendChild(div);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-feature')) {
        e.target.parentElement.remove();
    }
});

// Edit Button Populate Modal
document.querySelectorAll('.edit-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
        let modal = new bootstrap.Modal(document.getElementById('aboutModal'));
        modal.show();

        document.getElementById('about_id').value = btn.dataset.id;
        document.getElementById('title').value = btn.dataset.title;
        document.getElementById('years').value = btn.dataset.years;
        document.getElementById('description').value = btn.dataset.description;
        document.getElementById('happy_clients').value = btn.dataset.happy_clients;
        document.getElementById('projects_completed').value = btn.dataset.projects_completed;

        // Clear old features
        let featureArea = document.getElementById('feature-area');
        featureArea.innerHTML = '';
        let features = JSON.parse(btn.dataset.features || '[]');
        if(features.length){
            features.forEach(f => {
                let div = document.createElement('div');
                div.classList.add('feature-item','d-flex','mb-2');
                div.innerHTML = `<input type="text" name="features[]" class="form-control me-2" value="${f}">
                                 <button type="button" class="btn btn-danger remove-feature">x</button>`;
                featureArea.appendChild(div);
            });
        } else {
            // At least one empty field
            let div = document.createElement('div');
            div.classList.add('feature-item','d-flex','mb-2');
            div.innerHTML = `<input type="text" name="features[]" class="form-control me-2" placeholder="Enter feature">
                             <button type="button" class="btn btn-danger remove-feature">x</button>`;
            featureArea.appendChild(div);
        }
    });
});
</script>

@endsection
