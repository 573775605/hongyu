@if(!empty($status))
    @if($status['status']===true)
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">
                &times;
            </a>
            {{$status['msg'] or '保存成功'}}
        </div>
    @elseif($status['status']===false)
        <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert">
                &times;
            </a>
            {{$status['msg'] or '保存失败'}}
        </div>
    @endif
@endif