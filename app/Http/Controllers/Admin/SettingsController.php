<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $shop = Shop::firstOrCreate(['id' => 1]);
        $pageTitle = 'Shop Info';
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Settings', 'url' => route('settings.index'), 'active' => true],
        ];
        return view('admin.settings.index', compact('shop', 'pageTitle', 'breadcrumbs'));
    }

    public function ajaxUpdate(Request $request)
    {
        $shop = Shop::firstOrCreate(['id' => 1]);

        $validator = Validator::make($request->all(), [
            'name_shop' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'open_shop_time' => 'nullable|string|max:50',
            'close_shop' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'x' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'logo_shop' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shop->fill($request->except('logo_shop'));

        if ($request->hasFile('logo_shop') && $request->file('logo_shop')->isValid()) {
            if ($shop->logo_shop && Storage::disk('public')->exists($shop->logo_shop)) {
                Storage::disk('public')->delete($shop->logo_shop);
            }

            $ext = $request->file('logo_shop')->getClientOriginalExtension();
            $filename = 'shop_logo.' . $ext;
            $path = $request->file('logo_shop')->storeAs('shop_infos', $filename, 'public');
            $shop->logo_shop = $path;
        }

        $shop->save();

        return response()->json(['message' => 'Shop info updated successfully.']);
    }









    public function banners(){
        for ($i = 1; $i <= 4; $i++) {
            Banner::firstOrCreate(['id' => $i], [
                'title' => '',
                'status' => 1,
                'link' => '',
                'image' => null,
            ]);
        }
        $banners = Banner::whereIn('id', [1, 2, 3, 4])->orderBy('id')->get();
        return view('admin.settings.banners', compact('banners'))->with([
            'pageTitle' => 'Banners',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
                ['label' => 'Banners', 'url' => route('settings.banners'), 'active' => true],
            ],
        ]);
    }

    public function ajaxUpdateAll(Request $request){
        $data = $request->input('banners');
        if (!$data || !is_array($data)) {
            return response()->json(['message' => 'Invalid data submitted.'], 422);
        }

        $errors = [];
        $updatedCount = 0;

        foreach ($data as $key => $bannerData) {
            $id = $bannerData['id'] ?? null;
            if (!$id) continue;

            $banner = Banner::find($id);
            if (!$banner) {
                $errors[$key] = "Banner ID $id not found.";
                continue;
            }

            $validator = Validator::make($bannerData, [
                'title' => 'required|string|max:255',
                'status' => 'required|boolean',
                'link' => 'nullable|url|max:255',
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            $banner->title = $bannerData['title'];
            $banner->status = $bannerData['status'];
            $banner->link = $bannerData['link'] ?? null;

            // Update image with custom filename sa1, sa2, ..., sa10
            if ($request->hasFile("banners.$key.image")) {
                $imageFile = $request->file("banners.$key.image");
                if ($imageFile->isValid()) {
                    // Delete old image
                    if ($banner->image && Storage::exists($banner->image)) {
                        Storage::delete($banner->image);
                    }

                    // Generate custom filename: sa{id}.{ext}
                    $extension = $imageFile->getClientOriginalExtension();
                    $filename = 'sa' . $id . '.' . $extension;
                    $path = $imageFile->storeAs('banners', $filename, 'public');
                    $banner->image = $path;
                }
            }

            $banner->save();
            $updatedCount++;
        }

        if (count($errors) > 0) {
            return response()->json([
                'message' => 'Some banners failed to update.',
                'errors' => $errors,
            ], 422);
        }

        return response()->json([
            'message' => "Successfully updated $updatedCount banner(s).",
        ]);
    }
}
