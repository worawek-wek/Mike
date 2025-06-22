@extends('../layout/' . $layout)

@section('subhead')
    <title>เพิ่ม พนักงาน</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{$title}}</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- END: Profile Menu -->
        <div class="col-span-12">
            <!-- BEGIN: Display Information -->
            <form action="{{$action}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="intro-y box lg:mt-5">
                <div class="p-5">
                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <button type="submit" class="btn btn-primary w-20 mb-4" style="text-align: right;">บันทึก</button>
                            <div class="grid grid-cols-12 gap-x-5">
                                <div class="col-span-12 2xl:col-span-6">
                                    <div>
                                        <label for="update-profile-form-1" class="form-label">ชื่อ - นามสกุล</label>
                                        <input name="name" id="update-profile-form-1" type="text" class="form-control" placeholder="ชื่อ-นามสกุล" value="{{ @$user['name'] }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-10" class="form-label">รหัสพนักงาน</label>
                                        <input name="employee_id" id="update-profile-form-10" type="text" class="form-control" placeholder="รหัสพนักงาน" value="{{ @$user['employee_id'] }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-2" class="form-label">Email</label>
                                        <input name="email" id="update-profile-form-2" type="email" class="form-control" placeholder="Email" value="{{ @$user['email'] }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-10" class="form-label">เบอร์โทรศัพท์</label>
                                        <input name="phone" id="update-profile-form-10" type="text" class="form-control" placeholder="เบอร์โทรศัพท์" value="{{ @$user['phone'] }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-3" class="form-label">วันที่เข้างาน</label>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                        </div>
                                        <input type="text" class="datepicker form-control pl-12" name="work_start_date" id="update-profile-form-3" placeholder="Work start date" value="{{@$user->work_start_date}}" data-single-mode="true">
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-4" class="form-label">วันเกิด</label>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                        </div>
                                        
                                    
                                        {{-- <input type="text" class="datepicker form-control w-56 block mx-auto" data-single-mode="true" > --}}
                                    
                                
                                        <input type="text" class="datepicker form-control pl-12" name="birthday" id="update-profile-form-4" placeholder="Work start date" value="{{@$user->birthday}}" data-single-mode="true" onchange="ageCalcu(this.value)">
                                        {{-- <input name="birthday" id="update-profile-form-4" type="date" class="form-control" placeholder="Dirthday" value="{{ @$user['birthday'] }}" onchange="ageCalcu(this.value)"> --}}
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-5" class="form-label">อายุ</label>
                                        <input id="update-profile-form-5" type="text" class="form-control" placeholder="อายุ" disabled>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <label for="update-profile-form-11" class="form-label">ที่อยู่</label>
                                        <textarea name="address" id="update-profile-form-11" class="form-control" placeholder="ที่อยู่">{{ @$user['address'] }}</textarea>
                                    </div>
                                    {{-- <div class="mt-3">
                                        <label for="update-profile-form-6" class="form-label">Work start date</label>
                                        <input name="email" id="update-profile-form-6" type="work_start_date" class="form-control" placeholder="Work start date" value="{{ @$user['work_start_date'] }}">
                                    </div> --}}
                                </div>
                                <div class="col-span-12 2xl:col-span-6">
                                    <div class="mt-3 2xl:mt-0">
                                        <label for="update-profile-form-6" class="form-label">สาขา</label>
                                        <select name="ref_branch_id" id="update-profile-form-6" data-search="true" class="tom-select w-full">
                                            @foreach ($branch as $bra)
                                                <option @if($bra->id == @$user['ref_branch_id']) selected @endif value="{{$bra->id}}">{{$bra->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label for="update-profile-form-6" class="form-label">ตำแหน่ง</label>
                                        <select name="ref_position_id" id="update-profile-form-6" data-search="true" class="tom-select w-full">
                                            @foreach ($position as $pos)
                                                <option @if($pos->id == @$user['ref_position_id']) selected @endif value="{{$pos->id}}">{{$pos->position_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label for="update-profile-form-7" class="form-label">หัวหน้างาน</label>
                                        <select name="ref_user_id" id="update-profile-form-7" data-search="true" class="tom-select w-full">
                                            @foreach ($boss as $bos)
                                                <option @if($bos->id == @$user['ref_user_id']) selected @endif value="{{$bos->id}}">{{$bos->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label for="update-profile-form-8" class="form-label">กะ</label>
                                        <select name="ref_work_shift_id" id="update-profile-form-8" data-search="true" class="tom-select w-full">
                                            @foreach ($work_shift as $wos)
                                                <option @if($wos->id == @$user['ref_work_shift_id']) selected @endif value="{{$wos->id}}">{{$wos->work_shift_name.' '.$wos->from_time.' - '.$wos->to_time }} น.</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-9" class="form-label">ตารางวันหยุด</label>
                                        <select name="ref_schedule_id" id="update-profile-form-9" data-search="true" class="tom-select w-full">
                                            @foreach ($schedule as $wos)
                                                <option @if($wos->id == @$user['ref_schedule_id']) selected @endif value="{{$wos->id}}">{{$wos->schedule_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                              
                                    <div class="mt-3">
                                        <label for="update-profile-form-10" class="form-label">ลา</label>                      
                                            <select data-placeholder="Select your favorite actors" id="leave" class="tom-select w-full" onchange="dayLeave()" multiple>
                                                @foreach ($leave as $lea)
                                                    <option @if(in_array($lea->id ,@$user['leave_just_id'])) selected @endif value="{{$lea->id}}">{{$lea->leave_name}}</option>
                                                @endforeach
                                            </select>
                                    </div>  
                                    <div class="mt-3" id="NumberOfLeaveDays">
                                        @foreach ($leave as $lea2)
                                            @if(in_array($lea2->id ,@$user['leave_just_id']))
                                                <div id="diveLeaveId{{$lea2->id}}">
                                                    <label for="leaveId{{$lea2->id}}" class="form-label mt-3">{{$lea2->leave_name}}</label>
                                                    <input name="ref_leave_id[{{$lea2->id}}]"  id="leaveId{{$lea2->id}}" type="text" class="form-control" placeholder="Number of leave days" value="{{@$user->leave_id_number[$lea2->id]}}">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <script>
                                    var leaveIdArray = <?php echo json_encode(array_map('intval',@$user['leave_just_id'])) ?>;
                                    function dayLeave(){
                            
                                        var selectElement = document.getElementById("leave");
                                        var selectedOptions = [];
                                            for (var i = 0; i < selectElement.options.length; i++) {
                                                let leaveId = selectElement.options[i].value; // id ของ leave
                                                // console.log(selectElement.options[i].text);
                                                if ($("#leaveId"+leaveId).length === 0 & selectElement.options[i].selected) {
                                                        let NumberOfLeaveDays = '<div id="diveLeaveId'+leaveId+'">'
                                                                                +'<label for="leaveId'+leaveId+'" class="form-label mt-3">'+selectElement.options[i].text+'</label>'
                                                                                +'<input name="ref_leave_id['+leaveId+']" id="leaveId'+leaveId+'" type="text" class="form-control" placeholder="Number of leave days'+leaveId+'">'
                                                                                +'</div>';
                                                    $("#NumberOfLeaveDays").append(NumberOfLeaveDays);
                                                    selectedOptions.push(selectElement.options[i].value);
                                            }
                                            if(!selectElement.options[i].selected){
                                                $('#diveLeaveId'+leaveId).remove();
                                            }
                                        }
                                    }   
                                </script>
                                @php
                                    $label_pass = "รหัสผ่าน";
                                    if (!@$user) {
                                        $label_pass = "เปลี่ยนรหัสผ่าน";
                                    }
                                    if(empty($image_path)){
                                        $image_path = asset('dist/images/user.png');
                                    }
                                @endphp
                                <div class="col-span-12 2xl:col-span-6">
                                    <div class="mt-3">
                                        <label for="update-profile-form-2" class="form-label">{{$label_pass}}</label>
                                        <input name="password" id="password" type="password" class="form-control" placeholder="{{$label_pass}}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="update-profile-form-3" class="form-label">ยืนยัน รหัสผ่าน</label>
                                        <input id="confirm_password" type="password" class="form-control" placeholder="ยืนยัน รหัสผ่าน">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-20 mt-6">บันทึก</button>
                        </div>
                        <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                            <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                    <img class="rounded-md imagePreview" alt="Midone - HTML Admin Template" src="{{ $image_path }}">
                                    {{-- <img class="rounded-md" alt="Midone - HTML Admin Template" src="{{ asset('dist/images/' . $fakers[0]['photos'][0]) }}"> --}}
                                    {{-- <div title="Remove this profile photo?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </div> --}}
                                </div>
                                <div class="mx-auto cursor-pointer relative mt-5">
                                    <button type="button" class="btn btn-primary w-full">รูปภาพ</button>
                                    <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="image_name" onchange="imgChange(this)" value="{{ @$user['image_name'] }}">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            </form>
            <!-- END: Personal Information -->
        </div>
    </div>
    <script>
        ageCalcu();
        document.addEventListener('click', function(event) {
            // เมื่อมีคลิกเกิดขึ้น จะเข้าถึง event.target เพื่อหาองค์ประกอบที่ถูกคลิก
                ageCalcu();
        });
        function ageCalcu(){
            let Birthday = document.getElementById("update-profile-form-4").value;
            // alert(Birthday);
            var birthDate = new Date(Birthday);

            // ใช้ฟังก์ชั่นใน Date Object ในการเอาข้อมูลมาสร้าง string ใหม่ตาม format ที่ต้องการ
            var birthDateFormat = birthDate.getFullYear() + '-' + ('0' + (birthDate.getMonth() + 1)).slice(-2) + '-' + ('0' + birthDate.getDate()).slice(-2);
                    // return alert(v);
            var currentDate = new Date();
            // วันเกิด
            var dob = new Date(birthDateFormat);
            
            // หาความแตกต่างระหว่างวันที่ปัจจุบันกับวันเกิด
            var diff = currentDate.getTime() - dob.getTime();
            
            // หาปี
            var years = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
            diff -= years * (1000 * 60 * 60 * 24 * 365.25);
            
            // หาเดือน
            var months = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.44));
            diff -= months * (1000 * 60 * 60 * 24 * 30.44);
            
            // หาวัน
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            
            // แสดงผลลัพธ์
            document.getElementById("update-profile-form-5").value = years + " years " + months + " months " + days + " days";
        }
    </script>
    <script>
        var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");

        function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;

        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                $('.imagePreview').show();
                reader.onload = function(e) {
                $('.imagePreview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]); // convert to base64 string
                var nameImg = $('#nameImg').val();
                if(nameImg == ''){
                    var productCode = $('#productCode').val();
                    var productName = $('#productName').val();
                    
                    $('#nameImg').val(productCode+'_'+productName);
                }
            }
        }
            function imgChange(t) {
            
            const size =  
                    (t.files[0].size / 1024 / 1024).toFixed(2); 

                if (size > 2) { 
                    $('#customFile').val(null);
                     alert("The image size must not exceed 2 MB."); 
                     return false;
                }
            readURL(t);
        }
    </script> 

@endsection
