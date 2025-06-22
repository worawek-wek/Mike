
@section('subhead')

@endsection
    @php
        if(@$date_from_to){
            $value_date_from_to = $date_from_to;
        }else{
            $value_date_from_to = date('Y-m-01', strtotime('first day of last month')).' - '.date('Y-m-t', strtotime('last day of last month'));

        }
    @endphp
    
<input name="date_from_to" type="text" data-daterange="true" class="datepicker form-control w-56 block mx-auto p_search" id="date_from_to"
value="{{ $value_date_from_to }}">
