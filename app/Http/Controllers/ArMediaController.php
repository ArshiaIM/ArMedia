<?php

namespace Modules\ArMedia\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\ArMedia\Models\Armedia;

class ArMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('armedia::index');
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

        $request->validate([
            'image' => 'required|image|max:2048', // حداکثر 2 مگابایت
        ]);

        $userId = Auth::id();
        $image = $request->file('image');
        $folder = "armedia/$userId/profile"; // مسیر ذخیره
        $filename = time() . '_' . $image->getClientOriginalName();

        $path = $image->storeAs($folder, $filename, 'public');

        Armedia::create([
            'user_id' => $userId,
            'filename' => $filename,
            'path' => $path,
            'type' => $image->getMimeType(),
            'size' => $image->getSize(),
        ]);

        return back()->with('success', 'Image uploaded successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('armedia::show');
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
        $media = Armedia::findOrFail($id);
        $oldPath = $media->path;
        $newPath = 'armedia/'.Auth::id().'/'.$request->related_type.'/';

        if($oldPath){

            if (!File::exists(public_path($newPath))) {

                File::makeDirectory(public_path($newPath), 0755, true);
            }
            $newPath = 'armedia/'.Auth::id().'/'.$request->related_type.'/'.$media->filename;
            if(File::move($oldPath,$newPath)){
                $media->update([
                    'related_type'=>$request->related_type,
                    'related_id'=>$request->related_id ?? Auth::id(),
                    'path'=>$newPath,
                ]);
            }

        }

        return redirect()->route('armedia')->with('success', 'Media updated successfully!');
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

}
