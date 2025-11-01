<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk - PT. DELIAMAZING</title>
    <style>
        /* style keseluruhan body */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }


        .container {
            width: 100%;
        }

        /* Style header (kop)*/
        .header {
            display: grid;
            grid-template-columns: 70px 1fr 70px;
            align-items: center;
            border-bottom: 3px solid #FFB4B4;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            width: 50px;
            height: 50px;
        }
        
        .header-text {
            text-align: center;
        }

        .header-text h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #FFB4B4;
        }

        .header-text .slogan {
            font-size: 10px;
            font-style: italic;
            color: #5682b1c7;
            margin: 2px 0;
        }

        .header-text h2 {
            font-size: 14px;
            font-weight: 600;
            margin: 5px 0 0 0;
        }

        h2 {
            color: #5682B1;
        }

        /* Style Tabel Produk*/
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            word-wrap: break-word;
            text-align: left;
        }

        th {
            background-color: #FFB4B4;
            color: white;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background-color: #FFF5F5;
        }

        tbody tr:hover {
            background-color: #FFE8E8;
        }

        /* Style untuk bagian TTD*/
        .signature-section {
            margin-top: 50px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            text-align: center;
            font-size: 12px;
            width: 200px;
        }

        .signature-box .name {
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 70px;
            display: block;
        }

        .signature-box .title {
            font-size: 11px;
            color: #333;
            margin-top: 2px;
        }

    </style>
</head>
<body>
    <div class="container">
        
    <!-- HEADER (NAMA PERUSAHAAN + LOGO) -->
        <div class="header">
          <img src="{{ public_path('storage/image/Logo DA.png') }}" alt="Logo PT. DELIAMAZING" style="width:50px; height:50px;">
            <div class="header-text">
                <h1>PT. DELIAMAZING</h1>
                <p class="slogan">"Taste The Wonder of Deli"</p>
            </div>

            <div></div> 
        </div>
        <h2>REKAP DAFTAR PRODUK</h2>

        <!-- TABEL PRODUK -->
        <table>
            <thead>
                <tr>
                    <th style="width:5%;">ID</th>
                    <th style="width:20%;">Nama Produk</th>
                    <th style="width:10%;">Unit</th>
                    <th style="width:15%;">Type</th>
                    <th style="width:30%;">Information</th>
                    <th style="width:8%;">Qty</th>
                    <th style="width:20%;">Producer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ $product->type }}</td>
                    <td>{{ $product->information }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>{{ $product->producer }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TTD -->
        <div class="signature-section">
            <div class="signature-box">
                <p>Karawang, 1 November 2025</p>
                <p>Mengetahui,</p>
                <span class="name">Delia Nur Ilmi Salam</span>
                <p class="title">Pemilik Perusahaan (CEO)</p>
            </div>
        </div>

    </div>
</body>
</html>