@extends('backend.master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Hero Section</h2>

    <!-- Add Hero Button -->
    <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#heroModal">Update Hero Section</button>

    <!-- Hero Card -->
   <div class="container my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="max-width: 900px; border-radius: 20px; overflow: hidden;">
        <div class="row g-0 align-items-center">
            <!-- Image Section -->
            <div class="col-md-5">
                <img id="cardImage" src="{{ asset('backend/images/profile/'.$herosection->image) }}" class="img-fluid h-100 object-fit-cover" alt="Profile Image">
            </div>

            <!-- Content Section -->
            <div class="col-md-7">
                <div class="card-body p-5">
                    <h5 class="text-primary fw-bold mb-2" id="cardRole">I'm</h5>
                    <h1 class="display-5 fw-bold mb-3" id="cardName">{{$herosection->name}}</h1>
                    <h2 class="typed-text-output d-inline fw-normal text-muted" id="cardTypedText">{{$herosection->typed_texts}}</h2>

                    <p class="mt-3 text-secondary">
                        Passionate about creating beautiful and responsive web & app designs. Experienced in Front-End Development and modern web technologies.
                    </p>

                    <div class="mt-4 d-flex align-items-center gap-3">
                        <a href="{{asset('backend/file/cv/'.$herosection->cv)}}" target="_blank" id="cardCV" class="btn btn-primary py-2 px-4">Open CV</a>
                        <a href="{{$herosection->video_link}}" type="button" class="btn btn-outline-primary py-2 px-4" data-bs-toggle="modal" data-bs-target="#videoModal">Play Video</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Hero Modal -->
<div class="modal fade" id="heroModal" tabindex="-1" aria-labelledby="heroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{url('/admin/hero-section/store')}}" id="heroForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="heroModalLabel">Add / Update Hero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Typed Text (comma separated)</label>
                        <input type="text" name="typed_texts" id="typed_text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Video Link (YouTube)</label>
                        <input type="text" name="video_link" id="video_link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Upload CV</label>
                        <input type="file" name="cv" id="cv" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Profile Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="updateHeroCard()">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@php
    $link = $herosection->video_link;

    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $link, $matches)) {
        $videoId = $matches[1];
        $embed = "https://www.youtube.com/embed/{$videoId}";
    } 
    elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
        $videoId = $matches[1];
        $embed = "https://www.youtube.com/embed/{$videoId}";
    } 
    else {
        $embed = '';
    }
@endphp

<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    @if($embed)
                        <iframe id="videoFrame" src="{{ $embed }}" title="Video" allowfullscreen></iframe>
                    @else
                        <p class="text-center text-danger p-3">Invalid YouTube Link</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Image Preview
document.getElementById('image').onchange = evt => {
    const [file] = evt.target.files;
    if(file){
        document.getElementById('previewImage').src = URL.createObjectURL(file);
        document.getElementById('previewImage').style.display = 'block';
    }
};

// Update Hero Card on Save
function updateHeroCard(){
    // Update Card Values
    document.getElementById('cardName').innerText = document.getElementById('name').value;
    document.getElementById('cardTypedText').innerText = document.getElementById('typed_text').value;
    document.getElementById('cardCV').href = document.getElementById('cv_link').value;

    // Update Image
    const fileInput = document.getElementById('image');
    if(fileInput.files[0]){
        document.getElementById('cardImage').src = URL.createObjectURL(fileInput.files[0]);
    }

    // Update Video
    const videoLink = document.getElementById('video_link').value;
    if(videoLink){
        document.getElementById('videoFrame').src = videoLink.replace("watch?v=", "embed/");
    }

    // Close Modal
    var heroModal = bootstrap.Modal.getInstance(document.getElementById('heroModal'));
    heroModal.hide();
}
</script>
@endsection
