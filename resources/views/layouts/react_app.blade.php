<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="{{ asset($seo->favicon) ?? asset('favicon.png') }}" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seo->title ?? config('app.name', 'HS Engineering & Technology Ltd.') }}</title>

    <meta name="description" content="{{ $seo->description ?? 'HS Engineering & Technology Ltd. provides end-to-end engineering infrastructure solutions as EPC to telecommunications and power industries.' }}" />
    <meta name="author" content="HS Engineering & Technology Ltd." />
    @if(isset($seo->keywords))
        <meta name="keywords" content="{{ $seo->keywords }}">
    @endif

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="{{ $seo->title ?? 'HS Engineering & Technology Ltd.' }}" />
    <meta property="og:description" content="{{ $seo->description ?? 'End-to-end EPC engineering infrastructure solutions since 2010.' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset($seo->logo_header) ?? asset('opengraph-image-p98pqg.png') }}" />

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $seo->title ?? 'HS Engineering & Technology Ltd.' }}" />
    <meta name="twitter:description" content="{{ $seo->description ?? 'End-to-end EPC engineering infrastructure solutions.' }}" />
    <meta name="twitter:image" content="{{ asset($seo->logo_header) ?? asset('opengraph-image-p98pqg.png') }}" />

    <link rel="canonical" href="{{ url()->current() }}" />

    @viteReactRefresh
    @vite(['resources/js/index.css', 'resources/js/main.tsx'])
</head>

<body>
    <div id="app"></div>
    <script>
    window.__SEO__ = @json($seo);
</script>
</body>

</html>