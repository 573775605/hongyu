//upyun http api 上传js
function areaSelector(obj) {
    this.dom = obj.dom;
    this.url = obj.url;
    this.areaId = obj.areaId;
    this.selectedId = obj.selectedId;
    this.init();
}


areaSelector.prototype = {
    callback: null,
    url: null,
    areaId: 0,
    selectedId: 0,

    //初始化上传器
    init: function () {
        var myObj = this;
        $.getJSON(myObj.url, {areaId: myObj.areaId}, function (data) {
            if (data.status == 1) {
                console.log(data.data.list);
                $(data.data.list).each(function (index, elem) {
                    var dom = $('<select class="form-control" name="area[]"></select>');
                    $(elem).each(function (i, e) {
                        dom.append('<option value="' + e.id + '" onchange="myObj.selectArea(this)">' + e.areaname + '</option>')
                    });
                    myObj.dom.append(dom);
                });
            }
        });
    },
};


//
// selectArea: function (obj) {
//     var myObj = this;
//     $.getJSON(myObj.url, {areaId: myObj.areaId}, function (data) {
//         if (data.status == 1) {
//             $(data.data.list).each(function (index, elem) {
//                 var dom = $('<select class="form-control" name="area[]"></select>');
//                 $(elem).each(function (i, e) {
//                     dom.append('<option value="' + e.id + '" onchange="myObj.selectArea(this)">' + e.areaname + '</option>')
//                 });
//                 myObj.dom.append(dom);
//             });
//         }
//     });
//
// }
//
