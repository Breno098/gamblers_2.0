<?php

namespace App\Http\Controllers\Gambler;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Scoreboard;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Dashboard extends Controller
{
    public function index(GeneralService $generalService)
    {
        return Inertia::render('Gambler/Dashboard', [
            'users_scores' => $generalService->usersRanking(),
            'competitions_array' => $generalService->competitions()
        ]);
    }
}
