<?php

require './rc4.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['plain']['error'] === UPLOAD_ERR_OK) {
    $tmp = explode('.', $_FILES['plain']['name']);
    $ext = end($tmp);

    $plainText = file_get_contents($_FILES['plain']['tmp_name']);
    $key = $_POST['key'] ?? '';

    $encrypt = new RC4($plainText, $key, 'encrypt');
    $encrypt->doCipher();
    $output = $ext === 'txt' ? base64_encode($encrypt->output) : $encrypt->output;

    $filename = 'encrypt-' . uniqid() . '.' . $ext;
    file_put_contents(__DIR__ . '/../uploads/' . $filename, $output);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card m-5" style="width: 25rem;">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3 text-center">RC4 Encryption with File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain file:</strong></label>
        <input type="file" name="plain" id="plain" class="form-control" required>
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" value="<?= htmlspecialchars($_POST['key'] ?? '') ?>" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100 p-2">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($filename) && isset($output)) : ?>
      <?php if ($ext === 'txt') : ?>
        <p>
          <strong>Output (base64):</strong> <br><?= $output ?>
        </p>
      <?php endif ?>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download encrypted file</a>
      </p>
    <?php else : ?>
      <div class="alert alert-info text-center">
        <strong>Please upload decrypted file and key</strong>
      </div>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>