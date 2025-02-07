<?php

namespace Modules\ArMedia\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\ArMedia\Models\Armedia;
use Str;

class ArMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Armedia::where('user_id', '=', Auth::id())->get();
        return view('armedia::index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('armedia::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'image' => 'required|image|max:2048', // حداکثر 2 مگابایت
        ]);

        $userId = Auth::id();
        $image = $request->file('image');
        $folder = "armedia/$userId/unset"; // مسیر ذخیره
        $filename = time() . '_' . $image->getClientOriginalName();

        $path = $image->storeAs($folder, $filename, 'public');

        Armedia::create([
            'user_id' => $userId,
            'filename' => $filename,
            'path' => 'storage/' . $path,
            'type' => $image->getMimeType(),
            'related_type' => 'unset',

            'size' => $image->getSize(),
        ]);

        return redirect()->route('armedia.index')->with('success', 'Image uploaded successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $image = Armedia::findOrFail($id);
        return view('armedia::show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $file = Armedia::findOrFail($id);
        return view('armedia::edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


        $request->validate([
            'related_type' => 'required|string',
            'related_id' => 'nullable|integer',
        ]);
        $related_type = $request->related_type;

        if ($related_type != 'profile') {
            $related_id = $request->related_id;
            $related_id = $request->related_id;
            $newPath = 'storage/armedia/' .  Auth::id() . '/' . $related_type . '/' . $related_id . '/';
        }
        $newPath = 'storage/armedia/' . Auth::id() . '/' . $related_type . '/';


        $media = Armedia::findOrFail($id);
        $oldPath = $media->path;

        if ($oldPath) {

            if (!File::exists(public_path($newPath))) {

                File::makeDirectory(public_path($newPath), 0755, true);
            }
            $newPath .= $media->filename;
            if (File::move($oldPath, $newPath)) {
                $media->update([
                    'related_type' => $related_type,
                    'related_id' => $request->related_id,
                    'path' => $newPath,
                ]);
            }
        }

        return redirect()->route('armedia.index')->with('success', 'Media updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $media = Armedia::findOrFail($id);
        if ($media) {
            $filePath = $media->path;
            // بررسی وجود فایل
            if (File::exists($filePath)) {
                // حذف فایل
                File::delete($filePath);
            }

            // حذف رکورد از دیتابیس
            $media->delete();
            return back()->with('success', __('تصویر با موفقیت حذف شد.'));
        }
    }
    public function handleSelection(Request $request)
    {
        $selectedImages = $request->input('selected_images'); // لیست ID‌های انتخاب‌شده
        $ids = explode(',', $selectedImages);
        $user = User::findOrFail(Auth::id());
        $image = Armedia::findOrFail($ids)->first();

        $image->update([
            'related_type' => 'profile', // تعیین اینکه این تصویر مربوط به پروفایل است
            'user_id' => $user->id, // مرتبط کردن تصویر با کاربر جاری
        ]);

        $user->update([
            'profile_photo_path' => $image->path,
        ]);


        // انجام عملیات بر اساس نیاز
        return redirect()->route('dashboard')->with('success', 'Images selected successfully.');
    }

    public function getItems(Request $request)
    {
        $type = $request->query('type');

        // لیست مدل‌های مجاز
        $models = [
            // 'profile' => \App\Models\Users::class,
            // 'post'    => \App\Models\Post::class,
            // 'product' => \App\Models\Product::class,
            // 'banner'  => \App\Models\Banner::class,
        ];

        if (!array_key_exists($type, $models)) {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        if ($type == 'profile') {
            $items = [];
            return response()->json($items);
        } else {
            // دریافت داده‌ها با استفاده از مدل
            $items = $models[$type]::all();
        }



        return response()->json($items);
    }
}
