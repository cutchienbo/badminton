<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>
        Badminton Manager
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css\app.css') }}">

    <script src="{{ asset('js\jquery.min.js') }}"></script>

</head>

<body class="">

    {{ view('partial\sidebar') }}

    {{ view($content, $data) }}

    <script src="{{ asset('js\vendor-all.min.js') }}"></script>
    <script src="{{ asset('js\bootstrap.min.js') }}"></script>
    <script src="{{ asset('js\pcoded.min.js') }}"></script>
    <script src="{{ asset('js\main.js') }}"></script>

</body>

</html>