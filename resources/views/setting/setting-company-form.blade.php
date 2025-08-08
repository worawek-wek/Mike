
    <link rel="stylesheet" href="assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="assets/vendor/libs/quill/editor.css" />
<div class="modal-body">
    <div class="row g-3">
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">ชื่อบริษัท</label>
            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="" value="{{ @$company['name'] }}" />
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">รายละเอียด</label>
            <input type="text" class="form-control" name="detail" id="exampleFormControlInput1" placeholder="" value="{{ @$company['detail'] }}" />
        </div>
        <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="card mb-3">
                                    <div class="card-header border-bottom border-light">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-6">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-news text-main ti-md"></i>
                                                    สัญญาเช่า
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <form>
                                            <h4>คลิกเพื่อใส่ข้อมูล</h4>
                                            <div id="full-editor"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</div>
<div class="modal-footer rounded-0 justify-content-center">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
    <button type="submit" class="btn btn-main">บันทึก</button>
</div>

    <script src="assets/vendor/libs/quill/katex.js"></script>
    <script src="assets/vendor/libs/quill/quill.js"></script>
    <script src="assets/js/forms-editors.js"></script>
    