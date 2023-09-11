<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    protected User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index(Request $request)
    {
        $user = User::find(1);

        $options = Validator::make(
            [
                "limit" => $request->input("limit"),
                "sortBy" => $request->input("sortBy"),
                "exclude" => $request->input("exclude")
            ],
            [
                "limit" => "numeric|max:10",
                "sortBy" => Rule::in(["hex", "name"]),
            ]
        )->valid();

        // return $user->colors()
        return Color::whereBelongsTo($user)
            ->when(isset($options["sortBy"]), function (Builder $query) use ($options) {
                $query->orderBy($options["sortBy"]);
            })
            ->when(isset($options["exclude"]), function (Builder $query) use ($options) {
                $query->whereNotIn("id", $options["exclude"]);
            })
            ->when(isset($options["limit"]), function (Builder $query) use ($options) {
                $query->take($options["limit"]);
            })
            ->get(["name", "hex", "id"]);;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "hex" => "required"
        ]);

        /** @var Color */
        $color = $this->user->colors()->create($data);
        return response()->make($color, 201);
    }

    public function update(Request $request, $colorId)
    {
        $data = $request->validate([
            "name" => "required",
            "hex" => "required"
        ]);

        /** @var Color */
        $color = $this->user->colors()->whereId($colorId)->first();

        abort_if(!$color, 404);

        return $color->update($data) ? response()->make($color, 200) : null;
    }

    public function destroy($colorId)
    {
        return $this->user->colors()->whereId($colorId)->delete() ? abort(204) : abort(404);
    }
}
