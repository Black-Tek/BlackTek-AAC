<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\CharacterCreateRequest;
use App\Models\Player;
use App\Services\PlayerValidationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CharacterCreateController extends Controller
{
    public function __construct(
        private PlayerValidationService $validationService
    ) {}

    /**
     * Show the character creation form.
     */
    public function create(): Response
    {
        $account = account();

        $maxCharacters = config('blacktek.characters.max_per_account', 7);

        return Inertia::render('settings/character/create', [
            'vocations' => $this->validationService->getAvailableVocations(),
            'towns' => $this->validationService->getAvailableTowns(),
            'sexes' => $this->validationService->getAvailableSexes(),
            'characterCount' => $account->players()->count(),
            'maxCharacters' => $maxCharacters,
            'canCreate' => $account->players()->count() < $maxCharacters,
        ]);
    }

    /**
     * Store a new character.
     */
    public function store(CharacterCreateRequest $request): RedirectResponse
    {
        $account = account();

        $maxCharacters = config('blacktek.characters.max_per_account', 7);
        if ($account->players()->count() >= $maxCharacters) {
            return to_route('character.index')
                ->with('flash', [
                    'error' => 'You have reached the maximum number of characters allowed.',
                ]);
        }

        $validated = $request->validated();

        Player::create([
            'account_id' => $account->id,
            'name' => $validated['name'],
            'sex' => $validated['sex'],
            'vocation' => $validated['vocation'],
            'town_id' => $validated['town_id'],
            ...Player::getDefaultOutfit($validated['sex']),
            ...Player::getNewPlayerDefaults(),
        ]);

        return to_route('character.index')->with('flash', [
            'success' => 'Character created successfully.',
        ]);
    }
}
