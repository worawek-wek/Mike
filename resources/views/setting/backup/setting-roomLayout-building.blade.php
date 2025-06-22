
    <div class="accordion mt-3 accordion-bordered" id="accordionStyle1">
        @foreach ($building as $row)
            <div class="accordion-item card">
                <button
                    type="button"
                    class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#accordionStyle{{ $row->id }}-1"
                    aria-expanded="false">
                    <span class="d-flex flex-column">
                        <span style="font-size: medium;font-weight: 430">{{ $row->name }}</span>
                    </span>
                    </button>
              <div id="accordionStyle{{ $row->id }}-1" class="accordion-collapse collapse" data-bs-parent="#accordionStyle1">
                <div class="accordion-body">
                    <div class="text-end">
                        <button type="button" class="btn btn-danger" onclick="deleteBuilding('{{ $row->id }}')">
                            <i class="ti-xs ti ti-minus me-2"></i>ลบตึก</button>
                    </div>
                    <form class="insert_floor">
                        @csrf
                        <input name="ref_building_id" type="hidden" value="{{ $row->id }}" required />
                        <div class="addFloor py-3">
                            <div class="row">
                                <div class="col-sm-3">
                                </div>
                                <div class="col-sm-4">
                                    <input name="name" type="text" class="form-control" placeholder="เพิ่มชั้น" required />
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-light-main me-2">
                                        <i class="ti-xs ti ti-plus me-2"></i>เพิ่มชั้น</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="accordion mt-2 accordion-bordered" id="accordionStyleFloor{{ $row->id }}1">
                        <div id="floor{{ $row->id }}">
                            @include('setting/setting-roomLayout-floor')
                        </div>
                        </div>
                    </div>
                </div>
              </div>
            @endforeach
        </div>
    <script>
        var building = 0;
        function loadFloorData(){
            // alert(page);
            $.ajax({
                type: "GET",
                url: "/setting/room-layout/floor/"+building,
                success: function(data) {
                    $("#floor"+building).html(data);
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

        $('.insert_floor').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            var form = this;
            building = $(this).find('input[name="ref_building_id"]').val();
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มชั้นหรือไม่?',
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
                        url: '/setting/room-layout/floor', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                form.reset();
                                Swal.fire('เพิ่มชั้นเรียบร้อยแล้ว', '', 'success');
                                loadFloorData();
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
        
        function deleteBuilding(idBuilding){
                Swal.fire({
                    title: 'ยืนยันการดำเนินการ?',
                    text: 'คุณต้องการลบตึกหรือไม่?',
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
                            url: '/setting/room-layout/building/'+idBuilding, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                            type: 'DELETE',
                            data: {
                                _token : "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if(response == true){
                                    loadData();
                                    Swal.fire('ลบตึกเรียบร้อยแล้ว', '', 'success');

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
    </script>