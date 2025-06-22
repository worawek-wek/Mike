<div class="d-flex h5">
    <div class="flex-shrink-0">
        <span class="badge badge-center rounded-pill bg-danger">1</span>
    </div>
    <div class="flex-grow-1 ms-2">
        เลือกวิธีคิดค่าไฟฟ้า
    </div>
</div>
<div class="row g-3">
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="payelectric3">
                <input name="how_to_cal_ele" class="form-check-input" type="radio" value="3" {{ @$how['3'] }}
                    id="payelectric3">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง(คิดขั้นต่ำเป็นจำนวนเงิน)</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="payelectric2">
                <input name="how_to_cal_ele" class="form-check-input" type="radio" value="2" {{ @$how['2'] }}
                    id="payelectric2">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="payelectric1">
                <input name="how_to_cal_ele" class="form-check-input" type="radio" value="1" {{ @$how['1'] }}
                    id="payelectric1">
                <span class="custom-option-header">
                    <span class="h6 mb-0">เหมาจ่ายรายเดือน</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="payelectric4">
                <input name="how_to_cal_ele" class="form-check-input" type="radio" value="4" {{ @$how['4'] }}
                id="payelectric4">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง(คิดขั้นต่ำเป็นยูนิต)</span>
                </span>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-check custom-option custom-option-basic">
            <label class="form-check-label custom-option-content" for="payelectric5">
                <input name="how_to_cal_ele" class="form-check-input" type="radio" value="5" {{ @$how['5'] }}
                id="payelectric5">
                <span class="custom-option-header">
                    <span class="h6 mb-0">คิดตามจริง(บอกส่วนต่างจากราคาขั้นต่ำ)</span>
                </span>
            </label>
        </div>
    </div>
</div>
<div class="d-flex h5 mt-3">
    <div class="flex-shrink-0">
        <span class="badge badge-center rounded-pill bg-danger">2</span>
    </div>
    <div class="flex-grow-1 ms-2">
        กรอกข้อมูลค่าไฟฟ้า
    </div>
</div>
<div class="box in_ele_3">
    <div class="mb-2 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดตามจริง</label>
        <div class="col-8 col-md-8">
            <input class="form-control" name="ele_baht_per_unit_2" type="number" id="html5-text-input" value="{{ @$electric_bill->ele_baht_per_unit }}">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/ยูนิต</label>
    </div>
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">ขั้นต่ำ</label>
        <div class="col-8 col-md-8">
            <input name="minimum_ele_bill" class="form-control" type="number" id="html5-text-input" value="{{ @$electric_bill->minimum_ele_bill }}">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท</label>
    </div>
</div>
<div class="box in_ele_2">
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">คิดตามจริง</label>
        <div class="col-8 col-md-8">
            <input name="ele_baht_per_unit" class="form-control" type="number" value="{{ @$electric_bill->ele_baht_per_unit }}" step="any" id="html5-text-input">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/ยูนิต</label>
    </div>
</div>
<div class="box in_ele_1">
    <div class="mb-4 row gx-2">
        <label for="html5-text-input" class="col-md-2 col-form-label">เหมารายเดือน</label>
        <div class="col-8 col-md-8">
            <input class="form-control" name="ele_monthly_rental" type="number" id="html5-text-input" value="{{ @$electric_bill->ele_monthly_rental }}">
        </div>
        <label for="html5-text-input" class="col-4 col-md-2 col-form-label">บาท/เดือน</label>
    </div>
</div>
<div class="box in_ele_4">
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
<div class="box in_ele_5">
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
<script>
    $(function () {
        function toggleElectricBox(value) {
            $(".box").hide(); // ซ่อนทั้งหมดก่อน
            $(".in_ele_" + value).show(); // แสดงเฉพาะอันที่เลือก
        }

        // เรียกครั้งแรกเมื่อโหลดหน้า
        const selected = $('input[name="how_to_cal_ele"]:checked').val();
        if (selected) {
            toggleElectricBox(selected);
        }

        // เรียกเมื่อมีการเปลี่ยน radio
        $('input[name="how_to_cal_ele"]').on('change', function () {
            const newValue = $(this).val();
            toggleElectricBox(newValue);
        });
    });
</script>
