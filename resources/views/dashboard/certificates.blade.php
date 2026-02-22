@extends('layouts.main')

@section('title', 'My Certificates')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('my-courses') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i> My Courses
                    </a>
                    <a href="{{ route('my-quizzes') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-question-circle me-2"></i> My Quizzes
                    </a>
                    <a href="{{ route('certificates') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-certificate me-2"></i> Certificates
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <h2 class="mb-4">My Certificates</h2>
            
            <div class="row">
                @foreach($certificates as $certificate)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-certificate fa-4x text-primary mb-3"></i>
                            <h5>{{ $certificate->course->title }}</h5>
                            <p class="text-muted">Certificate #: {{ $certificate->certificate_number }}</p>
                            <p>Issued: {{ $certificate->issue_date->format('M d, Y') }}</p>
                            @if($certificate->pdf_url)
                            <a href="{{ $certificate->pdf_url }}" class="btn btn-success" download>
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $certificates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection