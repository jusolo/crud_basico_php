<?php
require_once './config.php';

class Model
{
  private $conn;

  public function __construct()
  {
    $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  public function createItem($data)
  {
    $name = $data['name'];
    $description = $data['description'];
    $categories = $data['categories'];
    $status = $data['status'];

    $sql = "INSERT INTO product (name_product, description_product) VALUES ('$name', '$description')";
    if ($this->conn->query($sql) === TRUE) {
      $sqlConsulta = "SELECT id_product FROM product ORDER BY id_product DESC LIMIT 1";
      $result = $this->conn->query($sqlConsulta);
      $content = $result->fetch_assoc();
      $idProduct = $content['id_product'];

      foreach ($categories as $value) {
        $sql2 = "INSERT INTO rel_product_category (product_id, category_id, status_id) VALUES ('$idProduct', '$value', '$status')";
        if ($this->conn->query($sql2) === FALSE) {
          return false;
        }
      }

      return true;
    }
    return false;
  }

  public function getAllItems()
  {
    $sql = "SELECT
    pro.id_product idProduct,
    pro.name_product nameProduct,
    pro.description_product desProduct,
    pro.created_at fecProduct,
    cat.name_category nameCategory,
    sta.description_status desStatus
    FROM rel_product_category rel
    INNER JOIN product pro ON pro.id_product = rel.product_id
    INNER JOIN category cat ON cat.id_category = rel.category_id
    INNER JOIN status sta ON sta.id_status = rel.status_id
    WHERE rel.status_id = 1";

    $result = $this->conn->query($sql);

    $products = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    }
    return $products;
  }

  public function getItem($id)
  {
    $sql = "SELECT
    pro.id_product idProduct,
    pro.name_product nameProduct,
    pro.description_product desProduct,
    pro.created_at fecProduct,
    cat.id_category idCategory,
    cat.name_category nameCategory,
    sta.id_status idStatus,
    sta.description_status desStatus
    FROM rel_product_category rel
    INNER JOIN product pro ON pro.id_product = rel.product_id
    INNER JOIN category cat ON cat.id_category = rel.category_id
    INNER JOIN status sta ON sta.id_status = rel.status_id
    WHERE pro.id_product = $id AND rel.status_id = 1
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return null;
    }
  }

  public function getCategories()
  {
    $sql = "SELECT
    cat.id_category idCategory,
    cat.name_category nameCategory
    FROM category cat";

    $result = $this->conn->query($sql);

    $categories = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
    }
    return $categories;
  }

  public function updateItem($id, $data)
  {
    $name = $data['name'];
    $description = $data['description'];
    $category = $data['category'];
    $status = $data['status'];

    $sql = "UPDATE product SET name_product = '$name', description_product = '$description' WHERE id_product = $id";
    if ($this->conn->query($sql) === TRUE) {
      $sql = "UPDATE rel_product_category SET category_id = '$category', status_id = '$status' WHERE product_id = $id";
      if ($this->conn->query($sql) === TRUE) {
        return true;
      }
    }
    return false;
  }

  public function deleteItem($id)
  {
    $sql = "UPDATE rel_product_category SET status_id = 2 WHERE product_id = $id";
    if ($this->conn->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }
}
