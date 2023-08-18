<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
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

        return $user->colors($options);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);

        return true;
    }

    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            "name" => "required",
            "hex" => "required"
        ]);

        $color->name = $data["name"];
        $color->hex = $data["hex"];

        $color->save();

        return $color->name;
    }

    public function destroy(Color $color)
    {
        return ["deleted" => $color->delete()];
    }
}