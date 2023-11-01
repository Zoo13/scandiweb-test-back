<?php 


class Dvd extends Product
{
    private int $size;

    public function setMB($MB)
    {
        $this->size = $MB;
    }
    public function getMB()
    {
        return $this->size;
    }

    public function setProperties($parameters)
    {
        $this->setMB($parameters);
    }

    public function save()
    {
        $sql = Db::connect()->prepare("INSERT INTO products(id, sku, name, price, size, type)
        VALUES(null,:sku,:name,:price,:size,:type)");

        $sql->bindValue(':name', $this->getName());
        $sql->bindValue(':price', $this->getPrice());
        $sql->bindValue(':sku', $this->getSku());
        $sql->bindValue(':size', $this->getMB());
        $sql->bindValue(':type', 'dvd');
        $sql->execute();

    }
    public function validateDimensions($parameters)
    {

        if (isset($parameters)) {
            if (!is_numeric($parameters)) {
                array_push(Product::$errorsMessages, 'Size Must Be a Number');
            }
        } else {
            array_push(Product::$errorsMessages, 'Size must not be empty');
        }
    }
}
?>