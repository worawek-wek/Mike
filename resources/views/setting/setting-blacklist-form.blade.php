<div class="modal-body">
    <div class="row g-3">
        <div class="col-sm-12">
            <input type="hidden" name="last_id" value="{{ @$blacklist->id }}">
            <label for="exampleFormControlSelect{{ @$blacklist->id }}" class="form-label">เลือกผู้เช่า</label>
            <select class="select2 form-select" name="id" id="exampleFormControlSelect{{ @$blacklist->id }}"
                aria-label="Default select example" required> <span class="text-danger">*</span>
                    <option value="">เลือกผู้เช่า</option>
                    @if (@$blacklist)
                        <option selected value="{{ $blacklist->id }}">{{ $blacklist->name }} {{ $blacklist->surname }}&nbsp; / &nbsp;{{ $blacklist->phone }}&nbsp; / &nbsp;{{ $blacklist->id_card_number }}</option>
                    @endif
                    @foreach ($renters as $renter)
                        <option value="{{ $renter->id }}">{{ $renter->name }} {{ $renter->surname }}&nbsp; / &nbsp;{{ $renter->phone }}&nbsp; / &nbsp;{{ $renter->id_card_number }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">รายละเอียด</label>
            <textarea class="form-control" name="blacklist_detail" id="exampleFormControlInput1" placeholder="รายละเอียด">{{ @$blacklist['blacklist_detail'] }}</textarea>
        </div>
    </div>
</div>
<div class="modal-footer rounded-0 justify-content-center">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
    <button type="submit" class="btn btn-main">บันทึก</button>
</div>