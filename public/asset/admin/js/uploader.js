//upyun http api 上传js
function uploader(obj){
    this.dom = obj.dom;
    this.uploadUrl = obj.uploadUrl;
    this.callback = obj.callback;
    this.init();
}


uploader.prototype ={
    file_id : 0,
    file_url : '',
    callback:null,


    //初始化上传器
    init:function(){
        var myObj = this;
        $(this.dom).fileupload({
            url: this.uploadUrl,
            formData: {policy : this.policy, signature : this.signature},
            //dataType: 'json',
            done: function (e, data) {
                console.log(data);
                myObj.callback(data.result);
            }
        });
    },

};

