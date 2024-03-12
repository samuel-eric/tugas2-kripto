<?php

require './rc4.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $cipherText = base64_decode($_POST['cipher'] ?? '');
  $key = $_POST['key'] ?? '';

  $decrypt = new RC4($cipherText, $key, 'decrypt');
  $decrypt->doCipher();
  $output = $decrypt->output;

  $filename = 'decrypt-' . uniqid() . '.txt';
  file_put_contents(__DIR__ . '/../uploads/' . $filename, $output);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card m-5" style="width: 25rem;">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3 text-center">RC4 Decryption with Text</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="cipher" class="form-label"><strong>Cipher text (base64):</strong></label>
        <textarea id="cipher" name="cipher" class="form-control" required><?= htmlspecialchars($_POST['cipher'] ?? '') ?></textarea>
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" value="<?= htmlspecialchars($_POST['key'] ?? '') ?>" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100 p-2">Decrypt</button>
    </form>
    <hr>
    <?php if (isset($output)) : ?>
      <p>
        <strong>Output:</strong> <br><?= $output ?>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download decrypted text file</a>
      </p>
    <?php else : ?>
      <div class="alert alert-info text-center">
        <strong>Please input cipher text and key</strong>
      </div>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>