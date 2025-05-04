<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

// Models
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function getAll() {
        $query = Game::query();

        return DataTables::of($query->select('id', 'name', 'slug'))
            ->addColumn('action', function ($game) {
                return [
                    'slug' => $game->slug
                ];
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getOne(Game $game) {
        return $this->successfulResponseJSON(null, $game);
    }

    public function add(Request $request) {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        DB::beginTransaction();
        $create = Game::create([
            'name' => $request->name
        ]);

        if ($create) {
            DB::commit();
            return $this->successfulResponseJSON('Game has been added successfully');
        }

        DB::rollBack();
        return $this->failedResponseJSON('Game failed to be added', 500);
    }

    public function update(Request $request, Game $game) {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        DB::beginTransaction();
        $update = $game->update([
            'name' => $request->name
        ]);

        if ($update) {
            DB::commit();
            return $this->successfulResponseJSON('Game has been updated successfully');
        }

        DB::rollBack();
        return $this->failedResponseJSON('Game failed to be updated', 500);
    }

    public function delete(Game $game) {
        DB::beginTransaction();
        $delete = $game->delete();

        if ($delete) {
            DB::commit();
            return $this->successfulResponseJSON('Game has been deleted successfully');
        }

        DB::rollBack();
        return $this->failedResponseJSON('Game failed to be deleted', 500);
    }
}
