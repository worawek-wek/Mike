                @csrf
                @php
                    $readonly = "";
                    if (Auth::user()->ref_position_id != 1) {
                        $readonly = "readonly";
                    }
                @endphp
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No.</th>
                            <th class="whitespace-nowrap">Name</th>
                            <th class="whitespace-nowrap">From time</th>
                            <th class="whitespace-nowrap">To time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no_w_s = 1 @endphp
                        @foreach ($work_shift as $w_s)
                        {{-- <input name="work_shift[{{ $w_s['id'] }}]['id']" type="hidden" value="{{ @$w_s['id'] }}"> --}}
                        <tr class="intro-x" id="work_shift{{@$w_s->id}}">
                            <td class="w-5">
                                {{ $no_w_s++ }}
                            </td>
                            <td class="w-30">
                                <input name="work_shift[{{ $w_s['id'] }}][work_shift_name]" type="text" class="form-control" placeholder="Name" value="{{ @$w_s->work_shift_name }}" {{$readonly}}>
                            </td>
                            <td class="w-30">
                                <input name="work_shift[{{ $w_s['id'] }}][from_time]" type="time" class="form-control" value="{{@$w_s->from_time}}" {{$readonly}}>
                            </td>
                            <td class="w-30">
                                <input name="work_shift[{{ $w_s['id'] }}][to_time]" type="time" class="form-control" value="{{@$w_s->to_time}}" {{$readonly}}>
                            </td>
                            @if (Auth::user()->ref_position_id == 1)
                                <td class="w-10">
                                    <a class="flex items-center text-danger" href="javascript:;" onclick='HiddenWS({{@$w_s->id}})' data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        {{-- <i data-lucide="trash-2" class="block mx-auto w-5"></i> --}}
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        <tr class="intro-x">
                            <td class="w-5">
                                {{ $no_w_s++ }}
                            </td>
                            <td class="w-30">
                                <input name="work_shift[insert][work_shift_name]" type="text" class="form-control" placeholder="Name" {{$readonly}}>
                            </td>
                            <td class="w-30">
                                <input name="work_shift[insert][from_time]" type="time" class="form-control" placeholder="From time" {{$readonly}}>
                            </td>
                            <td class="w-30">
                                <input name="work_shift[insert][to_time]" type="time" class="form-control" placeholder="To time" {{$readonly}}>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="grid grid-cols-12 gap-x-5">
                
                    <div class="col-span-6 2xl:col-span-6">
                        <div id="SuccessWorkShift" style="display:none;" class="alert alert-success-soft show flex items-center mb-2" role="alert">
                            <i data-lucide="check" class="w-8 h-6 mr-2"></i> Saved successfully.
                        </div>
                    </div>
                    @if (Auth::user()->ref_position_id == 1)
                        <div class="col-span-6 2xl:col-span-6">
                            <p align="right"><button type="submit" class="btn btn-success w-20 mb-4 mt-4" style="text-align: right;">Save</button></p>
                        </div>
                    @endif
                </div>
