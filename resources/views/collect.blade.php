<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Product</title>
</head>
<body>
    <h1>Test</h1>    
    <table>
        <thead>
            <tr>
                <th>no</th>
                <th>nama</th>
                <th>harga</th>
                <th>status</th>
                <th>kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_url['data'] as $item_product)
                <tr>
                    <td>{{ $item_product['no'] }}</td>
                    <td>{{ $item_product['nama_produk'] }}</td>
                    <td>{{ $item_product['harga'] }}</td>
                    <td>{{ $item_product['status'] }}</td>
                    <td>{{ $item_product['kategori'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>