<?php

namespace App\Http\Controllers\Gambler;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GeneralController extends Controller
{
    public function scoreRules()
    {
        return Inertia::render('Gambler/General/scoreRules', []);
    }

    public function ranking()
    {
        return Inertia::render('Gambler/General/ranking', []);
    }

    public function scoreReport(GeneralService $generalService)
    {
        return Inertia::render('Gambler/General/scoreReport', [
            'reports' => $generalService->userReportById( Auth::user()->id )
        ]);
    }
}
