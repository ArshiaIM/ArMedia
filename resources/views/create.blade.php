{{-- فایل index.blade.php --}}
@extends('master')

@section('title', 'آپلود تصویر')

@section('content')
    <div class="upload-container">
        <h2>آپلود تصویر</h2>
        <input type="file" id="imageUpload" accept="image/*">
        <img id="imagePreview" alt="پیش‌نمایش تصویر">
    </div>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('imagePreview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
