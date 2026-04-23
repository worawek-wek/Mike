<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>

<div id="loadingOverlay" style="display: none;">
  <div class="spinner"></div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link rel="stylesheet" href="../../assets/vendor/libs/tagify/tagify.css" />

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
    select#selectAllRooms + .ts-wrapper .ts-control .item {
        background-color: #0d6efd !important; /* ฟ้าแบบ Bootstrap Primary */
        color: #fff !important;               /* ตัวหนังสือขาว */
        border-radius: 12px;                  /* มุมโค้ง */
        padding: 4px 10px;
        margin: 2px;
        font-weight: 500;
    }
    select#selectAllRooms + .ts-wrapper .ts-control .item:hover {
        background-color: #0e5ed7 !important; /* เขียวเข้มขึ้น */
    }
  </style>
  
<style>
    .table-detail {
        border-collapse: collapse; /* รวมเส้นขอบของตาราง */
        border-radius: 5px;
        overflow: hidden;
    }
    .table-detail th, .table-detail td {
        border: 1px solid #d9d9d9 !important; /* กำหนดเส้นขอบของ th และ td */
    }
    .table-detail th {
        vertical-align: middle;
        font-weight: 500;
        font-size: 14px;
        color: black !important;
    }
    .new_box .col-md-6 {
        padding: 5px 12px;
    }
    .table th {
        font-size: 15px;
        font-weight: bold;
        border: 1px solid #dbdade
    }
    .border-dbdade th {
        border: 1px solid #dbdade
    }
    .border-dbdade td {
        border: 1px solid #dbdade
    }
    .modalHeadDecor .modal-header {
        padding: 0;
    }

    .modalHeadDecor .modal-title {
        padding: 1.25rem 0.5rem 1.25rem 1.25rem;
        color: white;
        background-color: #54BAB9;
        position: relative;
    }

    .modalHeadDecor .modal-title::after {
        position: absolute;
        top: 0;
        right: -64px;
        content: '';
        width: 0;
        height: 0;
        border-top: 67px solid #54BAB9;
        border-right: 65px solid transparent;
    }

    #pills-tablayout button {
        background: transparent;
    }

    #pills-tablayout button.active {
        color: #54BAB9 !important;
    }

    .select-floor {
        width: 100px;
    }

    .box {
        display: none;
    }

    @media screen and (min-width:1024px) {
        .col-lg5 {
            width: calc(100%/5);
        }
    }


    @media screen and (max-width:767px) {
        .select-floor {
            width: 100%;
        }
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
                                    <div class="card-header">
                                        <div class="col-sm-12">
                                            <h4 class="mb-0">
                                                <i class="tf-icons ti ti-sitemap text-main ti-xl me-2"></i>
                                                จองห้อง
                                                {{ $room->name ?? '' }}
                                            </h4>
                                        </div>
                                </div>
                                    <div class="card-body"> 
                                        {{-- insert_renter --}}
                                    <form id="reserve_one_room">
                                    <div class="tab-content p-0" id="pills-tabContent">
                                        @csrf
                                        @php
                                            $thaiNames = [
                                                "",
                                            ];
                                            $thaiSurnames = [
                                                "",
                                            ];
                                            $t_phone = "";
                                            $t_id_code_number = "";
                                            if (Auth::user()->username == '0987654321') {
                                                $thaiNames = [
                                                    "กิตติ", "วราภรณ์", "อนันต์", "ศศิธร", "ธนพล", "พิชชา", "ศุภชัย", "นฤมล", "ธนวัฒน์", "อารยา",
                                                    "ธนากร", "ณัฐชา", "ปริญญา", "อัญชลี", "สราวุฒิ", "จุฑารัตน์", "วิชาญ", "นงนุช", "ภูริ", "ชุติมา",
                                                    "พีรพล", "ธัญญา", "ภานุวัฒน์", "อุไร", "ชลธี", "จิตราภรณ์", "ปกรณ์", "วาสนา", "ณัฐพล", "มยุรี",
                                                    "พีระ", "นฤมาศ", "ชัยวัฒน์", "สายฝน", "วิทยา", "อรวรรณ", "วัฒนา", "สุรีย์พร", "พงศกร", "ธีราพร",
                                                    "วรินทร", "สุนีย์", "จักรพงษ์", "ธิดารัตน์", "ประเสริฐ", "กมลวรรณ", "พชร", "วิลาสินี", "ศักดิ์สิทธิ์", "รัตนา",
                                                    "สรยุทธ", "ปวีณา", "เจษฎา", "ปาริชาติ", "ธวัชชัย", "สุวิมล", "ภาณุ", "ทิพย์วรรณ", "สันติ", "อัญญา",
                                                    "ปริวัฒน์", "ดารารัตน์", "ธีรพล", "พรรณี", "ชัยณรงค์", "สมหญิง", "สันติภาพ", "ลดาวัลย์", "ณัฐวุฒิ", "นฤดี",
                                                    "พิสิษฐ์", "วราภรณ์", "กฤษณะ", "เบญจมาศ", "ภาสกร", "ชลธิชา", "ทรงพล", "อุษา", "อนุชา", "เพ็ญศรี",
                                                    "ศรัณย์", "พัชรี", "อธิพงษ์", "ชไมพร", "ภัทรพล", "บุญรัตน์", "เกรียงไกร", "สุภาพร", "ภูวเดช", "สุนันทา",
                                                    "กษิดิศ", "วิลาวัลย์", "อิทธิพล", "รุ่งทิพย์", "ณัฐพงษ์", "จารุวรรณ", "อมรชัย", "บุษกร", "ชาญชัย", "วิมล"
                                                ];
                                                $thaiSurnames = [
                                                    "สุขสันต์", "ใจดี", "วัฒนากูล", "ศรีสุวรรณ", "พานิชย์", "บุญมี", "ประเสริฐศรี", "กุลวงศ์", "ธรรมรักษ์", "อินทร์แปลง",
                                                    "สุทธิสาร", "พัฒนกิจ", "ศักดิ์ศรี", "จันทร์เพ็ญ", "ทองแท้", "ศิริวัฒน์", "เจริญสุข", "เรืองฤทธิ์", "สกุลไทย", "เจนจิตต์",
                                                    "สาครินทร์", "รัตนคุณ", "มงคลชัย", "เศรษฐ์สิทธิ์", "อัครเดช", "ศิริวงศ์", "พงษ์พิพัฒน์", "พูนทรัพย์", "เพ็งดี", "กิตติพงษ์",
                                                    "ธรรมวงศ์", "ชัยยศ", "ชาญณรงค์", "สังข์ทอง", "ปรีดารัตน์", "วงศ์วาน", "ทองใบ", "ทองคำ", "ทวีทรัพย์", "เกียรติชัย",
                                                    "ยศธร", "เชิดชู", "มณีรัตน์", "สมหมาย", "วรรณพงษ์", "หงส์ทอง", "บุญศรี", "เนตรทิพย์", "ลิขิตวงศ์", "กาญจนวัฒน์",
                                                    "เพ็ญนภา", "จันทร์แก้ว", "อนันต์ชัย", "ชนะชัย", "แสงทอง", "รุ่งเรือง", "ตั้งจิตต์", "ตระการไทย", "เผ่าพันธุ์", "อร่ามเรือง",
                                                    "กิตติวงศ์", "ลิ้มทองคำ", "วงษ์สมบูรณ์", "กัลยาณมิตร", "สุนทรวัฒน์", "สุภกิจ", "อรุณรุ่ง", "อ่อนละม้าย", "พุฒิพงษ์", "จิตติธรรม",
                                                    "ประดิษฐ์", "ธนวัฒน์", "อารีย์วงศ์", "อ่อนใจดี", "เครือวัลย์", "เศรษฐศักดิ์", "ประภากร", "กาญจนสุวรรณ", "อุทัยวรรณ", "พิทักษ์กิจ",
                                                    "เพชรรัตน์", "ศักดากุล", "กิตติศักดิ์", "โสภา", "พิริยจิตร", "หาญกล้า", "ฤกษ์ดี", "รุ่งสว่าง", "กมลชัย", "วรสาร",
                                                    "อ่อนละไม", "จิตรเจริญ", "บุญช่วย", "เพ็ญศิริ", "จิตต์กมล", "สุทธินันท์", "ภักดี", "ทองพูล", "สวัสดี", "ธีรพัฒน์"
                                                ];
                                                $t_phone = "0".rand(800000000, 999999999);
                                                $t_id_code_number = rand(9000000000000, 9999999999999);
                                            }
                                        @endphp
                                            @if($room_id)
                                            
                                                <div class="row g-3 p-2">
                                                    <div class="col-sm-9"></div>
                                                    <div class="col-sm-3 text-end">
                                                        <button type="button" class="btn btn-info" onclick="window.location.href='/room/check-in/{{ $room_id }}'" data-bs-toggle="modal" data-bs-target="#insertCheckIn">
                                                            <i class="fa-solid fa-right-to-bracket me-2"></i>เปลี่ยนเป็นเข้าพัก
                                                        </button>
                                                    </div>
                                                </div>
                                            <input type="hidden" class="count-room-reserve">
                                            @endif
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
                          {{-- <input id="TagifyBasic" class="form-control" name="TagifyBasic" value="Tag1, Tag2, Tag3" /> --}}

                                                <div class="col-sm-5">
                                                    <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label><span class="text-danger">*</span>
                                                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ $thaiNames[array_rand($thaiNames)] }}" required/>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="exampleFormControlInput2" class="form-label">นามสกุล</label><span class="text-danger">*</span>
                                                    <input type="text" name="surname" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{ $thaiNames[array_rand($thaiSurnames)] }}" required/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="exampleFormControlInput3" class="form-label">เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)</label><span class="text-danger">*</span></label>
                                                    <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="{{ $t_phone }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);" required/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="exampleFormControlInput4" class="form-label">เลขบัตรประชาชน/Passport</label><span class="text-danger">*</span></label>
                                                    <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="{{ $t_id_code_number }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,13);"  required/>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="exampleFormControlInput5" class="form-label">ที่อยู่ตามสำเนาทะเบียนบ้าน</label>
                                                    <input type="text" name="address" class="form-control" id="exampleFormControlInput5" placeholder="เลขที่ ซอย ถนน อาคาร ห้องเลขที่ หรือหมู่บ้าน"/>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>เลือกจังหวัด</label>
                                                    <select name="ref_province_id" id="select2Basic">
                                                        <option selected disabled hidden value="">เลือกจังหวัด</option>
                                                        @foreach ($province as $pro)
                                                            <option value="{{ $pro->id }}">{{ $pro->name_in_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>เลือกอำเภอ</label>
                                                    <select name="ref_district_id" id="select2District99">
                                                        <option selected disabled hidden value="">เลือกอำเภอ</option>
                                                        @foreach ($district as $dis)
                                                            <option value="{{ $dis->id }}">{{ $dis->name_in_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>เลือกตำบล</label>
                                                    <select name="ref_subdistrict_id" id="select2Subdistrict">
                                                        <option selected disabled hidden value="">เลือกตำบล</option>
                                                        @foreach ($subdistrict as $sub_dis)
                                                            <option value="{{ $sub_dis->id }}">{{ $sub_dis->name_in_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                                                    <input type="number" name="zipcode" class="form-control" id="zipcode" placeholder="รหัสไปรษณีย์"/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="bs-datepicker-format2" class="form-label">วันที่จอง</label><span class="text-danger">*</span>
                                                    <input type="text" name="booking_date" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" value="{{ date('d/m/Y') }}" required/>
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
                                                    <label for="exampleFormControlInput13" class="form-label">วันที่เข้าพัก</label><span class="text-danger">*</span>
                                                    <input type="text" name="date_stay" class="form-control" id="exampleFormControlInput13" placeholder="วัน/เดือน/ปี" value="{{ date('d/m/Y') }}" required/>
                                                </div>
                                                <div class="row g-3" @if($room_id) style="display: none;" @endif>
                                                    <b class="text-black">รูปแบบการเลือกห้อง <span class="text-danger">*</span></b><br>
                                                    <div class="col-sm-2">
                                                        <input name="select_channel" class="form-check-input" type="radio" id="typeChooseRoom1" value="1" checked onclick="toggleSelectFields()">
                                                        <label class="form-check-label ms-1" for="typeChooseRoom1"> พิมพ์ชื่อห้อง </label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input name="select_channel" class="form-check-input" type="radio" id="typeChooseRoom2" value="2" onclick="toggleSelectFields()"> 
                                                        <label class="form-check-label ms-1" for="typeChooseRoom2"> ติ๊กชื่อห้อง </label>
                                                    </div>
                                                    <div></div>
                                                    <div class="col-sm-12" id="selectForm">
                                                        {{-- <textarea name="room_text" class="form-control user-tags" id="room_text" placeholder="พิมพ์ชื่อห้องและกด Enter" required></textarea> --}}
                                                        
                                        {{-- @if (@$room_id)
                                            <input type="hidden" name="room_text" id="room_text" value="">
                                        @endif --}}
                                                        <input name="room_text" class="form-control user-tags" data-role="tagsinput" id="room_text" placeholder="พิมพ์ชื่อห้องและกด Enter" value="{{ $room->name ?? ''; }}" onchange="cal_total_amount()">
                                                    </div>
                                                </div>
                                                
                                                {{-- <div class="row p-4 pt-1">
                                                    <div @if($room_id) style="display: none;" @endif>
                                                        <b class="text-black">รูปแบบการเลือกห้อง</b> <br>
                                                            <div class="col-sm-2">
                                                                <input name="select_channel" class="form-check-input" type="radio" id="typeChooseRoom1" value="1" checked onclick="toggleSelectFields()">
                                                                <label class="form-check-label ms-1" for="typeChooseRoom1"> พิมพ์ชื่อห้อง </label>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input name="select_channel" class="form-check-input" type="radio" id="typeChooseRoom2" value="2" onclick="toggleSelectFields()"> 
                                                                <label class="form-check-label ms-1" for="typeChooseRoom2"> ติ๊กชื่อห้อง </label>
                                                            </div>
                                                        </div>
                                                        <div></div>
                                                        <div class="col-sm-12" id="selectForm">
                                                            
                                                            <select name="room_text_id[]" id="selectAllRooms" multiple>
                                                                @foreach ($all_rooms as $op)
                                                                    <option value="{{ $op->id }}">{{ $op->name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div> --}}
                                                
                                                <div class="col-sm-5 selectForm2" style="display: none;">
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
                                                                                            <input name="buildings[{{ $build->id }}][{{ $floor->id }}][]" value="{{ $room->id }}" class="form-check-input room-selected buildings-{{ $build->id }} floors-{{ $floor->id }} input-check-room" type="checkbox" id="{{ $room->id }}" onchange="room_selected()"
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
                                                
                                                {{-- <div class="col-sm-12 ms-4 selectForm1" id="room-selected1">
                                                    @include('room/selected')
                                                </div> --}}
                                                <div class="col-sm-7 selectForm2" style="display: none;">
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
                                                    // $('#room_text').attr('required', true);
                                                    
                                                } else {
                                                    selectForm.style.display = 'none';
                                                    $('.selectForm2').show();
                                                    $('#ref_bank_id').removeAttr('required');
                                                    $('#transfer_time').removeAttr('required');
                                                    $('#select_date2').removeAttr('required')
                                                    // $('#room_text').removeAttr('required');
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
                                                <div class="col-sm-2">
                                                    <input name="deposit_status" class="form-check-input deposit_status me-1" type="radio" id="deposit_status_1" value="1" checked>
                                                    <label class="form-check-label" for="deposit_status_1"> มีค่ามัดจำ </label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input name="deposit_status" class="form-check-input deposit_status me-1" type="radio" id="deposit_status_2" value="2">
                                                    <label class="form-check-label" for="deposit_status_2"> ไม่มีค่ามัดจำ </label>
                                                </div>
                                            </div>
                                            <div class="row g-3 p-4 pt-1" id="paymentSection" >

                                                <div class="col-sm-12">
                                                    <label for="reserve_deposit" class="form-label">ค่ามัดจำ (บาท)</label>
                                                    <input type="number" name="deposit" class="form-control" id="reserve_deposit" placeholder="ค่ามัดจำ (บาท)" value="0" oninput="cal_total_amount()"/>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="reserve_deposit_total_amount" class="form-label">ยอดรวมค่ามัดจำทั้งหมด (บาท)</label>
                                                    <input type="text" name="deposit_all" class="form-control reserve_deposit_total_amount" value="0" readonly/>
                                                </div>
                                                <script>
                                                    document.addEventListener('click', function(event) {
                                                        cal_total_amount();
                                                    });
                                                    function cal_total_amount(){
                                                        var reserve_deposit = $('#reserve_deposit').val();
                                                        if(reserve_deposit > 0){

                                                            const selectChannel = document.querySelector('input[name="select_channel"]:checked').value;
                                                            
                                                            let count = 0;

                                                            if(!$('#check_selected').val() && selectChannel == 2){
                                                                // return Swal.fire('! โปรดเลือกห้องเช่า', '', 'warning');
                                                                count = $('.input-check-room:checked').length;
                                                                // alert(count);
                                                                // alert(888);

                                                            }
                                                            let roomText = $('#room_text').val().trim();

                                                            if (selectChannel == '1' && roomText !== '') {
                                                                count = $('.count-room-reserve').length;       // ดึงค่าใน input
                                                                // let value = $('#room_text').val();       // ดึงค่าใน input
                                                                // count = value.split(',').length;     // แยกด้วย comma แล้วนับจำนวน
                                                                // console.log('#room_text = '+ $('#room_text').val());
                                                            }
                                                            var reserve_deposit_total_amount = reserve_deposit*count;
                                                            $('.reserve_deposit_total_amount').val(reserve_deposit_total_amount.toLocaleString());
                                                            $('.reserve_deposit_total_amount_h5').html(reserve_deposit_total_amount.toLocaleString());

                                                        }
                                                    }
                                                </script>
                                                <div class="col-sm-12">
                                                    <div>
                                                        <label for="exampleFormControlInput31" class="form-label">วิธีการชำระเงิน</label>
                                                    </div>
                                                    {{-- <div class="ms-3">
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
                                                        id="tranfer" />
                                                    <label class="form-check-label" for="tranfer">&nbsp; โอนเงิน </label>
                                                    </div> --}}
                                                    {{-- ///////////////////////////////////////////////////// --}}
                                                    <div class="col-sm-11 mb-3">
                                                        <input name="payment_channel" class="form-check-input me-1 reservation_payment_channel" type="radio" id="reservation_payByCash" value="1" checked>
                                                        <label class="form-check-label" for="reservation_payByCash"> เงินสด </label>
                                                    </div>

                                                    <div id="paymentChanel_Res2">
                                                        <div class="col-sm-6 mb-3">
                                                            <label for="payment_date">วันที่ชำระเงิน</label>
                                                            <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date" autocomplete="off" value="{{date('d/m/Y')}}"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-11 mb-3">
                                                        <input name="payment_channel" class="form-check-input me-1 reservation_payment_channel" type="radio" id="reservation_payByTransfer" value="2">
                                                        <label class="form-check-label" for="reservation_payByTransfer"> โอนเงิน </label>
                                                    </div>

                                                    <!-- แสดงเมื่อเลือก โอนเงิน -->
                                                    <div id="paymentChanel_Res" style="display:none;">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>เลือกบัญชีธนาคาร</label><span class="text-danger"> *</span>
                                                            <select class="select2 form-select mb-2" name="ref_bank_id" id="exampleFormControlSelect1">
                                                                @foreach ($bank as $r_bank)
                                                                    <option value="{{ $r_bank->id }}">{{ $r_bank->bank.' '.$r_bank->bank_account_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3 mb-2">
                                                            <label for="transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                                                            <input type="time" name="transfer_time" class="form-control" placeholder="" id="transfer_time" autocomplete="off"/>
                                                        </div>
                                                        <div class="col-sm-6 mb-2">
                                                            <label for="payment_date2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                                                            <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                                                        </div>
                                                        <div class="col-sm-10 mt-3">
                                                            <label for="evidence_of_money_transfer">แนบหลักฐานการโอน</label>
                                                            <input type="file" name="evidence_of_money_transfer" class="form-control mb-2" id="evidence_of_money_transfer" accept="image/*">
                                                            <div class="preview-container">
                                                                <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 mb-2">
                                                        <h5 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="reserve_deposit_total_amount_h5">0</span> &nbsp;บาท
                                                        </h5>
                                                    </div>
                                                    {{-- ///////////////////////////////////////////////////// --}}
                                                </div>
                                                {{-- <div class="col-sm-12">
                                                    <label for="exampleFormControlInput33" class="form-label">วันที่รับชำระเงิน</label><span class="text-danger">*</span>
                                                    <input type="text" name="payment_received_date" class="form-control" id="exampleFormControlInput33" placeholder="วัน/เดือน/ปี" value="{{ date('d/m/Y') }}" required/>
                                                </div> --}}
                                            </div>
                                        </div>
                                                <div class="modal-footer rounded-0 justify-content-center">
                                                    {{-- <button type="button" class="btn btn-label-secondary me-2">ปิด</button> --}}
                                                    <button type="submit" class="btn btn-main">บันทึก</button>
                                                </div>
                                            </form>
                                        </div>
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
    
    {{-- ///////////////////////////////////////////////////////////// --}}
    {{-- @include('room/add-renter') --}}
    {{-- ///////////////////////////////////////////////////////////// --}}


    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script src="../../assets/vendor/libs/tagify/tagify.js"></script>
    <script src="../../assets/js/forms-tagify.js"></script>

</body>

    <div class="modal fade modalHeadDecor" id="roomRentalReservation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ชำระค่าจองหลายห้อง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reservation_form_all" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="p-2">
                            <label class="h5 mb-1">เลือกข้อมูลจากผู้เช่า</label>
                                <select name="ref_renter_id" id="select2Renter2" class="select2 form-select form-select-lg" onchange="get_room_rental_reservation(this.value)" required>
                                    <option selected hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                                    @foreach ($renter as $rent)
                                        <option {{$rent->contracts_id}} value="{{ $rent->id }}">{{ $rent->prefix.' '.$rent->name.' '.$rent->surname }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div id="room-rental-reservation">

                        </div>
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" id="submit_reservation_form_all" class="btn btn-main" disabled>บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>
<iframe id="print-iframe" style="display: none;"></iframe>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>
$(document).ready(function() {
    
        function toggleDepositSection() {
            let depositStatus = $('input[name="deposit_status"]:checked').val();

            if (depositStatus == 2) { // ไม่มีค่ามัดจำ
                $('#paymentSection')
                    .css('opacity', '0.5')
                    .find('input, select, textarea, button')
                    .prop('disabled', true);
            } else { // มีค่ามัดจำ
                $('#paymentSection')
                    .css('opacity', '1')
                    .find('input, select, textarea, button')
                    .prop('disabled', false);
            }
        }

        // โหลดครั้งแรก
        toggleDepositSection();

        // เปลี่ยน radio
        $('input[name="deposit_status"]').on('change', function () {
            toggleDepositSection();
        });

        $('.user-tags').on('itemAdded', function (event) {
            // alert(12323);
            const value = event.item;
            $.ajax({
            url: 'room/reserve/chec-user',
            method: 'POST',
            data: {
                keyword: value,
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                let tags = $('.bootstrap-tagsinput span.tag');
                if (!res.found) {
                        tags.each(function () {
                            if ($(this).text().trim() === value) {
                                $(this).addClass('invalid');
                            }
                        });
                }else{
                        tags.each(function () {
                            if ($(this).text().trim() === value) {
                                $(this).addClass('count-room-reserve');
                            }
                        });
                }
                cal_total_amount();
            },
            error: function () {
                alert("เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์");
            }
            });
        });
        $('.user-tags').on('itemRemoved', function (event) {
            cal_total_amount();
        });
    });
</script>
<script>
        tomProvince = new TomSelect("#select2Basic", {
                                        create: false,
                                        maxItems: 1,
                                        allowEmptyOption: true,
                                        sortField: { field: "text", direction: "asc" }
                                    });

        tomDistrict = new TomSelect("#select2District99", {
                        create: false,
                        maxItems: 1,
                        allowEmptyOption: true,
                        sortField: { field: "text", direction: "asc" }
                    });

        tomSubdistrict = new TomSelect("#select2Subdistrict", {
                        create: false,
                        maxItems: 1,
                        allowEmptyOption: true,
                        sortField: { field: "text", direction: "asc" }
                    });

        // setTimeout ถูกลบออกเพราะทำให้ datepicker ถูก initialize ซ้ำ 2 ครั้ง
    
        function room_selected() {
            document.getElementById('loadingOverlay').style.display = 'flex';
             $.ajax({
                url: '/room/selected', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                type: 'get',
                data: $('#reserve_one_room .room-selected:checked').serialize(),
                success: function(response) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        $("#room-selected").html(response);
                        cal_total_amount();
                        // Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success');
                        // $('#addserviceModal').modal('hide');
                        // setTimeout(function() {
                        //   location.reload();
                        // }, 4000);
                },
                error: function(error) {
                    Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                    console.error('เกิดข้อผิดพลาด:', error);
                }
            });
        };
        // จองห้องเดียว
        $('#reserve_one_room').on('submit', function(event) {  // อันนี้คือ เพิ่มการจอง
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            const selectChannel = document.querySelector('input[name="select_channel"]:checked').value;

            if($('#check_selected').val() == 0 && selectChannel == 2){
                return Swal.fire('! โปรดเลือกห้องเช่า', '', 'warning');
            }
            let roomText = $('#room_text').val().trim();

            if (selectChannel == '1' && roomText === '') {
                Swal.fire('! โปรดเลือกห้องเช่า', '', 'warning');
                return false;
            }
            
            var reserve_deposit = $('#reserve_deposit').val();
            let depositStatus = $('input[name="deposit_status"]:checked').val();
            if(depositStatus == 1){
                if(reserve_deposit < 1){
                    return Swal.fire('กรุณากรอก ค่ามัดจำ', '', 'warning');
                }
            }
            
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่ม การจอง หรือไม่?',
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
                        url: '/room', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response.message == null){
                                // return 1;
                                var modalEl = document.getElementById('reserveOneRoomModal');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                // $('#insertRenter').modal('hide');
                                // $('#roomRentalReservation').modal('show');
                                // get_room_rental_reservation(response);
                                $('#reserve_one_room')[0].reset();
                                // Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success');
                                
                                Swal.fire({
                                            title: 'เพิ่มการจองเรียบร้อยแล้ว',
                                            icon: 'success',
                                            timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                            timerProgressBar: true, 
                                            showConfirmButton: false,
                                            customClass: {
                                                title: 'custom-title', // กำหนดคลาสให้กับ title
                                            }}).then((result) => {
                                                window.location.href = '/room';
                                                // location.reload();
                                            });
                            }else{
                                Swal.fire({ html: `<div style="color:red; font-size: 20px;">${response.message}</div>`, icon: 'error'} );
                            }
                        },
                        error: function (xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                let messages = '';
                                $.each(xhr.responseJSON.errors, function (key, value) {
                                    messages += value + '<br>';
                                });

                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    html: messages,
                                    icon: 'error',
                                });
                            } else {
                                Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                                console.error('เกิดข้อผิดพลาด:', xhr);
                            }
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
        $('.reservation_payment_channel').on('change', function() {
            const paymentChannel = $('.reservation_payment_channel:checked').val();

            if (paymentChannel === '2') {
                // แสดงช่องโอนเงิน
                $('#paymentChanel_Res').show();
                $('#paymentChanel_Res2').hide();

                // ใส่ required
                $('#ref_bank_id').attr('required', true);
                $('#transfer_time').attr('required', true);
                $('#payment_date2').attr('required', true);
            } else {
                // แสดงช่องเงินสด
                $('#paymentChanel_Res').hide();
                $('#paymentChanel_Res2').show();

                // เอา required ออก
                $('#ref_bank_id').removeAttr('required');
                $('#transfer_time').removeAttr('required');
                $('#payment_date2').removeAttr('required');
            }
        });

        // ให้รันตอนโหลดหน้าด้วย (กรณีมีค่า checked อยู่แล้ว)
        $(document).ready(function() {
            $('.reservation_payment_channel:checked').trigger('change');
        });

        const fpConfig = {
            dateFormat: 'd/m/Y',
            allowInput: true,
        };
        flatpickr('#bs-datepicker-format2', fpConfig);
        flatpickr('#exampleFormControlInput13', fpConfig);
        flatpickr('#exampleFormControlInput33', fpConfig);
        flatpickr('#payment_date', fpConfig);
        flatpickr('#payment_date2', fpConfig);
        
    $(document).ready(function() {
        $('#select2Basic').on('change', function () {
            const provinceId = $(this).val();
            if (provinceId) {
            
                document.getElementById('loadingOverlay').style.display = 'flex';

            if (tomDistrict) {
                tomDistrict.destroy();
            }
            $('#select2District99').html('<option selected disabled hidden value="">เลือกอำเภอ</option>');

                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (district) {
                            $('#select2District99').append(
                                `<option value="${district.id}">${district.name_in_thai}</option>`
                            );
                        });

                        tomDistrict = new TomSelect("#select2District99", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
                        document.getElementById('loadingOverlay').style.display = 'none';
                    }
                });
            }
        });

        $('#select2District99').on('change', function () {
            var districtId = $(this).val();
            
            if (districtId) {
            
                document.getElementById('loadingOverlay').style.display = 'flex';

            if (tomSubdistrict) {
                tomSubdistrict.destroy();
            }
            $('#select2Subdistrict').html('<option selected disabled hidden value="">เลือกตำบล</option>');

                $.ajax({
                    url: '/get-subdistricts/' + districtId,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (subdistrict) {
                            $('#select2Subdistrict').append(
                                `<option value="${subdistrict.id}">${subdistrict.name_in_thai}</option>`
                            );
                        });

                        tomSubdistrict = new TomSelect("#select2Subdistrict", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
                        document.getElementById('loadingOverlay').style.display = 'none';
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

    

</script>