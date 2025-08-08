<table class="datatables-products table dataTable no-footer dtr-column"
    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
    <thead class="border-top">
        <tr class="text-center table-info">
            <th class="control  dtr-hidden" rowspan="1"
                colspan="1" style="width: 0px; display: none;"
                aria-label=""></th>
            <th class="text-center" style="padding: 0 50px;">
                ห้อง
            </th>
            <th class="text-center">
                ชื่อผู้เช่า
            </th>
            <th class="text-center" style="width: 57px;">
                เลขที่ใบเสร็จ
            </th>
            <th class="text-center" style="width: 150px;">
                วันที่รับชำระ
            </th>
            <th class="text-nowrap text-center">
                ช่องทาง
            </th>
            <th class="text-nowrap text-center">
                รับชำระโดย
            </th>
            {{-- <th class="text-center">
                รวม
            </th> --}}
            <th class="text-center" style="width: 100px;">
                ค่าห้องเช่า
            </th>
            <th class="text-center">
                ค่าน้ำ
            </th>
            <th class="text-center">
                ค่าไฟ
            </th>
            <th class="text-center">
                ค่าที่จอด <br> รถยนต์
            </th>
            <th class="text-center">
                ค่าที่จอด <br> รถมอเตอร์ไซค์
            </th>
            <th class="text-nowrap text-center">
                ส่วนกลาง
            </th>
            <th class="text-center">
                รวม
            </th>
            <th class="text-center">
                สถานะ
            </th>
            <!-- <th class="sorting_disabled" rowspan="1" colspan="1"
                style="width: 87px;" aria-label="Actions">จัดการ</th> -->
        </tr>
    </thead>
    <tbody>
        @forelse ($list_data as $row)
            <tr class="even table-success" align="center">
                <td class="control" tabindex="0" style="display: none;">
                </td>
                <td class="sorting_1">{{ $row->room_name }}</td>
                <td><span class="text-truncate">{{ $row->renter_name }}</span>
                </td>
                <td><span>{{ $row->receipt_number }}</span></td>
                <td style="padding: 0 22px;"><span>{{ date('d/m/Y', strtotime($row->payment_date)) }}</span></td>
                <td><span>
                    @if ($row->payment_method == 1)
                        เงินสด
                    @else
                        โอนเงิน
                    @endif     
                </span></td>
                <td><span>{{ $row->user->name }}</span></td>
                {{-- <td><span>{{ $row->rent }}</span></td> --}}
                <td><span>{{ $row->water_amount }}</span></td>
                <td><span>{{ $row->electricity_amount }}</span></td>
                <td><span> - </span></td>
                <td><span> - </span></td>
                <td><span> - </span></td>
                <td><span> - </span></td>
                <td><span>{{ number_format($row->total_amount) }}</span></td>
                <td><span class="badge bg-label-success"
                        text-capitalized="">ชำระแล้ว</span></td>
            </tr>
{{-- $data_list = [
                        $row->room_name,
                        $row->rent,
                        $row->water_amount,
                        $row->electricity_amount,
            ];
            $data_list_2 = [
                        number_format($row->total_amount),
                        0,
                        0,
                        $row->water_unit,
                        0,
                        $row->electricity_unit,
                        $row->renter_name,
                        @$row->room_for_rent->renter->fullThaiAddress(),
                        $row->id_card_number,
                        "",
                        $row->phone --}}

            @empty

                <tr>
                    <td colspan="20" class="text-center text-muted py-4">
                        <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                        ไม่พบข้อมูล
                    </td>
                </tr>

            @endforelse
        {{-- <tr class="even table-danger" align="center">
            <td class="control" tabindex="0" style="display: none;">
            </td>
            <td class="sorting_1">A101</td>
            <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
            </td>
            <td><span>RC202405000109</span></td>
            <td style="padding: 0 22px;"><span>25/04/2022</span></td>
            <td><span>เงินสด</span></td>
            <td><span>นิชกานต์</span></td>
            <td><span>4,000</span></td>
            <td><span>105</span></td>
            <td><span>2,023</span></td>
            <td><span>3,450</span></td>
            <td><span>4,000</span></td>
            <td><span>105</span></td>
            <td><span>2,023</span></td>
            <td><span>3,450</span></td>
            <td><span class="badge bg-label-danger"
                    text-capitalized="">ค้างชำระ</span></td>
        </tr> --}}
    </tbody>
</table>
    @include('layout/pagination')
