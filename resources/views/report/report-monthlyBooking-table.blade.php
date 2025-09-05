<table class="datatables-products table dataTable no-footer dtr-column"
    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
    style="width: 1396px;">
    <thead class="border-top">
        <tr class=" table-info">
            <th class="text-center" tabindex="0" style="width: 40px;">
                ห้อง
            </th>
            <th class="text-center">
                ชื่อผู้จอง</th>
            <th class="text-center" style="width: 123px;">
                หมายเลขการจอง</th>
            <th class="text-center">
                วันที่จอง
            </th>
            <th class="text-center">
                วันที่เข้าพัก</th>
            <th class="text-center">
                ช่องทาง
            </th>
            <th class="text-center">
                รับจองโดย
            </th>
            <th class="text-center">
                ค่ามัดจำ
            </th>
            {{-- <th class="text-center">
                รวม
            </th> --}}
            <th class="text-center">
                สถานะ
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($list_data as $row)
            <tr class="odd">
                
                <td class="text-center">{{ $row->room_name }}</td>
                <td class="text-center"><span class="text-truncate">{{ $row->renter_name }}</span>
                </td>
                <td class="text-center"><span>{{ $row->receipt_number }}</span></td>
                <td class="text-center"><span>{{  date("d/m/Y" , strtotime($row->booking_date)) }}</span></td>
                <td class="text-center"><span>{{  date("d/m/Y" , strtotime($row->date_stay)) }}</span></td>
                <td class="text-center"><span> 
                @if ($row->payment_method == 1)
                    เงินสด
                @else
                    โอนเงิน
                @endif 
                </span></td>
                <td class="text-center"><span>{{  $row->user->name }}</span></td>
                <td class="text-center"><span>{{ $row->deposit }}</span></td>
                {{-- <td class="text-center"><span>{{ $row->amount }}</span></td> --}}
                <td class="text-center"><span class="badge bg-label-success"
                        text-capitalized="">จองแล้ว</span></td>
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
<script>
    // setTimeout(() => {
        $('#all-booking').html("{{ $list_data->total() }}");
    // }, 2000);
</script>