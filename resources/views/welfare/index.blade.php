@extends('../layout/' . $layout)

@section('subhead')
    <title>สวัสดิการ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection
                
@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">สวัสดิการ</h2>
                    </div>
                <div class="intro-y box mt-5">
                    <div id="boxed-tab" class="p-5">
                    @if (Auth::user()->ref_position_id == 1)
                        <form id="form_edit_news" method="post" enctype="multipart/form-data">
                            @csrf
                            <textarea name="detail" class="editor" id="detail">
                                {{$welfare->detail}}
                            </textarea>
                            
                            <div class="grid grid-cols-12 gap-x-5">
                            
                                <div class="col-span-6 2xl:col-span-6">
                                    <div id="SuccessWorkShift" style="display:none;" class="alert alert-success-soft show flex items-center mb-2 mt-2" role="alert">
                                        <i data-lucide="check" class="w-8 h-6 mr-2"></i> Saved successfully.
                                    </div>
                                </div>
                                    <div class="col-span-6 2xl:col-span-6">
                                        <p align="right"><button type="submit" class="btn btn-success w-20 mb-4 mt-4" style="text-align: right;">Save</button></p>
                                    </div>
                            </div>
                        </form>
                    @else
                    <div style="margin: 30px;">
                        {!! $welfare->detail !!}
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    
        <script>
            $(document).ready(function(){
                $('#form_edit_news').submit(function(event){

                    event.preventDefault();
                    $(".id_loading_icon").show();
                    var formData = $(this).serialize();
                    $(this).css("pointer-events", "none");
                    $(this).css("opacity", "0.4");
                
                    // AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{url("edit_news")}}/2', // URL to submit form data
                        data: formData,
                        success: function(response){
                
                                $('#form_edit_news').css("pointer-events", "unset");
                                $('#form_edit_news').css("opacity", "unset");
                                $("#SuccessWorkShift").fadeIn(300);
                                $("#SuccessWorkShift").fadeOut(20000);
                        }
                    });
                });
                            });
        </script>
        {{-- <script>
            $(document).ready(function(){
                $('#form_edit_news').submit(function(event){
                
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
                        url: '{{url("user-setting/edit_news")}}', // URL to submit form data
                        data: formData,
                        success: function(response){
                            // console.log(formData);
                            $("#form_edit_news").html(response);
                        }
                    });
                });
            });
            
            let delete_id = [];
            function HiddenWS(idws){
                $('#edit_news'+idws).remove();
                delete_id.push(idws);
                console.log(delete_id);
            }
        </script> --}}
        <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
                        
        @endsection
        