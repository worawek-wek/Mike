
    <link rel="stylesheet" href="assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="assets/vendor/libs/quill/editor.css" />
<div class="modal-body">
    <div class="row g-3">
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">ชื่อบริษัท</label>
            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="" value="{{ @$company['name'] }}" />
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">รายละเอียด</label>
            <input type="text" class="form-control" name="detail" id="exampleFormControlInput1" placeholder="" value="{{ @$company['detail'] }}" />
        </div>
        <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="card mb-3">
                                    <div class="card-header border-bottom border-light">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-6">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-news text-main ti-md"></i>
                                                    สัญญาเช่า
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
                                        <form>
                                            <h4>คลิกเพื่อใส่ข้อมูล</h4>
                                            {{-- <div class="mb-3 d-flex gap-2 flex-wrap">
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">ชื่อหอพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">ที่อยู่หอพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">วันที่ปัจจุบัน</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">เดือน/ปีปัจจุบัน</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">ชื่อผู้เช่า</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">หมายเลขบัตรประชาชนผู้เช่า</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เบอร์โทรผู้เช่า</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">หมายเลขห้องพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">หมายเลขชั้นของห้องพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ระยะเวลาสัญญา</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">วันที่เริ่มต้นสัญญา</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">วันที่สิ้นสุดสัญญา</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เงินประกันห้อง</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ค่าเช่าห้อง</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ค่าเช่าเฟอร์นิเจอร์</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ค่าเช่าห้องไม่รวมค่าเฟอร์นิเจอร์</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">วันที่สิ้นสุดการชำระเงิน</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เลขมิเตอร์ไฟฟ้าเข้าพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เลขมิเตอร์น้ำเข้าพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ลายเซนต์ผู้เช่า</button>
                                            </div> --}}
                                            <div id="full-editor"></div>
                                            {{-- <div class="addFloor text-center pt-4">
                                                <button type="button" class="btn btn-main"><i
                                                        class="ti-xs ti ti-device-floppy me-2"></i>บันทึกแก้ไข</button>
                                            </div> --}}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</div>
<div class="modal-footer rounded-0 justify-content-center">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
    <button type="submit" class="btn btn-main">บันทึก</button>
</div>

    <script src="assets/vendor/libs/quill/katex.js"></script>
    <script src="assets/vendor/libs/quill/quill.js"></script>
    <script src="assets/js/forms-editors.js"></script>
    