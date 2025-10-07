<form action="/auth/doVerify" method="post">
    <input type="text" name="otp" placeholder="Masukkan OTP" required>
    <button type="submit">Verifikasi</button>
</form>
<?= session()->getFlashdata('error') ?>
