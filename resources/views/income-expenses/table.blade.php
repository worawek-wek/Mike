
<table class="datatables-basic table table-hover dataTable no-footer dtr-column"
id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
<thead class="border-top">
    <tr class=" table-info">
        <th class="text-center">
            วันที่
        </th>
        <th class="text-center">
            เลขที่ใบเสร็จ
        </th>
        <th class="text-center">
            รายละเอียด
        </th>
        <th class="text-center">
            ห้อง
        </th>
        {{-- <th class="text-center">
            หมวดหมู่
        </th> --}}
        <th class="text-center">
            จำนวนเงิน
        </th>
        <th class="text-center">
            โดย
        </th>
    </tr>
</thead>
<tbody>
    @foreach ($list_data as $key => $row)
    <tr class="odd" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#insurance" onclick="view({{ $row->id }})">
        <td class="text-center">{{ date('d/m/Y', strtotime($row->date)) }}</td>
        {{-- <td class="text-center">RC202404000121</td> --}}
        <td class="text-center">{{ $row->receipt->receipt_number ?? '-' }}</td>
        <td class="text-center">{{ $row->label }}</td>
        <td class="text-center">{{ $row->room->name ?? "รายจ่ายของ Office" }}</td>
        {{-- <td class="text-center">{{ $row->category->name }}</td> --}}
        @if ($row->type == 1)
            <td class="text-center text-success">
        @else
            <td class="text-center text-danger">
            -
        @endif
        @if ($row->type == 2)
            {{ number_format($row->amount, 2) }}</td>            
        @else
            {{ number_format($row->receipt->total_amount ?? $row->total_amount, 2) }}</td>            
        @endif
        <td class="text-center">{{ $row->user->name }}</td>
    </tr>
    @endforeach
</tbody>
</table>
    @include('layout/pagination')