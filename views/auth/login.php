<?php
/**
 * Login Page
 */
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Đăng Nhập</h3>
                
                <form method="POST" action="<?php echo APP_URL; ?>/api/auth/login">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">Đăng Nhập</button>
                </form>
                
                <hr>
                
                <p class="text-center mb-2">
                    Chưa có tài khoản? <a href="<?php echo APP_URL; ?>/auth/register">Đăng ký</a>
                </p>
                <p class="text-center">
                    <a href="<?php echo APP_URL; ?>/auth/forgot-password">Quên mật khẩu?</a>
                </p>
            </div>
        </div>
    </div>
</div>
