<style>
    .no-pointer {
        cursor: default !important;
    }
</style>
<div class="col-sm-6 col-lg-4" style="padding: 0 15px;">
    <div class="card card-border-shadow-info">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
                <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-success"><i class="ti ti-chevron-up ti-md"></i></span>
                </div>
                <h4 class="ms-1 mb-0 text-success" id="income_v">{{ number_format($income,2) }}</h4>
            </div>
            <p class="mb-1">รายรับทั้งหมด</p>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4" style="padding: 0 15px;">
    <div class="card card-border-shadow-danger">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
                <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-calendar-time ti-md"></i></span>
                </div>
                <h4 class="ms-1 mb-0 text-danger" id="expenses_v">{{ number_format($expenses,2) }}</h4>
            </div>
            <p class="mb-1">รายจ่ายทั้งหมด</p>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4 mb-4" style="padding: 0 15px;">
    <div class="card card-border-shadow-success" style="background-color: #dff7e9;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2 mt-1 pb-1">
                <h4 class="ms-1 mb-1" style="font-weight: 600;" id="total_v">{{ number_format($total,2) }}</h4>
            </div>
            <p class="mb-1">รวมทั้งหมด</p>
        </div>
    </div>
</div>