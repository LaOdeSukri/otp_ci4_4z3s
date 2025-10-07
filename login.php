<form action="/auth/doLogin" method="post">
    <input type="email" name="email" placeholder="Masukkan Email" required>
    <button type="submit">Kirim OTP</button>
</form>
<?= session()->getFlashdata('error') ?>
