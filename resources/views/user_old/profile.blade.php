@extends('../layout/' . $layout)

@section('subhead')
    <title>{{ $user->name }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $title }}</h2>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img data-action="zoom" alt="View picture" class="rounded-full" @if(!empty($user->image_name)) src="{{ asset('upload/user/' . $user->image_name) }}" @else src="{{asset('dist/images/user-index.png')}}" @endif>
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->name }}</div>
                    <div class="text-slate-500">{{ $user->position_name }}</div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>รหัส &nbsp; &nbsp; &nbsp; </b> {{ $user->employee_id }}
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>ชื่อ-นามสกุล &nbsp; &nbsp; &nbsp; </b> {{ $user->name }}
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>ชื่อเล่น &nbsp; &nbsp; &nbsp; </b> {{ $user->nickname }}
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>เพศ &nbsp; &nbsp; &nbsp; </b> 
                        @php
                            if($user->gender == 1){
                                echo "ชาย";
                            }else{
                                echo "หญิง";
                            };
                        @endphp
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>วันที่เริ่มงาน &nbsp; &nbsp; &nbsp; </b> {{ $user->work_start_date_th }} (<span id="workkingCalcuShow" style="color: #37d01a;"></span>)
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>เกิด &nbsp; &nbsp; &nbsp; </b> {{ $user->birthday_th }} (<span id="oldCalcuShow" style="color: #37d01a;"></span>)
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <i data-lucide="mail" class="w-4 h-4 mr-2"></i> &nbsp; &nbsp; &nbsp; {{ $user->email }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <i data-lucide="phone" class="w-4 h-4 mr-2"></i> &nbsp; &nbsp; &nbsp; {{ $user->phone }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i> &nbsp; &nbsp; &nbsp; {{ $user->address }}
                    </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <b>สาขา &nbsp; &nbsp; &nbsp; </b> {{ $user->branch->branch_name }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <b>ตำแหน่ง &nbsp; &nbsp; &nbsp; </b> {{ $user->position->position_name }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <b>หัวหน้างาน &nbsp; &nbsp; &nbsp; </b> {{ $user->user->name }}
                    </div>
                </div><br>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    @if ($user->ref_branch_id == 8)
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <b>วันหยุด &nbsp; &nbsp; &nbsp; </b> {{ $user->schedule->schedule_name }}
                        </div>
                    @endif
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <b>กะการทำงาน &nbsp; &nbsp; &nbsp; </b> {{ $user->work_shift->work_shift_name }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <b>หัวหน้างาน &nbsp; &nbsp; &nbsp; </b> {{ $user->user->name }}
                    </div>
                </div>
            </div>
        </div>
        <script>
                workkingCalcu();
                oldCalcu();
                function workkingCalcu(){
                    let Startday = "{{ $user->work_start_date }}";
                    document.getElementById("workkingCalcuShow").innerText = ageCalcu(Startday);
                }
                function oldCalcu(){
                    let Birthday = "{{ $user->birthday }}";
                    document.getElementById("oldCalcuShow").innerText = ageCalcu(Birthday);
                }
                function ageCalcu(date){
                    // alert(date);
                    var birthDate = new Date(date);

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
                    let result = '';
                    if(years > 0){
                        result += years + " ปี ";
                    }
                    if(months > 0){
                        result += months + " เดือน ";
                    }
                    if(days > 0){
                        result += days + " วัน ";
                    }
                    return result;
                }
        </script>
            </div>
        </div>
    </div>
@endsection
