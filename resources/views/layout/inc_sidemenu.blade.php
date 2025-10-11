<script>
    if ("{{session('branch_id')}}" == '') {
        window.location.href = '/branch/manage';  // ทำการ redirect ถ้าไม่มี branch_id
    }
</script>
<style>
    /* สีพื้นหลัง sidebar */
    aside#layout-menu {
        background-color: #6f6f6f !important;
    }

    /* ปิด pseudo-element ที่อาจทับ background */
    aside#layout-menu .menu-link::before {
        display: none !important;
    }

    /* สีปกติของลิงก์เมนู (ยังไม่ active) */
    aside#layout-menu .menu-link > div,
    aside#layout-menu .menu-link i {
        color: white !important;
    }

    /* Hover (เมื่อเอาเมาส์ชี้) */
    aside#layout-menu .menu-link:hover > div,
    aside#layout-menu .menu-link:hover > i {
        color: #000000 !important;
    }

    /* เมนูหลักที่ active */
    aside#layout-menu .menu-item.active > .menu-link {
        background-color: #ffffff !important;
        color: #000000 !important;
        border-radius: 6px;
        font-weight: bold;
    }

    aside#layout-menu .menu-item.active > .menu-link > div,
    aside#layout-menu .menu-item.active > .menu-link i {
        color: #000000 !important;
    }

    /* เมนูย่อยที่ active */
    aside#layout-menu .menu-sub .menu-item.active > .menu-link {
        background-color: #f0f0f0 !important;
        color: #000000 !important;
        border-radius: 6px;
    }

    aside#layout-menu .menu-sub .menu-item.active > .menu-link > div,
    aside#layout-menu .menu-sub .menu-item.active > .menu-link i {
        color: #000000 !important;
    }

    /* ลบ gradient เดิมที่อาจถูกกำหนดใน theme เดิม */
    .bg-menu-theme.menu-vertical .menu-item.active > .menu-link:not(.menu-toggle) {
        background: #ffffff !important;
        color: #000000 !important;
    }
    .menu-vertical .menu-item .menu-toggle::after {
        color: white;
    }
    .menu-vertical .menu-item:hover .menu-toggle::after {
        color: #000000; /* หรือสีที่คุณต้องการเวลาชี้เมาส์ */
    }
    .menu-vertical .menu-item.active .menu-toggle::after {
        color: rgb(0, 0, 0);
    }
    .bg-menu-theme .menu-inner .menu-item.open > .menu-link.menu-toggle
    {
        background:#9d9da0;
    }
