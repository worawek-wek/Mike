<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />

<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<style>
    /* .select2-container--open {
        z-index: 9999;
    } */
    .swal2-container {
        z-index: 9999 !important;
    }
    .nav-pills .nav-link.active {
        border: 2px solid #007bff;
        border-width: 1px;
        border-style: solid;
    }
    .nav-item .nav-link {
        border: none; /* ป้องกันไม่ให้มีเส้นโดยตรงบน .nav-link */
    }
    .dam {
        color: rgb(23, 23, 23);
        font-weight: 500;
        font-size: medium;
    }
    .dam-l {
        font-size: unset;
        color: rgb(23, 23, 23);
        font-weight: 410;
    }
    .nav-pills {
        --bs-nav-pills-link-active-bg: #ffffff;
    }
</style>
<div class="modal-content rounded-0">
    <div class="modal-header rounded-0">
        <span class="modal-title">
            <span class="h5" style="color: white;">&nbsp;{{ @$room->name }}&nbsp;</span>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="col-md-12" style="padding-right: unset !important;">
        <div class="card shadow-none bg-transparent mb-3">
            <div class="card-body">
                <ul class="nav nav-pills" role="tablist" style="justify-content: space-between;padding: 0 35px;">
                    <li class="nav-item" role="presentation">
                    {{-- <button type="button" class="btn btn-outline-primary">Primary</button> --}}
                      <button class="btn btn-outline-info nav-link active" 
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-edit" aria-controls="navs-pills-top-edit" aria-selected="false" tabindex="-1">
                        <span>
                          <i class="ti ti-users pe-1"></i>
                          <b class="dam">
                            ผู้เช่า
                          </b>
                        </span>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="btn btn-outline-danger nav-link" 
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-contract" aria-controls="navs-pills-top-contract" aria-selected="false" tabindex="-1">
                        <span>
                          <i class="ti ti-vocabulary pe-1"></i>
                          <b class="dam">
                          สัญญาเช่า
                          </b>
                        </span>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="btn btn-outline-primary nav-link" 
                                role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-payment"
                                aria-controls="navs-pills-top-payment"
                                aria-selected="false" tabindex="-1"
                                onclick="get_bill('{{ date('Y-m') }}')"
                                >
                        <span>
                          <i class="ti ti-cash-banknote pe-1"></i>
                          <b class="dam">
                          ชำระเงิน
                          </b>
                        </span>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="btn btn-outline-success nav-link" 
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-assets" aria-controls="navs-pills-top-assets" aria-selected="false" tabindex="-1">
                        <span>
                          <i class="ti ti-building-warehouse pe-1"></i>
                          <b class="dam">
                          รายการทรัพย์สิน
                          </b>
                        </span>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="btn btn-outline-warning nav-link" 
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-MoveOut" aria-controls="navs-pills-top-MoveOut" aria-selected="false" tabindex="-1"
                        onclick="get_move_out()"
                        >
                        <span>
                          <i class="ti ti-door-exit pe-1"></i>
                          <b class="dam">
                          ย้ายออก
                          </b>
                        </span>
                      </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-body" style="padding: 0 3em;">
            <div class="nav-align-top mb-3">
                    <div class="tab-content" style="box-shadow: unset;padding:0px">
                        
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า
ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า ผู้เช่า

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

                      <div class="tab-pane fade active show mb-5" id="navs-pills-top-edit" role="tabpanel">
                        <div class="card shadow-none bg-transparent">
                            <div class="card-body mb-4" style="background-color: #f5f5f5;border-radius: 1em;border: 1.6px solid #b5b5b56b;">
                                <div class="d-flex">
                                    <div class="col-sm-2">
                                        <img src="/main_picture/user-detail.png" width="100%" style="border-radius: 50%;">
                                    </div>
                                    <div class="col-sm-9 px-4">
                                        <b class="dam border-bottom border-light mb-2" style="display: block;">
                                            {{ $room_for_rent->prefix.' '.$room_for_rent->full_name }}
                                        </b>
                                            <b class="dam-l">
                                                เบอร์โทร :
                                            </b>
                                            <span>{{ $room_for_rent->phone }}</span>
                                            <br>
                                            <b class="dam-l">
                                                เลขบัตรประชาชน :
                                            </b>
                                            <span>{{ $room_for_rent->id_card_number }}</span>
                                            
                                                <div class="row mt-3">
                                                    <div class="col-md-4" style="padding-right: unset !important;">
                                                    </div>
                                                    <div class="col-md-4" style="padding-right: 0">
                                                        <select name="change_room" id="change_room" class="select2 form-select form-select-sm" data-style="btn-default" onchange="change_room(this.val)">
                                                                <option value="all">ย้ายห้อง</option>
                                                                @foreach ($otherRooms as $or)
                                                                    <option value="{{ $or->id }}">{{ $or->name }}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 d-flex justify-content-bottom align-items-bottom">
                                                        <div class="text-end">
                                                            <button type="submit" id="change_room_btn" class="btn btn-warning waves-effect waves-light" disabled>ยืนยัน</button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </div>
                            </div>
                            {{-- <button type="button" class="btn btn-success waves-effect waves-light mt-3 m-auto"></button> --}}
                            <button class="btn btn-success waves-effect waves-light mt-3 m-auto"
                                    tabindex="0" aria-controls="DataTables_Table_0"
                                    type="button" aria-haspopup="dialog"
                                    aria-expanded="false" data-bs-toggle="modal" data-bs-target="#addRenter">
                                <span><i class="ti ti-plus"></i> เพิ่มข้อมูลผู้เช่า</span>
                            </button>

                        </div>
                    </div>
                    



