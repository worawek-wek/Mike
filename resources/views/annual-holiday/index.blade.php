@extends('../layout/' . $layout)

@section('subhead')
    <title>ตารางวันหยุด</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection
                
@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">ตารางวันหยุด</h2>
                    </div>
                <div class="intro-y box mt-5">
                    <div id="boxed-tab" class="p-5">
                        <form action="{{url("annual-holiday")}}" id="form_annual_holiday" method="post" enctype="multipart/form-data">
                            @include('annual-holiday/form')
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
        <script>
            $(document).ready(function(){
                $('#form_annual_holiday').submit(function(event){
                
                    event.preventDefault();
                
                    // $(".id_loading_icon").show();
                    var formData = $(this).serializeArray();
                    // $(this).css("pointer-events", "none");
                    // $(this).css("opacity", "0.4");
                    // console.log(formData);
                    formData.push({name: 'delete_id[]', value: delete_id });
                    console.log(delete_id);
                    // AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{url("annual-holiday")}}', // URL to submit form data
                        data: formData,
                        success: function(response){
                            // console.log(formData);
                            $("#form_annual_holiday").html(response);
                            $("#SuccessWorkShift").fadeIn(300);
                            $("#SuccessWorkShift").fadeOut(10000);
                            // $("#SuccessWorkShift").css('display','display:-webkit-box;');
                        }
                    });
                });
            });
            
            let delete_id = [];
            function HiddenWS(idws){
                $('#annual_holiday'+idws).remove();
                delete_id.push(idws);
                console.log(delete_id);
            }
        </script>
        <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
                        
        @endsection
        