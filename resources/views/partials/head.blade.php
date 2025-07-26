<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="images/logo1.png" sizes="any">
<link rel="icon" href="images/logo1.png" type="image/png">
<link rel="apple-touch-icon" href="images/logo1.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
