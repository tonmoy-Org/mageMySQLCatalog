<?php
include 'db.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 20px;
            position: relative;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .product-card h3 {
            margin: 10px 0;
            color: #007bff;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
            display: inline-block;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #28a745;
        }

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            text-decoration: none;
        }

        .fab:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 6px 25px rgba(0, 123, 255, 0.6);
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }

        .fab i {
            font-size: 24px;
        }

        /* Tooltip for the FAB */
        .fab-tooltip {
            position: fixed;
            bottom: 35px;
            right: 90px;
            background: #333;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .fab:hover+.fab-tooltip {
            opacity: 1;
        }

        /* Header button alternative */
        .header-btn {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 12px 25px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
    </style>
</head>

<body>

    <h1>Our Products</h1>
    <a href="create.php" class="header-btn">
        <i class="fas fa-plus"></i> Add Product
    </a>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="' . $row['name'] . '">';
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p><strong>Price: </strong>$" . $row['price'] . "</p>";
                echo "<a href='update.php?id=" . $row['id'] . "' class='btn'>Edit</a>";
                echo "<a href='delete.php?id=" . $row['id'] . "' class='btn' onclick=\"return confirm('Delete this product?');\">Delete</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>

    <!-- Floating Action Button -->
    <a href="create.php" class="fab">
        <i class="fas fa-plus"></i>
    </a>
    <span class="fab-tooltip">Add New Product</span>

</body>

</html>