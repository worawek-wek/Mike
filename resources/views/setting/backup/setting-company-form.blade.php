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
    </div>
</div>
<div class="modal-footer rounded-0 justify-content-center">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
    <button type="submit" class="btn btn-main">บันทึก</button>
</div>