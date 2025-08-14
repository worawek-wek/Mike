<div class="p-2">
    <label class="h5 mb-1">เลือกข้อมูลจากผู้เช่า</label>
        <select name="ref_renter_id" class="form-select form-control" onchange="get_room_rental_contract(this.value)" required>
            <option selected disabled hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
            @foreach ($renter_contract as $rent)
                <option value="{{ $rent->renter->id }}">{{ $rent->renter->prefix.' '.$rent->renter->name.' '.$rent->renter->surname }}</option>
            @endforeach
        </select>
        
</div>
<div id="room-rental-contract">

</div>