<div class="row g-3">

    @foreach ($list_data as $row)

    <div class="col-sm-4">
        <div class="card card-action">
            <div class="card-header">
                <h5 class="card-action-title mb-0"></h5>
                <div class="card-action-element">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="javascript:void(0);"
                                class="card-collapsible text-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal"><i
                                    class="tf-icons ti ti-edit ti-sm" onclick="view({{ $row->id }})"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="card-reload text-danger" onclick="deleteBank('{{ $row->id }}')"><i
                                    class="tf-icons ti ti-trash ti-sm"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar avatar-xl">
                        <img src="/bank-logo/{{ $row->bank }}.png" alt="{{ $row->bank }}" data-bs-toggle="modal"
                        data-bs-target="#editModal"  onclick="view({{ $row->id }})">
                            {{-- class="rounded-circle"> --}}
                    </div>
                    <div>
                        <h5 class="mb-0 text-black"><b>{{ $row->bank }}</b></h5>
                        <h5 class="mb-0">สาขา &nbsp;{{ $row->branch }}</h5>
                        <h5 class="mb-0">ชื่อบัญชี &nbsp;{{ $row->bank_account_name }}</h5>
                        <h5 class="mb-0">เลขบัญชีเลขที่ &nbsp;{{ $row->bank_account_number }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>
