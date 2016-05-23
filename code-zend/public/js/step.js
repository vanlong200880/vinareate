(function($){
	window.Step = function(name, divId, itemsId){
		this.component = $("#" + divId);
		this.items = [];
		this.itemsId = itemsId;
		this.data = {};
		this.data.name = name;
	};
	Step.prototype = {
		pushItem: function(item){
			this.items[item.divId] = item;
		},
		getItem: function(divId){
			return this.items[divId];
		},
		getData: function(){
			var step = this;
			for(var i in this.items){
				if(this.items.hasOwnProperty(i)){
					var item = this.items[i];
					$.each(item.getData(), function(key, value){
						step.data[key] = value;
					});
				}
			}
			return step.data;
		},
		init: function(){
			var itemsId = this.itemsId["item"];
			for(var itemType in itemsId){
				if(itemsId.hasOwnProperty(itemType)){
					for(var itemName in itemsId[itemType]){
						if(itemsId[itemType].hasOwnProperty(itemName)){
							var itemDivId = itemsId[itemType][itemName];
							this[itemType](itemName, itemDivId);
						}
					}
				}
			}
		},
		item: function(name, divId){
			var item = this.component.find("#" + divId);
			item.name = name;
			item.divId = divId;
			this.pushItem(item);
			return item;
		},
		itemInput: function(name, divId){
			var input = this.item(name, divId);
			input.getData = function(){
				var r = {};
				r[this.name] = input.val();
				return r;
			};
			input.setData = function(d){
				input.val(d);
			};
		},
		itemTextArea: function(name, divId){
			var textArea = this.item(name, divId);
			textArea.getData = function(){
				var r = {};
				r[this.name] = textArea.html();
				return r;
			};
			textArea.setData = function(d){
				textArea.html(d);
			};
		},
		itemSelectPicker: function(name, divId){
			var selectPicker = this.item(name, divId);
			selectPicker.render = function(options){
				if(selectPicker.options){
					//empty when created
					selectPicker.empty();
				}
				selectPicker.options = options;
				for(var key in options){
					if(options.hasOwnProperty(key)){
						var option = $("<option>");
						option.val(options[key]["val"]);
						option.html(options[key]["html"]);
						selectPicker.append(option);
					}
				}
			};
			selectPicker.getData = function(){
				var r = {};
				r[this.name] = selectPicker.find("option:selected").val();
				return r;
			};
			selectPicker.setSelectedOption = function(optionVal){
				var option = this.find('option[value="' + optionVal + '"]');
				option.attr("selected", true);
			};
			selectPicker.getSelectedOption = function(){
				return selectPicker.find("option:selected");
			}
		},
		/**
		 * CUSTOM ITEM
		 * input/selectpicker is most used
		 * itemRadio, itemCheckBox, itemDragDrop, not frequently
		 * beside of that "tax history" also has it own custom
		 * >>> add custom item dynamic in step
		 * >>> add it here
		 */
		itemRadio: function(name, divId){
			var radioDiv = this.item(name, divId);
			radioDiv.render = function(radios){
				if(radioDiv.options){
					//empty when created
					radioDiv.empty();
				}
				radioDiv.options = radios;
				for(var i in radios){
					if(radios.hasOwnProperty(i)){
						var radio = radios[i];
						var div = $("<div>").addClass("radio-inline");
						var input = $("<input>");
						input.attr("name", name)
						     .attr("type", "radio")
						     .val(radio["input"]["val"]);
						var label = $("<label>").html(radio["label"]["html"]);
						div.append(input);
						div.append(label);
						radioDiv.append(div);
					}
				}
			};
			radioDiv.getData = function(){
				var r = {};
				var checkedRadio = radioDiv.find("input:checked");
//                        console.log(checkedRadio);
				r[this.name] = checkedRadio.val();
				return r;
			}
		},
		itemCheckbox: function(name, divId){
			var checkboxDiv = this.item(name, divId);
			checkboxDiv.render = function(checkboxs){
				if(checkboxDiv.options){
					//empty when created
					checkboxDiv.empty();
				}
				checkboxDiv.options = checkboxs;
				for(var i in checkboxs){
					if(checkboxs.hasOwnProperty(i)){
						var checkbox = checkboxs[i];
						var div = $("<div>");
						var input = $("<input>");
//                                input.attr("name", "name");
						input.attr("type", "checkbox")
						     .val(checkbox["id"]);
//                                var label = $("<label>").html(radio["label"]["html"]);
						var label = $("<label>").addClass("checkbox-inline");
						;
						label.append(input);
						label.append(checkbox["name"]);
//                                div.append(input);
						div.append(label);
						checkboxDiv.append(div);
					}
				}
			};
			checkboxDiv.getData = function(){
				var r = {};
				var checkedBoxs = [];
				checkboxDiv.find("input:checked").each(function(){
					checkedBoxs.push($(this).val());
				});
//                        console.log(checkedRadio);
				r[this.name] = checkedBoxs;
				return r;
			};
//                    return checkboxDiv;
		},
		ajaxCall: function(url, data){
			var formData = new FormData();
			for(var key in data){
				if(data.hasOwnProperty(key)){
					/**
					 * i don't know WHY, but JSON.stringify
					 * false on deep object
					 * >>> append (key > value) to prevent
					 * so deep object
					 * data[key] may be deep too @@
					 * JSON stringify on him
					 * this way just solve only 1 deep level
					 * in data[key]
					 */
					formData.append(key, JSON.stringify(data[key]));
				}
			}
			var oReq = new XMLHttpRequest();
			oReq.open("post", url);
			oReq.send(formData);
			return oReq;
		}
	};
})(jQuery);