<form class="upload_qr_code h4 mt-5" enctype="multipart/form-data">
    {{-- <input type="hidden" name="id" value="{{ $row->id }}"> --}}
    @csrf
    <div class="col-sm-3 mt-3 d-flex flex-column align-items-center">
        <label for="qr_code" class="align-self-start">QR Code <span class="text-danger"> *</span></label>
        <input name="qr_code" type="file" class="form-control mb-2" id="qr_code" accept="image/*" required>
        
        <div class="preview-container mb-2 text-center">
            <img id="preview" src="upload/qr-code/" alt="Preview" style=" display: none; width:100%; max-width:150px;">
        </div>

        <button type="submit" class="btn btn-sm btn-light-main">
            <i class="ti ti-plus me-1"></i> อัพโหลด
        </button>
    </div>
</form>
<form class="update_qr_code">
    @csrf
<div class="row mt-4">
        @forelse ($qr_code as $row)
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3">
                    <img class="card-img-top" src="upload/qr-code/{{ $row->qr_code }}" alt="Card image cap" style="padding: 5% 30%;"/>
                    <div class="card-body">
                    
                    <p class="card-text">
                        @foreach ($building as $build)
                            <!-- ตึกคุณแบม -->
                                    <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
                                        <label class="mb-0">
                                            <h5 class="card-title">{{ $build->name }}</h5>
                                        </label>
                                        @if (count($build->floor) > 0)
                                            <label for="building-{{ $build->id }}{{ $row->id }}" class="form-check-label d-flex align-items-center mb-0">
                                                <input
                                                    id="building-{{ $build->id }}{{ $row->id }}"
                                                    class="form-check-input room-selected me-2"
                                                    type="checkbox"
                                                    onchange="room_in_building_selected('building-{{ $build->id }}{{ $row->id }}','floors-{{$build->id}}')">
                                                <span class="h6 mb-0">เลือกทั้งตึก</span>
                                            </label>
                                        @endif
                                    </div>
                                    <div class="py-3 border-bottom">
                                        @foreach ($build->floor as $floor)
                                            <label class="form-check-label ms-2">
                                                <span class="d-flex flex-column align-items-center">
                                                    <input name="floor[{{ $floor->id }}]" 
                                                            value="{{ $row->qr_code }}" 
                                                            class="form-check-input room-selected building-{{ $build->id }}{{ $row->id }} floors{{ $floor->id }} floors-{{$build->id}}" 
                                                            type="checkbox" 
                                                            id="{{ $floor->id }}"
                                                    @checked($floor->qr_code == $row->qr_code)
                                                    onchange="uncheckOtherFloors(this,'{{$floor->id}}')">
                                                    <span class="my-2" style="font-size: medium;font-weight: 430">{{ $floor->name }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                            @endforeach
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text mb-0">
                            <small class="text-muted">เลือกชั้นที่ใช้ QR Code นี้</small>
                        </p>
                        <button type="button" class="btn btn-danger" onclick="deleteQrCode('{{ $row->id }}')">
                            <i class="fa fa-trash me-2"></i>ลบ
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        
        @empty
            <div>
                <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; height: 300px; text-align: center;">
                    <i class="ti ti-file-search" style="font-size: 24px; margin-bottom: 8px;"></i>
                    <span style="font-size: 14px; color: #888;">ไม่พบข้อมูล</span>
                </div>
            </div>
        @endforelse
        
        <button type="submit" class="btn btn-sm btn-light-main">
            <i class="ti-xs ti ti-pencil me-2"></i> บันทึกการเปลี่ยนแปลง
        </button>
</div>
    </form>
<script>
        function room_in_building_selected(buildingClass, floorClass) {
            const buildingCheckbox = document.getElementById(buildingClass);
            if (!buildingCheckbox) {
                console.warn(`ไม่พบ element id=${buildingClass}`);
                return;
            }

            const isChecked = buildingCheckbox.checked;

            // ถ้าเช็ค checkbox "เลือกทั้งตึก" → uncheck ชั้นทั้งหมดใน floorClass
            if (isChecked) {
                document.querySelectorAll(`.${floorClass}`).forEach(cb => {
                    cb.checked = false;
                });
            }

            // ตั้งค่าทุก checkbox ของตึกนี้ (buildingClass)
            document.querySelectorAll(`.${buildingClass}`).forEach(cb => {
                cb.checked = isChecked;
            });
        }

        function uncheckOtherFloors(checkbox, id) {
            if (checkbox.checked) {
                // Uncheck checkbox ที่มี class floors{id} แต่ไม่ใช่ตัวเอง
                document.querySelectorAll('.floors' + id).forEach(function (el) {
                    if (el !== checkbox) {
                        el.checked = false;
                    }
                });
            }

            // ✅ Sync สถานะ checkbox "เลือกทั้งตึก"
            const buildingClass = Array.from(checkbox.classList).find(cls => cls.startsWith('building-'));
            if (buildingClass) {
                const buildingCheckboxId = buildingClass; // เช่น 'building-13'
                const all = document.querySelectorAll(`.${buildingClass}`);
                const allChecked = Array.from(all).every(cb => cb.checked);

                const buildingCheckbox = document.getElementById(buildingCheckboxId);
                if (buildingCheckbox) {
                    buildingCheckbox.checked = allChecked;
                }
            }
        }
        handleFileInput('qr_code', 'preview');
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
        function selectFloor(){

        }
        
        function deleteQrCode(id){
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'Qr Code จะถูกลบออก?',
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
                        type: "DELETE",
                        url: "/setting/room-layout/delete_qr_code/"+id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if(response == true){
                                Swal.fire('ลบ Qr Code เรียบร้อยแล้ว', '', 'success');
                                QRCode();
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
                                QRCode();
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
                }
            });
        });
        $('.update_qr_code').on('submit', function (event) {
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
                    $.ajax({
                        url: '/setting/room-layout/update_qr_code', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            if (response == true) {
                                Swal.fire('บันทึกเรียบร้อยแล้ว', '', 'success');
                                QRCode();
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
</script>