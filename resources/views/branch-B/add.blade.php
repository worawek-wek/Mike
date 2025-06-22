<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{url('')}}/assets/"
  data-template="vertical-menu-template">
  <head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
    <link rel="stylesheet" href="{{url('')}}/assets/vendor/css/pages/page-auth.css" />
    <link rel="stylesheet" href="assets/vendor/libs/leaflet/leaflet.css" />
  </head>

  <body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-4 p-0">
            <img style="height: 100%;object-fit: cover;"
              src="{{url('')}}/assets/img/illustrations/auth-login-illustration-light-add.png"
              alt="auth-login-cover"
              class="img-fluid auth-illustration"
              data-app-light-img="illustrations/auth-login-illustration-light-add.png"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
        </div>
        <!-- /Left Text -->
        <!-- Login -->
        
        <div class="d-flex col-12 col-lg-8 align-items-center px-sm-5">
          <form id="branchAdd" >
            {{-- action="{{ url('branch/manage') }}" --}}
            @csrf
            <div class="row g-3">
              
                <div class="col-sm-12">
                  <div class="app-brand mb-4">
                  <img src="{{url('')}}/assets/img/illustrations/main.png" alt="" style="margin: auto;">
                </div>
              </div>
                <div class="col-sm-12">
                    <label>ชื่อสาขา <span class="text-danger">*</span></label>
                    <input name="name" type="text" class="form-control"
                        placeholder="กรอกชื่อสาขา" required/>
                </div>
                <div class="col-sm-12">
                    <label>ที่อยู่สาขา <span class="text-danger">*</span></label>
                    <input name="address" type="text" class="form-control"
                        placeholder="บ้านเลขที่/ หมู่/ ซอย/ ถนน" required/>
                </div>
                <div class="col-sm-3">
                    <label>เลือกจังหวัด</label>
                    <select name="ref_province_id" id="select2Basic" class="select2 form-select form-select-lg">
                        <option selected>เลือกจังหวัด</option>
                        @foreach ($province as $pro)
                            <option value="{{ $pro->id }}">{{ $pro->name_in_thai }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>เลือกอำเภอ</label>
                    <select name="ref_district_id" id="select2District" class="select2 form-select form-select-lg">
                        <option selected>เลือกอำเภอ</option>
                        @foreach ($district as $dis)
                            <option value="{{ $dis->id }}">{{ $dis->name_in_thai }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>เลือกตำบล</label>
                    <select name="ref_subdistrict_id" id="select2Subdistrict" class="select2 form-select form-select-lg">
                        <option selected>เลือกตำบล</option>
                        @foreach ($subdistrict as $sub_dis)
                            <option value="{{ $sub_dis->id }}">{{ $sub_dis->name_in_thai }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>รหัสไปรษณีย์</label>
                    <input name="zipcode" type="text" class="form-control" id=""
                        placeholder="รหัสไปรษณีย์" />
                </div>
                <div class="col-sm-12">
                    <label>ระบุตำแหน่งสาขาของคุณ</label>
                    <div class="leaflet-map" id="dragMap"></div>
                </div>
                <div class="col-sm-6">
                    <label>เบอร์โทรติดต่อสาขา <span class="text-danger">*</span></label>
                    <input name="phone" type="text" class="form-control" id="" placeholder="เบอร์โทรติดต่อสาขา" required/>
                </div>
                <div class="col-sm-6">
                    <label>อีเมลติดต่อสาขา </label>
                    <input name="email" type="email" class="form-control" id="" placeholder="อีเมลติดต่อสาขา" />
                </div>
                <div class="col-sm-6">
                    <label>สาขาของคุณทำบิลทุกวันที่เท่าไหร่
                        ?</label>
                    <select name="billing_date" id="select2Billing_date" class="select2 form-select form-select-lg">
                        @for ($i = 1; $i < 32; $i++)
                            <option value="{{$i}}">วันที่ {{$i}} ของทุกเดือน</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for=""
                        class="form-label">กำหนดวันที่สิ้นสุดการชำระเงิน</label>
                    <select name="payment_end_date" id="select2Payment_end_date" class="select2 form-select form-select-lg">
                        @for ($e = 1; $e < 32; $e++)
                            <option value="{{$e}}">วันที่ {{$e}} ของทุกเดือน</option>
                        @endfor
                    </select>
                </div>
                    <button type="submit" class="btn btn-main mt-5" style="margin-bottom: 10%;"><i class="ti ti-plus"></i> สร้างสาขา</button>
            </div>
        </form>
        </div>
        <!-- /Login -->
      </div>
    </div>

    <!-- / Content -->

    @include('layout/inc_js')
    <script src="assets/vendor/libs/leaflet/leaflet.js"></script>
    
<script>
    $('#branchAdd').on('submit', function(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
        if(!this.checkValidity()) {
            // ถ้าฟอร์มไม่ถูกต้อง
            this.reportValidity();
            return console.log('ฟอร์มไม่ถูกต้อง');
        }
        // return alert(123);
        Swal.fire({
            title: 'ยืนยันการดำเนินการ?',
            text: 'คุณต้องการเพิ่มสาขาหรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showDenyButton: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{"branch/add"}}', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response == true){
                            $('#branchAdd')[0].reset();
                            Swal.fire('เพิ่มสาขาเรียบร้อยแล้ว', '', 'success');
                            window.location.href = '{{url("/branch/manage")}}';
                        }
                    },
                    error: function(error) {
                        Swal.fire('เพิ่มสาขาเรียบร้อยแล้ว', '', 'success');
                        // setTimeout(() => {
                        //     window.location.href = '{{url("/branch/manage")}}';
                        // }, 5000);
                        // Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                        // console.error('เกิดข้อผิดพลาด:', error);
                    }
                });
            } else if (result.isDismissed) {
                // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
            }
        });
    });
    $('#select2District').select2();
    $('#select2Subdistrict').select2();
    $('#select2Billing_date').select2();
    $('#select2Payment_end_date').select2();
    const draggableMap = L.map('dragMap').setView([48.817152, 2.455], 12);
        const markerLocation = L.marker([48.817152, 2.455], {
            draggable: 'true'
        }).addTo(draggableMap);
        markerLocation.bindPopup("<b>ที่ตั้งสาขา</b>").openPopup();
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
        }).addTo(draggableMap);
</script>
  </body>
</html>
