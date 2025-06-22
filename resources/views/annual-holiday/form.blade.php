                @csrf
                @php
                    $readonly = "";
                    if (Auth::user()->ref_position_id != 1) {
                        $readonly = "readonly";
                    }
                @endphp
                <table class="table -mt-2" style="width: -webkit-fill-available;">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">ลำดับ</th>
                            <th class="whitespace-nowrap">วันหยุด</th>
                            <th class="whitespace-nowrap">วันที่</th>
                            <th class="whitespace-nowrap">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no_a_h = 1 @endphp
                        @foreach ($annual_holiday as $a_h)
                        {{-- <input name="annual_holiday[{{ $a_h['id'] }}]['id']" type="hidden" value="{{ @$a_h['id'] }}"> --}}
                        @if (Auth::user()->ref_position_id == 1)
                        <tr class="intro-x" id="annual_holiday{{@$a_h->id}}">
                            <td class="w-5">
                                {{ $no_a_h++ }}
                            </td>
                            <td class="w-30">
                                <input name="annual_holiday[{{ $a_h['id'] }}][name]" type="text" class="form-control" placeholder="วันหยุด" value="{{ @$a_h->name }}" {{$readonly}}>
                            </td>
                            <td class="w-30">
                                <input name="annual_holiday[{{ $a_h['id'] }}][date]" type="date" class="form-control" value="{{@$a_h->date}}" {{$readonly}}>
                            </td>
                            <td class="w-30">
                                <input name="annual_holiday[{{ $a_h['id'] }}][remark]" type="text" class="form-control" placeholder="หมายเหตุ" value="{{ @$a_h->remark }}" {{$readonly}}>
                            </td>
                                <td class="w-10">
                                    <a class="flex items-center text-danger" href="javascript:;" onclick='HiddenWS({{@$a_h->id}})' data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        {{-- <i data-lucide="trash-2" class="block mx-auto w-5"></i> --}}
                                    </a>
                                </td>
                        </tr>
                        @else
                        <tr class="intro-x">
                            <td class="w-5">
                                {{ $no_a_h++ }}
                            </td>
                            <td class="w-30">
                                {{ @$a_h->name }}
                            </td>
                            <td class="w-30">
                                {{ @$a_h->date_th}}                          
                            </td>
                            <td class="w-30">
                                {{ @$a_h->remark }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @if (Auth::user()->ref_position_id == 1)
                            <tr class="intro-x">
                                <td class="w-5">
                                    {{ $no_a_h++ }}
                                </td>
                                <td class="w-30">
                                    <input name="annual_holiday[insert][name]" type="text" class="form-control" placeholder="วันหยุด" {{$readonly}}>
                                </td>
                                <td class="w-30">
                                    <input name="annual_holiday[insert][date]" type="date" class="form-control" placeholder="วันที่" {{$readonly}}>
                                </td>
                                <td class="w-30">
                                    <input name="annual_holiday[insert][remark]" type="text" class="form-control" placeholder="หมายเหตุ" {{$readonly}}>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="grid grid-cols-12 gap-x-5">
                
                    <div class="col-span-6 2xl:col-span-6">
                        <div id="SuccessWorkShift" style="display:none;" class="alert alert-success-soft show flex items-center mb-2" role="alert">
                            <i data-lucide="check" class="w-8 h-6 mr-2"></i> บันทึกข้อมูลเรียบร้อยแล้ว
                        </div>
                    </div>
                    @if (Auth::user()->ref_position_id == 1)
                        <div class="col-span-6 2xl:col-span-6">
                            <p align="right"><button type="submit" class="btn btn-success w-20 mb-4 mt-4" style="text-align: right;">บันทึก</button></p>
                        </div>
                    @endif
                </div>
