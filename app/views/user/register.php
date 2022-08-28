<div class="container">
    <div class="login-register-box">
        <form id="login-form" action="<?php echo APP_URL. 'user/register'; ?>" method="post" onsubmit="checkRegisterForm(event)">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Register</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="email" class="form-control-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo !empty($_POST['email']) ? $_POST['email'] : '';?>" onkeyup="checkemail()"/>
                        <small id="email-feedback" class="feedback"></small>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" />
                        <small id="password-feedback" class="feedback"></small>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" onclick="checkRegisterForm(event)">Register</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>