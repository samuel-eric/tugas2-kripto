<?php

require './extended-vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['cipher']['error'] === UPLOAD_ERR_OK) {
    $tmp = explode('.', $_FILES['cipher']['name']);
    $ext = end($tmp);
    $key = $_POST['key'] ?? '';
    $cipherText = file_get_contents($_FILES['cipher']['tmp_name']);
    $plainText = ExtendedVigenere::decrypt($cipherText, $key);

    $filename = 'decrypt-' . uniqid() . '.' . $ext;
    file_put_contents(__DIR__ . '/../uploads/' . $filename, $plainText);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3 text-center">Decrypt Extended Vigenere Cipher with File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="cipher" class="form-label"><strong>Encrypted file:</strong></label>
        <input type="file" name="cipher" id="cipher" class="form-control" required>
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100 p-2">Decrypt</button>
    </form>
    <hr>
    <?php if (isset($_FILES['cipher']['tmp_name'])) : ?>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download file</a>
      </p>
    <?php else : ?>
      <div class="alert alert-info text-center">
        <strong>Please upload plain file and key</strong>
      </div>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>