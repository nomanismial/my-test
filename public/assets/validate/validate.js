//checks if value is object
function _is_obj(obj){
	if (typeof obj === "object"){
		return true;	
	}
	return false;
}
//checks if property exists
function _is_prop(obj, property){
	if (_is_obj(obj)){
		if (obj.hasOwnProperty(property)){
			return true;
		}
	}
	return false;
}
window._____ISERROR = false;
function check_validate(field, roles, parentEle){
	var errors = [];
	//Messages
	var messages = {
		"require" : "The :attribute is required.",
		"space" : "The :attribute does not allow space.",
		"min" : "The :attribute must be at least :min characters",
		"max" : "The :attribute must be less than :max characters",
		"special" : "The :attribute should not contain special characters.",
		"char" : "The :attribute should contain only characters.",
		"pattern" : "The :attribute is invalid format.",
		"username" : "The :attribute is invalid format.",
		"email" : "The :attribute is invalid format.",
		"phone" : "The :attribute is invalid format.",
		"emailphone" : "The email/phone is invalid format.",
		"emailphonereq" : "The email/phone is required.",
		"match" : "The :attribute does not match with :other.",
		"number" : "The :attribute is invalid number.",
	};
	//Checks special characters
	function is_spl_chr(el){
		var str = el.val();
		if(/^[a-zA-Z0-9- ]*$/.test(str) === false) {
			return true;
		}
		return false;
	}
	
	//Checks string is only number
	function is_number(el){
		var str = el.val();
		if(/^[0-9]*$/.test(str) === false) {
			return true;
		}
		return false;
	}
	
	//Checks special characters
	function is_chr(el){
		var str = el.val();
		if(/^[a-zA-Z ]*$/.test(str) === true) {
			return false;
		}
		return true;
	}
	
	//Checks space in the stirng
	function is_space(el){
		var str = el.val();
		if (/\s/.test(str)) {
			return true;
		}
		return false;
	}
	
	//Checks username in the stirng
	function is_username(el){
		var str = el.val();
		if(/^[a-zA-Z0-9.]*$/.test(str) === false) {
			return true;
		}
		return false;
	}
	//Cheks min characters
	function is_min(el, len){
		var c = el.val();
		if (c.length < len){
			return true;
		}
		return false;
	}
	//Checks max characters
	function is_max(el, len){
		var c = el.val();
		if (c.length > len){
			return true;
		}
		return false;
	}
	//Cheks if value is enters.
	function is_required(el){
		var c = el.val().trim();
		if (c===""){
			return true;
		}
		return false;
	}
	//Checks if value is empty
	function emailphonereq(el){
		var c = el.val().trim();
		if (c===""){
			return true;
		}
		return false;
	}
	
	//checks if email is valid format
	function is_email(el){
		var str = el.val();
		if(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(str) === false) {
			return true;
		}
		return false;
	}
	
	//Checks if phone is valid format
	function is_phone(el){
		var str = el.val();
		var re = /^([0-9]{4})[-]([0-9]{7})$/;
		if(re.test(str)===false){
			return true;
		}
		return false;
	}
	
	//Checks if phone or eamil is valid
	function isEmail_isPhone(el){
		var g = false;
		if(is_phone(el)===true){
    		g = true;
		}else if(is_email(el)===false){
			g =  true;
		}
		return g;
	}
	
	function is_match(el, matchWith){
		var str = el.val();
		var chk = $(parentEle).find("input[name='"+matchWith+"']").val();
		if (str!==chk){
			return true;
		}
		return false;
	}
	
	//removes error if role is valid
	function remove_error(field){
		var nm = field.attr("name");
		field.closest("form").find("p.error").remove();
		if (field.is("input")){
			$("input[name='"+nm+"']").prevAll("._dg_error").remove();	
			$("input[name='"+nm+"']").prevAll(".dg-b-icon").remove();	
		}else if (field.is("textarea")){
			$("textarea").prevAll("._dg_error").remove();	
			$("textarea").prevAll(".dg-b-icon").remove();
		}
	}
	
	//return validation messages
	function _validate_messages(field, role){
		var msg = "";
		if (_is_prop(messages,role)){
			msg = create_message(role);	
		}
		return msg;
	}
	
	//create message for print
	function create_message(role){
		var msg = messages[role];
		var field_name = field.attr("name");
		field_name = field_name.replace("-"," ");
		field_name = field_name.replace("_"," ");
		msg = msg.replace(":attribute", field_name);
		if (role==="min"){
			msg = msg.replace(":min", roles[role]);
		}
		if (role==="max"){
			msg = msg.replace(":max", roles[role]);
		}
		if (role==="match"){
			var v = roles[role];
			v = v.replace("-"," ");
			v = v.replace("_"," ");
			msg = msg.replace(":other", v);
		}
		errors.push(msg);
	}
	function _roles_check(roles, r){
		$.each(roles, function(key, value){
			switch(key){
				case  "require" :
					if (is_required(field)===true){
						_validate_messages(field, "require");	
						
					}
					break;
				case  "min" :
					if (is_min(field, value)===true){
						_validate_messages(field, "min");
					}
					break;
				case  "max" :
					if (is_max(field, value)===true){
						_validate_messages(field, "max");
					}
					break;
				case  "special":
					if (is_spl_chr(field)===true){
						_validate_messages(field, "special");
					}
					break;
				case  "char":
					if (is_chr(field)===true){
						_validate_messages(field, "char");
					}
					break;
				case  "number":
					if (is_number(field)===true){
						_validate_messages(field, "number");
					}
					break;
				case  "space":
					if (is_space(field)===true){
						_validate_messages(field, "space");
					}
					break;
				case  "username":
					if (is_username(field)===true){
						_validate_messages(field, "username");
					}
					break;
				case  "email":
					if (is_email(field)===true){
						_validate_messages(field, "email");
					}
					break;
				case  "phone":
					if (is_phone(field)===true){
						_validate_messages(field, "phone");
					}
					break;
				case  "emailphone":
					if (isEmail_isPhone(field)===false){
						_validate_messages(field, "emailphone");
					}
					break;
				case  "emailphonereq":
					if (emailphonereq(field)===true){
						_validate_messages(field, "emailphonereq");
					}
					break;
				case  "match":
					if (is_match(field, value)===true){
						_validate_messages(field, "match");
					}
					break;
			}	
		});
	}
	_roles_check(roles, true);
	remove_error(field);
	if(typeof errors[0] !== 'undefined') {
		$("<span class='_dg_error error'>"+errors[0]+"</span>").insertBefore(field);
		field.addClass("dg-b-error");
		field.removeClass("dg-b-success");
		$("<span class='dg-b-icon'></span>").insertAfter(field);
		window._____ISERROR = true;
	}else{
		field.addClass("dg-b-success");
		field.removeClass("dg-b-error");
		$("<span class='dg-b-icon'></span>").insertAfter(field);
		window._____ISERROR = false;
	}
}
function _is_validate(el, roles){
	if ($(el).length){
		$(el+' *').filter(':input').each(function(){
			var name = $(this).attr("name");
			if (_is_prop(roles, name)){
				var fl = $(this);
				fl.keyup(function(){
					check_validate(fl, roles[name],el);
				});
			}
		});	
	}
}
