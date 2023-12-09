<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }

        h1 {
            color: #343434;
            font-size: 24px;
            line-height: 34px;
            text-align: center;
        }

        h3 {
            display: block;
            line-height: 34px;
            text-align: center;
        }

        p {
            color: #777;
        }

        p.congratulation {

            font-size: 16px;
            line-height: 22px;
            margin: 15px auto 0;
            max-width: 500px;
            text-align: justify;
        }

        p.signature {
            font-size: 14px;
            line-height: 18px;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">

        <div class="row">
            <div class="col-lg-12">
                @yield("content")
            </div>
        </div>

    </div>
</div>
</body>
</html>
