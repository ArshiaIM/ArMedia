{{-- فایل edit.blade.php --}}
@extends('armedia::layouts.master')

@section('title', 'ویرایش تصویر')

@section('content')
    <div class="upload-container">
        <h2>آپلود تصویر</h2>
        <input type="file" id="imageUpload" accept="image/*" multiple>
        <button id="uploadBtn" class="upload-btn">آپلود</button>
        <div class="image-preview" id="imagePreview"></div>
    </div>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.classList.add('preview-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.dataset.index = index;

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('remove-btn');
                    removeBtn.innerText = '*';
                    removeBtn.addEventListener('click', function() {
                        previewItem.remove();
                        removeFileFromInput(index);
                    });

                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        });

        function removeFileFromInput(index) {
            const dt = new DataTransfer();
            const input = document.getElementById('imageUpload');
            const files = Array.from(input.files);

            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));

            input.files = dt.files;
        }
    </script>
@endsection
