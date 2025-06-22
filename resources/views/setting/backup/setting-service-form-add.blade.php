<div class="row g-3">
    <div class="col-sm-12">
        <label for="exampleFormControlInput1" class="form-label">เลือกบริการ</label>
        <div class="row g-3">
            
            @foreach ($service as $item)
                <div class="col-sm-4" id="service{{$item->id}}">
                    <div class="form-check custom-option custom-option-basic">
                        <label class="p-2 px-3" for="customRadioTemp1">
                            {{-- <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                id="customRadioTemp1" checked=""> --}}
                                {{-- @if ($item->id == 1)
                                    <input type="text" class="form-control" value="{{ $item->name }}">
                                    <input type="text" class="form-control mt-1" value="100">
                                    <button type="button" id="updateRoom{{ $item->id }}" class="btn btn-success mt-1" disabled onclick="updateItem('{{ $item->id }}')" align="rigth">
                                        <i class="ti-xs ti ti-pencil me-2"></i>บันทึก
                                    </button>
                                @else
                                <span class="custom-option-header">
                                    <span class="h6 mb-0">{{ $item->name }} <i class="ti ti-pencil text-warning"></i> <i class="ti ti-trash me-1 text-danger"></i></span>
                                </span>
                                @endif --}}
                                <span class="custom-option-header">
                                    <span class="h6 mb-0" id="itemName{{ $item->id }}">
                                        {{ $item->name }} 
                                        <a href="javascript:void(0)"><i class="ti ti-pencil text-warning" onclick="editService('{{ $item->id }}')"></i></a>
                                        <a href="javascript:void(0)"><i class="ti ti-trash me-1 text-danger" onclick="deleteService('{{ $item->id }}')"></i></a>
                                        <br>
                                        <span class="text-danger">
                                            {{ $item->price }} 
                                        </span>
                                    </span>
                                </span>
                                
                                <!-- Hidden input fields that will be displayed when editing -->
                                <div id="editForm{{ $item->id }}" style="display:none;">
                                    <input type="text" name="remark" class="form-control" id="nameInput{{ $item->id }}" value="{{ $item->name }}" required>
                                    <input type="number" name="remark" class="form-control mt-1" id="priceInput{{ $item->id }}" value="{{ $item->price }}" required>
                                    <button type="button" id="updateRoom{{ $item->id }}" class="btn btn-success mt-1" onclick="updateService('{{ $item->id }}')" align="right">
                                        บันทึก
                                    </button>
                                    <button type="button" class="btn btn-secondary mt-1" onclick="cancleEditService('{{ $item->id }}')" align="rigth">
                                        ยกเลิก
                                    </button>
                                </div>
                            
                        </label>
                    </div>
                </div>
            @endforeach
{{-- 
            <div class="col-sm-4">
                <div class="form-check custom-option custom-option-basic">
                    <label class="form-check-label custom-option-content" for="customRadioTemp2">
                        <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                            id="customRadioTemp2">
                        <span class="custom-option-header">
                            <span class="h6 mb-0">ค่าที่จอดรถ</span>
                        </span>
                        <!-- <span class="custom-option-body">
                            <small>Get 1 project with 1 teams members.</small>
                        </span> -->
                    </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check custom-option custom-option-basic">
                    <label class="form-check-label custom-option-content" for="customRadioTemp3">
                        <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                            id="customRadioTemp3">
                        <span class="custom-option-header">
                            <span class="h6 mb-0">ค่าอินเตอร์เน็ต</span>
                        </span>
                        <!-- <span class="custom-option-body">
                            <small>Get 1 project with 1 teams members.</small>
                        </span> -->
                    </label>
                </div>
            </div> --}}

        </div>
    </div>
    <div class="col-sm-6">
        <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ</label>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" required/>
    </div>
    <div class="col-sm-6">
        <label for="exampleFormControlInput1" class="form-label">ค่าบริการ</label>
        <input type="text" name="price" class="form-control" id="exampleFormControlInput1" placeholder="" required/>
    </div>
</div>
<script>
    function editService(itemId) {
        // ซ่อนชื่อที่แสดงและไอคอน
        document.getElementById('itemName' + itemId).style.display = 'none';
        
        // แสดง input fields และปุ่มบันทึก
        document.getElementById('editForm' + itemId).style.display = 'block';
    }
    function cancleEditService(itemId) {
        // ซ่อนชื่อที่แสดงและไอคอน
        document.getElementById('itemName' + itemId).style.display = 'block';
        
        // แสดง input fields และปุ่มบันทึก
        document.getElementById('editForm' + itemId).style.display = 'none';
    }

    function updateService(itemId) {
        // ดึงค่าจาก input
        const nameValue = document.getElementById('nameInput' + itemId).value;
        const priceValue = document.getElementById('priceInput' + itemId).value;
        
        Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการแก้ไขค่าบริการหรือไม่?',
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
                        url: 'setting/service/update/'+itemId, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: nameValue,
                            price: priceValue
                        },
                        success: function(response) {
                            if(response == true){
                                Swal.fire('แก้ไขค่าบริการเรียบร้อยแล้ว', '', 'success');
                                $('#setElectricModal').modal('hide');
                                loadData(page);
                                getService();
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
        // ส่งข้อมูลไปที่ backend หรือจัดการตามที่ต้องการ (อาจจะใช้ AJAX หรือการ submit ฟอร์ม)
    }
    function deleteService(itemId) {
        // ดึงค่าจาก input
        Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการลบค่าบริการหรือไม่?',
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
                        url: 'setting/service/delete/'+itemId, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response == true){
                                Swal.fire('ลบค่าบริการเรียบร้อยแล้ว', '', 'success');
                                $('#setElectricModal').modal('hide');
                                loadData(page);
                                getService();
                                // $('#service'+itemId).remove();
                                // หลังจากบันทึก, ซ่อน input และแสดงชื่อใหม่
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
        // ส่งข้อมูลไปที่ backend หรือจัดการตามที่ต้องการ (อาจจะใช้ AJAX หรือการ submit ฟอร์ม)
    }
</script>