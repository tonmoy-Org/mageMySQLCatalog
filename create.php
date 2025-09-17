<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));

    $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Product added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .header h1 {
            font-weight: 500;
            font-size: 24px;
        }

        .header p {
            margin-top: 8px;
            opacity: 0.9;
        }

        .form-container {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        input,
        .file-input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        }

        .file-input {
            position: relative;
            cursor: pointer;
        }

        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-text {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-input-text span {
            color: #666;
        }

        .btn {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004494 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .image-preview {
            width: 100%;
            max-height: 200px;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 576px) {
            .container {
                border-radius: 12px;
            }

            .header {
                padding: 20px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i> Add New Product</h1>
            <p>Fill in the details to create a new product</p>
        </div>

        <div class="form-container">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="productForm">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <div class="file-input">
                        <div class="file-input-text">
                            <span id="file-name">Choose an image file</span>
                            <i class="fas fa-upload"></i>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" required
                            onchange="previewImage(this)">
                    </div>
                    <div class="image-preview" id="imagePreview">
                        <img src="" alt="Image Preview">
                    </div>
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </form>

            <a href="read.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById('imagePreview');
            const fileName = document.getElementById('file-name');

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.style.display = 'block';
                    preview.querySelector('img').src = e.target.result;
                }

                reader.readAsDataURL(file);
                fileName.textContent = file.name;
            } else {
                preview.style.display = 'none';
                fileName.textContent = 'Choose an image file';
            }
        }

        // Add real-time validation
        document.getElementById('productForm').addEventListener('input', function (e) {
            if (e.target.id === 'name') {
                if (e.target.value.length < 2) {
                    e.target.style.borderColor = '#dc3545';
                } else {
                    e.target.style.borderColor = '#28a745';
                }
            }

            if (e.target.id === 'price') {
                if (parseFloat(e.target.value) <= 0) {
                    e.target.style.borderColor = '#dc3545';
                } else {
                    e.target.style.borderColor = '#28a745';
                }
            }
        });
    </script>
</body>

</html>