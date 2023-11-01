<?php
require_once './config.php';
require_once './fpdf/fpdf.php';


class PDF extends FPDF
{
  function PrintTitle($title)
  {
    // Add Title
    $this->SetFont('Arial', 'B', 16);
    $this->Cell(0, 10, $title, 0, 1, 'C');
    $this->Ln(10);
  }

  function PrintData($data)
  {
    // Add Content
    $this->SetFont('Arial', 'B', 12);
    foreach ($data as $product) {
      $this->Cell(0, 10, 'ID: ' . $product['dataProduct'][0]['idProduct'], 0, 1);
      $this->Cell(0, 10, 'Name: ' . $product['dataProduct'][0]['nameProduct'], 0, 1);
      $this->Cell(0, 10, 'Description: ' . $product['dataProduct'][0]['desProduct'], 0, 1);
      $this->Cell(0, 10, 'Date: ' . $product['dataProduct'][0]['fecProduct'], 0, 1);
      $this->Cell(0, 10, 'Status: ' . $product['dataProduct'][0]['desStatus'], 0, 1);

      $this->Cell(0, 10, 'Categories:', 0, 1);
      foreach ($product['dataCategories'] as $category) {
        $this->Cell(0, 10, '- ' . $category['nameCategory'], 0, 1);
      }

      self::PrintLine();
      $this->Ln(10);
    }
  }

  function PrintLine()
  {
    // Add Line
    $this->SetDrawColor(0, 0, 0);
    $this->SetLineWidth(0.5);
    $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 180, $this->GetY());
    $this->Ln(10);
  }
}

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
    $sqlProducts = "SELECT DISTINCT
    pro.id_product idProduct,
    pro.name_product nameProduct,
    pro.description_product desProduct,
    pro.created_at fecProduct,
    sta.description_status desStatus
    FROM product pro
    INNER JOIN rel_product_category rel ON rel.product_id = pro.id_product
    INNER JOIN status sta on sta.id_status = rel.status_id
    WHERE rel.status_id = 1";

    $resultProducts = $this->conn->query($sqlProducts);

    $result = array();

    if ($resultProducts->num_rows > 0) {
      while ($product = $resultProducts->fetch_assoc()) {
        $idProduct = $product['idProduct'];

        $sqlCategories = "SELECT
        cat.id_category idCategory,
        cat.name_category nameCategory
        FROM category cat
        INNER JOIN rel_product_category rel ON rel.category_id = cat.id_category
        WHERE rel.status_id = 1 AND rel.product_id = $idProduct";

        $resultCategories = $this->conn->query($sqlCategories);

        $dataCategories = array();
        if ($resultCategories->num_rows > 0) {
          while ($category = $resultCategories->fetch_assoc()) {
            $dataCategories[] = $category;
          }
        }

        $dataAll = array(
          "dataProduct" => $product,
          "dataCategories" => $dataCategories,
        );

        $result[] = self::procesingData($dataAll);
      }
    }

    return $result;
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

  public function procesingData($obj)
  {
    //Procesing data product
    $dataProduct = array();

    $product = $obj['dataProduct'];

    $idProduct = $product['idProduct'];
    $nameProduct = $product['nameProduct'];
    $desProduct = $product['desProduct'];
    $fecProduct = $product['fecProduct'];
    $desStatus = $product['desStatus'];

    $dataProduct[] = array(
      'idProduct' => $idProduct,
      'nameProduct' => $nameProduct,
      'desProduct' => $desProduct,
      'fecProduct' => $fecProduct,
      'desStatus' => $desStatus,
    );


    //Procesing data categories
    $dataCategories = array();

    foreach ($obj['dataCategories'] as $category) {
      $idCategory = $category['idCategory'];
      $nameCategory = $category['nameCategory'];

      $dataCategories[] = array(
        'idCategory' => $idCategory,
        'nameCategory' => $nameCategory,
      );
    }

    //Juntamos los datos
    $datos = array(
      'dataProduct' => $dataProduct,
      'dataCategories' => $dataCategories,
    );

    return $datos;
  }

  public function createPdf($obj)
  {
    // Create object PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // View Title
    $pdf->PrintTitle("LIST PRODUCTS");

    // View Data
    $pdf->PrintData($obj);

    // Out PDF
    $pdf->Output("productos", "I");
    return true;
  }
}
