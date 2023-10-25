<?php include "./layout/header.php" ?>

<div class="container">
  <h2 class="border border-primary bg bg-primary p-3 my-3 text-center text-uppercase text-white">Delte product</h2>

  <h2>Are you sure you want to remove this product?</h2>
  <form action="index.php?action=delete" method="post" class="row g-3">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <div class="col-12">
      <button type="submit" class="btn btn-danger">Delete</button>
    </div>
  </form>
</div>