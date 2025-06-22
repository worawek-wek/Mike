

<div class="col-span-12">
    <div class="box pr-5 pl-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">Annoucment News</h2>
            <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                <div  id="changeTapNews">
                    <label class="btn btn-warning mr-1 mt-2" for="show-example-5" type="button" onclick="changeTapNews(1);">
                        <i data-lucide="check-square" class="w-4 h-4 mr-1" style="color: white;"></i> Edit
                    </label>
                </div>
            </div>
        </div>
        <div class="p-5">
            <p align="center" id="change_loading" style="display: none"><i data-loading-icon="oval" data-color="black"></i></p>
            {{-- /////  แสดง  ///// --}}
            <div class="preview" id="view_news" style="overflow: hidden;height: 300px;">
                {!! $news->detail !!}
            </div>
            <p align="right" id="ViewNewsAll" class="mr-1 mt-2" style="color: blue;">
                <a href="javascript:void();" onclick="ViewNewsAll()">
                ... View all 
                </a>
            </p>

            {{-- /////  จบ แสดง  ///// --}}

            {{-- /////  เริ่ม แก้ไข  ///// --}}
            <form id="edit_news" style="display: none;margin-top: -10px;">

                @csrf
                <button class="btn btn-primary mr-1 mb-2">
                    <i data-lucide="save" class="block mx-auto w-4 h-4 mr-1"></i>
                    Save
                    <span class="id_loading_icon" style="display: none">
                        <i data-loading-icon="oval" data-color="white" class="w-4 h-4 ml-2"></i>
                    </span>
                </button>
                    <textarea name="detail" class="editor" id="detail">
                        {{ $news->detail }}
                    </textarea>
                <button class="btn btn-primary mr-1 mt-2">
                    <i data-lucide="save" class="block mx-auto w-4 h-4 mr-1"></i>
                    Save
                    <span class="id_loading_icon" style="display: none">
                        <i data-loading-icon="oval" data-color="white" class="w-4 h-4 ml-2"></i>
                    </span>
                </button>
            </form>
            {{-- /////  จบ แก้ไข  ///// --}}
            
        </div>
    </div>
</div>
<div id="viewNews" style="display: none;">
    <label class="btn btn-success mr-1 mt-2" for="show-example-5" type="button" onclick="changeTapNews(2);">
        <i data-lucide="eye"  class="w-4 h-4 mr-1" style="color: white;"></i> View
    </label>
</div>
<div id="viewEdit" style="display: none;">
    <label class="btn btn-warning mr-1 mt-2" for="show-example-5" type="button" onclick="changeTapNews(1);">
        <i data-lucide="check-square" class="w-4 h-4 mr-1" style="color: white;"></i> Edit
    </label>
</div>

<script>
    function changeTapNews(change_news){
        $('#change_loading').css('display','block');
        setTimeout(() => {
            if(change_news == 1){
                var textView = $("#viewNews").html();
                $('#view_news').css('display','none');
                $('#edit_news').css('display','block');
                $("#changeTapNews").html(textView);
            }else{
                var textEdit = $("#viewEdit").html();
                $('#edit_news').css('display','none');
                $('#view_news').css('display','block');
                $("#changeTapNews").html(textEdit);
            }
            $('#change_loading').css('display','none');
        }, 100);

    }
    function ViewNewsAll(){
        $('#ViewNewsAll').hide();
        $('#view_news').css('overflow','unset');
        $('#view_news').css('height','unset');
    }
</script>
{{-- <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script> --}}