</style>
@php
    $permission_daschborad = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 1)->where('status', 0)->first();
    $permission_room = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 2)->where('status', 0)->first();
    $permission_meter = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 3)->where('status', 0)->first();
    $permission_bill = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 4)->where('status', 0)->first();
    $permission_income_expenses = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 15)->where('status', 0)->first();
    $permission_analysis = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 16)->where('status', 0)->first();
    $permission_report = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 17)->where('status', 0)->first();
    $permission_renter = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 18)->where('status', 0)->first();
    $permission_vehicle = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 19)->where('status', 0)->first();
    $permission_audit = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 20)->where('status', 0)->first();
    $permission_setting = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 21)->where('status', 0)->first();
    $permission_dorm_info = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 59)->where('status', 0)->first();/////
    $permission_manage_bill = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 60)->where('status', 0)->first();
    $permission_rental_contract = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 61)->where('status', 0)->first();
    $permission_room_layout = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 62)->where('status', 0)->first();
    $permission_water_electric_bill = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 63)->where('status', 0)->first();
    $permission_room_rent = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 64)->where('status', 0)->first();
    $permission_service_discount = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 65)->where('status', 0)->first();
    $permission_fine = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 66)->where('status', 0)->first();
    $permission_bank = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 67)->where('status', 0)->first();
    $permission_blacklist = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 68)->where('status', 0)->first();
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme pt-2">
    <div class="app-brand demo" style="height: 66px;">
        <div class="app-brand-link d-block text-center w-100">
            <img src="assets/img/illustrations/main.png" alt="" class="mw-100" height="100%">
        </div>

        <a href="javascript:void(0);" class="layout-menu-toggle text-large ms-auto" style="color: white;">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
          </a>
    </div>

    {{-- <div class="menu-inner-shadow"></div> --}}
    
    <ul class="menu-inner py-3">
        <li class="menu-item" @if(@$permission_daschborad) style='display:none;' @endif>
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        <li class="menu-item" @if(@$permission_room) style='display:none;' @endif>
            <a href="/room" class="menu-link">
                <i class="menu-icon tf-icons ti ti-sitemap"></i>
                <div>
                    <span data-i18n="ผังห้อง">ผังห้อง</span>
                    <span class="badge bg-danger text-white badge-notifications px-2 py-1 mx-3" id="countBookingRoom"></span>
                </div>
            </a>
        </li>
        <li class="menu-item" @if(@$permission_meter) style='display:none;' @endif>
            <a href="/meter" class="menu-link">
                <i class="menu-icon tf-icons ti ti-id"></i>
                <div data-i18n="มิเตอร์">มิเตอร์</div>
            </a>
        </li>
        <li class="menu-item" @if(@$permission_bill) style='display:none;' @endif>
            <a href="/bill" class="menu-link">
                <i class="menu-icon tf-icons ti ti-license"></i>
                <div>
                    <span data-i18n="บิลค่าเช่า">บิลค่าเช่า</span>
                    <span class="badge bg-danger text-white badge-notifications px-2 py-1 mx-3" id="countBill"></span>
                </div>
            </a>
        </li>
        <li class="menu-item" @if(@$permission_income_expenses) style='display:none;' @endif>
            <a href="/income-expenses" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calculator"></i>
                <div data-i18n="รายรับ-รายจ่าย">รายรับ-รายจ่าย</div>
            </a>
        </li>
        <!-- วิเคราะห์ -->
        <li class="menu-item" @if(@$permission_analysis) style='display:none;' @endif>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-circle-half-2"></i>
                <div data-i18n="วิเคราะห์">วิเคราะห์</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/analysis/monthly-rent" class="menu-link">
                        <div data-i18n="วิเคราะห์ค่าเช่ารายเดือน">วิเคราะห์ค่าเช่ารายเดือน</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/analysis/income-expense" class="menu-link">
                        <div data-i18n="วิเคราะห์รายรับ-รายจ่าย">วิเคราะห์รายรับ-รายจ่าย</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/analysis/water" class="menu-link">
                        <div data-i18n="วิเคราะห์ค่าน้ำ">วิเคราะห์ค่าน้ำ</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/analysis/elect" class="menu-link">
                        <div data-i18n="วิเคราะห์ค่าไฟ">วิเคราะห์ค่าไฟ</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/analysis/meter" class="menu-link">
                        <div data-i18n="วิเคราะห์มิเตอร์ผู้เช่า">วิเคราะห์มิเตอร์ผู้เช่า</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/analysis/tenants" class="menu-link">
                        <div data-i18n="วิเคราะห์การเข้าออกผู้เช่า">วิเคราะห์การเข้าออกผู้เช่า</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- รายงานสรุป -->
        <li class="menu-item" @if(@$permission_report) style='display:none;' @endif>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-chart-pie-3"></i>
                <div data-i18n="รายงานสรุป">รายงานสรุป</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/report/view-overview" class="menu-link">
                        <div data-i18n="ภาพรวม">ภาพรวม</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/report/rent-bill" class="menu-link">
                        <div data-i18n="รายงานบิลค่าเช่า">รายงานบิลค่าเช่า</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/report/move-in" class="menu-link">
                        <div data-i18n="รายงานย้ายเข้า">รายงานย้ายเข้า</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/report/move-out" class="menu-link">
                        <div data-i18n="รายงานย้ายออก">รายงานย้ายออก</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/report/bad-debt" class="menu-link">
                        <div data-i18n="รายงานหนี้สูญ">รายงานหนี้สูญ</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/report/monthly-booking" class="menu-link">
                        <div data-i18n="รายงานจองรายเดือน">รายงานจองรายเดือน</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item" @if(@$permission_renter) style='display:none;' @endif>
            <a href="/renter" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="ผู้เช่า">ผู้เช่า</div>
            </a>
        </li>
        <li class="menu-item" @if(@$permission_vehicle) style='display:none;' @endif>
            <a href="/vehicle" class="menu-link">
                <i class="menu-icon tf-icons ti ti-car"></i>
                <div data-i18n="ยานพาหนะ">ยานพาหนะ</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/user" class="menu-link">
                <i class="menu-icon tf-icons ti ti-copy"></i>
                <div data-i18n="บุคลากร">บุคลากร</div>
            </a>
        </li>
        <li class="menu-item" @if(@$permission_audit) style='display:none;' @endif>
            <a href="/audit" class="menu-link">
                <i class="menu-icon tf-icons ti ti-receipt-tax"></i>
                <div data-i18n="บัญชี">บัญชี</div>
            </a>
        </li>
        <!-- ตั้งค่าหอพัก -->
        <li class="menu-item" @if(@$permission_setting) style='display:none;' @endif>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-adjustments-horizontal"></i>
                <div data-i18n="ตั้งค่าหอพัก">ตั้งค่าหอพัก</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" @if(@$permission_dorm_info) style='display:none;' @endif>
                    <a href="/setting/dorm-info" class="menu-link">
                        <div data-i18n="ข้อมูลหอพัก">ข้อมูลหอพัก</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_manage_bill) style='display:none;' @endif>
                    <a href="/setting/manage-bill" class="menu-link">
                        <div data-i18n="จัดการบิล">จัดการบิล</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_rental_contract) style='display:none;' @endif>
                    <a href="/setting/rental-contract" class="menu-link">
                        <div data-i18n="สัญญาเช่า">สัญญาเช่า</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_room_layout) style='display:none;' @endif>
                    <a href="/setting/room-layout" class="menu-link">
                        <div data-i18n="ผังห้อง">ผังห้อง</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_water_electric_bill) style='display:none;' @endif>
                    <a href="/setting/water-electric-bill" class="menu-link">
                        <div data-i18n="ค่าน้ำ-ค่าไฟ">ค่าน้ำ-ค่าไฟ</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_room_rent) style='display:none;' @endif>
                    <a href="/setting/room-rent" class="menu-link">
                        <div data-i18n="ค่าเช่าห้อง">ค่าเช่าห้อง</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_service_discount) style='display:none;' @endif>
                    <a href="/setting/service-discount" class="menu-link">
                        <div data-i18n="ค่าบริการ ส่วนลด">ค่าบริการ ส่วนลด</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_fine) style='display:none;' @endif>
                    <a href="/setting/fine" class="menu-link">
                        <div data-i18n="ค่าปรับ">ค่าปรับ</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_bank) style='display:none;' @endif>
                    <a href="/setting/bank" class="menu-link">
                        <div data-i18n="บัญชีธนาคาร">บัญชีธนาคาร</div>
                    </a>
                </li>
                <li class="menu-item" @if(@$permission_blacklist) style='display:none;' @endif>
                    <a href="/setting/blacklist" class="menu-link">
                        <div data-i18n="บัญชีดำ">บัญชีดำ</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var currentUrl = window.location.pathname;
        var links = document.querySelectorAll(".menu-link");

        links.forEach(function (link) {
            var href = link.getAttribute("href");

            if (href && currentUrl.startsWith(href)) {
                var li = link.closest("li.menu-item");
                if (li) {
                    li.classList.add("active");

                    // เปิดเมนูแม่ ถ้ามี
                    var parentToggle = li.closest("ul.menu-sub");
                    if (parentToggle) {
                        var parentMenu = parentToggle.closest("li.menu-item");
                        if (parentMenu) {
                            parentMenu.classList.add("open", "active");
                        }
                    }
                }
            }
        });
    });
</script>