@extends('backend.master')
@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Manage Services</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal">
            <i class="bi bi-plus-lg"></i> Add Service
        </button>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Services Table --}}
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Icon</th>
                <th>Price</th>
                <th>Description</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
            <tr>
                <td>{{ $service->title }}</td>
                <td><i class="{{ $service->icon }}"></i> <small>{{ $service->icon }}</small></td>
                <td>${{ $service->price }}</td>
                <td>{{ Str::limit($service->description, 50) }}</td>
                <td>
                    <button 
                        class="btn btn-sm btn-warning editBtn"
                        data-id="{{ $service->id }}"
                        data-title="{{ $service->title }}"
                        data-icon="{{ $service->icon }}"
                        data-price="{{ $service->price }}"
                        data-description="{{ $service->description }}"
                        data-bs-toggle="modal"
                        data-bs-target="#serviceModal"
                    >
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.services.delete', $service->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this service?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- 🔹 Service Add/Edit Modal --}}
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3 border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="serviceModalLabel">Add Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="service_id">

        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Service Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Icon (FontAwesome class)</label>
                <input type="text" name="icon" id="icon" class="form-control" placeholder="e.g. fa fa-code" required>
                <small class="text-muted">Use FontAwesome icon class (like: <code>fa fa-laptop-code</code>)</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="text" name="price" id="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- 🔹 Script for Edit --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll(".editBtn");
    const modal = document.getElementById("serviceModal");
    const modalLabel = document.getElementById("serviceModalLabel");

    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const icon = this.dataset.icon;
            const price = this.dataset.price;
            const description = this.dataset.description;

            modal.querySelector("#service_id").value = id;
            modal.querySelector("#title").value = title;
            modal.querySelector("#icon").value = icon;
            modal.querySelector("#price").value = price;
            modal.querySelector("#description").value = description;

            modalLabel.textContent = "Edit Service";
        });
    });

    // Reset modal on close
    modal.addEventListener("hidden.bs.modal", function() {
        modal.querySelector("form").reset();
        modal.querySelector("#service_id").value = "";
        document.getElementById("serviceModalLabel").textContent = "Add Service";
    });
});
</script>

@endsection
