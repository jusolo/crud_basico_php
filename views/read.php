<?php include "./layout/header.php" ?>

<div class="container">
  <a href="index.php?action=viewCreate" class="btn btn-primary my-3">New product</a>
  <?php
  echo $msg;
  if (strlen($msg) > 0) {
  ?>
    <div class="alert alert-<?php echo $tipo ?>" role="alert">
      <?php echo $msg ?>
    </div>
  <?php
  }
  ?>

  <h2 class="border border-primary bg bg-primary p-3 my-3 text-center text-uppercase text-white">List products</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Category</th>
        <th scope="col">Status</th>
        <th scope="col">Date</th>
        <th scope="col">Options</th>
      </tr>
    </thead>
    <tbody>
      <?php $cont = 1;
      foreach ($products as $product) : ?>
        <tr>
          <th scope="row"><?php echo $cont; ?></th>
          <td><?php echo $product['nameProduct']; ?></td>
          <td><?php echo $product['desProduct']; ?></td>
          <td><?php echo $product['nameCategory']; ?></td>
          <td><?php echo $product['desStatus']; ?></td>
          <td><?php echo $product['fecProduct']; ?></td>
          <td>
            <a class="btn btn-warning" href="index.php?action=viewUpdate&id=<?php echo $product['idProduct']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
            <a class="btn btn-danger" href="index.php?action=viewDelete&id=<?php echo $product['idProduct']; ?>"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php $cont++;
      endforeach; ?>
    </tbody>
  </table>
</div>

<?php include "./layout/footer.php" ?>