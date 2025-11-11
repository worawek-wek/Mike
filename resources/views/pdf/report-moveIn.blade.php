<style>
    @media print {
        body {
            font-size: 10px;
            margin: 10mm;
        }

        table {
            width: 100% !important;
            max-width: 100% !important;
            table-layout: fixed;
            border-collapse: collapse;
        }

        th, td {
            font-size: 10px;
            word-wrap: break-word;
            border: 1px solid black;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }

        .text-truncate {
            white-space: normal !important;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }
    }

    .text-center {
        text-align: center;
    }
</style>
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
            <td><span>{{ $row->security_deposit }}</span></td>
            <td><span>{{ @$row->renter->room_for_rent->deposit }}</span></td>
            <td><span>{{ @$row->security_deposit-@$row->renter->room_for_rent->deposit }}</span></td>
        </tr>
            @empty

                <tr>
                    <td colspan="14" class="text-center text-muted py-4" style="padding-bottom:15px;">
                        <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                        ไม่พบข้อมูล
                    </td>
                </tr>

            @endforelse
    </tbody>
</table>
    </tbody>
</table>