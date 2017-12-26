/**
 * Created by ze on 2016/11/06.
 */
table = $('#listTable').bootstrapTable({
    url: listUrl,
    dataType: "json",
    pagination: true, //分页
    striped: true,//是否显示行间隔色
    sidePagination: "server", //服务端处理分页
    queryParamsType: '', //默认值为 'limit' ,在默认情况下 传给服务端的参数为：offset,limit,sort
    queryParams: function (params) {
        var from = $('#search').serializeArray();
        $(from).each(function (k, v) {
            params[v.name] = v.value;
        })
        return params;
    },
// 设置为 '' 在这种情况下传给服务器的参数为：pageSize,pageNumber
    columns: listColumns
});

function search() {
    table.bootstrapTable('selectPage', 1);
}
$('#search select').change(function () {
    table.bootstrapTable('selectPage', 1);
});
$(function () {
    document.onkeydown = function (e) {
        var ev = document.all ? window.event : e;
        if (ev.keyCode == 13) {// 如（ev.ctrlKey && ev.keyCode==13）为ctrl+Center 触发
            //要处理的事件
            search();
            return false;
        }
    }
});