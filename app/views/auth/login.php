<div class="my-container" id="my-container">
    <div class="my-form-container my-sign-up">
    <!-- <form>
        <h1>Create Account</h1>
        <span>Register your account to access the system</span>
        <input type="text" placeholder="Name" />
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <button>Sign Up</button>
    </form> -->
    </div>
    <div class="my-form-container my-sign-in">
    <form class="form w-100" method="POST" novalidate="novalidate" id="form_login" action="<?= base_url('auth/login_proses') ?>">
        <h1>Masuk</h1>
        <span class="mb-5 text-center">Web pendataan penjualan dan perhitungan moving avarage</span>
        <div class="fv-row w-100 mb-6">
            <input type="email" id="email" placeholder="Masukkan alamat email" name="email" autocomplete="off" class="form-control  form-control-solid w-100" required/>
            </div>
            <div class="fv-row w-100 mb-3" data-kt-password-meter="true">
            <input type="password" id="password" onkeyup="hideye(this, '#hideye')" placeholder="Masukkan kata sandi" name="password" autocomplete="off" class="form-control  form-control-solid w-100" required/>
            <span class="btn btn-sm btn-icon position-absolute translate-middle end-0 me-n2 d-none" id="hideye" style="top: 50%;" data-kt-password-meter-control="visibility">
                <i class="fa-solid fa-eye fs-5 text-muted"></i>
                <i class="fa-solid fa-eye-slash fs-5 text-muted d-none"></i>
            </span>
        </div>
        <button type="submit" id="button_login">
            <span class="indicator-label">Masuk</span>
        </button>
    </form>
    </div>
    <div class="my-toggle-container">
    <div class="my-toggle">
        <div class="my-toggle-panel my-toggle-left">
        <!-- <h1>Welcome Back!</h1>
        <p>Enter your personal details to use all of site features</p>
        <button class="hidden" id="login">Sign In</button> -->
        </div>
        <div class="my-toggle-panel my-toggle-right">
        <?php if(isset($setting->logo) && $setting->logo != '' && file_exists('./data/setting/'.$setting->logo)) : ?>
        <div class="background-partisi-contain" style="background-image : url('<?= image_check($setting->logo,'setting'); ?>');width : 100px;height : 100px;"></div>
        <?php endif;?>
        <h1 class="text-white my-1 py-1">Selamat Datang</h1>
        <p class="text-white my-1 py-1">
            Masuk menggunakan akun terdaftar untuk melanjutkan akses
        </p>
        <!-- <button class="hidden" id="register">Sign Up</button> -->
        </div>
    </div>
    </div>
</div>