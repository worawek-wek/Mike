<!doctype html>
@extends('../layout/' . $layout)
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{url('')}}/assets/"
  data-template="vertical-menu-template">
  <head>
    @include('layout/inc_header')
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{url('')}}/assets/vendor/css/pages/page-auth.css" />
  </head>

  <body>
    <div id="loadingOverlay" style="display: none;">
    <div class="spinner"></div>
    </div>

    <style>
    /* พื้นหลังทึบ */
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* สปินเนอร์หมุน */
    .spinner {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #28c76f;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center mx-0">
            <img style="max-height: none;"
              src="{{url('')}}/assets/img/illustrations/auth-login-illustration-light.png"
              alt="auth-login-cover"
              class="img-fluid auth-illustration"
              data-app-light-img="illustrations/auth-login-illustration-light.png"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->
        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="col-12 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
              <img src="{{url('')}}/assets/img/illustrations/main.png" alt="" style="margin: auto;">
            </div>
            <!-- /Logo -->
            <h3 class="mb-1 text-primary">รีเซ็ต รหัสผ่าน</h3>
            <p class="mb-4">ตั้งรหัสผ่านใหม่ของคุณ</p>

                    {{-- @include('layout/inc_footer') --}}
            <div id="formAuthentication" class="mb-3">
              
                <form id="reset_password">		
                    @csrf
                    <input type="hidden" name="remember_token" value="{{ $remember_token }}">
                    <div class="row g-3">
                        <div class="col-span-12 mb-4">
                            <div class="col-sm-6 mt-3">
                                <label for="update-profile-form-2" class="form-label">รหัสผ่าน</label><span class="text-danger"> *</span>
                                <input name="password" id="password2" type="password" class="form-control" placeholder="รหัสผ่าน" required>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <label for="update-profile-form-3" class="form-label">ยืนยัน รหัสผ่าน</label><span class="text-danger"> *</span>
                                <input id="confirm_password2" type="password" class="form-control" placeholder="ยืนยัน รหัสผ่าน" required>
                            </div>
                        </div>
                        <script>
                            //// ทำ เช็ค Password เริ่ม
                            var password2 = document.getElementById("password2"), confirm_password2 = document.getElementById("confirm_password2");

                            function validatePassword2(){
                                if(password2.value != confirm_password2.value) {
                                    confirm_password2.setCustomValidity("โปรดกรอกรหัสผ่านให้ตรงกัน");
                                } else {
                                    confirm_password2.setCustomValidity('');
                                }
                            }

                            password2.onchange = validatePassword2;
                            confirm_password2.onkeyup = validatePassword2;
                            //// ทำ เช็ค Password จบ

                        </script> 
                    </div>
                    
                  <button type="submit" class="btn btn-main">บันทึก</button>
                </form>
            </div>
                <p>
                  <span>มีบัญชี</span>
                  <a href="login">
                    <span>เข้าสู่ระบบ</span>
                  </a>
                </p>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>

    @include('layout/inc_js')
<script>
    
        $('#reset_password').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ รีเซ็ตรหัสผ่าน หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                showDenyButton: false,
                didOpen: () => {
                    // โฟกัสที่ปุ่ม confirm
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                document.getElementById('loadingOverlay').style.display = 'flex';
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'user/reset-password', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            document.getElementById('loadingOverlay').style.display = 'none';
                            if(response == true){
                                $('#reset_password')[0].reset();
                                Swal.fire('รีเซ็ตรหัสผ่านเรียบร้อย', '', 'success').then((result) => {
                                    window.location.href = '/login';
                                    // location.reload();
                                });
                                // setTimeout(() => {
                                //     location.href = '/branch/manage'
                                // }, 1000);
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
        $('#bs-datepicker-format').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
            autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
            todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
        });
</script>

  </body>
</html>

