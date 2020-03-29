<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
    <title>Garou</title>
</head>
<body>
<div id="app">
    <room room-code="{{$room->code}}"></room>
</div>
<script>window.Laravel = "{{csrf_token()}}"</script>
<script src="{{mix('/js/app.js')}}"></script>
</body>
</html>
