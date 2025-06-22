<table class="datatables-basic table dataTable no-footer dtr-column"
id="DataTables_Table_0" aria-describedby="DataTables_Table_0_warning">
<thead class="border-top">
    <tr class=" table-warning">
        <th class="text-center" tabindex="0" style="width: 40px;">
            ลำดับ
        </th>
        <th class="text-center">
            ชื่อ</th>
        <th class="text-center">
            ห้อง
        </th>
        <th class="text-center">
            เดือน
        </th>
        <th class="text-center">
            ค้างชำระ
        </th>
        <th class="text-center">
            จำนวนเงินรวม
        </th>
        {{-- <th class="text-center">
            &nbsp;
        </th> --}}
    </tr>
</thead>
<tbody>
    @foreach ($list_data as $key => $row)
    <tr class="odd" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#invoice" onclick="view({{ $row->id }})">
        <td class="control" tabindex="0" style="display: none;">
        </td>
        <td class="text-center">{{ $list_data->firstItem()+$key }}</td>
        <td class="text-center"><span class="text-truncate">{{ $row->prefix.' '.$row->renter_name }}</span>
        </td>
        <td class="text-center">{{ $row->room_name }}</td>
        <td class="text-center">กันยายน, ตุลาคม</td>
        <td class="text-center text-danger">{{ number_format($row->rent+$row->electricity_amount+$row->water_amount) }}</td>
        <td class="text-center">{{ number_format($row->rent+$row->electricity_amount+$row->water_amount) }}</td>
        {{-- <td class="text-center">
            <div class="d-inline-block text-nowrap">
                <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light">
                    <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                </button>
            </div>
        </td> --}}
    </tr>
    @endforeach
</tbody>
</table>
    @include('layout/pagination')