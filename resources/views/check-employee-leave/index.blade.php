@extends('../layout/' . $layout)

@section('subhead')
    <title>Users</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">ตรวจสอบการลา</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: General Report -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
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
                        <option @if($bra->id == @$user['ref_branch_id']) selected @endif value="{{$bra->id}}">{{$bra->branch_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_position_id" onchange="loadData('{{$page_url}}/datatable')" data-search="true" class="tom-select w-full p_search">
                        <option value="0" hidden> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ตำแหน่ง &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($position as $pos)
                        <option @if($pos->id == @$user['ref_position_id']) selected @endif value="{{$pos->id}}">{{$pos->position_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 ml-3 2xl:mt-0">
                <select name="ref_leave_id" onchange="loadData('{{$page_url}}/datatable')" data-search="true" class="tom-select w-full p_search">
                        <option value="0" hidden> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ประเภทการลา &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>
                    @foreach ($leave as $lea)
                        <option @if($lea->id == @$user['ref_leave_id']) selected @endif value="{{$lea->id}}">{{$lea->leave_name}}</option>
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
            {{-- Ajax ดึงตารางแสดง --}}
        </div>
        <!-- END: Pagination -->

    </div>
</div>
</div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
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
        var loading = $("#loading").html();
        $("#table-data").html(loading);
        
        var page = "{{$page_url}}/datatable";
        var searchData = {};
        
        loadData(page);
        let change_user_id = null;
        let change_status_id = null;
        function modal_confirm_change_status(id, status){
            change_user_id = id;
            change_status_id = status;
        }
        let change_boss_status_id = null;
        function modal_confirm_change_boss_status(id, status){
            change_user_id = id;
            change_boss_status_id = status;
        }
        function loadData(pages){
            
            $('.p_search').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });

            page = pages;
            $.ajax({
                type: "GET",
                url: pages,
                data: searchData,
                success: function(data) {
                    $("#table-data").html(data);
                }
            });
        }
        function change_status(id,sta_tus){
            if(id == "n"){
                id = change_user_id;
            }
            if(sta_tus == "n"){
                sta_tus = change_status_id;
            }

            $.ajax({
                type: "POST",
                url: "{{$page_url}}/change_status/"+id,
                data: {
                    status : sta_tus,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#dropdown'+id).css('display','none');
                    loadData(page);
                }
            });
            // alert(page);
        }
        function change_boss_status(id,sta_tus){
            if(id == "n"){
                id = change_user_id;
            }
            if(sta_tus == "n"){
                sta_tus = change_boss_status_id;
            }
            if(sta_tus == 1){
                $('#loading'+id).show();
                $('#approve'+id).hide();
            }
            $.ajax({
                type: "POST",
                url: "{{$page_url}}/change_boss_status/"+id,
                data: {
                    boss_status : sta_tus,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('.dropdown-menu').hide();

                    $('#dropdown'+id).css('display','none');
                    loadData(page);
                }
            });
            // alert(page);
        }


</script>

@endsection