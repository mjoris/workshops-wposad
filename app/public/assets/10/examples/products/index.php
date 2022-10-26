<?php

require_once('../WebApiHelper.php');
require_once('includes/config.php');
require_once('includes/functions.php');

$db = getDatabase();

$helper = new WebApiHelper();

if ($matches = $helper->matches('GET', 'api/products')) {

    $products = $db->query('SELECT id, title, price, quantity FROM products')->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['products' => $products]);
    exit();

} else if ($matches = $helper->matches('POST', 'api/products')) {

    $bodyParams = $helper->getHttpBody();
    $title = $bodyParams['title'] ?? false;
    $price = $bodyParams['price'] ?? false;
    $quantity = $bodyParams['quantity'] ?? false;
    if (($title !== false) && ($price !== false) && ($quantity !== false)) {

        $description = $bodyParams['description'] ?? ''; // optional

        // validation
        $errorList = [];
        if (strlen($title) === 0) {
            $errorList[] = 'Title must not be empty.';
        }
        if (! is_numeric($price)) {
            $errorList[] = 'Price must be numeric.';
        }
        if (filter_var($quantity, FILTER_VALIDATE_INT) === false) {
            $errorList[] = 'Quantity must be integer.';
        }

        if (!$errorList) {
            $stmt = $db->prepare('INSERT INTO products (title, price, quantity, description, added_on) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$title, $price, $quantity, $description, (new DateTime())->format('Y-m-d H:i:s')]);

            if ($stmt->rowCount()  > 0) {
                WebApiHelper::message(201, 'Product has been created.'); // 201 Created
            } else {
                WebApiHelper::message(503, 'Unable to create product.'); // 503 Service Unavailable
            }
        } else {
            WebApiHelper::message(422, implode(' ', $errorList)); // 422 Unprocessable Entity
        }
    } else {
        WebApiHelper::message(400, 'Unable to create product. Malformed request.'); // 400 Bad Request
    }
    exit();

} else if ($matches = $helper->matches('GET', 'api/products/([0-9]+)')) {

    $id = $matches[0];
    $stmt = $db->prepare('SELECT id, title, price, quantity FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product !== false)
        echo json_encode($product);
    else {
        WebApiHelper::message(404, 'Product does not exist.');
    }
    exit();

} else if (str_starts_with($helper->getPath() , 'api')) {

    WebApiHelper::message(404, 'Not found.');
    exit();

} else {

    header('Content-type: text/html; charset=UTF-8');

}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
    <style>
        body {
            font-family: Lato;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 200px;
            height: 200px;
            float: left;
            margin: 0 20px 20px 0;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .container {
            padding: 2px 16px;
        }
    </style>
</head>
<body>
<h1>Products</h1>

<script>
    ;(function() {
        'use strict';

        // wait till DOM is loaded
        window.addEventListener('load', function() {
            let url = 'api/products';

            // POST example: fetch(url, {method: 'post', body: JSON.stringify(opts)})
            // response.ok is true when the status code is 2xx
            fetch(url)
                .then(response => response.ok ? response.json() : Promise.reject({err: response.status}))
                .then(data => fillProducts(data))
                .catch(error => window.alert('Request Failed: ' + error.err));

            let fillProducts = function (data) {
                data.products.forEach(function (product, index) {
                    document.body.innerHTML += '<div class="card"><div class="container"><h4>' + product.title + '</h4><p>Price: ' + product.price + '&euro;</p><p>Stock quantity: ' + product.quantity + '</p></div></div>';
                });
            };


        });
    })();
</script>
</body>
</html>
