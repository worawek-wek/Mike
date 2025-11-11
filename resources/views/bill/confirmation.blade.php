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