@extends('../layout/' . $layout)

@section('subhead')
    <title>สรุปเวลาพนักงาน</title>
@endsection

@section('subcontent')
<style>
    .disa{
        /* cursor: not-allowed; */
        --tw-bg-opacity: 1;
        background-color: rgb(var(--color-slate-100) / var(--tw-bg-opacity));
        "
    }
</style>
    <h2 class="intro-y text-lg font-medium mt-10">สรุปเวลาพนักงาน</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            {{-- ////////// --}}
            <div class="w-full sm:w-auto mt-3 mr-3 sm:mt-0 sm:ml-auto md:ml-0">
                <input name="month" type="month" class="form-control p_search" id="month_search" placeholder="ชื่อ-นามสกุล" onclick="checkDisabled()" onchange="changeMonthSearch(this.value)" value="@if(@$_GET['month']){{$_GET['month']}}@else{{ date('Y-m', strtotime('-1 month')) }}@endif">
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-3">
                {{-- <input name="date_from" type="date" class="form-control p_search" placeholder="ชื่อ-นามสกุล" onchange="loadData('{{$page_url}}/datatable')"> --}}
                <div class="preview">
                    <input name="date_from_to" type="text" data-daterange="true" class="datepicker form-control w-56 block mx-auto p_search disa" id="date_from_to"
                           value="@if(@$_GET['date_from_to']){{$_GET['date_from_to']}}@else{{ date('Y-m-01', strtotime('first day of last month')) }} - {{ date('Y-m-t', strtotime('last day of last month'))}}@endif">
                </div>
            </div>
            @if (in_array(Auth::user()->ref_position_id, [1,3]))

            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input name="search" type="text" class="form-control w-56 box pr-10 p_search" oninput="loadData('{{$page_url}}/datatable')" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_branch_id" onchange="loadData('{{$page_url}}/datatable')" data-search="true" class="tom-select w-full p_search">
                        <option value="0" hidden> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; สาขา &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($branch as $bra)
                        <option @if($bra->id == @$_GET['ref_branch_id']) selected @endif value="{{$bra->id}}">{{$bra->branch_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_position_id" onchange="loadData('{{$page_url}}/datatable')" data-search="true" class="tom-select w-full p_search">
                        <option value="0" hidden> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ตำแหน่ง &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($position as $pos)
                        <option @if($pos->id == @$_GET['ref_position_id']) selected @endif value="{{$pos->id}}">{{$pos->position_name}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            {{-- <div class="text-center">
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#basic-modal-preview" class="btn btn-primary">Show Modal</a>
            </div> --}}
            <!-- END: Modal Toggle -->
            <!-- BEGIN: Modal Content -->
            <div id="basic-modal-upload-excel" class="modal" tabindex="-1" aria-hidden="true">
                @include('user-time/import-excel-modal')
            </div>
            @if (Auth::user()->ref_position_id == 1)
                <button class="btn box flex items-center text-slate-600 dark:text-slate-300 ml-5" data-tw-toggle="modal" data-tw-target="#basic-modal-upload-excel" style="background-color: #62ed1f;color: white;">
                    <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Import Excel
                </button>
            @endif
        </div>
        <!-- BEGIN: Data List -->
        <div id="loading" class="hidden">
            <div style="margin-top: 100px" class="col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                <i data-loading-icon="three-dots" class="w-8 h-8"></i>
            </div>
        </div>
        <div id="table-data" class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            
        </div>
        <!-- END: Pagination -->

    </div>
    
    <style>
        #file_excel {
            outline: none;
            padding: 4px;
            margin: -4px;
        }
            #file_excel:focus-within::file-selector-button,
            #file_excel:focus::file-selector-button {
            outline: 2px solid #0964b0;
            outline-offset: 2px;
        }
            #file_excel::before {
            top: 16px;
        }

            #file_excel::after {
            top: 14px;
        }
            #file_excel {
            position: relative;
        }
            #file_excel::file-selector-button {
            width: 121px;
            color: transparent;
        }
            /* Faked label styles and icon */
            #file_excel::before {
            position: absolute;
            pointer-events: none;
            /*   top: 11px; */
            left: 40px;
            color: #0964b0;
            content: "Choose File";
        }
            #file_excel::after {
            position: absolute;
            pointer-events: none;
            /*   top: 10px; */
            left: 16px;
            height: 20px;
            width: 20px;
            content: "";
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230964B0'%3E%3Cpath d='M18 15v3H6v-3H4v3c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h-2zM7 9l1.41 1.41L11 7.83V16h2V7.83l2.59 2.58L17 9l-5-5-5 5z'/%3E%3C/svg%3E");
        }
            /* file upload button */
            #file_excel::file-selector-button {
            border-radius: 4px;
            padding: 0 16px;
            height: 40px;
            cursor: pointer;
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.16);
            box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
            margin-right: 16px;
            transition: background-color 200ms;
        }
            /* file upload button hover state */
            #file_excel::file-selector-button:hover {
            background-color: #f3f4f6;
        }
            /* file upload button active state */
            #file_excel::file-selector-button:active {
            background-color: #e5e7eb;
        }
    </style>
    <!-- END: Delete Confirmation Modal -->
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
        function checkDisabled(){
            if ($("#month_search").is(":dis")) {
                $("#month_search").removeAttr("dis");
                console.log("Element with id='month_search' is disabled.");
            }
        }
        function changeMonthSearch(valMonth) {

            let monthIndex = parseInt(valMonth.split("-")[1]-1, 10);

            // สร้างวัตถุ Date สำหรับวันที่ 1 ของเดือน
            var firstDayOfMonth = new Date(new Date().getFullYear(), monthIndex, 1);

            // สร้างวัตถุ Date สำหรับวันสุดท้ายของเดือน
            var lastDayOfMonth = new Date(new Date().getFullYear(), monthIndex + 1, 0);

            // Format วันที่ให้เป็น "MMM DD YYYY"
            var formattedFirstDay = new Intl.DateTimeFormat('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: '2-digit' 
            }).format(firstDayOfMonth);

            var formattedLastDay = new Intl.DateTimeFormat('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: '2-digit' 
            }).format(lastDayOfMonth);

            // $('#date_from_to').val(formattedFirstDay+' - '+formattedLastDay);
            $('#date_from_to').val(change_forrmat(formattedFirstDay)+' - '+change_forrmat(formattedLastDay));
            // loadData("{{$page_url}}/datatable");
            rePage();
        }
        
        function change_forrmat(originalDateString){
            let dateObj = new Date(originalDateString);
            return `${dateObj.getDate()} ${dateObj.toLocaleString('en-us', { month: 'short' })}, ${dateObj.getFullYear()}`;
        }
        function rePage(){
            $('.p_search:not([dis])').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });
            
                // สร้าง query string จาก parameters
                var queryString = $.param(searchData);

                // สร้าง URL ใหม่ที่จะใช้ในการรีเฟรชหน้าเว็บ
                var newUrl = window.location.pathname + '?' + queryString;

                // รีเฟรชหน้าเว็บด้วย URL ใหม่
                window.location.replace(newUrl);
        }
        let date_from_to = $('#date_from_to').val();

        document.addEventListener('click', function(event) {
            // เมื่อมีคลิกเกิดขึ้น จะเข้าถึง event.target เพื่อหาองค์ประกอบที่ถูกคลิก
            var new_date_from_to = $('#date_from_to').val();
            if(date_from_to != new_date_from_to){
                $("#month_search").addClass("disa");
                $("#date_from_to").removeClass("disa");
                $("#month_search").val("");
                loadData("{{$page_url}}/datatable");
            }
            date_from_to = $('#date_from_to').val();
            // console.log(date_from_to);
        });

        function change_file() {
            $("#import_excel_user").css("display","none");
            $("#check_import_excel_user").css("display","block");
            $('#check_import_excel_user').removeAttr('disabled', true);
        }
        function import_excel_user() {
            var formData = new FormData();
            var file = $('#file_excel')[0].files[0];
            formData.append('file', file);
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: '{{$page_url}}/import_excel_user', // URL ที่จะส่งไป
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status === true){
                        const el = document.querySelector("#basic-modal-upload-excel");
                        const modal = tailwind.Modal.getOrCreateInstance(el);
                        modal.hide();
                        loadData(page);
                        $("#basic-modal-upload-excel").html(response.modal);
                    }else{
                        check_import_excel_user
                    }
                }
            });
        }
        function check_import_excel_user() {
            var formData = new FormData();
            var file = $('#file_excel')[0].files[0];
            formData.append('file', file);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: '{{$page_url}}/check_import_excel_user', // URL ที่จะส่งไป
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status === true){
                        const el = document.querySelector("#basic-modal-upload-excel");
                        const modal = tailwind.Modal.getOrCreateInstance(el);
                        modal.hide();
                        $("#basic-modal-upload-excel").html(response.modal);
                        loadData(page);
                    }else{
                        $("#table-excel").html(response.modal);
                        $("#import_excel_user").css("display","block");
                        $("#check_import_excel_user").css("display","none");
                    }
                }
            });
        }
        var loading = $("#loading").html();
        $("#table-data").html(loading);
        
        var page = "{{$page_url}}/datatable";
        var searchData = {};
        
        loadData(page);
        // function search(){
        //     loadData(page, searchData);
        // }
        // $('.button-apply').click(function() {
        //     console.log('Button clicked!');
        //         // Add more code here if needed
        //     });
        function loadData(pages){
            $('.p_search:not([dis])').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });
            // return alert(searchData);

            // alert(page);
            page = pages;
            $.ajax({
                type: "GET",
                url: pages,
                data: searchData,
                success: function(data) {
                    $("#table-data").html(data);
                }
            });
            // alert(page);
        }
        let DeleteId = '';
        function Delete(id){
            DeleteId = id;
            // console.log(DeleteId);
        }
        function confirmDelete(){
            $.ajax({
                type: "DELETE",
                url: "{{$page_url}}/"+DeleteId,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    // $('#delete-confirmation-modal').modal('hide');
                    loadData(page);
                }
            });

        }


</script>

@endsection
            