<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();
        $courses = PortalDataService::getEnrolledCourses();

        return view('portal.certificates', [
            'courses' => $courses,
            'active' => 'certificates',
        ]);
    }
}
