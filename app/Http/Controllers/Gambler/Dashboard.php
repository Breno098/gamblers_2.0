<?php

namespace App\Http\Controllers\Gambler;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Redirect;

class Dashboard extends Controller
{
    public function index()
    {
        return Inertia::render('Gambler/Dashboard', [
        ]);
    }
}
