<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Media::all(["id", "path"]);
        // ->each(function ($media): Media {
        //     $media->path = Storage::url($media->path);
        //     return $media;
        // });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file("image");

        Validator::make($request->all(), [
            "image" => ["required", "image"]
        ])->validate();

        $path = $image->store("products", "public");

        $media = new Media([
            "path" => $path,
        ]);

        $media->save();

        return Storage::url($media->path);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}