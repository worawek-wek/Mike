<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
        @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
    <link rel="stylesheet" href="assets/vendor/libs/leaflet/leaflet.css" />
</head>
<style>
    .modalHeadDecor .modal-header {
        padding: 0;
    }

    .modalHeadDecor .modal-title {
        padding: 1.25rem 1.5rem 1.25rem;
        color: white;
        background-color: #54BAB9;
        position: relative;
    }

    .modalHeadDecor .modal-title::after {
        position: absolute;
        top: 0;
        right: -65px;
        content: '';
        width: 0;
        height: 0;
        border-top: 65px solid #54BAB9;
        border-right: 65px solid transparent;
    }
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layout/inc_sidemenu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('layout/inc_topmenu')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="card mb-3">
                                    <div class="card-header border-bottom border-light">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-6">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-building-community text-main ti-md"></i>
                                                    ข้อมูลหอพัก
                                                </h4>
                                            </div>
                                            <!-- <div class="col-sm-6 text-end">
                                                <button type="button" class="btn btn-main waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#addModal"><i
                                                        class="ti-xs ti ti-plus me-2"></i>เพิ่มบัญชี</button>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <form id="update_branch">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ชื่อหอพัก<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" id=""
                                                        placeholder="กรอกชื่อหอพัก" value="{{ $branch->name }}" required />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ที่อยู่หอพัก<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="address" class="form-control" id=""
                                                        placeholder="บ้านเลขที่/ หมู่/ ซอย/ ถนน" value="{{ $branch->address }}" required />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>เลือกจังหวัด</label>
                                                    <select name="ref_province_id" id="select2Basic" class="select2 form-select form-select-lg">
                                                        <option selected>เลือกจังหวัด</option>
                                                        @foreach ($province as $pro)
                                                            <option @if ($pro->id == $branch->ref_province_id)
                                                                selected
                                                            @endif value="{{ $pro->id }}">{{ $pro->name_in_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>เลือกอำเภอ</label>
                                                    <select name="ref_district_id" id="select2District" class="select2 form-select form-select-lg">
                                                        <option selected>เลือกอำเภอ</option>
                                                        @foreach ($district as $dis)
                                                            <option @if ($dis->id == $branch->ref_district_id)
                                                                selected
                                                            @endif value="{{ $dis->id }}">{{ $dis->name_in_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>เลือกตำบล</label>
                                                    <select name="ref_subdistrict_id" id="select2Subdistrict" class="select2 form-select form-select-lg">
                                                        <option selected>เลือกตำบล</option>
                                                        @foreach ($subdistrict as $sub_dis)
                                                            <option @if ($sub_dis->id == $branch->ref_subdistrict_id)
                                                                selected
                                                            @endif value="{{ $sub_dis->id }}">{{ $sub_dis->name_in_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="" class="form-label">รหัสไปรษณีย์</label>
                                                    <input type="text" name="zipcode" class="form-control" id="zipcode"
                                                        placeholder="รหัสไปรษณีย์" value="{{ $branch->zipcode }}" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="hidden" id="lat" name="lat" value="{{ $branch->lat }}">
                                                    <input type="hidden" id="lng" name="lng" value="{{ $branch->lng }}">
                                                    <label for="" class="form-label">ระบุตำแหน่งหอพักของคุณ</label>
                                                    <div class="leaflet-map" id="dragMap"></div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">เบอร์โทรติดต่อหอพัก<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="phone" class="form-control" id="" placeholder=""
                                                    value="{{ $branch->phone }}" required />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">อีเมลติดต่อหอพัก </label>
                                                    <input type="email" name="email" class="form-control" id="" placeholder="" value="{{ $branch->email }}" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">หอพักของคุณทำบิลทุกวันที่เท่าไหร่
                                                        ?</label>
                                                    <select class="form-select" name="billing_date">
                                                        @for ($i = 0; $i < 32; $i++)
                                                            <option @if ($i == $branch->billing_date)
                                                                selected
                                                            @endif  value="{{ $i }}">วันที่ {{ $i }} ของทุกเดือน</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for=""
                                                        class="form-label">กำหนดวันที่สิ้นสุดการชำระเงิน</label>
                                                    <select class="form-select" name="payment_end_date">
                                                        @for ($e = 0; $e < 32; $e++)
                                                            <option @if ($e == $branch->payment_end_date)
                                                                selected
                                                            @endif  value="{{ $e }}">วันที่ {{ $e }} ของทุกเดือน</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" class="btn btn-main">บันทึก</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                        @include('layout/inc_footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>

    <!-- / Layout wrapper -->
         @include('layout/inc_js')
         <script>
            $('#update_branch').on('submit', function(event) {
                event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                if(!this.checkValidity()) {
                    // ถ้าฟอร์มไม่ถูกต้อง
                    this.reportValidity();
                    return console.log('ฟอร์มไม่ถูกต้อง');
                }
                // return alert(123);
                Swal.fire({
                    title: 'ยืนยันการดำเนินการ?',
                    text: 'คุณต้องการแก้ไขรายละเอียดสาขาหรือไม่?',
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
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/setting/dorm-info/update_branch', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                if(response == true){
                                    Swal.fire('แก้ไขรายละเอียดสาขาเรียบร้อยแล้ว', '', 'success').then((result) => {
                                        // location.reload();
                                    });
                                    // $('#setting-rental-contract').html('');
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
            
            $('#select2Basic').change(function() {
                var provinceId = $(this).val();
                
                // เคลียร์ dropdown สำหรับอำเภอและตำบล
                $('#select2District').empty().append('<option selected disabled hidden value="">เลือกอำเภอ</option>');
                $('#select2Subdistrict').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                if (provinceId) {
                    $.ajax({
                        url: '/get-districts/' + provinceId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(district) {
                                $('#select2District').append('<option value="' + district.id + '">' + district.name_in_thai + '</option>');
                            });
                        }
                    });
                }
            });

            $('#select2District').change(function() {
                var districtId = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#select2Subdistrict').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                if (districtId) {
                    $.ajax({
                        url: '/get-subdistricts/' + districtId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(subdistrict) {
                                $('#select2Subdistrict').append('<option value="' + subdistrict.id + '">' + subdistrict.name_in_thai + '</option>');
                            });
                        }
                    });
                }
            });
            $('#select2Subdistrict').change(function() {
                var subdistrictsid = $(this).val();
                if (subdistrictsid) {
                    $.ajax({
                        url: '/get-zipcode/' + subdistrictsid,
                        type: 'GET',
                        success: function(data) {
                            $('#zipcode').val(data);
                        }
                    });
                }
            });
         </script>
    <script src="assets/vendor/libs/leaflet/leaflet.js"></script>
    <script>
        const draggableMap = L.map('dragMap').setView(["{{ $branch->lat }}", "{{ $branch->lng }}"], 12);

        // เพิ่ม marker ที่ลากได้
        const markerLocation = L.marker(["{{ $branch->lat }}", "{{ $branch->lng }}"], {
            draggable: true
        }).addTo(draggableMap);

        // แสดง popup
        markerLocation.bindPopup("<b>ที่ตั้งหอพัก</b>").openPopup();

        // โหลด tile map
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
        }).addTo(draggableMap);

        // เมื่อมีการลาก marker เสร็จ
        markerLocation.on('dragend', function (e) {
            const position = markerLocation.getLatLng();
            // แสดงตำแหน่งใหม่ใน popup
            markerLocation.setLatLng(position, { draggable: true }).bindPopup(
                `<b>ตำแหน่งใหม่</b><br>Lat: ${position.lat.toFixed(6)}<br>Lng: ${position.lng.toFixed(6)}`
            ).openPopup();

            // บันทึกลง input ซ่อน
            document.getElementById('lat').value = position.lat;
            document.getElementById('lng').value = position.lng;
        });

        // ตั้งค่า input ให้เป็นค่าตั้งต้น
        document.getElementById('lat').value = "{{ $branch->lat }}";
        document.getElementById('lng').value = "{{ $branch->lng }}";
    </script>

</body>

</html>