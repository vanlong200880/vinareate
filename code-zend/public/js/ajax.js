$(document).ready(function(){
	var x = document.getElementById("select_province");
	console.log(x);
	$("#select_province").change(function(){
		$('.district-detail').css('display','none');
		var id = document.getElementById("select_province").value;
		var data = {};
		data.id = id; // {id: 31}
   		$.ajax({
   			type:"POST",
   			dataType:'json',
   			url:"/vinareate/code-zend/public/backend/ajax",
   			async:true,
   			data: {'id':id},
   			success:function(data){
   				var html='';
   				html += '<label for="number-address">Chọn Quận/Huyện: </label>';
   				html += '<select class="form-control" id="select_district" name="select_district">';
   				html += '<option value="">Chọn Quận/Huyện</option>';
   				$.each(data, function(key, item){
   					$.each(item, function(key2, item2){
   						html += "<option value='";html+=item2['id'];html+= "'>";
	   					html +=item2['name'];
	   					html += '</option>';
   					});
   					
   				});
   				html += '</select>';
   				$('#test').html(html);
   				// test=data['id'].value;
   				console.log(data);
   				// $("#select_district").html;
   				// console.log($("#select_district").html(data));
   			}
   		});
		});


});