@extends('../layout/' . $layout)

@section('subhead')
    <title>พนักงาน</title>
    
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">พนักงาน</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @if (Auth::user()->ref_position_id == 1)
            <a href="{{$page_url}}/create" class="btn btn-primary shadow-md mr-2">เพิ่ม &nbsp; <i class="w-4 h-4" data-lucide="plus"></i></a>
            @endif
            {{-- ////////// --}}
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input name="search" type="text" class="form-control w-56 box pr-10 p_search" onkeyup="loadData('{{$page_url}}/datatable')" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_branch_id" onchange="loadData('{{$page_url}}/datatable')" data-search="true" class="tom-select w-full p_search">
                        <option value="0" hidden> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; สาขา &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($branch as $bra)
                        <option value="{{$bra->id}}">{{$bra->branch_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_position_id" onchange="loadData('{{$page_url}}/datatable')" data-search="true" class="tom-select w-full p_search">
                        <option value="0" hidden> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ตำแหน่ง &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($position as $pos)
                        <option value="{{$pos->id}}">{{$pos->position_name}}</option>
                    @endforeach
                </select>
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
        
        function loadData(pages,){
            
            $('.p_search').each(function() {
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
            