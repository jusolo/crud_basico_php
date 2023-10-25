<?php
require_once './models/Model.php';

class Controller {
    private $model;

    public function __construct() {
        $this->model = new Model();
    }

    public function create($data) {
        return $this->model->createItem($data);
    }

    public function readAll() {
        return $this->model->getAllItems();
    }

    public function read($id) {
        return $this->model->getItem($id);
    }

    public function readCategories() {
        return $this->model->getCategories();
    }

    public function update($id, $data) {
        return $this->model->updateItem($id, $data);
    }

    public function delete($id) {
        return $this->model->deleteItem($id);
    }
}
