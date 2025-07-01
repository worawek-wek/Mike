    {{-- {{dd($list_data['to'])}} --}}
    <table class="datatables-basic table dataTable no-footer dtr-column"
            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
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
                    <th class="text-center">
                        เบอร์ติดต่อ
                    </th>
                    <th class="text-center">
                        เลขบัตรประชาชน/Passport
                    </th>
                    <th class="text-center">
                        เมื่อ
                    </th>
                    <th class="text-center">
                        ดำเนินการ
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list_data as $key => $row)
                    <tr class="odd">
                        <td class="text-center" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#editModal" onclick="view({{ $row->id }})">
                            {{ $loop->iteration + (($list_data->currentPage() - 1) * $list_data->perPage()) }}
                        </td>
                        <td class="text-center" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#editModal" onclick="view({{ $row->id }})">
                            {{ $row->prefix.' '.$row->name.' '.$row->surname }}
                        </td>
                        <td class="text-center" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#editModal" onclick="view({{ $row->id }})">
                            {{ $row->blacklist_detail }}
                        </td>
                        <td class="text-center" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#editModal" onclick="view({{ $row->id }})">
                            {{ $row->phone }}
                        </td>
                        <td class="text-center" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#editModal" onclick="view({{ $row->id }})">
                            {{ $row->id_card_number }}
                        </td>
                        <td class="text-center" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#editModal" onclick="view({{ $row->id }})">
                            {{ date('d/m/Y', strtotime($row->blacklist_date)) }}
                        </td>
                        <td class="text-center">
                            @if(Auth::user()->user_has_branch->position->id == 1)
                            <a href="javascript:void(0);" class="card-reload text-danger" onclick="deleteBlacklist('{{ $row->id }}')"><i class="tf-icons ti ti-trash ti-sm"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
@include('layout/pagination')