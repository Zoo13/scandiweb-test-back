<?php 

class Book extends Product
{
    private int $weight;
    public function setProperties($parameters)
    {
        $this->setWeight($parameters);
    }
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }
    public function getWeight()
    {
        return $this->weight;
    }

    public function save()
    {
        $sql = Db::connect()->prepare("INSERT INTO products(id, sku, name, price, size, type)
        VALUES(null,:sku,:name,:price,:size,:type)");

        $sql->bindValue(':name', $this->getName());
        $sql->bindValue(':price', $this->getPrice());
        $sql->bindValue(':sku', $this->getSku());
        $sql->bindValue(':size', $this->getWeight());

        $sql->bindValue(':type', 'book');

        $sql->execute();

    }
    public function validateDimensions($parameters)
    {
        if (isset($parameters)) {
            if (!is_numeric($parameters)) {
                array_push(Product::$errorsMessages, 'Weight Must Be a Number');
            }
        } else {
            array_push(Product::$errorsMessages, 'Weight must not be empty');
        }

    }

}?>