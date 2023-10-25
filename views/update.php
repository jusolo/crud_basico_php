<?php include "./layout/header.php" ?>

<div class="container">
  <h2 class="border border-primary bg bg-primary p-3 my-3 text-center text-uppercase text-white">Edit product</h2>
  <form action="index.php?action=update" method="post" class="row g-3">
    <input type="hidden" name="id" value="<?php echo $product['idProduct']; ?>">
    <div class="col-md-12">
      <label for="inputName" class="form-label">Name</label>
      <input type="text" class="form-control" name="inputName" id="inputName" value="<?php echo $product['nameProduct']; ?>">
    </div>
    <div class="col-md-12">
      <label for="inputDescription" class="form-label">Description</label>
      <textarea class="form-control" name="inputDescription" id="inputDescription" cols="30" rows="10"><?php echo $product['desProduct']; ?></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputCategory" class="form-label">Category</label>
      <select class="form-select" name="inputCategory" id="inputCategory">
        <option selected>Choose...</option>
        <?php foreach ($categories as $category) : ?>
          <option <?php if ($product['idCategory'] == $category['idCategory']) { ?> selected <?php } ?> value="<?php echo $category['idCategory']; ?>"><?php echo $category['nameCategory']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label for="inputStatus" class="form-label">Status</label>
      <select class="form-select" name="inputStatus" id="inputStatus">
        <option value="1" <?php if ($product['idStatus'] == 1) {
                          ?> selected <?php } ?>>Active</option>
        <option value="2" <?php if ($product['idStatus'] == 2) {
                          ?> selected <?php } ?>>Inactive</option>
      </select>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">Save</button>
    </div>
  </form>
</div>