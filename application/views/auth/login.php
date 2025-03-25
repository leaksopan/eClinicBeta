<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - eClinic' ?></title>
    <style>
        /* Bootstrap Mini */
        *,::after,::before{box-sizing:border-box}
        html{font-family:sans-serif;line-height:1.15}
        body{margin:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#f8f9fa}
        h3,h5,p{margin-top:0}
        h3{margin-bottom:.5rem}
        p{margin-bottom:1rem}
        a{color:#3c8dbc;text-decoration:none;background-color:transparent}
        a:hover{color:#0056b3;text-decoration:underline}
        img{vertical-align:middle;border-style:none}
        button,input{overflow:visible}
        .container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}
        @media (min-width:576px){.container{max-width:540px}}
        @media (min-width:768px){.container{max-width:720px}}
        @media (min-width:992px){.container{max-width:960px}}
        @media (min-width:1200px){.container{max-width:1140px}}
        .form-control{display:block;width:100%;height:calc(1.5em + .75rem + 2px);padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem}
        .form-group{margin-bottom:1rem}
        .btn{display:inline-block;font-weight:400;text-align:center;vertical-align:middle;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem}
        .btn:hover{text-decoration:none}
        .btn-primary{color:#fff;background-color:#3c8dbc;border-color:#3c8dbc}
        .btn-primary:hover{color:#fff;background-color:#367fa9;border-color:#367fa9}
        .btn-block{display:block;width:100%}
        .alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}
        .alert-success{color:#155724;background-color:#d4edda;border-color:#c3e6cb}
        .alert-danger{color:#721c24;background-color:#f8d7da;border-color:#f5c6cb}
        .input-group{position:relative;display:flex;align-items:stretch;width:100%}
        .input-group-prepend{display:flex;margin-right:-1px}
        .input-group-text{display:flex;align-items:center;padding:.375rem .75rem;margin-bottom:0;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.25rem 0 0 .25rem}
        .input-group>.form-control{position:relative;flex:1 1 auto;width:1%;margin-bottom:0;border-radius:0 .25rem .25rem 0}
        .text-center{text-align:center!important}
        .text-danger{color:#dc3545!important}
        .mb-4{margin-bottom:1.5rem!important}
        
        /* Custom Styles */
        .login-container{max-width:450px;margin:5% auto 0;padding:30px;background:#fff;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,.1)}
        .login-logo{text-align:center;margin-bottom:20px}
        .login-title{text-align:center;margin-bottom:30px;color:#3c8dbc}
        .forgot-password{text-align:right;margin-top:10px}
        .login-footer{text-align:center;margin-top:20px;color:#777}
        .demo-accounts{margin-top:20px;border:1px dashed #ddd;padding:15px;border-radius:4px;background-color:#f9f9f9}
        .demo-accounts h5{margin-bottom:10px;color:#666}
        .demo-account-item{margin-bottom:5px;font-size:14px}
        .demo-label{display:inline-block;width:100px;font-weight:600}
        
        /* Icons */
        .icon{display:inline-flex;align-items:center;justify-content:center;width:1.25em;height:1em;vertical-align:-0.125em;text-align:center}
        .icon::before{display:inline-block}
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-logo">
                <!-- SVG Logo -->
                <svg width="150" height="150" xmlns="http://www.w3.org/2000/svg">
                  <style>
                    .text { font: bold 24px sans-serif; fill: #3c8dbc; }
                    .clinic { fill: #1f2d3d; }
                    .icon { fill: #3c8dbc; }
                  </style>
                  <rect x="25" y="40" width="100" height="70" rx="10" ry="10" fill="#f8f9fa" stroke="#3c8dbc" stroke-width="3"/>
                  <path class="icon" d="M75 55 v15 h15 v10 h-15 v15 h-10 v-15 h-15 v-10 h15 v-15 z"/>
                  <text x="75" y="110" text-anchor="middle" class="text">eClinic</text>
                  <text x="75" y="130" text-anchor="middle" class="clinic" font-size="14">Management System</text>
                </svg>
            </div>
            <h3 class="login-title">eClinic Management System</h3>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?= form_open('auth/login', ['class' => 'login-form']) ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="icon">👤</span>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= set_value('username') ?>" autofocus required>
                    </div>
                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="icon">🔒</span>
                            </span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
                
                <div class="forgot-password">
                    <a href="<?= site_url('auth/forgot_password') ?>">Lupa Password?</a>
                </div>
            <?= form_close() ?>
            
            <!-- Informasi Akun Demo -->
            <div class="demo-accounts">
                <h5><span class="icon">ℹ</span> Akun Demo</h5>
                <div class="demo-account-item">
                    <span class="demo-label">Admin:</span> admin / admin123
                </div>
                <div class="demo-account-item">
                    <span class="demo-label">Dokter:</span> dokter / dokter123
                </div>
                <div class="demo-account-item">
                    <span class="demo-label">Perawat:</span> perawat / perawat123
                </div>
                <div class="demo-account-item">
                    <span class="demo-label">Apoteker:</span> apoteker / apoteker123
                </div>
                <div class="demo-account-item">
                    <span class="demo-label">Kasir:</span> kasir / kasir123
                </div>
            </div>
            
            <div class="login-footer">
                <p>&copy; <?= date('Y') ?> eClinic Management System</p>
            </div>
        </div>
    </div>
</body>
</html> 