<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>
    <link rel="stylesheet" href="{{ asset('css/charts.css') }}">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
    <style>
        .btn-custom {
            background-color:rgb(0, 0, 0);
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 2px 4px 2px; /* Added top margin */
            cursor: pointer;
            border-radius: 12px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color:rgb(83, 83, 83);
        }
    </style>
</head>
<body>
    <div class="container-parent">
    <button id="download-all" class="btn btn-custom">Descargar todas las gráficas como PNG</button>
        <div class="container">

            @foreach ($charts as $chart)
                <figure class="highcharts-figure">
                    <div id="{{ $chart['id'] }}"></div>
                    <p class="highcharts-description">
                        <!-- {{ $chart['description'] }} -->
                    </p>
                </figure>
                <br>
            @endforeach
        </div>
    </div>
    @foreach ($chartScripts as $script)
        <script src="{{ asset('js/' . $script) }}"></script>
    @endforeach
    <script>
        document.getElementById('download-all').addEventListener('click', function() {
            const expandButtons = Array.from(document.querySelectorAll('.highcharts-a11y-proxy-element[title="Menú de exportación"]'));
            expandButtons.forEach((button, index) => {
                setTimeout(() => {
                    button.click();
                }, index * 500); // 500 ms delay between each expand click
            });

            setTimeout(() => {
                const downloadButtons = Array.from(document.querySelectorAll('.highcharts-menu-item')).filter(button => button.textContent.includes('Descargar PNG'));
                downloadButtons.forEach((button, index) => {
                    setTimeout(() => {
                        button.click();
                    }, index * 1000); // 1000 ms = 1 second delay between each download click
                });
            }, expandButtons.length * 500 + 1000); // Wait for all expand clicks to finish before starting downloads
        });
    </script>
</body>
</html>
