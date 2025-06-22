
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
            <tr>
                <td>ค่าเช่าแอร์ (บาท/เดือน)</td>
                <td><input name="air_rental" type="number" class="form-control form-control-sm bg-lightGray" min="0"
                        value="{{ @$room_rent->air_rental }}" oninput="updateTotal()"></td>
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
            const air_rental = parseFloat(document.querySelector('input[name="air_rental"]').value) || 0;
            const total = rent + furniture_rental + air_rental;
    
            // ใช้ toLocaleString() เพื่อแสดงผลในรูปแบบที่มีการใส่เครื่องหมาย , (comma)
            const formattedTotal = total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    
            // อัปเดตผลลัพธ์ในหน้า HTML
            document.querySelector('#total').textContent = formattedTotal;
        }
    
        // เรียกใช้ฟังก์ชันครั้งแรกเพื่อให้แสดงผลยอดรวมทันที
        updateTotal();
    </script>
    