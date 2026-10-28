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
}
