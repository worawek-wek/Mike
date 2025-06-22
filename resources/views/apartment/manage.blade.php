<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template">
  <head>
    @include('layout/inc_header')
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />
  </head>

  <style>
    .table th {
        font-size: 15px;
        font-weight: bold;
    }
    .table td {
        padding-top: 14px;
        padding-bottom: 14px;
    }
    .modalHeadDecor .modal-header {
        padding: 0;
    }
    
    .modalHeadDecor .modal-title {
        padding: 1.25rem 1.5rem 1.25rem;
        color: white;
        background-color: #54BAB9;
        position: relative;
    }
    
    .modalHeadDecor .modal-title::after {
        position: absolute;
        top: 0;
        right: -65px;
        content: '';
        width: 0;
        height: 0;
        border-top: 65px solid #54BAB9;
        border-right: 65px solid transparent;
    }
    </style>
  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="col-9">
          <!-- Login -->
          <div class="card">
            <div class="px-4">
              <!-- Logo -->
                <div class="card-header border-bottom border-light">
                  <div class="row justify-content-between">
                    <div class="col-sm-12">
                      <div class="app-brand">
                      <img src="{{url('')}}/assets/img/illustrations/main.png" alt="" style="margin: auto;">
                    </div>
                  </div>
                      <div class="col-sm-6 mb-4">
                          <h4 class="">
                              {{ $apartment->name }}
                          </h4>
                      </div>
                      <div class="col-sm-6 text-end">
                          <button type="button" class="btn btn-main waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0"
                          type="button" aria-haspopup="dialog"
                          aria-expanded="false" data-bs-toggle="modal" data-bs-target="#addserviceModal">
                            <i class="ti-xs ti ti-plus me-2"></i>เพิ่มสาขาใหม่</button>
                      </div>
                      @foreach ($branch as $row)
                          
                      <div class="col-sm-6 mb-4">
                        <div class="card" style="border: 1px solid #d6d6d6;">
                          <div class="py-3 pt-4 justify-content-between" style="background-color: #fff5eb;border-bottom: 1px solid #d6d6d6;">
                            <h4 class="card-title m-0 me-2 text-center">{{ $row->name }}</h4>
                          </div>
                          <div class="row px-5 py-4">
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-warning">
                                        <i class="ti ti-users ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-warning me-2">194</span><span>มีผู้เช่า</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-danger">
                                        <i class="ti ti-alert-circle ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-danger me-2">100</span><span>ค้างชำระ</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class="ti ti-calendar-time ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-info me-2">100</span><span>จอง</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class="ti ti-checkbox ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-success me-2">30</span><span>ห้องว่าง</span></h5>
                                </div>
                              </div>
                            </div>
                            
                            <button onclick="location.href='{{ url("dashboard") }}';" type="button" class="btn btn-main waves-effect waves-light">
                              <i class="ti-xs ti ti-pencil me-2"></i>
                              จัดการ
                            </button>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      
                      {{-- <div class="col-sm-6 mb-4">
                        <div class="card" style="border: 1px solid #d6d6d6;">
                          <div class="py-3 pt-4 justify-content-between" style="background-color: #fff5eb;border-bottom: 1px solid #d6d6d6;">
                            <h4 class="card-title m-0 me-2 text-center">ตึกคุณโบท</h4>
                          </div>
                          <div class="row px-5 py-4">
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-warning">
                                        <i class="ti ti-users ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-warning me-2">194</span><span>มีผู้เช่า</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-danger">
                                        <i class="ti ti-alert-circle ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-danger me-2">100</span><span>ค้างชำระ</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class="ti ti-calendar-time ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-info me-2">100</span><span>จอง</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class="ti ti-checkbox ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-success me-2">30</span><span>ห้องว่าง</span></h5>
                                </div>
                              </div>
                            </div>
                            
                            <button onclick="location.href='{{ url("dashboard") }}';" type="button" class="btn btn-main waves-effect waves-light">
                              <i class="ti-xs ti ti-pencil me-2"></i>
                              จัดการ
                            </button>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 mb-4">
                        <div class="card" style="border: 1px solid #d6d6d6;">
                          <div class="py-3 pt-4 justify-content-between" style="background-color: #fff5eb;border-bottom: 1px solid #d6d6d6;">
                            <h4 class="card-title m-0 me-2 text-center">ตึกคุณเบล</h4>
                          </div>
                          <div class="row px-5 py-4">
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-warning">
                                        <i class="ti ti-users ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-warning me-2">194</span><span>มีผู้เช่า</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-danger">
                                        <i class="ti ti-alert-circle ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-danger me-2">100</span><span>ค้างชำระ</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class="ti ti-calendar-time ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-info me-2">100</span><span>จอง</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class="ti ti-checkbox ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-success me-2">30</span><span>ห้องว่าง</span></h5>
                                </div>
                              </div>
                            </div>
                            
                            <button onclick="location.href='{{ url("dashboard") }}';" type="button" class="btn btn-main waves-effect waves-light">
                              <i class="ti-xs ti ti-pencil me-2"></i>
                              จัดการ
                            </button>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 mb-4">
                        <div class="card" style="border: 1px solid #d6d6d6;">
                          <div class="py-3 pt-4 justify-content-between" style="background-color: #fff5eb;border-bottom: 1px solid #d6d6d6;">
                            <h4 class="card-title m-0 me-2 text-center">ตึกคนหล่อ</h4>
                          </div>
                          <div class="row px-5 py-4">
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-warning">
                                        <i class="ti ti-users ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-warning me-2">194</span><span>มีผู้เช่า</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-danger">
                                        <i class="ti ti-alert-circle ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-danger me-2">100</span><span>ค้างชำระ</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-info">
                                        <i class="ti ti-calendar-time ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-info me-2">100</span><span>จอง</span></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-6 mb-4">
                              <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;">
                                    <span class="avatar-initial rounded-circle bg-label-success">
                                        <i class="ti ti-checkbox ti-md"></i>
                                    </span>
                                </div>
                                <div class="card-info">
                                  <h5 class="mb-0"><span class="text-success me-2">30</span><span>ห้องว่าง</span></h5>
                                </div>
                              </div>
                            </div>
                            
                            <button onclick="location.href='{{ url("dashboard") }}';" type="button" class="btn btn-main waves-effect waves-light">
                              <i class="ti-xs ti ti-pencil me-2"></i>
                              จัดการ
                            </button>
                          </div>
                        </div>
                      </div> --}}

                </div>
              </div>
                <!-- /Logo -->
                

            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <div class="modal fade modalHeadDecor" id="addserviceModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content rounded-0">
              <div class="modal-header rounded-0">
                  <h5 class="modal-title" id="exampleModalLabel1">&nbsp;เพิ่มสาขา</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="add_branch">		
                  @csrf
                  <div class="modal-body">
                      <div class="row g-3 p-4">
                          <div class="col-sm-6" style="margin: auto;">
                              <label for="" class="form-label">ชื่อสาขา</label><span class="text-danger"> *</span>
                              <input name="name" type="text" class="form-control" placeholder="ชื่อสาขา" required />
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer rounded-0 justify-content-center">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                      <button type="submit" class="btn btn-main">บันทึก</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
    <!-- / Content -->
    @include('layout/inc_js')

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-auth.js"></script>
    <script>
      $('#add_branch').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มสาขาหรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                showDenyButton: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'branch/add', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                $('#add_branch')[0].reset();
                                Swal.fire('เพิ่มสาขาเรียบร้อยแล้ว', '', 'success');
                                $('#addserviceModal').modal('hide');
                                setTimeout(function() {
                                  location.reload();
                                }, 4000);
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
  </body>
</html>
