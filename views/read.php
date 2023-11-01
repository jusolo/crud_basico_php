<?php include "./layout/header.php" ?>

<div class="container my-3">
  <a href="index.php?action=viewCreate" class="btn btn-primary my-3">New product</a>
  <a href="index.php?action=generatePdf" target="_blank" class="btn btn-dark my-3">Generate pdf</a>
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
        <th scope="col">Categories</th>
        <th scope="col">Status</th>
        <th scope="col">Date</th>
        <th scope="col">Options</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($products as $product) :
        foreach ($product['dataProduct'] as $data) :
      ?>
          <tr>
            <td><?php echo $data['idProduct']; ?></td>
            <td><?php echo $data['nameProduct']; ?></td>
            <td><?php echo $data['desProduct']; ?></td>
            <td><?php
                $lastKey = array_key_last($product['dataCategories']);
                foreach ($product['dataCategories'] as $key => $category) {
                  echo $category['nameCategory'];
                  if ($key !== $lastKey) {
                    echo " - ";
                  }
                } ?>
            </td>
            <td><?php echo $data['desStatus']; ?></td>
            <td><?php echo $data['fecProduct']; ?></td>
            <td>
              <a class="btn btn-warning" href="index.php?action=viewUpdate&id=<?php echo $data['idProduct']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
              <a class="btn btn-danger" href="index.php?action=viewDelete&id=<?php echo $data['idProduct']; ?>"><i class="fa-solid fa-trash"></i></a>
            </td>
          </tr>
      <?php
        endforeach;
      endforeach; ?>
    </tbody>
  </table>
</div>

<?php include "./layout/footer.php" ?>