<?php require_once 'dbConfig.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cars sold by each brand along with the total number sold and total revenue</h1>
    <?php
    $stmt = $pdo->prepare("SELECT 
    Cars.brand AS Car_brand, 
    COUNT(Sales.sale_id) AS cars_sold, 
    SUM(Sales.sale_price) AS total_revenue 
FROM 
    Sales 
JOIN 
    Cars ON Sales.car_id = Cars.car_id 
GROUP BY 
    Cars.brand;


");
        
    $executeQuery = $stmt->execute();

    if($executeQuery){
        $customers = $stmt->fetchAll();
    } else {
        echo "Query Failed";
        exit; // Stops further execution if query fails
    }
    ?>

    <table> 
        <tr>
            <th>Car_brand</th>
            <th>cars_sold</th>
            <th>total_revenue</th>
        </tr>
        
    <?php if (!empty($customers)): ?>
        <?php foreach ($customers as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Car_brand']); ?></td>
            <td><?php echo htmlspecialchars($row['cars_sold']); ?></td>
            <td><?php echo htmlspecialchars($row['total_revenue']); ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No data found</td>
        </tr>
    <?php endif; ?>
    </table>
</body>
</html>