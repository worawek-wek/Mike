<style>
    .preview-container img {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 4px;
    }
</style>
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
                    <form class="upload_qr_code" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{ $row->id }}">
                        @csrf
                        <div class="col-sm-3 mt-3 d-flex flex-column align-items-center">
                            <label for="qr_code{{ $row->id }}" class="align-self-start">QR Code</label>
                            <input name="qr_code" type="file" class="form-control mb-2" id="qr_code{{ $row->id }}">
                            
                            <div class="preview-container mb-2 text-center">
                                <img id="preview{{ $row->id }}" src="upload/qr-code/{{ $row->qr_code }}" alt="Preview" style="
                                @if($row->qr_code == '')
                                    display: none;
                                @endif
                                    width:100%; max-width:150px;">
                            </div>

                            <button type="submit" class="btn btn-sm btn-light-main">
                                <i class="ti ti-plus me-1"></i> อัพโหลด
                            </button>
                        </div>
                    </form>
                    <div class="text-end">
                        <button type="button" class="btn btn-danger" onclick="deleteBuilding('{{ $row->id }}')">
                            <i class="ti-xs ti ti-minus me-2"></i>ลบตึก</button>
                    </div>
                    <form class="">
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
        "@foreach ($building as $row)"
            handleFileInput('qr_code{{$row->id}}', 'preview{{$row->id}}');
        "@endforeach"
        function handleFileInput(fileInputId, previewId) {
            const fileInput = document.getElementById(fileInputId);
            const previewImage = document.getElementById(previewId);

            fileInput.addEventListener('change', function () {
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';  // แสดงภาพพรีวิว
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewImage.style.display = 'none'; // ซ่อนพรีวิวถ้าไม่ได้เลือกไฟล์
                }
            });
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
        $('.upload_qr_code').on('submit', function (event) {
            event.preventDefault();

            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการบันทึกการเปลี่ยนแปลง หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                didOpen: () => {
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this); // ใช้ this เพื่ออ้างถึงฟอร์มปัจจุบัน

                    $.ajax({
                        url: '/setting/room-layout/upload_qr_code', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response == true) {
                                Swal.fire('บันทึกเรียบร้อยแล้ว', '', 'success');
                                get_move_out(); // หรือฟังก์ชันอื่นที่คุณใช้
                            }
                        },
                        error: function (error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
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