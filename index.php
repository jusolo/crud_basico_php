<?php
// index.php
require_once 'config.php';
require_once 'controllers/Controller.php';

$controller = new Controller();

$tipo = "";
$msg = "";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
  switch ($action) {
    case 'viewCreate':
      $categories = $controller->readCategories();
      include('views/create.php');
      break;
    case 'create':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
          'name' => $_POST['inputName'],
          'description' => $_POST['inputDescription'],
          'categories' => $_POST['inputCategories'],
          'status' => $_POST['inputStatus'],
        ];
        $result = $controller->create($data);
        if ($result) {
          $tipo = "success";
          $msg = "product created successfully!";
          header('Location: index.php?action=read');
        } else {
          $tipo = "danger";
          $msg = "the product could not be created!";
          header('Location: index.php?action=read');
        }
      } else {
        $tipo = "warning";
        $msg = "an unknown error occurred!";
        header('Location: index.php?action=read');
      }
      break;
    case 'read':
      $products = $controller->readAll();
      include('views/read.php');
      break;
    case 'viewUpdate':
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = $controller->read($id);
        $categories = $controller->readCategories();
        if ($product) {
          include('views/update.php');
        } else {
          $tipo = "warning";
          $msg = "unknown product!";
          header('Location: index.php?action=read');
        }
      } else {
        $tipo = "warning";
        $msg = "unknown product!";
        header('Location: index.php?action=read');
      }
      break;
    case 'update':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
          'id' => $_POST['id'],
          'name' => $_POST['inputName'],
          'description' => $_POST['inputDescription'],
          'category' => $_POST['inputCategory'],
          'status' => $_POST['inputStatus'],
        ];
        $result = $controller->update($data['id'], $data);
        if ($result) {
          $tipo = "success";
          $msg = "product updated successfully!";
          header('Location: index.php?action=read');
        } else {
          $tipo = "danger";
          $msg = "the product could not be updated!";
          header('Location: index.php?action=read');
        }
      } else {
        $tipo = "warning";
        $msg = "an unknown error occurred!";
        header('Location: index.php?action=read');
      }
      break;
    case 'viewDelete':
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = $controller->read($id);
        $categories = $controller->readCategories();
        if ($product) {
          include('views/delete.php');
        } else {
          $tipo = "warning";
          $msg = "unknown product!";
          header('Location: index.php?action=read');
        }
      } else {
        $tipo = "warning";
        $msg = "unknown product!";
        header('Location: index.php?action=read');
      }
      break;
    case 'delete':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $result = $controller->delete($id);
        if ($result) {
          $tipo = "success";
          $msg = "product deleted successfully!";
          header('Location: index.php?action=read');
        } else {
          $tipo = "danger";
          $msg = "the product could not be deleted!";
          header('Location: index.php?action=read');
        }
      } else {
        $tipo = "warning";
        $msg = "an unknown error occurred!";
        header('Location: index.php?action=read');
      }
      break;
    default:
      header('Location: index.php?action=read');
      break;
  }
} else {
  header('Location: index.php?action=read');
}
