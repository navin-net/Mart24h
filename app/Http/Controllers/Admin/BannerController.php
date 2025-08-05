<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // Ensure we always return 4 banners
        $banners = Banner::latest()->take(4)->get();

        // Auto-create missing
        $count = $banners->count();
        for ($i = 0; $i < 4 - $count; $i++) {
            $banners->push(new Banner([
                'id' => $i,
                'title' => '',
                'image' => '',
                'status' => 1,
                'link' => '',
            ]));
        }
        return view('admin.settings.banner.index', [
            'pageTitle' => __('messages.banners'),
            'heading' => __('messages.banners'),
            'banners' => $banners,
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.banners'), 'url' => route('banner.index'), 'active' => false],
                ['label' => __('messages.create'), 'url' => '', 'active' => true],
            ]
        ]);

    }


public function ajaxUpdateAll(Request $request)
{
    $banners = $request->input('banners');
    $responses = [];

    foreach ($banners as $index => $data) {
        $rules = [
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
            'link' => 'nullable|url',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Validation failed on row #{$index}",
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = isset($data['id']) && $data['id']
            ? Banner::find($data['id'])
            : new Banner();

        $banner->fill($data);

        if ($request->hasFile("banners.{$index}.image")) {
            $file = $request->file("banners.{$index}.image");
            $path = $file->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();
        $responses[] = $banner->id;
    }

    return response()->json([
        'success' => true,
        'message' => 'All banners updated!',
        'ids' => $responses
    ]);
}


}
