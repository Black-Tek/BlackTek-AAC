<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CharacterController extends Controller
{
    public function index(): Response
    {
        $characters = account()->players()->orderBy('level', 'desc')->get();

        return Inertia::render('settings/character/index', [
            'characters' => $characters,
        ]);
    }
}
