<?php 


class Furniture extends Product
{
    private int $height;
    private int $width;
    private int $length;

    public function setProperties($parameters)
    {
        $this->setHeight($parameters->height);
        $this->setWidht($parameters->width);
        $this->setLength($parameters->length);
    }
    public function setHeight(int $height)
    {
        $this->height = $height;
    }
    public function getHeight()
    {
        return $this->height;
    }

    public function setWidht(int $width)
    {
        $this->width = $width;
    }
    public function getWidht()
    {
        return $this->width;
    }

    public function setLength(int $length)
    {
        $this->length = $length;
    }
    public function getLength()
    {
        return $this->length;
    }
    public function save()
    {
        $sql = Db::connect()->prepare("INSERT INTO products(id, sku, name, price, size, type)
        VALUES(null,:sku,:name,:price,:size,:type)");

        $sql->bindValue(':name', $this->getName());
        $sql->bindValue(':price', $this->getPrice());
        $sql->bindValue(':sku', $this->getSku());

        $dimensions = $this->getHeight() . 'x' . $this->getWidht() . 'x' . $this->getLength();

        $sql->bindValue(':size', $dimensions);

        $sql->bindValue(':type', 'furniture');

        $sql->execute();
    }
    public function validateDimensions($parameters)
    {
        if (isset($parameters)) {
            $obj = $parameters;
            if (isset($obj->height)) {
                $height = $obj->height;
                if (!is_numeric($height)) {
                    array_push(Product::$errorsMessages, 'Height Must Be a Number');
                }
            } else {
                array_push(Product::$errorsMessages, 'Height must not be empty');
            }
            if (isset($obj->width)) {
                $width = $obj->width;
                if (!is_numeric($width)) {
                    array_push(Product::$errorsMessages, 'Width Must Be a Number');
                }
            } else {
                array_push(Product::$errorsMessages, 'Width must not be empty');
            }
            if (isset($obj->length)) {
                $length = $obj->length;
                if (!is_numeric($length)) {
                    array_push(Product::$errorsMessages, 'Length Must Be a Number');
                }
            } else {
                array_push(Product::$errorsMessages, 'Length must not be empty');
            }

        } else {
            array_push(Product::$errorsMessages, 'Size must not be empty');
        }

    }
}
?>