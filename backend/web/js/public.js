function myclearNoNum(obj)
{
	obj.value = obj.value.replace(/[^\d.]/g,"");
	obj.value = obj.value.replace(/^\./g,"");
	obj.value = obj.value.replace(/\.{2,}/g,".");
	obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}
function myclearNoInt(obj)
{
	obj.value = obj.value.replace(/[^\d]/g,"");
}
function form_msg(obj,msg,tag){
	$(obj).parent().parent().attr("class", "control-group");;
	$(obj).parent().find('.help-inline').html('');
	$(obj).parent().find('.help-block').html('');
	$(obj).parent().parent().addClass(tag);
	$(obj).parent().find('.help-inline').html(msg);
	$(obj).parent().find('.help-block').html('');
	return false;
}

function load_select2(obj,search_name,search_id){
   $(obj).select2({
		placeholder: "点击查询机构",
		minimumInputLength: 2,
		multiple: false,  
		ajax: {
			url: search_name, 
			dataType: "json",　
			type: "GET",　
			quietMillis: 1000, 
			data: function (term, page) {
				return {
　　　　　　　　　　　　　　　sSearch: term, 
　　　　　　　　　　　　　　　page: 20   
				};
			},
			results: function (data, page) {
				var optData=Array();
				if(data){
					var  opt='';
					var text='';
					for(var i=0;i<data.length;i++){
						text=data[i].name;
						if(data[i].name_cn){
							text +='/'+data[i].name_cn;
						}
						if(data[i].name_tw){
							text +='/'+data[i].name_tw;
						}
						opt={'id':data[i].id,'text':text};
						optData.push(opt);
					}
				}
				return {
					results: optData 
				};
			}
		},
		//formatSelection: resultFormatSelection,  // 设定查询样式
	   // formatResult: resultFormatResult,　　　　// 设定查询结果样式
		dropdownCssClass: "bigdrop", 　　　　// 设定SELECT2下拉框样式，bigdrop样式并不在CSS里定义，暂时没深入研究
		escapeMarkup: function (m) {
			return m;
		},
　　　　　		initSelection: function (element, callback) { 
			var id = $(element).val();
			if(id !== "") {
				$.ajax(search_id, {
					data: {id: id},
					dataType: "json"
				}).done(function(data) {
					var optData=Array();
					if(data){
						var  opt='';
						var text=data.name;
						if(data.name_cn){
							text +='/'+data.name_cn;
						}
						if(data.name_tw){
							text +='/'+data.name_tw;
						}
						opt={'id':data.id,'text':text};
						callback(opt);
					}
				});
			}
		}　
	});
 }