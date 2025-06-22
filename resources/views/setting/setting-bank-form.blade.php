<div class="modal-body">
    <div class="row g-3">
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">เลือกบัญชีธนาคาร</label>
            <select class="select2 form-select" name="bank" id="exampleFormControlSelect1"
                aria-label="Default select example">
                {{-- <option selected>บัญชีธนาคาร</option> --}}
                <option @if (@$bank['bank'] == "พร้อมเพย์") selected @endif value="พร้อมเพย์">พร้อมเพย์</option>
                <option @if (@$bank['bank'] == "ธนาคารกรุงเทพ") selected @endif value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                <option @if (@$bank['bank'] == "ธนาคารกสิกรไทย") selected @endif value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                <option @if (@$bank['bank'] == "ธนาคารกรุงไทย") selected @endif value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                <option @if (@$bank['bank'] == "ธนาคารทหารไทยธนชาต") selected @endif value="ธนาคารทหารไทยธนชาต">ธนาคารทหารไทยธนชาต</option>
                <option @if (@$bank['bank'] == "ธนาคารไทยพาณิชย์") selected @endif value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                <option @if (@$bank['bank'] == "ธนาคารกรุงศรีอยุธยา") selected @endif value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                <option @if (@$bank['bank'] == "ธนาคารออมสิน") selected @endif value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                {{-- <option @if (@$bank['bank'] == "ธนาคารอาคารสงเคราะห์") selected @endif value="ธนาคารอาคารสงเคราะห์">ธนาคารอาคารสงเคราะห์</option>
                <option @if (@$bank['bank'] == "ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร") selected @endif value="ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร">ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร</option>
                <option @if (@$bank['bank'] == "ธนาคารธนชาต") selected @endif value="ธนาคารธนชาต">ธนาคารธนชาต</option>
                <option @if (@$bank['bank'] == "ธนาคารเกียรตินาคิน") selected @endif value="ธนาคารเกียรตินาคิน">ธนาคารเกียรตินาคิน</option>
                <option @if (@$bank['bank'] == "ธนาคารซีไอเอ็มบีไทย") selected @endif value="ธนาคารซีไอเอ็มบีไทย">ธนาคารซีไอเอ็มบีไทย</option>
                <option @if (@$bank['bank'] == "ธนาคารอิสลามแห่งประเทศไทย") selected @endif value="ธนาคารอิสลามแห่งประเทศไทย">ธนาคารอิสลามแห่งประเทศไทย</option>
                <option @if (@$bank['bank'] == "ธนาคารทิสโก้") selected @endif value="ธนาคารทิสโก้">ธนาคารทิสโก้</option>
                <option @if (@$bank['bank'] == "ธนาคารยูโอบี") selected @endif value="ธนาคารยูโอบี">ธนาคารยูโอบี</option>
                <option @if (@$bank['bank'] == "ธนาคารแลนด์ แอนด์ เฮาส์") selected @endif value="ธนาคารแลนด์ แอนด์ เฮาส์">ธนาคารแลนด์ แอนด์ เฮาส์</option>
                <option @if (@$bank['bank'] == "ธนาคารไอซีบีซี (ไทย)") selected @endif value="ธนาคารไอซีบีซี (ไทย)">ธนาคารไอซีบีซี (ไทย)</option>
                <option @if (@$bank['bank'] == "ธนาคารไทยเครดิต") selected @endif value="ธนาคารไทยเครดิต">ธนาคารไทยเครดิต</option> --}}
            </select>
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput1" class="form-label">สาขา</label>
            <input type="text" class="form-control" name="branch" id="exampleFormControlInput1" placeholder="" value="{{ @$bank['branch'] }}" />
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput1" class="form-label">ชื่อบัญชี</label>
            <input type="text" class="form-control" name="bank_account_name" id="exampleFormControlInput1" placeholder="" value="{{ @$bank['bank_account_name'] }}" />
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">เลขที่บัญชี</label>
            <input type="text" class="form-control" name="bank_account_number" id="exampleFormControlInput1" placeholder="" value="{{ @$bank['bank_account_number'] }}"/>
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput1" class="form-label">หมายเหตุ</label>
            <input type="text" class="form-control" name="remark" id="exampleFormControlInput1" placeholder="" value="{{ @$bank['remark'] }}"/>
        </div>
    </div>
</div>
<div class="modal-footer rounded-0 justify-content-center">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
    <button type="submit" class="btn btn-main">บันทึก</button>
</div>