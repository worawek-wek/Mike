{{-- ทำสัญญาหลายห้อง --}}
{{-- ทำสัญญาหลายห้อง --}}
{{-- ทำสัญญาหลายห้อง --}}
{{-- ทำสัญญาหลายห้อง --}}

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<!-- ก่อน </body> -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<div class="p-2">
    <label class="h5 mb-1">เลือกข้อมูลจากผู้เช่า</label>
        <select name="ref_renter_id" id="select2RenterContract" onchange="get_room_rental_contract(this.value)" required>
            <option selected disabled hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
            @foreach ($renter_contract as $rent)
                <option value="{{ $rent->renter->id }}">{{ $rent->renter->prefix.' '.$rent->renter->name.' '.$rent->renter->surname }}</option>
            @endforeach
        </select>
        
</div>
<div id="room-rental-contract">

</div>
<script>
    new TomSelect("#select2RenterContract", {
                    create: false,
                    maxItems: 1,
                    allowEmptyOption: true,
                    sortField: { field: "text", direction: "asc" }
                });
</script>