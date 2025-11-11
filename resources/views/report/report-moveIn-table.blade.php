<table class="datatables-products table dataTable no-footer dtr-column"
    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
    style="width: 1396px;">
    <thead class="border-top">
        <tr class=" table-info">
            <th class="text-center" style="width: 50px !important;">ห้อง</th>
            <th class="text-center" style="width: 100px !important;">วันที่</th>
            <th class="" style="text-align: left; width: 250px !important;">ชื่อผู้เช่า</th>
            <th class="" style="text-align: left; width: 250px !important;">ผู้ทำรายการ</th>
            <th class="text-center" style="width: 70px !important;">ช่องทาง</th>
            <th class="text-center" style="width: 140px !important;">ค่าประกันห้อง</th>
            <th class="text-center" style="width: 150px !important;">หักค่ามัดจำจอง</th>
            <th class="text-center" style="width: 120px !important;">รวม</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($list_data as $row)          
        <tr class="odd text-center">
            <td class="sorting_1">{{ $row->room->name }}</td>
            <td><span>{{ date('d/m/Y', strtotime($row->created_at)) }}</span></td>
            <td style="text-align: left;"><span>{{ @$row->renter->prefix.' '.@$row->renter->name.' '.@$row->renter->surname }}</span></td>
            <td style="text-align: left;"><span>{{ @$row->renter->room_for_rent->user->name }}</span></td>
            <td><span>{{ @$row->renter->room_for_rent->payment_method == 1 ? 'เงินสด': 'โอนเงิน'; }}</span></td>
            <td><span>{{ number_format($row->security_deposit,0) }}</span></td>
            <td><span>{{ number_format(@$row->renter->room_for_rent->deposit,0) }}</span></td>
            <td><span>{{ number_format(@$row->security_deposit-@$row->renter->room_for_rent->deposit,0) }}</span></td>
        </tr>
            @empty

                <tr>
                    <td colspan="20" class="text-center text-muted py-4">
                        <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                        ไม่พบข้อมูล
                    </td>
                </tr>

            @endforelse
    </tbody>
</table>
@include('layout/pagination')

