<div class="modal fade" id="deleteStudent{{ $student->id }}" tabindex="-1" aria-labelledby="deleteStudentLabel{{ $student->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('students.destroy', $student->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStudentLabel{{ $student->id }}">Form Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are U sure to delete?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
                </div>
            </div>
        </form>
    </div>
</div>
