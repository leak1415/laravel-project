<div class="modal fade" id="student{{ $student->id }}" tabindex="-1" aria-labelledby="studentLabel{{ $student->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentLabel{{ $student->id }}">View Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <strong>Name:</strong> {{ $student->name }}
                    </div>
                    <div class="col-md-12">
                        <strong>Email:</strong> {{ $student->email }}
                    </div>
                    <div class="col-md-12">
                        <strong>Phone:</strong> {{ $student->phone }}
                    </div>
                    <div class="col-md-12">
                        <strong>Student ID:</strong> {{ $student->student_id }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
