{{-- فایل پرنت: master.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="{{ Module::asset('armedia:css/all.min.css') }}"> --}}
    <script src="https://kit.fontawesome.com/6897057b8a.js" crossorigin="anonymous"></script>



    <title>@yield('title')</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .upload-container {
            width: 70%;
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .image-preview {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .preview-item {
            position: relative;
        }

        .preview-item img {
            max-width: 150px;
            height: auto;
            border-radius: 5px;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 20px;
            height: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-btn {
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .upload-btn:hover {
            background-color: #0056b3;
        }

        .uploaded-images {
            margin-top: 20px;
        }

        .image-list {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .image-item {
            position: relative;
            width: 100px;
            cursor: pointer;
        }

        .image-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .select-image {
            display: block;
            width: 100%;
            margin-top: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
