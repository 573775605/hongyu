        $(document).on("change",".selects",function(){//select 字体颜色
            var _this = $(this);
            if($(this).find("option:selected").hasClass("redColorOption"))
            {
                $(".selects").css("color","#999");
            }
            else
            {
                    $(".selects").css("color","#555");
            }
        });