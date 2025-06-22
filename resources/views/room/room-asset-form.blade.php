            <!-- ชื่อทรัพย์สิน + โทรทัศน์ -->
            @csrf
            <input type="hidden" name="id" value="{{ $room_has_asset->id }}">
            <div class="row">
                <label class="col-sm-4 col-form-label text-black"><strong>ชื่อทรัพย์สิน</strong></label>
                <div class="col-sm-8">
                <div class="form-control-plaintext">{{ $room_has_asset->asset->name }}</div>
                </div>
            </div>

            <!-- ค่าปรับ -->
            <div class="row">
                <label class="col-sm-4 col-form-label text-black"><strong>ค่าปรับ (กรณีเสียหาย)</strong></label>
                <div class="col-sm-8">
                <div class="form-control-plaintext">{{ number_format($room_has_asset->asset->fine) }}</div>
                </div>
            </div>

            <!-- สถานะทรัพย์สิน -->
            <div class="row">
                <label class="col-sm-4 col-form-label text-black"><strong>สถานะทรัพย์สิน</strong></label>
                <div class="col-sm-8">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="asset_yes" value="1"
                    @if ($room_has_asset->status == 1)
                        checked
                    @endif>
                    <label class="form-check-label" for="asset_yes">มี</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="asset_no" value="0"
                    @if ($room_has_asset->status == 0)
                        checked
                    @endif>
                    <label class="form-check-label" for="asset_no">ไม่มี</label>
                </div>
                </div>
            </div>

            <!-- สภาพทรัพย์สิน -->
            <div class="row">
                <label class="col-sm-4 col-form-label text-black"><strong>สภาพทรัพย์สิน</strong></label>
                <div class="col-sm-8">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="condition" id="condition_ok" value="1" 
                    @if ($room_has_asset->condition == 1)
                        checked
                    @endif>
                    <label class="form-check-label" for="condition_ok">เรียบร้อย</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="condition" id="condition_not_ok" value="0"
                    @if ($room_has_asset->condition == 0)
                        checked
                    @endif>
                    <label class="form-check-label" for="condition_not_ok">ไม่เรียบร้อย</label>
                </div>
                </div>
            </div>

            <!-- หมายเหตุ -->
            <div class="row">
                <label for="note" class="col-sm-12 col-form-label text-black"><strong>หมายเหตุ</strong>
                <textarea class="form-control mt-1" id="note" name="remark" rows="3" placeholder="กรอกหมายเหตุ">{{ $room_has_asset->remark }}</textarea>
                </label>
            </div>

            <!-- รูปภาพก่อนเข้าพัก -->
            <div class="row mt-1">
                <label for="image" class="col-sm-12 col-form-label text-black">
                <strong>รูปภาพก่อนเข้าพัก</strong>
                <input class="form-control mt-1" type="file" id="image" name="image_name" accept="image/*" onchange="previewImage(event)">
                </label>
            </div>
            
            <!-- Preview image -->
            <div class="row mt-2">
                <div class="col-sm-12">
                <img id="preview" alt="Preview" style="@if(!@$room_has_asset->image_name) display: none; @endif max-height: 200px;" class="img-thumbnail" src="/upload/asset/{{ $room_has_asset->image_name }}">
                </div>
            </div>
            
            <script>
                function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('preview');
            
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
            
                    reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    };
            
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
                }
            </script>
            

            <!-- ปุ่ม -->
            <div class="row mt-4">
                <div class="col-sm-12 text-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-info text-white">บันทึก</button>
                </div>
            </div>