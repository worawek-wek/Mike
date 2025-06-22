    <h2 class="intro-y text-lg font-medium mt-8 mb-4">พบ {{ count($alreadyexists) }} รายการที่มีอยู่แล้ว</h2>
    <table class="table table-report -mt-2">
        <thead>
            <tr align="center">
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">รหัสพนักงาน</th>
                <th class="whitespace-nowrap">ชื่อ</th>
                <th class="whitespace-nowrap" style="width: 30%;">วันที่</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alreadyexists as $key => $row)
                <tr class="intro-x">
                    <td class="text-center">{{ $key+1 }}</td>
                    <td class="text-center">{{ @$row[2] }}</td>
                    <td class="w-60 text-center">
                        {{ @$row[3] }}
                    </td>
                    <td class="text-center">{{ @$row[6] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (@$newitem)
    <h2 class="intro-y text-lg font-medium mt-8 mb-4">{{ count($newitem) }} รายการใหม่</h2>
    <table class="table table-report -mt-2">
        <thead>
            <tr align="center">
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">รหัสพนักงาน</th>
                <th class="whitespace-nowrap">ชื่อ</th>
                <th class="whitespace-nowrap" style="width: 30%;">วันที่</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($newitem as $key2 => $row2)
                <tr class="intro-x">
                    <td class="text-center">{{ @$key2+1 }}</td>
                    <td class="text-center">{{ @$row2[2] }}</td>
                    <td class="w-60 text-center">
                        {{ @$row2[3] }}
                    </td>
                    <td class="text-center">{{ @$row2[6] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
        