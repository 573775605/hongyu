<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}">
    <title>添加权限</title>

    <link href="{{ asset('asset/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset("asset/admin/js/plugins/ztree/css/zTreeStyle/zTreeStyle.css") }}" rel="stylesheet">
    <style>
        .btn {
            border-radius: 3px;
        }

        .ibox-tools {
            display: inline-block;
            float: right;
            margin-top: 0;
            position: relative;
            padding: 0;
        }

        .btn-primary {
            color: #ffffff !important;
            background-color: #7266ba;
            border-color: #7266ba;
        }

        .float-e-margins .btn {
            margin-bottom: 5px;
        }

        .ibox-title h5 {
            display: inline-block;
            font-size: 14px;
            margin: 0 0 7px;
            padding: 0;
            text-overflow: ellipsis;
            float: left;
        }

        .btn-w-m {
            min-width: 120px;
        }

        {
            background-color: #f0f3f4
        ;
        }

        .wrapper-content {
            padding: 20px;
        }

        .ibox {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #dee5e7;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .ibox-title {
            height: 41px;
            border-color: #edf1f2;
            background-color: #f6f8f8;
            color: #333;
            font-weight: 700;
            border-radius: 2px 2px 0 0;
            padding: 15px 15px 3px 15px;
            border-bottom: 1px solid transparent;
            display: block;
            clear: both;
        }

        .ibox-content {
            clear: both;
        }

        .ibox-content {
            background-color: #ffffff;
            color: inherit;
            padding: 15px 20px 20px 20px;
            border-color: #e7eaec;
            -webkit-border-image: none;
            -o-border-image: none;
            border-image: none;
            border-style: solid solid none;
            border-width: 1px 0px;
        }

        form-control, .single-line {
            display: block;
            border-color: #cfdadd;
            border-radius: 2px;
            width: 100%;
            height: 30px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #cfdadd;
            box-shadow: none;
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .hr-line-dashed {
            border-top: 1px dashed #e7eaec;
            color: #ffffff;
            background-color: #ffffff;
            height: 1px;
            margin: 20px 0;
        }

        .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
        }

        float-e-margins .btn {
            margin-bottom: 5px;
        }

        .float-e-margins .btn {
            margin-bottom: 5px;
        }

    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height: 50px">
                        <h5>
                            权限管理
                        </h5>
                        <div class="ibox-tools">
                            <a href="javascript:history.go(-1)">
                                <button class="btn btn-w-m btn-primary">返回</button>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">权限名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="display_name" value="{{old('display_name',isset($row->data->display_name)?$row->data->display_name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属父级</label>
                                <div class="col-sm-10">
                                    <ul class="ztree" id="ztree"></ul>
                                </div>
                                <input type="hidden" name="parent_id" value="{{old('parent_id',isset($row->data->parent_id)?$row->data->parent_id:0)}}">
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">执行操作</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{old('name',isset($row->data->name)?$row->data->name:'')}}">
                                    {!! $errors->first('name','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">描述</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="description" value="{{old('description',isset($row->data->description)?$row->data->description:'')}}">
                                    {!! $errors->first('description','<span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> :message</span>') !!}
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-5">
                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="{{ asset('asset/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{asset("asset/admin/js/plugins/ztree/js/jquery.ztree.core.js")}}"></script>
<script>
    $(function () {
        var setting = {
            data: {
                key: {
                    name: 'display_name'
                },
                simpleData: {
                    enable: true,
                    pIdKey: 'parent_id',
                    rootPId: 0
                }
            },
            callback: {
                onClick: function (event, treeId, treeNode) {
                    $('input[name=parent_id]').val(treeNode.id);
                }
            }
        };
        //节点数据
        var rows ={!! $rows->toJson() !!};

        var ztree = $.fn.zTree.init($("#ztree"), setting, rows);
        //展开说有节点
        ztree.expandAll(true);
                @if(old('parent_id',isset($row->data->parent_id)?$row->data->parent_id:''))
        var parentNode = ztree.getNodeByParam('id',{{old('parent_id',isset($row->data->parent_id)?$row->data->parent_id:'')}});
        ztree.selectNode(parentNode);
        $('input[name=parent_id]').val(parentNode.id);
        @endif
    })
</script>
</body>

</html>
