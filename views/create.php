<?php include "./layout/header.php" ?>


<div class="container">
  <h2 class="border border-primary bg bg-primary p-3 my-3 text-center text-uppercase text-white">Create new product</h2>
  <form action="index.php?action=create" method="post" class="row g-3">
    <div class="col-md-12">
      <label for="inputName" class="form-label">Name</label>
      <input type="text" class="form-control" name="inputName" id="inputName">
    </div>
    <div class="col-md-12">
      <label for="inputDescription" class="form-label">Description</label>
      <textarea class="form-control" name="inputDescription" id="inputDescription" cols="30" rows="10"></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputCategory" class="form-label">Categories</label>
      <select class="form-select" name="inputCategories[]" id="inputCategories" multiple>
        <option selected>Choose...</option>
        <?php foreach ($categories as $category) : ?>
          <option value="<?php echo $category['idCategory']; ?>"><?php echo $category['nameCategory']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label for="inputStatus" class="form-label">Status</label>
      <select class="form-select" name="inputStatus" id="inputStatus">
        <option selected>Choose...</option>
        <option value="1">Active</option>
        <option value="2">Inactive</option>
      </select>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">Save</button>
    </div>
  </form>
</div>