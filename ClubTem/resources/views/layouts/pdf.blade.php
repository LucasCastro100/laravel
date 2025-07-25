<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        @font-face {
            font-family: 'Nunito Sans';
            src: url('{{ public_path('fonts/NunitoSans_Regular.ttf') }}') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nunito Sans';
            src: url('{{ public_path('fonts/NunitoSans_Bold.ttf') }}') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nunito Sans';
            src: url('{{ public_path('fonts/NunitoSans_Italic.ttf') }}') format('truetype');
            font-weight: 400;
            font-style: italic;
        }

        @font-face {
            font-family: 'Nunito Sans';
            src: url('{{ public_path('fonts/NunitoSans_BoldItalic.ttf') }}') format('truetype');
            font-weight: 700;
            font-style: italic;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Nunito Sans', sans-serif;
            font-weight: 400;
        }

        section {
            margin-bottom: 48px
        }

        section:last-child {
            margin-bottom: 0;
        }

        .headerPDF {
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .headerPDF:last-child {
            margin-bottom: 0;
        }

        .headerPDF .title {
            margin: 0;
            text-align: center;
        }

        .headerPDF,
        table th,
        table td {
            padding: 16px;
            border-style: solid;
            border-color: #000;
            border-width: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        table thead th,
        table thead td {
            text-align: center;
        }

        table th {
            font-weight: bold;
            font-size: 0.80rem;
            text-align: center
        }

        table td {
            font-size: 0.65rem;
        }

        table tbody tr:nth-child(odd),
        table tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 1);
        }

        table tbody tr:nth-child(even),
        table tbody tr:nth-child(even) {
            background-color: rgba(150, 150, 150, 0.2);
        }

        table.contract th:nth-child(1),
        {
        width: 100px;
        }

        table.contract td:nth-child(2) {
            width: 200px;
        }

        table.contract td:nth-child(3) {
            width: 525px;
        }

        table.contract td:nth-child(4),
        table.contract td:nth-child(5),
        {
        width: 325px;
        }

        table.extract .column-1 {
            width: 50px;
        }

        table.extract .column-2 {
            width: 200px;
        }

        table.extract .column-3 {
            width: 150px;
        }

        table.extract .column-4 {
            width: 500px;
        }

        table.extract .column-5,
        table.extract .column-6 {
            width: 100px;
        }

        .text-center {
            text-align: center
        }

        [class*='col-'] {
            padding: 0.5rem 1rem;
        }

        .col-4 {
            width: calc(100% * 4 / 12);
        }

        .col-6 {
            width: calc(100% * 6 / 12);
        }

        .w-100 {
            widows: 100%;
        }

        .mb-1 {
            margin-bottom: 1rem
        }

        .mb-0 {
            margin-bottom: 0;
        }

        table.extract {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        table.extract th,
        table.extract td {
            border: 1px solid black;
            padding: 8px;
        }

        table.extract thead th {
            text-align: center;
        }

        table.extract thead {
            display: table-header-group;
        }

        table.extract tbody {
            display: table-row-group;
        }

        table.extract
    </style>

    <title>Extrato PDF</title>
</head>

<body id="pdf">
    @yield('main')
</body>

</html>
