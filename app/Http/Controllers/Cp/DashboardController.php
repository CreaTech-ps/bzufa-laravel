<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Scholarship;
use App\Models\Partner;
use App\Models\SuccessStory;
use App\Models\ScholarshipApplication;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news' => News::where('is_published', true)->count(),
            'news_total' => News::count(),
            'scholarships' => Scholarship::where('is_active', true)->count(),
            'scholarships_total' => Scholarship::count(),
            'partners' => Partner::count(),
            'success_stories' => DB::table('success_stories')->count(),
            'team_members' => DB::table('team_members')->count(),
            'scholarship_applications' => ScholarshipApplication::where('status', 'pending')->count(),
            'scholarship_applications_total' => ScholarshipApplication::count(),
            'volunteer_applications' => VolunteerApplication::where('status', 'pending')->count(),
            'volunteer_applications_total' => VolunteerApplication::count(),
            'tamkeen_requests' => DB::table('tamkeen_partnership_requests')->where('status', 'pending')->count(),
            'tamkeen_requests_total' => DB::table('tamkeen_partnership_requests')->count(),
            'partnership_requests' => DB::table('partnership_requests')->where('status', 'pending')->count(),
            'partnership_requests_total' => DB::table('partnership_requests')->count(),
        ];

        $stats['pending_total'] = $stats['scholarship_applications'] + $stats['volunteer_applications']
            + $stats['tamkeen_requests'] + $stats['partnership_requests'];

        $recentNews = News::orderByDesc('published_at')->take(5)->get(['id', 'title_ar', 'title_en', 'published_at']);
        $recentApplications = ScholarshipApplication::with('scholarship')->orderByDesc('created_at')->take(5)->get();

        return view('cp.dashboard', compact('stats', 'recentNews', 'recentApplications'));
    }
}
