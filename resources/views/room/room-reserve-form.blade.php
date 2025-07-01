<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<style>
    .bootstrap-tagsinput {
      width: 100%;
    }
    .bootstrap-tagsinput .tag.invalid {
      background-color: #dc3545 !important;
      color: white;
    }

    .bootstrap-tagsinput .tag {
    color: white !important; 
    background-color: #007bff !important; 
    padding: 5px;
    border-radius: 4px;
    margin-right: 2px;
    }

    .bootstrap-tagsinput .tag.invalid {
    background-color: #dc3545 !important; /* สีแดง */
    color: white !important;
    }

  </style>
<div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;">
                        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);;">
                            <i class="tf-icons ti ti-user text-main" style="font-size: 25px;vertical-align: baseline;"></i>
                            ข้อมูลส่วนตัว
                        </h5>
                        <div class="row g-3 p-4 pt-1">
                            <div class="col-sm-2">
                                <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label>
                                <select name="prefix" class="form-select" id="exampleFormControlSelect1"
                                    aria-label="Default select example">
                                    <option value="บริษัท" selected>บริษัท</option>
                                    <option value="นาย">นาย</option>
                                    <option value="นางสาว">นางสาว</option>
                                    <option value="นาง">นาง</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label>
                                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="วรเวก"/>
                            </div>
                            <div class="col-sm-5">
                                <label for="exampleFormControlInput2" class="form-label">นามสกุล</label>
                                <input type="text" name="surname" class="form-control" id="exampleFormControlInput2" placeholder="" value="ชึรัมย์" />
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput3" class="form-label">เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)</label>
                                <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="0987776543"/>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput4" class="form-label">เลขบัตรประชาชน/Passport</label>
                                <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="1234567890123"/>
                            </div>
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput5" class="form-label">ที่อยู่ตามสำเนาทะเบียนบ้าน</label>
                                <input type="text" name="address" class="form-control" id="exampleFormControlInput5" placeholder="เลขที่ ซอย ถนน อาคาร ห้องเลขที่ หรือหมู่บ้าน" value="12/34"/>
                            </div>
                            <div class="col-sm-4">
                                <label>เลือกจังหวัด</label>
                                <select name="ref_province_id" id="select2Basic" class="select2 form-select form-select-lg" required>
                                    <option selected disabled hidden value="">เลือกจังหวัด</option>
                                    @foreach ($province as $pro)
                                        <option value="{{ $pro->id }}" @if ($pro->id == 2) selected @endif>{{ $pro->name_in_thai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>เลือกอำเภอ</label>
                                <select name="ref_district_id" id="select2District99" class="select2 form-select form-select-lg" required>
                                    <option selected disabled hidden value="">เลือกอำเภอ</option>
                                    @foreach ($district as $dis)
                                        <option value="{{ $dis->id }}" @if ($dis->id == 53) selected @endif>{{ $dis->name_in_thai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>เลือกตำบล</label>
                                <select name="ref_subdistrict_id" id="select2Subdistrict" class="select2 form-select form-select-lg" required>
                                    <option selected disabled hidden value="">เลือกตำบล</option>
                                    @foreach ($subdistrict as $sub_dis)
                                        <option value="{{ $sub_dis->id }}" @if ($sub_dis->id == 176) selected @endif>{{ $sub_dis->name_in_thai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                                <input type="text" name="zipcode" class="form-control" id="zipcode" placeholder="รหัสไปรษณีย์" value="10540" />
                            </div>
                            <div class="col-sm-6">
                                <label for="bs-datepicker-format2" class="form-label">วันที่จอง</label>
                                <input type="text" name="booking_date" value="24/04/2025" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput12" class="form-label">ช่องทางการจอง</label>
                                <input type="text" name="booking_channel" class="form-control" id="exampleFormControlInput12" placeholder="ช่องทางการจอง" value="จองโดยตรงกับที่พัก" />
                            </div>
                        </div>
                    </div>

                    <div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
                        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
                            <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
                            รายการจองห้อง
                        </h5>
                        <div class="row g-3 p-4 pt-1">
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput13" class="form-label">วันที่เข้าพัก</label>
                                <input type="text" name="date_stay" class="form-control" id="exampleFormControlInput13" placeholder="วัน/เดือน/ปี" value="24/04/2025" required/>
                            </div>
                            
                            <b class="text-black">รูปแบบการเลือกห้อง</b> <br>
                            <div class="col-sm-2">
                                <input name="select_channel" class="form-check-input" type="radio" id="defaultRadio1" value="1" checked onclick="toggleSelectFields()">
                                <label class="form-check-label ms-1" for="defaultRadio1"> พิมพ์ชื่อห้อง </label>
                            </div>
                            <div class="col-sm-2">
                                <input name="select_channel" class="form-check-input" type="radio" id="defaultRadio2" value="2" onclick="toggleSelectFields()"> 
                                <label class="form-check-label ms-1" for="defaultRadio2"> ติ๊กชื่อห้อง </label>
                            </div>
                            <div></div>
                            <div class="col-sm-12" id="selectForm">
                                {{-- <textarea name="room_text" class="form-control user-tags" id="room_text" placeholder="พิมพ์ชื่อห้องและกด Enter" required></textarea> --}}
                                <input name="room_text" class="form-control user-tags" data-role="tagsinput" id="room_text" placeholder="พิมพ์ชื่อห้องและกด Enter" required>
                            </div>
                            <div class="col-sm-7 selectForm2" style="display: none;">
                                <label for="exampleFormControlInput14" class="form-label">เลือกห้อง</label>
                                <div class="accordion stick-top accordion-bordered" id="courseContent">
                                    @foreach ($buildings as $build)
                                    <!-- ตึกคุณแบม -->
                                    <div class="accordion-item
                                        @if ($buildings[0]->id == $build->id)
                                            active
                                        @endif
                                        mb-0">
                                        <div class="accordion-header" id="headingOne{{ $build->id }}">
                                            <button type="button" class="accordion-button bg-lighter rounded-0" data-bs-toggle="collapse" data-bs-target="#chapterOne{{ $build->id }}" aria-expanded="true" aria-controls="chapterOne{{ $build->id }}">
                                                <span class="d-flex flex-column">
                                                    <span style="font-size: medium;font-weight: 430">{{ $build->name }}</span>
                                                </span>
                                            </button>
                                        </div>
                                        <div id="chapterOne{{ $build->id }}" class="accordion-collapse collapse
                                            @if ($buildings[0]->id == $build->id)
                                                show
                                            @endif
                                            " data-bs-parent="#courseContent">
                                            <div class="accordion-body py-3 border-top">
                                                <input value="buildings-{{ $build->id }}" class="form-check-input room-selected" type="checkbox" id="buildings-{{ $build->id }}" onchange="room_in_building_selected('buildings-{{ $build->id }}')" style="margin-left: 70px;">
                                                <label for="buildings-{{ $build->id }}" class="form-check-label ms-1"><span class="mb-0 h6">เลือกทั้งตึก</span></label>
                                                <div class="form-check align-items-center mb-3 mt-2">
                                                    <div class="accordion stick-top accordion-bordered" id="courseContent2">
                                                        <!-- ชั้นมาทำอะไรที่นี่ -->
                                                    @foreach ($build->floor as $floor)
                                                        <div class="accordion-item 
                                                            @if ($buildings[0]->id == $build->id && $build->floor[0]->id == $floor->id)
                                                                active
                                                            @endif
                                                            mb-0">
                                                            <div class="accordion-header" id="headingOne{{ $build->id }}2">
                                                                <button type="button" class="accordion-button bg-lighter rounded-0" data-bs-toggle="collapse" data-bs-target="#chapterOne{{ $floor->id }}1" aria-expanded="true" aria-controls="chapterOne{{ $floor->id }}1">
                                                                    <span class="d-flex flex-column">
                                                                        <span class="me-2" style="font-size: medium;font-weight: 430">{{ $floor->name }}</span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                            <div id="chapterOne{{ $floor->id }}1" class="accordion-collapse collapse
                                                                @if ($buildings[0]->id == $build->id && $build->floor[0]->id == $floor->id)
                                                                show
                                                                @endif"
                                                                data-bs-parent="#courseContent2">
                                                                <div class="accordion-body py-3 border-top">

                                                                <input value="floors-{{ $floor->id }}" class="form-check-input room-selected buildings-{{ $build->id }}" type="checkbox" id="floors-{{ $floor->id }}" onchange="room_in_floor_selected('floors-{{ $floor->id }}')" style="margin-left: 70px;">
                                                                <label for="floors-{{ $floor->id }}" class="form-check-label ms-2"><span class="mb-0 h6">เลือกทั้งชั้น</span></label>


                                                                @foreach ($floor->room as $room)

                                                                    <div class="form-check d-flex align-items-center mb-1">
                                                                        <input name="buildings[{{ $build->id }}][{{ $floor->id }}][]" value="{{ $room->id }}" class="form-check-input room-selected buildings-{{ $build->id }} floors-{{ $floor->id }}" type="checkbox" id="{{ $room->id }}" onchange="room_selected()"
                                                                        @if ($room->status != 0)
                                                                            disabled
                                                                        @endif
                                                                        />
                                                                        <label for="{{ $room->id }}" class="form-check-label ms-2">
                                                                            <span class="mb-0 h6">{{ $room->name }} 
                                                                                @if ($room->status == 1)
                                                                                    (ติดจอง)
                                                                                @elseif ($room->status == 2)
                                                                                    (มีผู้พักอาศัย)
                                                                                @endif
                                                                            </span>
                                                                        </label>
                                                                    </div>

                                                                @endforeach
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="col-sm-5 selectForm2" style="display: none;">
                                <div class="accordion-body py-3 mt-3">
                                    <div class="ms-4" id="room-selected">
                                        @include('room/selected')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        toggleSelectFields();
                        function toggleSelectFields() {
                            const selectChannel = document.querySelector('input[name="select_channel"]:checked').value;
                            const selectForm = document.getElementById('selectForm');
                            // const selectForm2 = document.querySelector('.selectForm2');
                            // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
                            if (selectChannel == '1') {
                                selectForm.style.display = 'block';
                                $('.selectForm2').hide();
                                $('#ref_bank_id').attr('required', true);
                                $('#transfer_time').attr('required', true);
                                $('#select_date2').attr('required', true);
                                $('#room_text').attr('required', true);
                                
                            } else {
                                selectForm.style.display = 'none';
                                $('.selectForm2').show();
                                $('#ref_bank_id').removeAttr('required');
                                $('#transfer_time').removeAttr('required');
                                $('#select_date2').removeAttr('required')
                                $('#room_text').removeAttr('required');
                            }
                        }
                        function room_in_building_selected(buildingClass) {
                            // checkbox หลัก
                            const buildingCheckbox = document.querySelector(`input[value="${buildingClass}"]`);
                            const roomCheckboxes = document.querySelectorAll(`.room-selected.${buildingClass}`);

                            // เมื่อ checkbox หลักถูกกด → ปรับค่าของ checkbox ห้องทั้งหมด (ที่ไม่ disabled)
                            const isChecked = buildingCheckbox.checked;
                            roomCheckboxes.forEach(cb => {
                                if (!cb.disabled) cb.checked = isChecked;
                            });

                            room_selected();
                        }
                        function room_in_floor_selected(floorClass) {
                            // checkbox หลัก
                            const floorCheckbox = document.querySelector(`input[value="${floorClass}"]`);
                            const roomCheckboxes = document.querySelectorAll(`.room-selected.${floorClass}`);

                            // เมื่อ checkbox หลักถูกกด → ปรับค่าของ checkbox ห้องทั้งหมด (ที่ไม่ disabled)
                            const isChecked = floorCheckbox.checked;
                            roomCheckboxes.forEach(cb => {
                                if (!cb.disabled) cb.checked = isChecked;
                            });

                            room_selected();
                        }

                        function update_building_checkbox(buildingClass) {
                            const buildingCheckbox = document.querySelector(`input[value="${buildingClass}"]`);
                            const roomCheckboxes = document.querySelectorAll(`.room-selected.${buildingClass}`);

                            const allChecked = Array.from(roomCheckboxes).every(cb => cb.checked);
                            buildingCheckbox.checked = allChecked;
                        }
                    </script>
                    <div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
                        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
                            <i class="tf-icons ti ti-device-ipad-dollar text-main" style="font-size: 25px;vertical-align: baseline;"></i>
                            รายละเอียดการชำระเงิน
                        </h5>
                        <div class="row g-3 p-4 pt-1">
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput30" class="form-label">ค่ามัดจำ (บาท)</label>
                                <input type="text" name="deposit" class="form-control" id="exampleFormControlInput30" placeholder="" value="2000"/>
                            </div>
                            <div class="col-sm-12">
                                <div>
                                    <label for="exampleFormControlInput31" class="form-label">วิธีการชำระเงิน</label>
                                </div>
                                <div class="ms-3">
                                <input
                                    name="payment_method"
                                    class="form-check-input"
                                    type="radio"
                                    value="1"
                                    id="defaultRadio1"
                                    checked />
                                <label class="form-check-label" for="defaultRadio1">&nbsp; เงินสด </label>
                                <input
                                    name="payment_method"
                                    class="form-check-input ms-2"
                                    type="radio"
                                    value="2"
                                    id="defaultRadio2" />
                                <label class="form-check-label" for="defaultRadio2">&nbsp; โอนเงิน </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput33" class="form-label">วันที่รับชำระเงิน</label>
                                <input type="text" name="payment_received_date" class="form-control" id="exampleFormControlInput33" placeholder="วัน/เดือน/ปี" value="24/04/2025" required/>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#select2Basic').change(function() {
                                var provinceId = $(this).val();
                                
                                // เคลียร์ dropdown สำหรับอำเภอและตำบล
                                $('#select2District99').empty().append('<option selected disabled hidden value="">เลือกอำเภอ</option>');
                                $('#select2Subdistrict').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                                if (provinceId) {
                                    $.ajax({
                                        url: '/get-districts/' + provinceId,
                                        type: 'GET',
                                        success: function(data) {
                                            data.forEach(function(district) {
                                                $('#select2District99').append('<option value="' + district.id + '">' + district.name_in_thai + '</option>');
                                            });
                                        }
                                    });
                                }
                            });

                            $('#select2District99').change(function() {
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

                            $('#selectpickerBuilding').change(function() {
                                var building = $(this).val();
                                
                                // เคลียร์ dropdown สำหรับตำบล
                                $('#selectpickerFloor').empty().append('<option value="all">ทุกชั้น</option>');

                                if(building == 'all'){
                                    $('#selectpickerFloor').prop('disabled', true);
                                    return;
                                }
                                if (building) {
                                    $.ajax({
                                        url: '/get-floors/' + building,
                                        type: 'GET',
                                        success: function(data) {
                                            $('#selectpickerFloor').prop('disabled', false);
                                            data.forEach(function(floor) {
                                                $('#selectpickerFloor').append('<option value="' + floor.id + '">' + floor.name + '</option>');
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
                        });

                        $(document).ready(function() {
                            $('.user-tags').on('itemAdded', function (event) {
                                const value = event.item;
                                $.ajax({
                                url: 'room/reserve/chec-user',
                                method: 'POST',
                                data: {
                                    keyword: value,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (res) {
                                    if (!res.found) {
                                    let tags = $('.bootstrap-tagsinput span.tag');
                                    tags.each(function () {
                                        if ($(this).text().trim() === value) {
                                        $(this).addClass('invalid');
                                        }
                                    });
                                    }
                                },
                                error: function () {
                                    alert("เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์");
                                }
                                });
                            });
                        });

                    </script>