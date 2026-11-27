@extends('layouts.app')

@section('title', 'Classroom & Video LMS — SkillLearner')

@section('content')
<script>
    // Forward to active course player in student portal
    window.location.href = "{{ url('/my-courses/reel-mastery-by-canva') }}";
</script>
<div style="padding: 3rem; text-align: center;">
    <p>Redirecting to Course Player...</p>
    <a href="{{ url('/my-courses/reel-mastery-by-canva') }}" class="btn btn-primary" style="background: #1877f2; padding: 0.6rem 1.4rem; border-radius: 8px; color: #fff; text-decoration: none;">
        Open Course Player ➔
    </a>
</div>
@endsection
