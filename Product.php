<?php 
abstract class Product
{
    private string $sku;
    private string $name;
    private float $price;
    public static $errorsMessages = [];



    static public function getProducts()
    {

        $statment = Db::connect()->prepare('SELECT * FROM products ORDER BY id DESC');
        $statment->execute();
        $products = $statment->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function setSku(string $sku)
    {
        $this->sku = $sku;
    }

    public function getSku()
    {
        return $this->sku;
    }


    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }


    public static function validate($sku, $name, $price)
    {
        $pdo = Db::connect();
        $pdo = $pdo->prepare('SELECT sku FROM products');
        $pdo->execute();
        $listOfSku = [];
        $productSku =  $pdo->fetchAll(PDO::FETCH_ASSOC);;
        foreach ($productSku as $singleSku) {
            array_push($listOfSku, $singleSku['sku']);
        }
        if (!isset($sku)) {
            array_push(self::$errorsMessages, 'Sku must not be empty');
        }else{
            if (in_array($sku, $listOfSku)) {
                array_push(self::$errorsMessages, 'Sku already exists');
            }
        }
        if (!isset($name)) {
            array_push(self::$errorsMessages, 'Name must not be empty');
        }
        if (!isset($price)) {
            array_push(self::$errorsMessages, 'Price must not be empty');
        }else{
            if (!is_numeric($price)) {
                array_push(self::$errorsMessages, 'Price Must Be a Number');
            }
        }
    }

    static public function massDelete($products)
    {
        $pdo = Db::connect();
        $arrayLength = count($products);
        $multipliedString = rtrim(str_repeat('?,', $arrayLength), ',');
        $pdo = $pdo->prepare("DELETE FROM products WHERE id IN ($multipliedString)");
        $pdo->execute($products);
    }

    abstract public function save();
    abstract public function setProperties($parameters);
    abstract public function validateDimensions($parameters);
}


?>
