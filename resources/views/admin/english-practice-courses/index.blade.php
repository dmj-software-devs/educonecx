@extends('layouts.admin')

@section('title', 'English Practice Courses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1">English Practice Courses</h1>
        <p class="text-muted mb-0">Manage video lessons shown in the Practice Room.</p>
    </div>
    <a href="{{ route('admin.english-practice-courses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Course</a>
</div>


<div class="table-container bg-white">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Lessons</th>
                    <th>Status</th>
                    <th>Sort</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>
                            <strong>{{ $course->title }}</strong><br>
                            <small class="text-muted">{{ $course->slug }}</small>
                        </td>
                        <td>{{ $course->level ? ucfirst($course->level) : '—' }}</td>
                        <td>{{ $course->lessons_count }}</td>
                        <td><span class="badge bg-{{ $course->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($course->status) }}</span></td>
                        <td>{{ $course->sort_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.english-practice-courses.lessons.create', $course) }}" class="btn btn-sm btn-outline-success">Add Lesson</a>
                            <a href="{{ route('admin.english-practice-courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.english-practice-courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this English practice course?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">No English practice courses yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $courses->links() }}
</div>
@endsection
