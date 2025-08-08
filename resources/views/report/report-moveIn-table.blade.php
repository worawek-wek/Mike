<table class="datatables-products table dataTable no-footer dtr-column"
    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
    style="width: 1396px;">
    <thead class="border-top">
        <tr class=" table-info">
            <th class="text-center" style="padding: 0 50px;">
                ห้อง
            </th>
            <th class="text-center">
                วันที่
            </th>
            <th class="text-center" style="width: 57px;">
                โดย
            </th>
            <th class="text-center">
                ช่องทาง
            </th>
            <th class="text-center">
                ค่าประกันห้อง
            </th>
            <th class="text-center">
                หักค่ามัดจำจอง
            </th>
            <th class="text-center">
                รวม
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_data as $row)            
        <tr class="odd text-center">
            <td class="sorting_1">{{ $row->room->name }}</td>
            <td><span>{{ date('d/m/Y', strtotime($row->created_at)) }}</span>
            </td>
            <td><span>{{ @$row->renter->room_for_rent->user->name }}</span></td>
            <td><span>{{ @$row->renter->room_for_rent->payment_method == 1 ? 'เงินสด': 'โอนเงิน'; }}</span></td>
            <td><span>{{ $row->security_deposit }}</span></td>
            <td><span>{{ @$row->renter->room_for_rent->deposit }}</span></td>
            <td><span>{{ @$row->security_deposit+@$row->renter->room_for_rent->deposit }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('layout/pagination')

