<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();
        $courses = PortalDataService::getEnrolledCourses();

        return view('portal.courses', [
            'courses' => $courses,
            'active' => 'courses',
        ]);
    }
}
