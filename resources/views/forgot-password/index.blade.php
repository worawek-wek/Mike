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
            <h3 class="mb-1 text-primary">ลืมรหัสผ่าน</h3>
            <p class="mb-4">ยืนยัน Email ของคุณ!</p>

                    {{-- @include('layout/inc_footer') --}}
            <div id="formAuthentication" class="mb-3">
              <form id="form_forgot_password">		
                    @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="" class="form-label">อีเมล</label></label><span class="text-danger"> *</span>
                                <input name="email" id="email_2" type="email" class="form-control" placeholder="อีเมล" required/>
                            </div>
                        </div>
                <button type="submit" class="btn btn-main mt-4">ยืนยัน</button>
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
    
        $('#form_forgot_password').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการยืนยัน Email หรือไม่?',
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
                        url: 'user/forgot-password-send-mail', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            document.getElementById('loadingOverlay').style.display = 'none';
                            if(response.status == true){
                                $('#form_forgot_password')[0].reset();
                                Swal.fire({
                                    title: 'ส่งอีเมลเรียบร้อย!',
                                    html: 'โปรดตรวจสอบอีเมลของคุณ<br>เพื่อรีเซ็ตรหัสผ่านใหม่',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง'
                                    });
                                // setTimeout(() => {
                                //     location.href = '/branch/manage'
                                // }, 1000);
                            }else{
                                Swal.fire(response.message, '', 'warning');
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

