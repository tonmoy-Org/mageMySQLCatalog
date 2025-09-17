<?php
include 'db.php';

// Fetch product data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

// Handle form submission
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // If image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $sql = "UPDATE products SET name='$name', price='$price', image=? WHERE id=$id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $image);
        $stmt->execute();
    } else {
        $sql = "UPDATE products SET name='$name', price='$price' WHERE id=$id";
        $conn->query($sql);
    }
    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
            max-width: 600px;
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
            position: relative;
        }
        
        .header h1 {
            font-weight: 500;
            font-size: 24px;
        }
        
        .header p {
            margin-top: 8px;
            opacity: 0.9;
        }
        
        .back-btn {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            color: rgba(255, 255, 255, 0.8);
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
        
        input, .file-input {
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
        
        .image-preview {
            width: 100%;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .current-image {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .current-image img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .new-image-preview {
            display: none;
            text-align: center;
        }
        
        .new-image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .note {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        @media (max-width: 576px) {
            .container {
                border-radius: 12px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 20px;
                margin-left: 25px;
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
            <a href="read.php" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1><i class="fas fa-edit"></i> Update Product</h1>
            <p>Edit the details for <?php echo htmlspecialchars($product['name']); ?></p>
        </div>
        
        <div class="form-container">
            <form method="post" enctype="multipart/form-data" id="updateForm">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <div class="image-preview">
                        <div class="current-image">
                            <p>Current Image:</p>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="new-image-preview" id="newImagePreview">
                            <p>New Image Preview:</p>
                            <img src="" alt="New Image Preview">
                        </div>
                    </div>
                    <div class="file-input">
                        <div class="file-input-text">
                            <span id="file-name">Choose a new image (optional)</span>
                            <i class="fas fa-upload"></i>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <p class="note">Leave empty to keep the current image</p>
                </div>
                
                <button type="submit" name="update" class="btn">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById('newImagePreview');
            const fileName = document.getElementById('file-name');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.style.display = 'block';
                    preview.querySelector('img').src = e.target.result;
                }
                
                reader.readAsDataURL(file);
                fileName.textContent = file.name;
            } else {
                preview.style.display = 'none';
                fileName.textContent = 'Choose a new image (optional)';
            }
        }
        
        // Add real-time validation
        document.getElementById('updateForm').addEventListener('input', function(e) {
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