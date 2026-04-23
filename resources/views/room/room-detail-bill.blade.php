{{-- หน้าชำระเงิน --}}
<div class="alert alert-success text-black p-2 mt-4 px-2" role="alert" style="font-size: large;">บิลเดือน {{ $bill_month }}</div>
   @foreach ($receipt as $key => $item_receipt)
       
        <table class="table table-detail table-bordered">
            <thead>
                <tr>
                    <th width="40%" style="vertical-align: middle;font-weight: 500;">สถานะบิล</th>
                    <th style="vertical-align: middle; font-weight: 500;">
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <i class="ti ti-checkbox text-success" style="font-size: 34px"></i>
                            <div>
                                <span class="text-success">ชำระเงิน (ผ่านเคาน์เตอร์หอพัก)</span><br>
                                <span style="font-weight: 500; font-size: smaller;">
                                    เมื่อ {{ date('d/m/Y , H:i น.', strtotime($item_receipt->created_at)) }} โดย {{ $item_receipt->user->name }}
                                </span>
                            </div>
                        </div>
                        {{-- <span class="text-danger">ค้างชำระ</span><br> --}}
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> วันที่รับชำระเงิน </td>
                    <td>
                    @php
                        $date = new DateTime(date('Y-m-d', strtotime($item_receipt->created_at)));
                        $englishDay = $date->format('l');
                        
                    @endphp
                        {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($item_receipt->created_at)) !!}</td>
                </tr>
                <tr>
                    <td> ช่องทางการชำระเงิน </td>
                    <td>{{ $item_receipt->payment_channel == 1 ? "เงินสด": "โอนเงิน"; }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-detail table-bordered mt-4">
            <thead>
                <tr>
                    <th width="70%" style="vertical-align: middle;font-weight: 500;">รายการ</th>
                    <th style="vertical-align: middle;font-weight: 500;">
                        จำนวนเงิน (บาท)
                    </th>
                </tr>
            </thead>
            <tbody>
                    @php
                        $amount = 0;
                    @endphp
                @foreach ($item_receipt->payment_list as $key => $item_payment_list)
                    <tr>
                        <td class="{{$item_payment_list->discount == 1 ? "text-danger fw-bold" : ""}}">
                            {{ $item_payment_list->title }}
                        </td>

                            @if ($item_payment_list->discount == 1)
                                @php
                                    $amount -= $item_payment_list->price;
                                @endphp
                                <td class="text-danger fw-bold">{{ number_format(0-$item_payment_list->price) }}</td>

                            @else
                                @php    
                                $amount += $item_payment_list->price;
                                @endphp
                                <td>{{ number_format($item_payment_list->price) }}</td>

                            @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <th class=" mb-0 fw-bold" style="color: #28c76f !important;">
                    {{ number_format($amount) }}
                    </th>
                </tr>
            </tfoot>
        </table>
        <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
            <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{$item_receipt->id}})"><span
                    class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน</button>
        </div>
        @if(!$loop->last)
            <hr class="mb-4">
        @endif
@endforeach    
   @foreach ($invoice as $key => $item_invoice)
       
        <table class="table table-detail table-bordered">
            <thead>
                <tr>
                    <th width="40%" style="vertical-align: middle;font-weight: 500;">สถานะบิล </th>
                    <th style="vertical-align: middle; font-weight: 500;">
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <div>
                                @if($item_invoice->ref_status_id != 5)
                                    <span class="mx-2 badge bg-label-danger">ค้างชำระ</span>
                                @else
                                    <i class="ti ti-checkbox text-danger" style="font-size: 34px"></i>
                                    <span class="text-success">ชำระเงิน (ผ่านเคาน์เตอร์หอพัก)</span><br>
                                    <span style="font-weight: 500; font-size: smaller;">
                                        เมื่อ {{ date('d/m/Y , H:i น.', strtotime($item_invoice->created_at)) }} โดย {{ $item_invoice->user->name }}
                                    </span>
                                @endif    
                            </div>
                        </div>
                        {{-- <span class="text-danger">ค้างชำระ</span><br> --}}
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                
                @if($item_invoice->ref_status_id == 7)
                @else    
                                    
                    <tr>
                        <td> วันที่รับชำระเงิน </td>
                        <td>
                        @php
                            $date = new DateTime(date('Y-m-d', strtotime($item_invoice->created_at)));
                            $englishDay = $date->format('l');
                            
                        @endphp
                            {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($item_invoice->created_at)) !!}</td>
                    </tr>
                    <tr>
                        <td> ช่องทางการชำระเงิน </td>
                        <td>{{ $item_invoice->payment_channel == 1 ? "เงินสด": "โอนเงิน"; }}</td>
                    </tr>
                @endif 
            </tbody>
        </table>
        <table class="table table-detail table-bordered mt-4">
            <thead>
                <tr>
                    <th width="70%" style="vertical-align: middle;font-weight: 500;">รายการ</th>
                    <th style="vertical-align: middle;font-weight: 500;">
                        จำนวนเงิน (บาท)
                    </th>
                </tr>
            </thead>
            <tbody>
                    @php
                    // App\Models\RentBill::find($item_invoice->id);
                        $amount = 0;
                    @endphp
                @foreach ($item_invoice->payment_list as $key => $item_payment_list)
                    <tr>
                        <td class="{{$item_payment_list->discount == 1 ? "text-danger fw-bold" : ""}}">
                            {{ $item_payment_list->title }}
                        </td>

                            @if ($item_payment_list->discount == 1)
                                @php
                                    $amount -= $item_payment_list->price;
                                @endphp
                                <td class="text-danger fw-bold">{{ number_format(0-$item_payment_list->price) }}</td>

                            @else
                                @php    
                                $amount += $item_payment_list->price;
                                @endphp
                                <td>{{ number_format($item_payment_list->price) }}</td>

                            @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <th class=" mb-0 fw-bold" style="color: #28c76f !important;">
                    {{ number_format($amount) }}
                    </th>
                </tr>
            </tfoot>
        </table>
        <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
            <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdfInvoice({{$item_invoice->id}})"><span
                    class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้</button>
        </div>
        @if(!$loop->last)
            <hr class="mb-4">
        @endif
@endforeach    
<div class="mb-3"></div>  
<iframe id="print-iframe" style="display: none;"></iframe>                   
<script>
    function printPdf(id) {
        $.ajax({
            url: '/pdf/receipt/'+id,
            type: 'GET',
            success: function(html) {
                const iframe = document.getElementById('print-iframe');
                const doc = iframe.contentWindow.document;
                doc.open();
                doc.write(html);
                doc.close();

                // รอโหลดก่อนค่อยพิมพ์
                iframe.onload = function () {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };
            },
            error: function(xhr) {
                alert('เกิดข้อผิดพลาด');
                console.error(xhr.responseText);
            }
        });
    }
    function printPdfInvoice(id) {
        $.ajax({
            url: '/pdf/invoice/'+id,
            type: 'GET',
            success: function(html) {
                const iframe = document.getElementById('print-iframe');
                const doc = iframe.contentWindow.document;
                doc.open();
                doc.write(html);
                doc.close();

                // รอโหลดก่อนค่อยพิมพ์
                iframe.onload = function () {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let messages = '';
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        messages += value + '<br>';
                    });

                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        html: messages,
                        icon: 'error',
                    });
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                    console.error('เกิดข้อผิดพลาด:', xhr);
                }
            }
        });
    }
</script>