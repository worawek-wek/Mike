<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายรับรายจ่าย</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }

        .no-border {
            border: none;
        }

        .summary-table td {
            text-align: left;
            padding-left: 8px;
        }

        .summary-label {
            font-weight: bold;
        }

        .header-title {
            font-weight: bold;
            font-size: 14px;
            padding-bottom: 4px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        $name_room = 'หอพักคร เจริญใจ';
    @endphp

    <div class="text-center" style="margin-bottom:10px;">
        <div class="header-title">เอกสารเช็ครถยนต์ {{ @$name_room }}</div>
        <div class="header-title">วันที่ _______/_______/_______</div>
    </div>

    <!-- ตารางข้อมูล -->
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width: 50px;">ทะเบียนรถ</th>
                <th class="text-center" style="width: 50px;">ห้องพัก</th>
                <th class="text-center" style="width: 150px;">รายละเอียดรถ</th>
                <th class="text-center" style="width: 150px;">เลขสติ๊กเกอร์</th>
                <th class="text-center" style="width: 50px;">23.00 น.</th>
                <th class="text-center" style="width: 50px;">3.00 น.</th>
                <th class="text-center" style="width: 50px;">6.00 น.</th>
            </tr>
        </thead>
        <tbody>
            @php 
            $count = @$list_data->count();
            $check_count = 25 - $count;
            @endphp
            @foreach ($list_data as $key => $row)
                <tr class="odd">
                    <td>{{@$row->vehicle->car_registration ?? '-'}}</td>
                    <td>{{ @$row->room_for_rent->room->name }}</td>
                    <td>{{@$row->vehicle->detail ?? '-'}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            @for($i=0;$i<$check_count;$i++)
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

</body>

</html>
