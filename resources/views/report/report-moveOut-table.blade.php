<table class="datatables-products table dataTable no-footer dtr-column"
    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
    style="width: 1396px;">
    <thead class="border-top">
        <tr class=" table-info">
            <th class="text-center" style="width: 50px;">
                ลำดับ
            </th>
            <th class="text-center">
                ห้อง
            </th>
            <th class="text-center">
                เลขที่ใบเสร็จ
            </th>
            <th style="width: 109px;">
                วันที่รับชำระเงิน
            </th>
            <th class="text-center">
                รับชำระโดย
            </th>
            {{-- <th class="text-center">
                ยอด
            </th>
            <th class="text-center">
                คืนเงินประกันห้อง
            </th> --}}
            <th class="text-center">
                รวม
            </th>
            <th class="text-center" style="width: 87px;">
                จัดการ
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_data as $key => $row)
            <tr class="odd text-center">
                <td class="  control" tabindex="0" style="display: none;">
                </td>
                
                <td class="sorting_1">{{ $key+1 }}</td>
                <td>{{ $row->room->name }}</td>
                <td><span>{{ $row->receipt_number }}</span></td>
                <td><span>{{ date('d/m/Y', strtotime($row->payment_date)) }}</span></td>
                <td><span>{{ $row->user->name }}</span></td>
                {{-- <td><span>4,209</span></td>
                <td><span>0</span></td> --}}
                <td><span class="text-danger">{{ number_format($row->total_amount) }} บาท</span></td>
                <td><button onclick="printPdfReceipt({{$row->id}})"
                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                            class="ti ti-printer ti-md"></i></button></td>
            </tr>
        @endforeach
    </tbody>
</table>