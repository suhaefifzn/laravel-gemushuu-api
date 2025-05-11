<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;

use App\Models\Game;

use App\Services\GameService;
use App\DTOs\GameData;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    protected GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function getAll(): JsonResponse
    {
        $query = $this->gameService->getAll();

        return DataTables::of($query)
            ->addColumn('action', fn($game) => ['slug' => $game->slug])
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getOne(Game $game): JsonResponse
    {
        $data = $this->gameService->getOne($game);

        return $this->successfulResponseJSON(null, $data);
    }

    public function add(StoreGameRequest $request): JsonResponse
    {
        $data = GameData::fromArray($request->validated());
        $this->gameService->create($data);

        return $this->successfulResponseJSON('Game has been created successfully', null, 201);
    }

    public function update(UpdateGameRequest $request, Game $game): JsonResponse
    {
        $data = GameData::fromArray($request->validated());
        $updatedGame = $this->gameService->update($game, $data);

        return $this->successfulResponseJSON(null, $updatedGame);
    }

    public function delete(Game $game): JsonResponse
    {
        $this->gameService->delete($game);

        return $this->successfulResponseJSON('Game has been deleted successfully');
    }
}
