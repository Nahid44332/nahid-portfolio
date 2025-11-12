@extends('backend.master')
@section('content')

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Manage Skills, Experience & Education</h2>

    <div class="d-flex gap-2 justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bulkAddModal">
            <i class="bi bi-plus-lg"></i> Add Multiple
        </button>
    </div>

    {{-- Skills Table --}}
    <div class="card mb-3">
        <div class="card-header">Skills</div>
        <div class="card-body p-0">
            <table class="table mb-0" id="skills-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Percentage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($skills as $i => $s)
                    <tr data-id="{{ $s->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->percentage }}%</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-type="skill" data-id="{{ $s->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Experience Table --}}
    <div class="card mb-3">
        <div class="card-header">Experience</div>
        <div class="card-body p-0">
            <table class="table mb-0" id="experiences-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Years</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($experiences as $i => $e)
                    <tr data-id="{{ $e->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $e->title }}</td>
                        <td>{{ $e->company }}</td>
                        <td>{{ $e->year_from }} - {{ $e->year_to }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-type="experience" data-id="{{ $e->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Education Table --}}
    <div class="card mb-3">
        <div class="card-header">Education</div>
        <div class="card-body p-0">
            <table class="table mb-0" id="educations-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Institution</th>
                        <th>Years</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($educations as $i => $ed)
                    <tr data-id="{{ $ed->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $ed->title }}</td>
                        <td>{{ $ed->institution }}</td>
                        <td>{{ $ed->year_from }} - {{ $ed->year_to }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-type="education" data-id="{{ $ed->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Bulk Add Modal --}}
<div class="modal fade" id="bulkAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Skills / Experiences / Educations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="bulkAddForm">
                @csrf
                <div class="modal-body" style="max-height:65vh; overflow:auto;">

                    {{-- Skills area --}}
                    <div class="mb-4">
                        <h6>Skills <button type="button" id="add-skill-row" class="btn btn-sm btn-outline-primary ms-2">+ Add Row</button></h6>
                        <div id="skills-area">
                            <div class="d-flex gap-2 mb-2 skill-row">
                                <input class="form-control" name="skills[0][name]" placeholder="Skill name" required>
                                <input class="form-control" name="skills[0][percentage]" type="number" placeholder="%" required>
                                <button type="button" class="btn btn-outline-danger remove-row">×</button>
                            </div>
                        </div>
                    </div>

                    {{-- Experiences area --}}
                    <div class="mb-4">
                        <h6>Experiences <button type="button" id="add-exp-row" class="btn btn-sm btn-outline-primary ms-2">+ Add Row</button></h6>
                        <div id="experiences-area">
                            <div class="d-flex gap-2 mb-2 exp-row">
                                <input class="form-control" name="experiences[0][title]" placeholder="Job title" required>
                                <input class="form-control" name="experiences[0][company]" placeholder="Company" required>
                                <input class="form-control" name="experiences[0][year_from]" placeholder="From">
                                <input class="form-control" name="experiences[0][year_to]" placeholder="To">
                                <button type="button" class="btn btn-outline-danger remove-row">×</button>
                            </div>
                        </div>
                    </div>

                    {{-- Educations area --}}
                    <div class="mb-4">
                        <h6>Educations <button type="button" id="add-edu-row" class="btn btn-sm btn-outline-primary ms-2">+ Add Row</button></h6>
                        <div id="educations-area">
                            <div class="d-flex gap-2 mb-2 edu-row">
                                <input class="form-control" name="educations[0][title]" placeholder="Course" required>
                                <input class="form-control" name="educations[0][institution]" placeholder="Institution" required>
                                <input class="form-control" name="educations[0][year_from]" placeholder="From">
                                <input class="form-control" name="educations[0][year_to]" placeholder="To">
                                <button type="button" class="btn btn-outline-danger remove-row">×</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="bulkSubmitBtn" type="submit" class="btn btn-primary">Save All</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    let skillIndex = 1, expIndex = 1, eduIndex = 1;

    const skillsArea = document.getElementById('skills-area');
    const expsArea = document.getElementById('experiences-area');
    const edusArea = document.getElementById('educations-area');

    // Add row handlers
    document.getElementById('add-skill-row').addEventListener('click', () => {
        const html = `<div class="d-flex gap-2 mb-2 skill-row">
            <input class="form-control" name="skills[${skillIndex}][name]" placeholder="Skill name" required>
            <input class="form-control" name="skills[${skillIndex}][percentage]" type="number" placeholder="%" required>
            <button type="button" class="btn btn-outline-danger remove-row">×</button>
        </div>`;
        skillsArea.insertAdjacentHTML('beforeend', html);
        skillIndex++;
    });

    document.getElementById('add-exp-row').addEventListener('click', () => {
        const html = `<div class="d-flex gap-2 mb-2 exp-row">
            <input class="form-control" name="experiences[${expIndex}][title]" placeholder="Job title" required>
            <input class="form-control" name="experiences[${expIndex}][company]" placeholder="Company" required>
            <input class="form-control" name="experiences[${expIndex}][year_from]" placeholder="From">
            <input class="form-control" name="experiences[${expIndex}][year_to]" placeholder="To">
            <button type="button" class="btn btn-outline-danger remove-row">×</button>
        </div>`;
        expsArea.insertAdjacentHTML('beforeend', html);
        expIndex++;
    });

    document.getElementById('add-edu-row').addEventListener('click', () => {
        const html = `<div class="d-flex gap-2 mb-2 edu-row">
            <input class="form-control" name="educations[${eduIndex}][title]" placeholder="Course" required>
            <input class="form-control" name="educations[${eduIndex}][institution]" placeholder="Institution" required>
            <input class="form-control" name="educations[${eduIndex}][year_from]" placeholder="From">
            <input class="form-control" name="educations[${eduIndex}][year_to]" placeholder="To">
            <button type="button" class="btn btn-outline-danger remove-row">×</button>
        </div>`;
        edusArea.insertAdjacentHTML('beforeend', html);
        eduIndex++;
    });

    // Remove row (delegated)
    document.addEventListener('click', function(e){
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('.skill-row, .exp-row, .edu-row')?.remove();
        }
    });

    // AJAX submit
    const form = document.getElementById('bulkAddForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const submitBtn = document.getElementById('bulkSubmitBtn');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Saving...';

        const formData = new FormData(form);

        fetch("{{ route('skill_experience.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => r.json())
        .then(res => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Save All';
            if (res.status === 'success') {
                // Append returned created items to tables (if any)
                if (res.created) {
                    // skills
                    if(res.created.skills && res.created.skills.length){
                        const tbody = document.querySelector('#skills-table tbody');
                        res.created.skills.forEach((s) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>-</td>
                                <td>${escapeHtml(s.name)}</td>
                                <td>${escapeHtml(s.percentage)}%</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-type="skill" data-id="${s.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>`;
                            tbody.prepend(row);
                        });
                    }
                    // experiences
                    if(res.created.experiences && res.created.experiences.length){
                        const tbody = document.querySelector('#experiences-table tbody');
                        res.created.experiences.forEach((e) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>-</td>
                                <td>${escapeHtml(e.title)}</td>
                                <td>${escapeHtml(e.company)}</td>
                                <td>${escapeHtml(e.year_from||'')} - ${escapeHtml(e.year_to||'')}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-type="experience" data-id="${e.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>`;
                            tbody.prepend(row);
                        });
                    }
                    // educations
                    if(res.created.educations && res.created.educations.length){
                        const tbody = document.querySelector('#educations-table tbody');
                        res.created.educations.forEach((ed) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>-</td>
                                <td>${escapeHtml(ed.title)}</td>
                                <td>${escapeHtml(ed.institution)}</td>
                                <td>${escapeHtml(ed.year_from||'')} - ${escapeHtml(ed.year_to||'')}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-type="education" data-id="${ed.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>`;
                            tbody.prepend(row);
                        });
                    }
                }

                form.reset();
                var modal = bootstrap.Modal.getInstance(document.getElementById('bulkAddModal'));
                modal.hide();
                alert(res.message || 'Saved successfully');
            } else {
                if (res.errors) {
                    let messages = [];
                    for (const k in res.errors) messages.push(res.errors[k].join(', '));
                    alert('Validation: ' + messages.join('\n'));
                } else {
                    alert(res.message || 'Something went wrong');
                }
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Save All';
            console.error(err);
            alert('Server error. Check console.');
        });
    });

    // Delete handler
    document.addEventListener('click', function(e){
        if(e.target.closest('.delete-btn')){
            const btn = e.target.closest('.delete-btn');
            const id = btn.dataset.id;
            const type = btn.dataset.type;
            if(!confirm('Are you sure to delete this item?')) return;

            fetch(`/backend/skill-experience/delete/${type}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(res => {
                if(res.status === 'success'){
                    btn.closest('tr').remove();
                    alert(res.message || 'Deleted successfully');
                } else {
                    alert(res.message || 'Something went wrong');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Server error');
            });
        }
    });

    function escapeHtml(unsafe){
        return unsafe === null || unsafe === undefined ? '' : String(unsafe)
            .replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;')
            .replaceAll('"','&quot;').replaceAll("'",'&#039;');
    }
});
</script>

@endsection
