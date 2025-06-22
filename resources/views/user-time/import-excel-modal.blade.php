    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-10 text-center">
                {{-- <form id="import_excel_user"> --}}
                    
                    <input class="mb-4" type="file" id="file_excel" name="file_excel" onchange="change_file()">
                    <div id="table-excel">
                        {{-- ตรงนี้ เอาไว้แสดงรายการซ้ำ และ รายการใหม่ --}}
                    </div>
                    <button id="check_import_excel_user" style="color:white;background-color: #62ed1f;margin: auto;margin-top: revert-layer;" class="btn btn-success shadow-md mr-2 mt-4" onclick="check_import_excel_user()" disabled>อัพโหลด ไฟล์ Excel</button>
                    <button id="import_excel_user" style="display:none;color:white;background-color: #62ed1f;margin: auto;margin-top: revert-layer;" class="btn btn-success shadow-md mr-2 mt-4" onclick="import_excel_user()">ยืนยัน อัพโหลด ไฟล์ Excel</button>
                {{-- </form> --}}
            </div>
        </div>
    </div>