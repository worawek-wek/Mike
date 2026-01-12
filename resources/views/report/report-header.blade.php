<div class="row g-3 justify-content-between mb-4">
    <div class="col-sm-12">
        <h4 class="mb-0">
            <i class="tf-icons ti ti-chart-pie-3 text-main ti-md"></i>
            รายงานบิลค่าเช่า
        </h4>
    </div>
    <div class="col-sm-4">
        <div class="card card-border-shadow-warning h-100">
            <div
                class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <span class="badge bg-label-warning rounded p-2">
                            <i class="ti ti-check ti-26px"></i>
                        </span>
                    </div>
                    <h3 class="mb-0 me-2 text-warning" id="paid_wait_confirm">{{ $paid_wait_confirm }}</h3>
                </div>
                <div class="card-title mb-0">
                    <p class="mb-0">ชำระเงิน(โดยพนักงาน)</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-border-shadow-success h-100">
            <div
                class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <span class="badge bg-label-success rounded p-2">
                            <i class="ti ti-check ti-26px"></i>
                        </span>
                    </div>
                    <h3 class="mb-0 me-2 text-success" id="paid">{{ $paid }}</h3>
                </div>
                <div class="card-title mb-0">
                    <p class="mb-0">ชำระแล้ว</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-border-shadow-danger bg-danger-subtle h-100">
            <div
                class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="ti ti-x ti-26px"></i>
                        </span>
                    </div>
                    <h3 class="mb-0 me-2 text-danger" id="overdue">{{ $overdue }}</h3>
                </div>
                <div class="card-title mb-0">
                    <p class="mb-0">ยอดค้างชำระ</p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div>
    <h5 class="card-title">แยกตามการชำระ</h5>
    <div class="row justify-content-center">
        
        <div class="col-sm-3">
            <div class="d-flex mb-3 pb-1 align-items-center">
                <div class="chart-progress me-3" data-color="warning"
                    data-series="{{ $percent_cash_wait_for_confirm }}" data-progress_variant="true"></div>
                <div class="me-2">
                    <h6 class="mb-1">เงินสดคอนเฟิร์มแล้ว</h6>
                    <small id="cash">{{ number_format($cash_wait_for_confirm) }}</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
                <button type="button"
                            class="btn btn-main rounded-2 ms-auto d-write change_status_all_check"
                            data-bs-toggle="modal"
                            data-bs-target="#model-wait-for-confirmation"
                            >
                            รายละเอียด
                        </button>
        </div>
        <div class="col-sm-3">
            <div class="d-flex mb-3 pb-1 align-items-center">
                <div class="chart-progress me-3" data-color="danger"
                    data-series="{{ $percent_transfer_wait_for_confirm }}" data-progress_variant="true"></div>
                <div class="me-2">
                    <h6 class="mb-1">ผ่านการโอนเงิน </h6>
                    <small id="transfer">{{ number_format($transfer_wait_for_confirm) }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div>
    <h5 class="card-title">แยกตามการชำระ</h5>
    <div class="row justify-content-center">
        
        <div class="col-sm-3">
            <div class="d-flex mb-3 pb-1 align-items-center">
                <div class="chart-progress me-3" data-color="success"
                    data-series="{{ $percent_cash }}" data-progress_variant="true"></div>
                <div class="me-2">
                    <h6 class="mb-1">เงินสดรอคอนเฟิร์ม</h6>
                    <small id="cash">{{ number_format($cash) }}</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
                <button type="button"
                            class="btn btn-main rounded-2 ms-auto d-write change_status_all_check"
                            data-bs-toggle="modal"
                            data-bs-target="#model-confirmation"
                            >
                            รายละเอียด
                        </button>
        </div>
        <div class="col-sm-3">
            <div class="d-flex mb-3 pb-1 align-items-center">
                <div class="chart-progress me-3" data-color="danger"
                    data-series="{{ $percent_transfer }}" data-progress_variant="true"></div>
                <div class="me-2">
                    <h6 class="mb-1">ผ่านการโอนเงิน </h6>
                    <small id="transfer">{{ number_format($transfer) }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="/assets/js/app-academy-dashboard.js"></script>

    <div class="modal fade modalHeadDecor" id="model-confirmation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ยอดชำระแล้ว</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmation">
                    {{-- Modal รอคอนเฟิร์ม --}}

                    <div class="card mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header text-white pb-0">
                                <h5 class="mb-0">รายละเอียดการชำระเงิน</h5>
                            </div>

                            <div class="card-body p-3">
                                <ul class="list-group list-group-flush">

                                    <!-- เงินสด -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-money-bill-wave text-info fs-4 me-3"></i>
                                            <span>เงินสด</span>
                                        </div>
                                        <span>{{ number_format($confirm_by_ceo) }} &nbsp;บาท</span>
                                    </li>

                                    <!-- โอนเงิน -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-university text-warning text-info fs-4 me-3"></i>
                                            <span>โอนเงิน</span>
                                        </div>
                                        <span>{{ number_format(array_sum(array_column($total_amount, 'amount'))) }} &nbsp;บาท</span>
                                    </li>

                                    <!-- รวม -->
                                    <li class="list-group-item d-flex justify-content-center align-items-center text-success h5 pt-3 mb-0">
                                        <span class="fw-bold me-2">รวมทั้งหมด</span>
                                        <span class="fw-bold">{{ number_format(array_sum(array_column($total_amount, 'amount')) + $confirm_by_ceo) }} &nbsp;บาท</span>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-header text-white">
                                <h5 class="mb-0">ยอดโอน รายบัญชี</h5>
                            </div>
                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    @foreach ($total_amount as $key => $item)
                                        <li class="d-flex mb-3">
                                            <div class="avatar flex-shrink-0 me-4">
                                                <img src="/bank-logo/{{ $item['bank']->bank }}.png">
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0 fw-normal"><b class="me-2">ชื่อธนาคาร:</b> {{ $item['bank']->bank }} <br> <b class="me-2">เลขที่บัญชี:</b> {{ $item['bank']->bank_account_number }}<br> <b class="me-2">ชื่อบัญชี:</b> {{ $item['bank']->bank_account_name }}</h6>
                                                </div>
                                                <div class="user-progress">
                                                    <h6 class="mb-0"><span>{{ number_format($item['amount']) }} &nbsp;บาท</span></h6>
                                                </div>
                                            </div>
                                        </li>
                                        <hr>
                                    @endforeach
                                        
                                        <li class="list-group-item d-flex justify-content-center align-items-center text-warning h5">
                                            <span class="fw-bold me-2">รวมทั้งหมด</span>
                                            <span class="fw-bold">{{ number_format(array_sum(array_column($total_amount, 'amount'))) }} &nbsp;บาท</span>
                                        </li>
                                        
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="model-wait-for-confirmation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ยอดชำระแล้ว</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmation">
                    {{-- Modal รอคอนเฟิร์ม --}}

                    <div class="card mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header text-white pb-0">
                                <h5 class="mb-0">รายละเอียดการชำระเงิน</h5>
                            </div>

                            <div class="card-body p-3">
                                <ul class="list-group list-group-flush">

                                    <!-- เงินสด -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-money-bill-wave text-info fs-4 me-3"></i>
                                            <span>เงินสด</span>
                                        </div>
                                        <span>{{ number_format($cash_wait_for_confirm) }} &nbsp;บาท</span>
                                    </li>

                                    <!-- โอนเงิน -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-university text-warning text-info fs-4 me-3"></i>
                                            <span>โอนเงิน</span>
                                        </div>
                                        <span>{{ number_format(array_sum(array_column($total_amount_wait_for_confirm, 'amount'))) }} &nbsp;บาท</span>
                                    </li>

                                    <!-- รวม -->
                                    <li class="list-group-item d-flex justify-content-center align-items-center text-success h5 pt-3 mb-0">
                                        <span class="fw-bold me-2">รวมทั้งหมด</span>
                                        <span class="fw-bold">{{ number_format(array_sum(array_column($total_amount_wait_for_confirm, 'amount')) + $cash_wait_for_confirm) }} &nbsp;บาท</span>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-header text-white">
                                <h5 class="mb-0">ยอดโอน รายบัญชี</h5>
                            </div>
                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    @foreach ($total_amount_wait_for_confirm as $key => $item_tawfc)
                                        <li class="d-flex mb-3">
                                            <div class="avatar flex-shrink-0 me-4">
                                                <img src="/bank-logo/{{ $item_tawfc['bank']->bank }}.png">
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0 fw-normal"><b class="me-2">ชื่อธนาคาร:</b> {{ $item_tawfc['bank']->bank }} <br> <b class="me-2">เลขที่บัญชี:</b> {{ $item_tawfc['bank']->bank_account_number }}<br> <b class="me-2">ชื่อบัญชี:</b> {{ $item_tawfc['bank']->bank_account_name }}</h6>
                                                </div>
                                                <div class="user-progress">
                                                    <h6 class="mb-0"><span>{{ number_format($item_tawfc['amount']) }} &nbsp;บาท</span></h6>
                                                </div>
                                            </div>
                                        </li>
                                        <hr>
                                    @endforeach
                                        
                                        <li class="list-group-item d-flex justify-content-center align-items-center text-warning h5">
                                            <span class="fw-bold me-2">รวมทั้งหมด</span>
                                            <span class="fw-bold">{{ number_format(array_sum(array_column($total_amount_wait_for_confirm, 'amount'))) }} &nbsp;บาท</span>
                                        </li>
                                        
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>