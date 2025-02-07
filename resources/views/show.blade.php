@extends('armedia::layouts.master')

@section('title', 'انتخاب تصویر')

@section('content')
    <div class="image-preview-container">
        <img src="{{ asset($image->path) }}" class="selected-image">
        <form action="{{ route('armedia.update', $image->id) }}" method="POST" id="updateForm">
            @csrf
            @method('PATCH')

            <label for="related_type">محل استفاده:</label>
            <select name="related_type" id="related_type">
                <option {{ $image->related_type == 'profile' ? 'selected' : '' }} value="profile">پروفایل</option>
                <option {{ $image->related_type == 'post' ? 'selected' : '' }} value="post">مقاله</option>
                <option {{ $image->related_type == 'product' ? 'selected' : '' }} value="product">محصول</option>
                <option {{ $image->related_type == 'banner' ? 'selected' : '' }} value="banner">بنر</option>
            </select>

            <input type="hidden" name="related_id" id="related_id"> <!-- فیلد مخفی برای ارسال ID -->

            <button type="submit" class="save-btn select-image">ذخیره</button>
        </form>

        <div id="result"></div> <!-- نمایش داده‌ها -->

        <script>
            document.getElementById('related_type').addEventListener('change', function() {
                let selectedType = this.value;

                fetch("{{ route('armedia.getItems') }}?type=" + selectedType, {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        let resultDiv = document.getElementById('result');
                        resultDiv.innerHTML = ""; // پاک کردن موارد قبلی

                        if (data.length > 0) {
                            data.forEach(item => {
                                let div = document.createElement('div');
                                div.classList.add('item');
                                div.textContent = "ID: " + item.id + " | Title: " + (item.title || item
                                    .name);

                                // رویداد کلیک برای انتخاب آیتم
                                div.addEventListener('click', function() {
                                    document.getElementById('related_id').value = item
                                    .id; // مقدار را در فیلد مخفی قرار می‌دهد

                                    // حذف انتخاب از سایر موارد
                                    document.querySelectorAll('.item').forEach(el => el.classList
                                        .remove('selected'));
                                    this.classList.add(
                                    'selected'); // اضافه کردن کلاس به آیتم انتخاب‌شده
                                });

                                resultDiv.appendChild(div);
                            });
                        } else {
                            resultDiv.innerHTML = "<p>هیچ موردی یافت نشد.</p>";
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        </script>

        <style>
            .item {
                padding: 10px;
                border: 1px solid #ccc;
                margin: 5px 0;
                cursor: pointer;
            }

            .item.selected {
                background-color: #4CAF50;
                color: white;
            }
        </style>
    </div>
@endsection