{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////

สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า
สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า สัญญาเช่า

//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

                        <div class="tab-pane fade" id="navs-pills-top-contract" role="tabpanel">
                            
                        
                        <form id="form_contract" @if ($room->status == 2) style="display:none;" @endif>
                            @csrf
                            <input type="hidden" name="ref_renter_id" value="{{ $room_for_rent->id }}">
                            <input type="hidden" name="contract[1][ref_room_id]" value="{{ @$room->id }}">
                            <div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;" id="">
                                <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
                                    <i class="tf-icons ti ti-vocabulary text-main" style="font-size: 25px;"></i>
                                    กรุณากรอกรายละเอียดสัญญาเช่า
                                </h5>
                                <div class="row g-2 p-4 pt-1">
                                    <div class="col-sm-12">
                                        <select name="ref_renter_id" id="select2RenterContract2" class="select2 form-select form-select-lg" onchange="get_room_rental_contract(this.value)" required>
                                            <option selected disabled hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                                            @foreach ($renter as $rent)
                                                <option value="{{ $rent->id }}" selected>{{ $rent->prefix.' '.$rent->name.' '.$rent->surname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row col-sm-12 g-2" id="room-form-contract">
                                        @include('room/room-form-contract')
                                    </div>
                                </div>
                            <div class="modal-footer rounded-0 justify-content-center">
                                <button type="button" class="btn btn-label-secondary" onclick="get_contract()">ยกเลิก</button>
                                <button type="submit" class="btn btn-main">บันทึกสัญญา</button>
                            </div>
                            </div>
                        </form>
                        
                        
                        <div class="m-2" id="room-detail-contract"
                            @if ($room->status != 2)
                                style="display:none;"
                            @endif
                        >
                            {{-- @include('room/room-detail-contract') --}}
                        </div>

                      </div>
<script>
    edit_contract();
    function edit_contract(){   // function ดึงข้อมูล แสดง form แก้ไขสัญญา
        $.ajax({
            type: "GET",
            url: "{{ $page_url }}/get-room-form-contract/{{$room->id}}",
            success: function(data) {
                $("#room-form-contract").html(data);

                initContractFormScript();
            }
        });

        $('#form_contract').show(); // ซ่อน Form แก้ไขสัญญา
        $('#room-detail-contract').hide(); // แสดง ข้อมูลสัญญา
    }
    

    if("{{$room->status}}" == 2 ){   // ถ้าทำสัญญาแล้ว ให้เรียกใช้ funtion get_contract()
        get_contract();
    }


    function get_contract(){   // function ดึงข้อมูล แสดง ข้อมูลสัญญา
        $.ajax({
            type: "GET",
            url: "{{ $page_url }}/get-room-detail-contract/{{$room->id}}",
            success: function(data) {
                $("#room-detail-contract").html(data);
            }
        });

        $('#form_contract').hide(); // ซ่อน Form แก้ไขสัญญา
        $('#room-detail-contract').show(); // แสดง ข้อมูลสัญญา
    }
    
    document.getElementById('add_expenses').addEventListener('click', function() {
        var newExpense = document.getElementById('new-expense-template').cloneNode(true);
        newExpense.style.display = 'block';
        newExpense.removeAttribute('id');
        document.getElementById('expenses-list').appendChild(newExpense);
        newExpense.querySelector('.remove-expense').addEventListener('click', function() {
            newExpense.remove();
        });
    });
</script>




{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน
ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน ชำระเงิน

////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
                          
                      <div class="tab-pane fade" id="navs-pills-top-payment" role="tabpanel">
                            <label class="mb-1">เลือกบิลย้อนหลัง</label>
                            <select name="month" id="select2month" class="select2 form-select form-select-lg" onchange="get_bill(this.value)" required>
                                <option value="2025-6">{{ $month_thai[5] }} 2025</option>
                                <option value="2025-5">{{ $month_thai[4] }} 2025</option>
                                <option value="2025-4">{{ $month_thai[3] }} 2025</option>
                            </select>
                        <div id="bill">
                            
                        </div>
                    </div>


{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน
รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน รายการทรัพย์สิน

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

                        <div class="tab-pane fade mb-5 px-5" id="navs-pills-top-assets" role="tabpanel">
                          {{-- <label class="mb-2" style="font-weight: 500;font-size: large;color:black;margin-left:30px;" for="">รายการทรัพย์สินทั้งหมด</label> --}}
                              <table class="table table-detail table-bordered">
                                  <thead>
                                      <tr>
                                          <th style="vertical-align: middle;font-weight: 500;">รายการ</th>
                                          <th style="vertical-align: middle;font-weight: 500;">ค่าปรับ</th>
                                          <th width="30%" style="vertical-align: middle;font-weight: 500;">สถานะ</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($asset as $asset_v)
                                      <tr>
                                          <td> {{ $asset_v->name }} </td>
                                          <td> {{number_format($asset_v->fine)}} </td>
                                          <td>
                                            @if (@$asset_has_room[$asset_v->id] == 1) {{-- ถ้า status = 1 ให้แสดงว่ามี --}}
                                                <span class="text-success">
                                                    <i class="ti ti-checkbox"></i>
                                                    มี
                                                </span>
                                            @endif
                                            <a href="javascript:void(0);" onclick="getDetailAsset({{ @$room->id}},{{$asset_v->id}})"><span class="badge bg-label-dark">ตั้งค่าข้อมูล</span></a>
                                          </td>
                                      </tr>
                                    @endforeach
                                      {{-- <tr>
                                          <td>ตู้เย็น</td>
                                          <td> {{number_format(2000)}} </td>
                                          <td>
                                            <span class="text-success">
                                                <i class="ti ti-checkbox"></i>
                                                มี
                                            </span>
                                          </td>
                                      </tr> --}}
                                  </tbody>
                              </table>
                              
                              
                          </div>


{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก
ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

                            <div class="tab-pane fade" id="navs-pills-top-MoveOut" role="tabpanel">
                                @include('room/move-out')
                            </div>
                        </div>
                    </div>
                </div>
                
        </div>
        
    </div>
      
<script>
    get_bill("{{date('Y-m')}}");
    function editAssetModal(){
            var myModal = new bootstrap.Modal(document.getElementById('editAssetModal'));
                myModal.show();
        }
    // get_bill()
    function get_bill(month){
        $.ajax({
            type: "GET",
            url: "{{ $page_url }}/get-bill/{{$room->id}}/"+month,
            success: function(data) {
                $("#bill").html(data);
            }
        });
    }
    function get_move_out(){
        $.ajax({
            type: "GET",
            url: "{{ $page_url }}/get-move-out/{{$room->id}}",
            success: function(data) {
                $("#navs-pills-top-MoveOut").html(data);
                
                new TomSelect("#select-renter", {
                    create: false,      // ไม่ให้พิมพ์เพิ่มเอง
                    maxItems: 1,        // จำกัดให้เลือกได้ 1 ค่า
                    allowEmptyOption: true, // แสดง option แรกที่ไม่มีค่า (เช่น "-- กรุณาเลือก --")
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            }
        });
    }
    $('#pay2').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ หักจากเงินประกัน หรือไม่?',
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
                Swal.fire('หักจากเงินประกันเรียบร้อยแล้ว', '', 'success');

                // if (result.isConfirmed) {
                //     $.ajax({
                //         url: '{{$page_url}}/{{$room->id}}', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                //         type: 'POST',
                //         data: $(this).serialize(),
                //         success: function(response) {
                //             if(response == true){
                //                 Swal.fire('แก้ไขพนักงานเรียบร้อยแล้ว', '', 'success');
                //                 loadData(page);
                //                 view('{{$room->id}}');
                //             }
                //         },
                //         error: function(error) {
                //             Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                //             console.error('เกิดข้อผิดพลาด:', error);
                //         }
                //     });
                // } else if (result.isDismissed) {
                //     // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                // }
            });
        });
    $('#edit_user').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ แก้ไข พนักงาน หรือไม่?',
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
                        url: '{{$page_url}}/{{$room->id}}', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                Swal.fire('แก้ไขพนักงานเรียบร้อยแล้ว', '', 'success');
                                loadData(page);
                                view('{{$room->id}}');
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
        $('#formAssetModal').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ แก้ไข ทรัพย์สิน หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                showDenyButton: false,
                didOpen: () => {
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // ใช้ FormData แทน serialize เพื่อส่งไฟล์ได้
                    let form = document.getElementById('formAssetModal');
                    let formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                    $.ajax({
                        url: '{{$page_url}}/asset/update_asset',
                        type: 'POST',
                        data: formData,
                        contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                        processData: false,
                        success: function(response) {
                            if (response == true) {
                                var modalEl = document.getElementById('editAssetModal');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                loadData(page);
                                view('{{$room->id}}');
                                Swal.fire('แก้ไข ทรัพย์สิน เรียบร้อยแล้ว', '', 'success').then((result) => {
                                    if (result.isConfirmed) {
                                        // สั่งให้เปิด Tap รายการทรัพย์สิน
                                        const targetTab = document.querySelector('button[data-bs-target="#navs-pills-top-assets"]');
                                        if (targetTab) {
                                            const tab = new bootstrap.Tab(targetTab);
                                            tab.show();
                                        }
                                    }
                                });

                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                }
            });
        });

    $('#change_room_btn').on('click', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            var room_name = $("#change_room option:selected").text();
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                html: 'คุณต้องการย้ายไปห้อง &nbsp;<span class="text-success">'+room_name+'</span> &nbsp;หรือไม่?',
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
                        url: '/room/change_room/{{$room->id}}/'+$("#change_room").val(), // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response == true){
                                loadData(page);
                                Swal.fire('ย้ายห้องเรียบร้อยแล้ว', '', 'success')
                                view($("#change_room").val())
                                // $('#room-rental-contract').html('');
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
        $('#period, #contract_date').on('input', function() {
            var contractDate = $('#contract_date').val();
            var period = $('#period').val();

            // ตรวจสอบว่า contractDate และ period มีค่าหรือไม่
            if (contractDate && period && !isNaN(period)) {
                var dateParts = contractDate.split('/');
                var day = dateParts[0];
                var month = dateParts[1];
                var year = dateParts[2];

                // สร้างวันในรูปแบบปี, เดือน, วัน
                var date = new Date(year, month - 1, day);

                // เพิ่มเดือนตาม period ที่ใส่
                date.setMonth(date.getMonth() + parseInt(period));

                // แปลงวันที่กลับเป็นรูปแบบ day/month/year
                var newDate = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear();

                // ใส่วันที่ที่คำนวณในฟิลด์ contract_date_to
                $('#contract_date_to').val(newDate);
            }
        });
        $('#form_contract').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            let url = "/room/insert_contract";
            
            if("{{$room->status}}" == 2 ){   // ถ้าทำสัญญาแล้ว ให้เรียกใช้ funtion get_contract()
                
                url = "/room/update_contract/{{ @$contract->id }}";
                
            }
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่ม สัญญา หรือไม่?',
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
                        url: url, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if("{{$room->status}}" != 2 ){   // ถ้าทำสัญญาแล้ว ให้เรียกใช้ funtion get_contract()
                                openDe(response.rent_bill_id,response.contract_id);
                            }
                            // $('#form_contract')[0].reset();
                            loadData(page);
                            summary();
                            Swal.fire('เพิ่มสัญญาเรียบร้อยแล้ว', '', 'success').then((result) => {
                                // location.reload();
                                get_contract();

                            });
                                
                                // $('#room-rental-contract').html('');
                            // }
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
        function change_room(){
            $('#change_room_btn').prop('disabled', false);
        }
        $(document).ready(function() {
            // $('#change_room').select2({
            //     placeholder: 'เลือกห้อง',
            //     dropdownParent: $('#insurance'),
            //     allowClear: true
            // });
        });
        $('#bs-datepicker-format2').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
            autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
            todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
        });
        $('#bs-datepicker-basic').datepicker({
            format: 'mm/dd/yyyy', // Set the date format
            autoclose: true        // Close the datepicker when a date is selected
        });
        $('#select2month').select2();
        // $('#select2RenterDetail').select2();
        $('#select2RenterContract').select2();
        $('#select2RenterContract2').select2();

</script>