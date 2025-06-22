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
    <h2 class="intro-y text-lg font-medium mt-10">{{ $user->name }} @if(!empty($user->nickname)) ({{$user->nickname}})@endif</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            {{-- ////////// --}}
            <div class="w-full sm:w-auto mt-3 mr-3 sm:mt-0 sm:ml-auto md:ml-0">
                <input name="month" type="month" class="form-control p_search" id="month_search" placeholder="ชื่อ-นามสกุล" onchange="changeMonthSearch(this.value)" value="@if(@$_GET['month']){{$_GET['month']}}@else{{ date('Y-m', strtotime('-1 month')) }}@endif">
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-3">
                {{-- <input name="date_from" type="date" class="form-control p_search" placeholder="ชื่อ-นามสกุล" onchange="loadData('{{$page_url}}/datatable')"> --}}
                <div class="preview">
                    <input name="date_from_to" type="text" data-daterange="true" class="datepicker form-control w-56 block mx-auto p_search disa" id="date_from_to"
                           value="@if(@$_GET['date_from_to']){{$_GET['date_from_to']}}@else{{ date('Y-m-01', strtotime('first day of last month')) }} - {{ date('Y-m-t', strtotime('last day of last month'))}}@endif">
                </div>
            </div>
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
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">ต้องการลบ ?</div>
                        <div class="text-slate-500 mt-2">พนักงานจะถูกเปลี่ยนสถานะเป็น ลาออก</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" data-tw-dismiss="modal" onclick="confirmDelete()" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
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
                loadData("{{$page_url}}/datatable_by_id");
            }
            date_from_to = $('#date_from_to').val();
            // console.log(date_from_to);
        });

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
                    if(response == true){
                        const el = document.querySelector("#basic-modal-upload-excel");
                        const modal = tailwind.Modal.getOrCreateInstance(el);
                        modal.hide();
                        loadData(page);

                    }
                }
            });
        }
        var loading = $("#loading").html();
        $("#table-data").html(loading);
        
        var page = "{{$page_url}}/datatable_by_id/";
        var searchData = {};
        
        loadData(page);
        // function search(){
        //     loadData(page, searchData);
        // }
        // $('.button-apply').click(function() {
        //     console.log('Button clicked!');
        //         // Add more code here if needed
        //     });
        function loadData(pages,){
            
            $('.p_search:not([dis])').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });

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
            