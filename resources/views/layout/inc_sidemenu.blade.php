<script>
    if ("{{session('branch_id')}}" == '') {
        window.location.href = '/branch/manage';  // ทำการ redirect ถ้าไม่มี branch_id
    }
</script>
<style>
    .active .menu-link i {
        color: #000000 !important; /* เปลี่ยนสีของไอคอนใน <li> ที่มีคลาส active */
    }
    .active .menu-link {
        color: #000000 !important; /* เปลี่ยนสีของไอคอนใน <li> ที่มีคลาส active */
        background: white !important;
    }
    .active .menu-link > div {
        color: #000000 !important;
    }
    .layout-menu{
        background-color: #6f6f6f !important;
    }
    .menu-link > div{
        color:white;
    }
    .menu-link i {
        color: white !important; /* เปลี่ยนสีของไอคอนใน <li> ที่มีคลาส active */
    }
    .menu-link:hover > div,
    .menu-link:hover > i {
        color: #000000 !important; /* Change background on hover */
    }
    .menu-toggle::after {
        content: "";
        position: absolute;
        top: 48%;
        display: block;
        width: 0.42em;
        height: 0.42em;
        border: 1.5px solid white;
        border-bottom: 0;
        border-left: 0;
        transform: translateY(-50%) rotate(45deg);
    }
    .menu-item.open .menu-toggle::after {
        content: "";
        position: absolute;
        top: 48%;
        display: block;
        width: 0.42em;
        height: 0.42em;
        border: 1.5px solid #6f6f6f;
        border-bottom: 0;
        border-left: 0;
        transform: translateY(-50%) rotate(45deg);
    }
    .menu-item.open .menu-icon {
        color: #6f6f6f !important; /* เปลี่ยนสีพื้นหลัง */
    }
    .menu-item.open .menu-toggle > div {
        color: #6f6f6f !important; /* เปลี่ยนสีพื้นหลัง */
        font-weight: 500;
    }
    /* .menu-link > i:hover {
        color: #53b9b8 !important; /* เปลี่ยนสีของไอคอนใน <li> ที่มีคลาส active */
</style>
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
        <li class="menu-item">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/room" class="menu-link">
                <i class="menu-icon tf-icons ti ti-sitemap"></i>
                <div data-i18n="ผังห้อง">ผังห้อง</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/meter" class="menu-link">
                <i class="menu-icon tf-icons ti ti-id"></i>
                <div data-i18n="มิเตอร์">มิเตอร์</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/bill" class="menu-link">
                <i class="menu-icon tf-icons ti ti-license"></i>
                <div data-i18n="บิลค่าเช่า">บิลค่าเช่า</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/income-expenses" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calculator"></i>
                <div data-i18n="รายรับ-รายจ่าย">รายรับ-รายจ่าย</div>
            </a>
        </li>
        <!-- วิเคราะห์ -->
        <li class="menu-item">
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
        <li class="menu-item">
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
        <li class="menu-item">
            <a href="/renter" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="ผู้เช่า">ผู้เช่า</div>
            </a>
        </li>
        <li class="menu-item">
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
        <li class="menu-item">
            <a href="/audit" class="menu-link">
                <i class="menu-icon tf-icons ti ti-receipt-tax"></i>
                <div data-i18n="บัญชี">บัญชี</div>
            </a>
        </li>
        <!-- ตั้งค่าหอพัก -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-adjustments-horizontal"></i>
                <div data-i18n="ตั้งค่าหอพัก">ตั้งค่าหอพัก</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/setting/dorm-info" class="menu-link">
                        <div data-i18n="ข้อมูลหอพัก">ข้อมูลหอพัก</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/manage-bill" class="menu-link">
                        <div data-i18n="จัดการบิล">จัดการบิล</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/rental-contract" class="menu-link">
                        <div data-i18n="สัญญาเช่า">สัญญาเช่า</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/room-layout" class="menu-link">
                        <div data-i18n="ผังห้อง">ผังห้อง</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/water-electric-bill" class="menu-link">
                        <div data-i18n="ค่าน้ำ-ค่าไฟ">ค่าน้ำ-ค่าไฟ</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/room-rent" class="menu-link">
                        <div data-i18n="ค่าเช่าห้อง">ค่าเช่าห้อง</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/service-discount" class="menu-link">
                        <div data-i18n="ค่าบริการ ส่วนลด">ค่าบริการ ส่วนลด</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/fine" class="menu-link">
                        <div data-i18n="ค่าปรับ">ค่าปรับ</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/setting/bank" class="menu-link">
                        <div data-i18n="บัญชีธนาคาร">บัญชีธนาคาร</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var links = document.querySelectorAll("ul li a");
        var currentUrl = window.location.pathname;

        links.forEach(function(link) {
            if (link.getAttribute("href") === currentUrl) {
                link.parentElement.classList.add("active");
            }
        });
    });
    </script>