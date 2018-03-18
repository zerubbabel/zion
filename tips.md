## jqGrid如何引入datepicker日期控件？

{name : 'csrq',index : 'csrq',align : "center",editable:true,editoptions:{
                dataInit:function(e){
                    $(e).datepicker({
                        language:"zh-CN",//语言
                        autoclose: true,//自动关闭
                        todayBtn: "linked",//
                        format: "yyyymmdd"//时间显示格式
                    });
                    $(this).click(function(e){//选中时间后隐藏
                        $(e).parent().datepicker('hide');
                    });
                }
            },sortable : false}