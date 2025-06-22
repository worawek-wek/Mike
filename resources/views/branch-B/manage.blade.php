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
                              อพาร์ทเม้นท์
                          </h4>
                      </div>
                      <div class="col-sm-6 text-end">
                          <button type="button" class="btn btn-main waves-effect waves-light" onclick="location.href='{{ url("building/add") }}';">
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

    <!-- / Content -->
    @include('layout/inc_js')

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-auth.js"></script>
  </body>
</html>
