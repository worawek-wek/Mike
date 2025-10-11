{{-- Modal รอคอนเฟิร์ม --}}

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
            <h5 class="mb-0">รายละเอียด</h5>
            {{-- <small class="text-muted">เดือนพฤษภาคม 2024</small> --}}
        </div>
    </div>
    <div class="card-body">
        <ul class="p-0 m-0">
            <li class="d-flex mb-3">
                <div class="avatar flex-shrink-0 me-4">
                    <span class="avatar-initial rounded bg-label-warning"><i
                            class="ti ti-businessplan ti-26px"></i></span>
                </div>
                <div
                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0 fw-normal">ยอดรอคอนเฟิร์ม</h6>
                    </div>
                    <div class="user-progress">
                        <h6 class="text-warning mb-0"><span class="detail_confirm_by_employee"></span></h6>
                    </div>
                </div>
            </li>
            <li class="d-flex mb-3">
                <div class="avatar flex-shrink-0 me-4">
                    <span class="avatar-initial rounded bg-label-warning"><i
                            class="ti ti-currency-dollar ti-26px"></i></span>
                </div>
                <div
                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0 fw-normal">ยอดรวมในบัญชี ก่อนคอนเฟิร์ม</h6>
                    </div>
                    <div class="user-progress">
                        <h6 class="text-warning mb-0"><span class="confirm_by_ceo"></span></h6>
                    </div>
                </div>
            </li>
            <li class="d-flex mb-3">
                <div class="avatar flex-shrink-0 me-4">
                    <span class="avatar-initial rounded bg-label-success"><i
                            class="ti ti-database ti-26px"></i></span>
                </div>
                <div
                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0 fw-normal">ยอดรวมในบัญชี หลังคอนเฟิร์ม</h6>
                    </div>
                    <div class="user-progress">
                        <h6 class="text-success mb-0"> <span class="confirm_by_employee_confirm_by_ceo"></span></h6>
                    </div>
                </div>
            </li>
            
        </ul>
        <div class="card card-body border-0 shadow-none py-2">
            <div
                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <h5>บิลรอคอนเฟิร์ม</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr class=" table-info">
                            <th class="control sorting_disabled dtr-hidden" rowspan="1"
                                colspan="1" style="width: 0px; display: none;"
                                aria-label=""></th>
                            <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all"
                                rowspan="1" colspan="1" style="width: 18px;"
                                data-col="1" aria-label="">
                                #
                            <th class="text-center" tabindex="0" style="width: 40px;">
                                ห้อง
                            </th>
                            <th class="text-center">
                                ผู้เช่า</th>
                            <th class="text-center">
                                จำนวนเงินรวม
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_data as $key => $row_2)
                            {{-- <tr class="odd" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#invoice" onclick="view({{ $row_2->id }},'detail')"> --}}
                            <tr class="odd">
                                <td class="  dt-checkboxes-cell">
                                    {{ $key+1 }}
                                <td class="text-center">{{ $row_2->room->name }}</td>
                                <td class="text-center"><span class="text-truncate">{{ $row_2->renter->fullName() }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-truncate">{{ number_format($row_2->total_amount) }}</span>
                                </td>
                                {{-- <td class="text-center">
                                    <button class="btn btn-danger" onclick="changeStatusBill({{ $row_2->invoice->id }},3,'ยกเลิกใบเสร็จ')">
                                        <span>
                                            <i class="ti-md ti ti-x"></i>
                                            <b class="dam">ยกเลิกใบเสร็จ</b>
                                        </span>
                                    </button>
                                </td> --}}
                            </tr>
                        @endforeach
                        <tr class="bg-label-warning">
                            <th class="text-center" colspan="3">ยอดรวม</th>
                            <th class="text-center text-warning detail_confirm_by_employee"></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>