<?php
require_once('Db.php');
require_once('Product.php');
require_once('Dvd.php');
require_once('Book.php');
require_once('Furniture.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
$request_uri = $_SERVER["REQUEST_URI"];

switch ($request_uri) {
    case "/scandiTest/php/saveproduct";
        $user = json_decode(file_get_contents('php://input'));
        if (!isset($user->type)) {
            array_push(self::$errorsMessages, 'type must not be empty');
            echo json_encode(Product::$errorsMessages);
            break;
        }
        $productName = $user->type;
        $productObject = new $productName();
        Product::validate($user->sku ?? null, $user->name ?? null, $user->price ?? null);
        $productObject->validateDimensions($user->size ?? null);
        if (empty(Product::$errorsMessages)) {
            $productObject->setName($user->name);
            $productObject->setSku($user->sku);
            $productObject->setPrice($user->price);
            $productObject->setProperties($user->size);
            $productObject->save();
        }
        echo json_encode(Product::$errorsMessages);
        break;
    case "/scandiTest/php/delete":
        Product::massDelete(json_decode(file_get_contents('php://input')));
    case "/scandiTest/php/getProducts";
        echo json_encode(Product::getProducts());
        break;
}
