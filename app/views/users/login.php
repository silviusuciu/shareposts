<?php require APPROT . '/views/inc/header.php'; ?>
    <div class="row mt-4">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light">
                <?php echo flash('register_success'); ?>
                <?php echo flash('logout_success'); ?>
                <h2>Login</h2>
                <p>Please fill in your credentials to log in</p>
                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-group mb-3">
                        <label class="mb-1" for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo ( !empty( $data['email_err'] ) ) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label class="mb-1" for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo ( !empty( $data['password_err'] ) ) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err'] ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success w-100">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light w-100">No account? Register</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROT . '/views/inc/footer.php'; ?>
