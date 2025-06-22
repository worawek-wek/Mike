<div class="row g-3 mb-5">
    <div class="col-sm-12">
        <label for="defaultSelect" class="form-label">รูปแบบการคิดค่าปรับ</label>
        <select id="defaultSelect" name="fine_type" class="form-select">
            <option value="1">อัตราคงที่</option>
        </select>
    </div>
    <div class="col-sm-10 col-8">
        <label for="defaultSelect" class="form-label">กำหนดค่าปรับรายวัน</label>
        <input type="text" name="fine_day" class="form-control" value="{{ @$fine->fine_day }}">
    </div>
    <div class="col-sm-2 col-4">
        <label for="defaultSelect" class="form-label">&nbsp;</label>
        <input type="text" readonly="" class="form-control-plaintext" value="บาท/วัน">
    </div>
    {{-- <div class="col-sm-4 col-8">
        <label for="defaultSelect" class="form-label">มากกว่า</label>
        <input type="text" name="after_fine_day" class="form-control" value="{{ @$fine->after_fine_day }}">
    </div>
    <div class="col-sm-2 col-4">
        <label for="defaultSelect" class="form-label">&nbsp;</label>
        <input type="text" readonly="" class="form-control-plaintext" value="วัน">
    </div> --}}
    <div class="col-sm-4 col-8">
        <label for="defaultSelect" class="form-label">มีค่าปรับสูงสุด</label>
        <input type="text" name="maximum_fine" class="form-control" value="{{ @$fine->maximum_fine }}">
    </div>
    <div class="col-sm-2 col-4">
        <label for="defaultSelect" class="form-label">&nbsp;</label>
        <input type="text" readonly="" class="form-control-plaintext" value="บาท/เดือน">
    </div>
    <div class="col-sm-10 col-8">
        <label for="defaultSelect" class="form-label">วันที่เริ่มคิดค่าปรับ</label>
        <select id="defaultSelect" name="start_fine_day" class="form-select">
            @for ($i = 1; $i <= 31; $i++)
                <option value="{{ $i }}"
                @if (@$fine->start_fine_day == $i)
                    selected
                @endif>
                วันที่ {{ $i }}</option>                
            @endfor
        </select>
    </div>
    <div class="col-sm-2 col-4">
        <label for="defaultSelect" class="form-label">&nbsp;</label>
        <input type="text" readonly="" class="form-control-plaintext" value="ของเดือน">
    </div>
</div>
<div class="alert alert-success text-black">
    <div class="d-flex">
        <div class="flex-shrink-0">
            <i class="ti ti-info-circle text-main ti-md"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            ยอดของการคิดค่าปรับแบบอัตโนมัติจะถูกนำไปเป็นหนี้ค้างชำระในเดือนถัดไป<br>
            **หากไม่กำหนดค่าปรับสูงสุด ระบบจะทำการคิดค่าปรับสูงสุดตามจำนวนวันของเดือนนั้นๆ เช่น
            เดือน มกราคม กำหนดค่าปรับวันละ 100 บาท ค่าปรับสูงสุดจะเท่ากับ 3100 บาท<br>
            ***การคิดค่าปรับจะคำนวณยอดออกมาเป็นเดือนต่อเดือนเท่านั้น เช่น
            หากผู้เช่ามียอดค้างชำระในเดือนมกราคม และกุมภาพันธ์
            ยอดชำระของเดือนมีนาคมจะมีเพียงแค่ค่าปรับจากเดือนกุมภาพันธ์เท่านั้น
            ส่วนค่าปรับของเดือนมกราคม จะอยู่ในบิลของเดือนกุมภาพันธ
        </div>
    </div>
</div>
    
{{--     
    
    <table class="table table-bordered">
        <thead>
            <tr class="table-warning">
                <th>รายการ</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ค่าเช่าห้อง (บาท/เดือน)</td>
                <td><input name="rent" type="number" class="form-control form-control-sm bg-lightGray" min="0"
                        value="{{ @$room_rent->rent }}" oninput="updateTotal()"></td>
            </tr>
            <tr>
                <td>ค่าเช่าเฟอร์นิเจอร์ (บาท/เดือน)</td>
                <td><input name="furniture_rental" type="number" class="form-control form-control-sm bg-lightGray" min="0"
                        value="{{ @$room_rent->furniture_rental }}" oninput="updateTotal()"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>รวม</th>
                <th class="text-end">
                    <h4 class="text-main mb-0 fw-bold" id="total"></h4>
                </th>
            </tr>
        </tfoot>
    </table>
    <script>
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', updateTotal);
        });
    
        function updateTotal() {
            const rent = parseFloat(document.querySelector('input[name="rent"]').value) || 0;
            const furniture_rental = parseFloat(document.querySelector('input[name="furniture_rental"]').value) || 0;
            const total = rent + furniture_rental;
    
            // ใช้ toLocaleString() เพื่อแสดงผลในรูปแบบที่มีการใส่เครื่องหมาย , (comma)
            const formattedTotal = total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    
            // อัปเดตผลลัพธ์ในหน้า HTML
            document.querySelector('#total').textContent = formattedTotal;
        }
    
        // เรียกใช้ฟังก์ชันครั้งแรกเพื่อให้แสดงผลยอดรวมทันที
        updateTotal();
    </script> --}}
    