<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private function formatCount($count)
    {
        if ($count < 6) {
            return $count; 
        } else {
            return ($count - ($count % 5)) . '+'; 
        }
    }

    public function index()
    {
        $studentCount = Siswa::count();
        $courseCount = Course::count();
        $teacherCount = Admin::where('role', 'guru')->count();

        $studentCountFormatted = $this->formatCount($studentCount);
        $courseCountFormatted = $this->formatCount($courseCount);
        $teacherCountFormatted = $this->formatCount($teacherCount);


        $latestCourses = Course::orderBy('created_at', 'desc')->limit(3)->get();
        $latestActivities = Kegiatan::orderBy('created_at', 'desc')->limit(3)->get();

        return view('client.pages.home', compact('courseCount', 'studentCountFormatted', 'studentCount', 'teacherCount',  'latestCourses', 'latestActivities'));
    }
}
