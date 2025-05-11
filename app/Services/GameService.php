<?php

namespace App\Services;

use App\Models\Game;
use App\DTOs\GameData;

use Illuminate\Support\Facades\DB;

class GameService
{
    public function getAll()
    {
        return Game::query()->select('id', 'name', 'slug');
    }

    public function getOne(Game $game): Game
    {
        return $game;
    }

    public function create(GameData $data): Game
    {
        return DB::transaction(function () use ($data) {
            return Game::create([
                'name' => $data->name,
            ]);
        });
    }

    public function update(Game $game, GameData $data): Game
    {
        return DB::transaction(function () use ($game, $data) {
            $game->update([
                'name' => $data->name,
            ]);
            return $game;
        });
    }

    public function delete(Game $game): void
    {
        DB::transaction(fn() => $game->delete());
    }
}
