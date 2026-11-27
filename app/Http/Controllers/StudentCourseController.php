<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentCourseController extends Controller
{
    /**
     * Display Enrolled Courses in Student Portal.
     * Regular users see only visible courses; Super Admin sees all courses with visibility controls.
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $userRole = Auth::user()?->role ?? session('user.role', 'user');
        $isSuperAdmin = ($userRole === 'super_admin');

        // Regular users only see visible courses
        $courses = PortalDataService::getEnrolledCourses(! $isSuperAdmin);

        return view('portal.courses', [
            'courses' => $courses,
            'isSuperAdmin' => $isSuperAdmin,
            'active' => 'courses',
        ]);
    }

    /**
     * Display Single Course Video Player & Lessons Submenu (Matches Image 2).
     */
    public function show(Request $request, string $slug): View
    {
        PortalDataService::ensureUserSession();

        $userRole = Auth::user()?->role ?? session('user.role', 'user');
        $isSuperAdmin = ($userRole === 'super_admin');

        $courses = PortalDataService::getEnrolledCourses(! $isSuperAdmin);
        $course = PortalDataService::getCourseBySlug($slug, ! $isSuperAdmin);

        $lessons = $course['lessons_list'] ?? [];
        $lessonIndex = (int) $request->query('lesson', 0);
        if ($lessonIndex < 0 || $lessonIndex >= count($lessons)) {
            $lessonIndex = 0;
        }

        $activeLesson = $lessons[$lessonIndex] ?? ($lessons[0] ?? null);

        return view('portal.course-player', [
            'course' => $course,
            'courses' => $courses,
            'lessons' => $lessons,
            'activeLesson' => $activeLesson,
            'activeLessonIndex' => $lessonIndex,
            'isSuperAdmin' => $isSuperAdmin,
            'active' => 'courses',
        ]);
    }

    /**
     * Classroom route proxy to show the course player.
     */
    public function classroom(Request $request): View
    {
        $slug = (string) $request->query('course', 'reel-mastery-by-canva');

        return $this->show($request, $slug);
    }
}
