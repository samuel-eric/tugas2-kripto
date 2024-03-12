<?php

require './rc4.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $plainText = $_POST['plain'] ?? '';
  $key = $_POST['key'] ?? '';

  $encrypt = new RC4($plainText, $key, 'encrypt');
  $encrypt->doCipher();
  $output = base64_encode($encrypt->output);

  $filename = 'encrypt-' . uniqid() . '.txt';
  file_put_contents(__DIR__ . '/../uploads/' . $filename, $output);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card m-5" style="width: 25rem;">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3 text-center">RC4 Encryption with Text</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain text:</strong></label>
        <textarea id="plain" name="plain" class="form-control" required><?= htmlspecialchars($_POST['plain'] ?? '') ?></textarea>
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" value="<?= htmlspecialchars($_POST['key'] ?? '') ?>" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100 p-2">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($output)) : ?>
      <p>
        <strong>Output (base64):</strong> <br><?= $output ?>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download encrypted text file</a>
      </p>
    <?php else : ?>
      <div class="alert alert-info text-center">
        <strong>Please input plain text and key</strong>
      </div>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>