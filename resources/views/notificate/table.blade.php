    {{-- {{dd($list_data['to'])}} --}}
    <table class="datatables-basic table dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
        <thead class="border-top">
            <tr class=" table-info">
                <th class="text-center" tabindex="0" style="width: 40px;">
                    ลำดับ
                </th>
                <th class="text-center">
                    ชื่อผู้เช่า
                </th>
                <th class="text-center">
                    รายละเอียด
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $key => $row)
            <tr class="odd" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#insurance" onclick="view({{ $row->id }})">
                <td class="text-center">
                    {{ $list_data->firstItem()+$key }}
                </td>
                <td class="text-center">
                    {{ $row->renter->name.' '.$row->renter->surname }}
                </td>
                <td class="text-center">
                    {{ $row->detail }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
@include('layout/pagination')
        