<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Termwind\Components\Ul;

class ColorController extends Controller
{
    public function index(Request $request, string $trashed = null)
    {
        return request()->user()->colors()
            ->when($trashed, function (Builder $q): void {
                $q->onlyTrashed();
            })
            ->get(["name", "hex", "id"]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "hex" => "required"
        ]);

        /** @var Color */
        $color = request()->user()->colors()->create($data);
        return response()->make($color, 201);
    }

    public function update(Request $request, $colorId)
    {
        $data = $request->validate([
            "name" => "required",
            "hex" => "required"
        ]);

        /** @var Color */
        $color = request()->user()->colors()->whereId($colorId)->first();

        abort_if(!$color, 404);

        return $color->update($data) ? response()->make($color, 200) : null;
    }

    public function destroy(int $colorId, string  $trashed = null)
    {
        $q = request()->user()->colors()
            ->whereId($colorId)
            ->when($trashed, function (Builder $q): void {
                $q->onlyTrashed();
            });

        return ($trashed ? $q->forceDelete() : $q->delete())
            ? response()->noContent() : abort(404);
    }

    public function destroyMany(Request $request, string $trashed = null)
    {
        $query = request()->user()->colors()
            ->when($trashed, function (Builder $q) {
                $q->onlyTrashed();
            });

        /** @var Collection */
        $userColorIds = $query->pluck("id");

        $validIds = collect($request->input("ids"))
            ->filter(fn (int  $item) => $userColorIds->contains($item),)
            ->flatten();

        $query = $query->whereIn("id", $validIds);

        return ($trashed ? $query->forceDelete() : $query->delete())
            ? response()->noContent()
            : abort(404);
    }

    public function restore($colorId)
    {
        /** @var Color */
        return request()->user()->colors()->whereId($colorId)->restore()
            ? response()->noContent()
            : abort(404);
    }

    public function restoreMany(Request $request)
    {
        $query = request()->user()->colors()->onlyTrashed();

        /** @var Collection */
        $userColorIds = $query->pluck("id");

        $validIds = collect($request->input("ids"))
            ->filter(fn (int  $item) => $userColorIds->contains($item),)
            ->flatten();

        return  $query->whereIn("id", $validIds)->restore()
            ? response()->noContent()
            : abort(404);
    }
}
