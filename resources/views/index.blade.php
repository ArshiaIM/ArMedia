{{-- فایل index.blade.php --}}
@extends('armedia::layouts.master')

@section('title', 'آپلود تصویر')

@section('content')
    <div class="upload-container">
        <h2>آپلود تصویر</h2>
        <form action="{{ route('armedia.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" id="imageUpload" name="image" accept="image/*" multiple>
            <button id="uploadBtn" class="upload-btn">آپلود</button>
        </form>

        <div class="image-preview" id="imagePreview"></div>
        <div class="uploaded-images">
            <h3>تصاویر آپلود شده</h3>
            <div class="image-list">
                @foreach ($images as $image)
                    <div class="image-item">

                        <img src="{{ asset($image->path) }}" data-id="{{ $image->id }}">
                        <button class="select-image" data-id="{{ $image->id }}">انتخاب</button>
                        <button class="delete-image" data-id="{{ $image->id }}">حذف</button>
                    </div>
                @endforeach
            </div>
        </div>

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
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
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

        document.querySelectorAll('.select-image').forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.dataset.id;
                window.location.href = `/armedia/${imageId}`;
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

        document.querySelectorAll('.delete-image').forEach(button => {
            button.addEventListener('click', function() {
                let imageId = this.getAttribute('data-id');

                if (!confirm("آیا از حذف این تصویر مطمئن هستید؟")) return;

                fetch("{{ route('armedia.destroy', '') }}/" + imageId, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.message) {
                            alert(data.message);
                            this.parentElement.remove(); // حذف از صفحه
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    </script>
@endsection
