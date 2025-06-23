<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dropdown Test</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <div class="container mt-5 p-5">
        <h1>Halaman Tes Minimalis</h1>
        <p>Jika dropdown di bawah ini berfungsi, maka masalahnya 100% ada pada konflik skrip di template utama Anda (kemungkinan besar file `app.js` atau `jquery.min.js`).</p>
        <hr>

        <div class="btn-group">
            <button type="button" class="btn btn-lg btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Tombol Tes Dropdown
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Menu Item 1</a></li>
                <li><a class="dropdown-item" href="#">Menu Item 2</a></li>
                <li><a class="dropdown-item" href="#">Menu Item 3</a></li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```