@extends('../layout/' . $layout)

@section('subhead')
    <title>พนักงาน</title>
    
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">Export to Excel</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="javascript:;" onclick="exportExcel('{{ url("export-excel/import-excel-user-leave") }}')" class="btn box flex items-center text-slate-600 dark:text-slate-300 ml-5 mr-3" data-tw-toggle="modal" data-tw-target="#basic-modal-upload-excel" style="background-color: #62ed1f;color: white;">
                <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> สรุปการลา
            </a>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                {{-- <input name="date_from" type="date" class="form-control p_search" placeholder="ชื่อ-นามสกุล" onchange="loadData('{{$page_url}}/datatable')"> --}}
                <div class="preview">
                    <input name="date_from_to" type="text" data-daterange="true" class="datepicker form-control w-56 block mx-auto p_search disa" id="date_from_to" value="123" placeholder="วันที่">
                </div>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_branch_id" data-search="true" class="tom-select w-full p_search">
                        <option selected value="null"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; สาขา &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($branch as $bra)
                        <option value="{{$bra->id}}">{{$bra->branch_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_status_id" data-search="true" class="tom-select w-full p_search">
                        <option value="null" selected> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; สถานะ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($status as $sts)
                        <option value="{{$sts->id}}">{{$sts->status_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="javascript:;" onclick="exportExcelUser('{{ url("export-excel/import-excel-user") }}')" class="btn box flex items-center text-slate-600 dark:text-slate-300 ml-5" data-tw-toggle="modal" data-tw-target="#basic-modal-upload-excel" style="background-color: #62ed1f;color: white;">
                    <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> ข้อมูลพนักงาน
                </a>
                <div class="mt-3 ml-3 2xl:mt-0">
                    <select name="ref_branch_id" data-search="true" class="tom-select w-full user_search">
                            <option selected value="null"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; สาขา &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                        @foreach ($branch as $bra)
                            <option value="{{$bra->id}}">{{$bra->branch_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3 ml-3 2xl:mt-0">
                    <select name="ref_position_id" data-search="true" class="tom-select w-full user_search">
                            <option selected value="null"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ตำแหน่ง &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                        @foreach ($position as $bra)
                            <option value="{{$bra->id}}">{{$bra->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
        var searchData = {};
        function exportExcel(newUrl) {
            $('.p_search:not([dis])').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });
                // สร้าง query string จาก parameters
                var queryString = $.param(searchData);
                // รีเฟรชหน้าเว็บด้วย URL ใหม่
                window.location.replace(newUrl + '?' + queryString);
                // window.open(newUrl + '?' + queryString, '_blank')
        }

        var searchDataUser = {};
        function exportExcelUser(newUrl) {
            $('.user_search:not([dis])').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchDataUser[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchDataUser
            });
                // สร้าง query string จาก parameters
                var queryString = $.param(searchDataUser);
                // รีเฟรชหน้าเว็บด้วย URL ใหม่
                window.location.replace(newUrl + '?' + queryString);
                // window.open(newUrl + '?' + queryString, '_blank')
        }
</script>

@endsection
            