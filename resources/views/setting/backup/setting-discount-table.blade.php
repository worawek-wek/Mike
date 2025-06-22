@foreach ($building as $build)
<h4 class="mb-0">{{ $build->name }}</h4>
@foreach ($build['floor'] as $floor)
    
<div class="card shadow-none border-bottom rounded-0">
    <div class="card-header px-0 px-md-4">
        <div
            class="d-flex justify-content-between align-items-center flex-md-row flex-column">
            <h4 class="mb-0">{{ $floor->name }}</h4>
            <div>
                {{-- <button type="button"
                    class="btn btn-light-main">เลือกทั้งชั้น</button> --}}
                    <button class="edit-rent-d btn btn-main waves-effect waves-light me-md-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#editdiscountModal" onclick="view_discount('all')" disabled>
                        <i class="ti ti-plus ti-xs"></i>เพิ่มส่วนลดหลายห้อง
                    </button>
                    <button type="button" class="edit-rent-d btn btn-danger waves-effect waves-light me-md-2 mb-2 mb-md-0"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteDiscountModal"
                            onclick="deleteDiscount_d()"
                            disabled>
                        <i class="ti ti-trash ti-xs"></i>ลบส่วนลดหลายห้อง
                    </button>
                    
                <button type="button" class="btn btn-label-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#editDiscountModal"
                    onclick="getDiscount()"
                    >กำหนดส่วนลด</button>
            </div>
        </div>
    </div>
    
    <div class="card-body px-0 px-md-4">
        <div class="row g-3">
            {{-- ///////////////////////////////////////////// --}}
            @foreach ($floor['room'] as $room)
                <div class="col-md-6 col-lg-3">
                    <div class="card bg-lightGray card-check card-selected check-container"
                        id="card-d-{{ $room->id }}"
                        onclick="toggleDiscountCheckbox({{ $room->id }}, event)">
                        <div class="card-body text-center">
                            <input class="form-check-input ids_discount" type="checkbox" value="{{ $room->id }}" id="room-d-{{ $room->id }}" onchange="toggleDiscountCheckbox({{ $room->id }}, event)">
                            <h5 class="card-title">{{ $room->name }}</h5>
                            <ul class="list-group list-group-flush mb-2">
                                @foreach ($room['room_has_discount'] as $room_has_discount)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                        <span><i class="ti ti-checkbox ti-xs text-main me-2"></i>{{ $room_has_discount->discount->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- ปุ่มนี้จะไม่ทำให้ checkbox เปลี่ยนสถานะ -->
                            <button type="button"
                                class="btn btn-main btn-sm rounded-2"
                                data-bs-toggle="modal"
                                data-bs-target="#editdiscountModal"
                                onclick="view_discount({{ $room->id }}); event.stopPropagation();">
                                <i class="ti ti-plus ti-xs"></i> เพิ่มส่วนลด
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- ////////////////////////////////////////// --}}
        </div>
    </div>
</div>
<style>
    .bg-d-selected {
        background-color: #f5ecd1 !important; /* สีเขียวเมื่อเลือก */
    }
    .check-container {
        cursor: pointer; /* ทำให้รู้ว่าสามารถคลิกได้ */
    }
</style>
<script>
    function toggleDiscountCheckbox(roomId, event) {
        // ถ้าคลิกมาจากปุ่ม ให้หยุดการทำงานที่นี่เลย
        if (event.target.closest("button")) {
            return;
        }

        let checkbox = document.getElementById(`room-d-${roomId}`);
        let card = document.getElementById(`card-d-${roomId}`);

        checkbox.checked = !checkbox.checked; // Toggle ค่า checked

        if (checkbox.checked) {
            card.classList.add("bg-d-selected"); // เพิ่มคลาสเมื่อ checked
        } else {
            card.classList.remove("bg-d-selected"); // ลบคลาสเมื่อ unchecked
        }

        toggleDiscountButtonState(); // เรียกฟังก์ชันเดิมเพื่ออัปเดต UI
    }

    function toggleDiscountButtonState() {
        // ตรวจสอบว่า checkbox ทั้งหมดมีการติ๊กหรือไม่
        const checkboxes = document.querySelectorAll('.ids_discount');
        const buttons = document.querySelectorAll('.edit-rent-d');
        
        // ถ้ามี checkbox อย่างน้อยหนึ่งตัวที่ถูกติ๊ก ให้เปิดปุ่ม
        const isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        
        // เปิดหรือปิดปุ่มตามสถานะ
        buttons.forEach(button => {
            if (isAnyChecked) {
                button.disabled = false; // เปิดปุ่ม
            } else {
                button.disabled = true; // ปิดปุ่ม
            }
        });
    }

</script>
@endforeach
@endforeach