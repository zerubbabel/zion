var respData=[{'regionName':'yuyao','regionNameEN':'yuyaoen','regionShortnameEn':'yy','regioncode':'yycode'}];
$('#autocompleteInput').autocomplete({
        source:function(query,process){
            var matchCount = this.options.items;//返回结果集最大数量
            /*$.post("/bootstrap/region",{"matchInfo":query,"matchCount":matchCount},function(respData){
                return process(respData);
            });*/
			return process(respData);
        },
        formatItem:function(item){
            return item["regionName"]+"("+item["regionNameEn"]+"，"+item["regionShortnameEn"]+") - "+item["regionCode"];
        },
        setValue:function(item){
            return {'data-value':item["regionName"],'real-value':item["regionCode"]};
        }
    });
 
$("#goBtn").click(function(){ //获取文本框的实际值
        var regionCode = $("#autocompleteInput").attr("real-value") || "";
        alert(regionCode);
    });