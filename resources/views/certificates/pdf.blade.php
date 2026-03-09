<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        /* Simplified styles for PDF */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: white;
            margin: 0;
            padding: 20px;
        }
        .certificate-pdf {
            max-width: 1000px;
            margin: 0 auto;
            border: 10px solid #0A1D44;
            padding: 40px;
            position: relative;
        }
        h1 { color: #0A1D44; font-size: 48px; }
        .name { font-size: 42px; color: #18386E; }
        .course { font-size: 32px; color: #2E5C61; }
        /* Add more PDF-friendly styles */
    </style>
</head>
<body>
    <div class="certificate-pdf">
        <h1>CERTIFICATE OF COMPLETION</h1>
        <p>This is proudly presented to</p>
        <div class="name">{{ $certificate->user->full_name }}</div>
        <p>for successfully completing</p>
        <div class="course">{{ $certificate->course->title }}</div>
        <p>Certificate ID: {{ $certificate->certificate_number }}</p>
        <p>Issue Date: {{ $certificate->issue_date->format('F d, Y') }}</p>
    </div>
</body>
</html>