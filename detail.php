<?php
// Ambil parameter dari URL
$ikan = $_GET['ikan'] ?? '';

// Data detail ikan
$details = [
    'veiltail' => [
        'name' => 'Veiltail',
        'description' => 'Veiltail Betta fish have long, flowing tails that resemble a veil.',
        'image' => 'img/veiltail_cupang.jpg'
    ],
    'halfsun' => [
        'name' => 'Halfsun',
        'description' => 'Halfsun Betta fish are a crossbreed between Halfmoon and other Betta species.',
        'image' => 'img/halfsun_cupang.jpg'
    ],
    'plakat' => [
        'name' => 'Plakat',
        'description' => 'Plakat Betta fish have short, stubby fins and are known for their fighting ability.',
        'image' => 'img/plakat_cupang.jpg'
    ],
    'halfmoon' => [
        'name' => 'Halfmoon',
        'description' => 'Halfmoon Betta fish have tails that spread 180 degrees, resembling a half-moon.',
        'image' => 'img/halfmoon_cupang.jpg'
    ],
    'chagoi' => [
        'name' => 'Chagoi',
        'description' => 'Chagoi Koi fish are known for their gentle nature and brownish color.',
        'image' => 'img/chagoi.jpg'
    ],
    'tancho' => [
        'name' => 'Tancho',
        'description' => 'Tancho Koi fish have a distinctive red spot on their heads, resembling the Japanese flag.',
        'image' => 'img/Tanco.jpg'
    ],
    'shiro_utsuri' => [
        'name' => 'Shiro Utsuri',
        'description' => 'Shiro Utsuri Koi fish have a striking black and white pattern.',
        'image' => 'img/shiro.png'
    ],
    'ochiba_shigure' => [
        'name' => 'Ochiba Shigure',
        'description' => 'Ochiba Shigure Koi fish have a unique pattern resembling autumn leaves.',
        'image' => 'img/ochi.jpeg'
    ],
];

$detail = $details[$ikan] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail <?php echo $detail['name'] ?? 'Ikan'; ?></title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url("bg 1.png");
        }
        .container {
            width: 400px; /* Fixed width for the card */
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center the content */
        }
        .container img {
            width: 400px; /* Set a fixed width */
            height: 350px; /* Set a fixed height */
            object-fit: cover; /* Ensure the image covers the entire area */
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .container h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .container p {
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
            text-align: center;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="dashboard.php" method="GET">
        <button type="submit" class="back-button">&larr;</button>
    </form>
    <div class="container">
        <?php if ($detail): ?>
            <img src="<?php echo $detail['image']; ?>" alt="<?php echo $detail['name']; ?>">
            <h1><?php echo $detail['name']; ?></h1>
            <p><?php echo $detail['description']; ?></p>
        <?php else: ?>
            <h1>Detail tidak ditemukan</h1>
            <p>Maaf, detail ikan yang Anda cari tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
