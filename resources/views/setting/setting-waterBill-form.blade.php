<div class="d-flex h5">
    <div class="flex-shrink-0">
        <span class="badge badge-center rounded-pill bg-info">1</span>
    </div>
    <div class="flex-grow-1 ms-2">
        เลือกวิธีคิดค่าน้ำ
    </div>
</div>
<div class="row g-3">
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="paywater4">
                <input name="how_to_cal_water" class="form-check-input" type="radio" value="4" {{ @$how['4'] }}
                    id="paywater4">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง(คิดขั้นต่ำเป็นจำนวนเงิน)</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="paywater3">
                <input name="how_to_cal_water" class="form-check-input" type="radio" value="3" {{ @$how['3'] }}
                    id="paywater3">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง</span>
                </span>
            </label>
        </div>
    </div>
    {{-- <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="paywater1">
                <input name="how_to_cal_water" class="form-check-input" type="radio" value="1" {{ @$how['1'] }}
                    id="paywater1">
                <span class="custom-option-header">
                    <span class="h6 mb-0">เหมาจ่ายรายเดือน</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="paywater2">
                <input name="how_to_cal_water" class="form-check-input" type="radio" value="2" {{ @$how['2'] }}
                    id="paywater2">
                <span class="custom-option-header">
                    <span class="h6 mb-0">เหมาจ่ายรายหัว</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="paywater5">
                <input name="how_to_cal_water" class="form-check-input" type="radio" value="5" {{ @$how['5'] }}
                    id="paywater5">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง(คิดขั้นต่ำเป็นยูนิต)</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="paywater6">
                <input name="how_to_cal_water" class="form-check-input" type="radio" value="6" {{ @$how['6'] }}
                id="paywater6">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง(บอกส่วนต่างจากราคาขั้นต่ำ)</span>
                </span>
            </label>
        </div>
    </div> --}}
</div>
<div class="d-flex h5 mt-3">
    <div class="flex-shrink-0">
        <span class="badge badge-center rounded-pill bg-info">2</span>
    </div>
    <div class="flex-grow-1 ms-2">
        กรอกข้อมูลค่าน้ำ
    </div>
</div>
<div class="box in_3">
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดตามจริง</label>
        <div class="col-8 col-md-8">
            <input name="water_baht_per_unit" class="form-control" type="number" value="{{ @$water_bill->water_baht_per_unit }}" step="any" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/ยูนิต</label>
    </div>
</div>
<div class="box in_4">
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดตามจริง</label>
        <div class="col-8 col-md-8">
            <input name="water_baht_per_unit_2" class="form-control" type="number" id="html5-text-input" value="{{ @$water_bill->water_baht_per_unit }}">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/ยูนิต</label>
    </div>
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">ขั้นต่ำ</label>
        <div class="col-8 col-md-8">
            <input name="minimum_water_bill" class="form-control" type="number" id="html5-text-input" value="{{ @$water_bill->minimum_water_bill }}">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท</label>
    </div>
</div>
{{-- <div class="box in_1">
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">เหมารายเดือน</label>
        <div class="col-8 col-md-8">
            <input class="form-control" name="water_monthly_rental" type="number" id="html5-text-input" value="{{ @$water_bill->water_monthly_rental }}">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/เดือน</label>
    </div>
</div>
<div class="box in_2">
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">เหมาหัวละ</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/เดือน</label>
    </div>
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">จำนวนผู้เช่า</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">คน</label>
    </div>
</div>
<div class="box in_5">
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดตามจริง</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/ยูนิต</label>
    </div>
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">ยูนิตขั้นต่ำ</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">ยูนิต</label>
    </div>
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดเป็นเงิน</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท</label>
    </div>
</div>
<div class="box in_6">
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดตามจริง</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/ยูนิต</label>
    </div>
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">ยูนิตขั้นต่ำ</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">ยูนิต</label>
    </div>
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดเป็นเงิน</label>
        <div class="col-8 col-md-8">
            <input class="form-control" type="number" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท</label>
    </div>
</div> --}}

<script>
    $(document).ready(function() {
        getCheckedRadioValue();
        function getCheckedRadioValue() {
            var inputValue = $('input[type="radio"]:checked').val(); // ใช้ :checked เพื่อหาตัวที่เลือก
            
            var targetBox = $(".in_" + inputValue); // เลือกกล่องที่มีคลาสตามค่าที่เลือก
            $(".box").not(targetBox).hide(); // ซ่อนกล่องที่ไม่ตรงกับค่าที่เลือก
            $(targetBox).show(); // แสดงกล่องที่ตรงกับค่าที่เลือก
        }

        // ใช้ฟังก์ชัน getCheckedRadioValue เมื่อมีการเปลี่ยนแปลงสถานะของ radio
        $('input[type="radio"]').change(function() {
            getCheckedRadioValue(); // เรียกฟังก์ชันที่สร้างขึ้น
        });
    });
</script>