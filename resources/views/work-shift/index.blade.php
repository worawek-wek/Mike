@extends('../layout/' . $layout)

@section('subhead')
    <title>กะการทำงาน</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection
                
@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                <div class="intro-y box mt-5">
                    <div id="boxed-tab" class="p-5">
                        <form action="{{url("user-setting/work_shift")}}" id="form_work_shift" method="post" enctype="multipart/form-data">
                            @include('work-shift/form')
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
                $('#edit_news').submit(function(event){

                    event.preventDefault();
                
                    $(".id_loading_icon").show();
                    var formData = $(this).serialize();
                    $(this).css("pointer-events", "none");
                    $(this).css("opacity", "0.4");
                
                    // AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{url("edit_news")}}', // URL to submit form data
                        data: formData,
                        success: function(response){
                            var textEdit = $("#viewEdit").html();
                            setTimeout(() => {
                                
                                $('#view_news').html(response
                                    +'<button id="ViewNewsAll" onclick="ViewNewsAll()" class="btn btn-primary mr-1 mt-2">'
                                    +'View all'
                                    +'</button>'
                                );
                
                                $('#view_news').css('display','block');
                                $('#edit_news').css('display','none');
                
                                $('#edit_news').css("pointer-events", "unset");
                                $('#edit_news').css("opacity", "unset");
                                
                                $("#changeTapNews").html(textEdit);
                                $(".id_loading_icon").hide();
                            }, 3000);
                        }
                    });
                });
                            });
        </script>
        <script>
            $(document).ready(function(){
                $('#form_work_shift').submit(function(event){
                
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
                        url: '{{url("user-setting/work_shift")}}', // URL to submit form data
                        data: formData,
                        success: function(response){
                            // console.log(formData);
                            $("#form_work_shift").html(response);
                            $("#SuccessWorkShift").fadeIn(300);
                            $("#SuccessWorkShift").fadeOut(10000);
                            // $("#SuccessWorkShift").css('display','display:-webkit-box;');
                        }
                    });
                });
            });
            
            let delete_id = [];
            function HiddenWS(idws){
                $('#work_shift'+idws).remove();
                delete_id.push(idws);
                console.log(delete_id);
            }
        </script>
        <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
                        
        @endsection
        