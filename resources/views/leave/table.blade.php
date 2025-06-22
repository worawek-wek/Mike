    {{-- {{dd($list_data['to'])}} --}}
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-center whitespace-nowrap">POSITION</th>
                <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $row)
                <tr class="intro-x">
                    <td align="center">
                        {{ $row['position_name'] }}
                        {{-- <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $row['products'][0]['category'] }}</div> --}}
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="{{$page_url}}/{{$row->id}}/edit">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </a>
                            <a class="flex items-center text-danger" href="javascript:;" onclick='Delete({{$row["id"]}})' data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-6">
        
        <nav class="w-full sm:w-auto sm:mr-auto">
        @if ($list_data->lastPage() > 1)
            <ul class="pagination">
                <li class="page-item {{ ($list_data->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="javascript:void(0)" onclick='loadData("{{ $list_data->url(1) }}")'>First</a>
                </li>
                @for ($i = 1; $i <= $list_data->lastPage(); $i++)
                    <?php
                    $half_total_links = floor($list_data->total() / 2);
                    $from = $list_data->currentPage() - $half_total_links;
                    $to = $list_data->currentPage() + $half_total_links;
                    if ($list_data->currentPage() < $half_total_links) {
                    $to += $half_total_links - $list_data->currentPage();
                    }
                    if ($list_data->lastPage() - $list_data->currentPage() < $half_total_links) {
                        $from -= $half_total_links - ($list_data->lastPage() - $list_data->currentPage()) - 1;
                    }
                    ?>
                    @if ($from < $i && $i < $to)
                        <li class="page-item {{ ($list_data->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="javascript:void(0)" onclick='loadData("{{ $list_data->url($i) }}")'>{{ $i }}</a>
                        </li>
                    @endif
                @endfor
                <li class="page-item {{ ($list_data->currentPage() == $list_data->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="javascript:void(0)" onclick='loadData("{{ $list_data->url($list_data->lastPage()) }}")'>Last</a>
                </li>
            </ul>
        </nav>
        @endif
        <select onchange='loadData("{{$list_data->url($list_data->currentPage())}}&page=1&limit="+value)' class="w-20 form-select box mt-3 sm:mt-0">
            <option @if (@$query['limit'] == 1) selected @endif value="1">1</option>
            <option @if (@$query['limit'] == 2) selected @endif value="2">2</option>
            <option @if (@$query['limit'] == 3) selected @endif value="3">3</option>
            <option @if (@$query['limit'] == 4) selected @endif value="4">4</option>
        </select>
        </div>