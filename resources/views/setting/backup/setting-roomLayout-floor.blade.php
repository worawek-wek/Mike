

@foreach ($row['floor'] as $floor)
<div class="accordion-item card" id="idFloor{{ $floor->id }}">
<button
    type="button"
    class="accordion-button collapsed"
    data-bs-toggle="collapse"
    data-bs-target="#accordionStyleFloor{{ $floor->id }}-1"
    aria-expanded="false">
        <span class="d-flex flex-column">
            <span class="me-2" style="font-size: medium;font-weight: 430">{{ $floor->name }}</span>
        </span>
        </button>
        <div id="accordionStyleFloor{{ $floor->id }}-1" class="accordion-collapse collapse" data-bs-parent="#accordionStyleFloor{{ $floor->id }}1">
            <div class="accordion-body">
                    
            <div class="floor">
                <div class="text-end">
                    
                    <button type="button" class="btn btn-danger" onclick="deleteFloor('{{ $floor->id }}','{{ $floor->ref_building_id }}')">
                        <i class="ti-xs ti ti-minus me-2"></i>ลบชั้น</button>
                </div>
                
                <form class="insert_room">
                    @csrf
                    <input name="ref_floor_id" type="hidden" value="{{ $floor->id }}" required />
                    <div class="py-3">
                        <div class="row">
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-4">
                                <input name="name" type="text" class="form-control" placeholder="เพิ่มห้อง" required />
                            </div>
                            <div class="col-sm-4 text-start">
                            <button type="submit" class="btn btn-light-main me-2">
                                    <i class="ti-xs ti ti-plus me-2"></i>เพิ่มห้อง</button>
                                    
                            <button type="button" id="updateRoomAll" class="btn btn-success" onclick="updateRoom()">
                                <i class="ti-xs ti ti-pencil me-2"></i>บันทึกการแก้ไข
                            </button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div id="table_room{{ $floor->id }}" class="mt-2">
                    @include('setting/setting-roomLayout-room')
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
    var floor = 0;
    function loadRoomData(){
        // alert(page);
        $.ajax({
            type: "GET",
            url: "/setting/room-layout/room/"+floor,
            success: function(data) {
                $("#table_room"+floor).html(data);
            }
        });
        // alert(page);
    }
        function deleteFloor(idFloor, idBuilding){
                building = idBuilding;
                Swal.fire({
                    title: 'ยืนยันการดำเนินการ?',
                    text: 'คุณต้องการลบชั้นหรือไม่?',
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
                            url: '/setting/room-layout/floor/'+idFloor, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                            type: 'DELETE',
                            data: {
                                _token : "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if(response == true){
                                    loadFloorData();
                                    Swal.fire('ลบชั้นเรียบร้อยแล้ว', '', 'success');

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
        }
    $('.insert_room').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            var form = this;
            floor = $(this).find('input[name="ref_floor_id"]').val();
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มห้องหรือไม่?',
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
                        url: '/setting/room-layout/room', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                form.reset();
                                Swal.fire('เพิ่มห้องเรียบร้อยแล้ว', '', 'success');
                                loadRoomData();
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
</script>
