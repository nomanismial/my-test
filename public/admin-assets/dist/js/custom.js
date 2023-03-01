var ajaxReq = baseURL + "ajaxrequest";

function sendData(url, obj) {
    return $.ajax({
        "async": false,
        "type": "POST",
        "global": false,
        "dataType": "html",
        "url": url,
        "data": obj,
        "success": function (data) {
            smVaribale = data;
        }
    });
}
$(document).ready(function () {
    // Side Bar list item delete
    $(document).on("click", ".list-del", function () {
        var s = window.confirm("Do you want to continue?");
        if (s) {
            $(this).closest("li").remove();
        }
    });

    function urlTitle(txt_src) {
        var output = txt_src.replace(/[^a-zA-Z0-9]/g, ' ').replace(/\s+/g, "-").toLowerCase();
        /* remove first dash */
        if (output.charAt(0) == '-') output = output.substring(1);
        /* remove last dash */
        var last = output.length - 1;
        if (output.charAt(last) == '-') output = output.substring(0, last);

        return output;
    }

    function remove_special_char(txt_src) {
        var output = txt_src.replace(/[^a-zA-Z0-9]/g, ' ').replace(/\s+/g, " ");
        /* remove first dash */
        if (output.charAt(0) == '-') output = output.substring(1);
        /* remove last dash */
        var last = output.length - 1;
        if (output.charAt(last) == '-') output = output.substring(0, last);

        return output;
    }

    $(".cslug").keyup(function () {
        var v = $(this).val();
        var input = $(this).attr("data-link");
        $("input[name='" + input + "']").val(urlTitle(v));
    });

    $(".tcount").on("keyup change input paste", function(e){
        var v = $(this).val();
        var t = $(this).attr("data-count");
        if (t=="text"){
            $(this).closest(".input-group").find(".countshow").text(v.length);
        }else{
            var words = v.split(",").filter(item => item);
            var ln = words.length;
            $(this).closest(".input-group").find(".countshow").text(ln);
        }
    });
    $(".toggle-password").click(function () {
        if ($(this).hasClass("fa-eye-slash")) {
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
            $(this).closest("div").find("input").attr("type", "text");
        } else {
            $(this).addClass("fa-eye-slash");
            $(this).removeClass("fa-eye");
            $(this).closest("div").find("input").attr("type", "password");
        }
    });
    $(document).on("click", ".sconfirm", function () {
        var c = window.confirm("Do you want to continue?");
        if (c) {
            return true;
        } else {
            return false;
        }
    });

    $(".add-more-images a").click(function () {
        var m = $(".uc-image2").length;
        $(".uc-image2").each(function (index, value) {
            var indx = index + 1;
            $(this).find("input[type='hidden']").attr("name", "image" + indx);
            $(this).find(".image_display").attr("id", "image" + indx);
            $(this).find(".insert-media").attr("data-return", "#image" + indx);
            $(this).find(".insert-media").attr("data-link", "image" + indx);
        });
        var mc = parseInt(m) + 1;
        var d = '<div class="uc-image2" style="width:150px;height:150px;"><span class="close-image-x2">x</span>' +
            '<input type="hidden" name="image' + mc + '" value=""/>' +
            '<div id="image' + mc + '" class="image_display"></div>' +
            '<div style="margin-top:10px;">' +
            '<a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" ' +
            'data-return="#image' + mc + '" data-link="image' + mc + '">Add Image</a>' +
            '</div>' +
            '</div>';
        $(".ext-image").before(d);
        $("input[name='total_images']").val(mc);
        return false;
    });

    $(document).on("click", ".close-image-x2", function () {
        var r = window.confirm("Do you wnat to delete image");
        if (r) {
            $(this).parent().remove();
            var mc = 1;
            $(".uc-image2").each(function () {
                $(this).find("input").attr("name", "image" + mc);
                $(this).find(".image_display").removeClass("image" + (mc + 1));
                $(this).find(".image_display").addClass("image" + mc);
                $(this).find(".insert-media").attr("data-return", "image" + mc);
                $(this).find(".insert-media").attr("data-link", "image" + mc);
                mc++;
            });
        }
        $("input[name='total_images']").val(mc);
    });

    $(document).on("click", ".close-image-x", function () {
        var r = window.confirm("Do you wnat to delete image");
        if (r) {
            $(this).parent().remove();
            var mc = 1;
            $(".uc-image").each(function () {
                $(this).find("input").attr("name", "image" + mc);
                $(this).find(".image_display").removeClass("image" + (mc + 1));
                $(this).find(".image_display").addClass("image" + mc);
                $(this).find(".insert-media").attr("data-return", "image" + mc);
                $(this).find(".insert-media").attr("data-link", "image" + mc);
                mc++;
            });
        }
        $("input[name='total_images']").val(mc);
    });
    $(document).on("click", ".clear-image-x", function () {
        var r = window.confirm("Do you wnat to delete image");
        if (r) {
            $(this).parent().find("input").val("");
            $(this).parent().find(".image_display").html("");
        }
    });
    $(".fetch_data").click(function () {
        var _this = $(this);
        var f = $(this).attr("data-get");
        var u = $(this).attr("data-input");
        u = $("input[name='" + u + "']").val();
        var data = "action=_fetch_data&u=" + u + "&f=" + f;
        var sm;
        $.ajax({
            "async": false,
            "type": "POST",
            "global": false,
            "dataType": "html",
            "url": ajaxReq,
            "data": data,
            "beforeSend": function () {
                _this.next(".fetch-preloder").remove();
                _this.after("<div class='fetch-preloder'><img src='" + baseURL + "images/icons/loader.gif'></div>");
            },
            "success": function (data) {
                sm = data;
                $(".fetch-preloder").html("<div class='suc'>Data has been fetched successfully.</div>");
            }
        });

        //$(".is_m_check").html(sm);
        var result = JSON.parse(sm);
        for (x in result) {
            var rs = 'input[name=' + x + ']'; // Get the input element of form
            var tr = "textarea[name='" + x + "']"; // Get the textarea of form

            if ($(tr).length > 0) {
                var text_id = $("textarea[name='" + x + "']").attr("id");
                $("textarea[name='" + x + "']").val(result[x]);
                if (text_id != undefined) {
                    tinymce.get(text_id).setContent(result[x]);
                    //tinyMCE.get(text_id).execCommand("mceInsertContent",true,result[x]);
                }
            } else if ($(rs).length > 0) {
                if ($(rs).attr('type') != "radio") {
                    $(rs).val(result[x]);
                } else if ($(rs).attr("type") == "radio") {
                    $('input[type=radio]').each(function (index, element) {
                        name = $(element).attr('name');
                        db_rod = result[name];
                        if ($(element).val() == db_rod) {
                            $(element).attr('checked', true);
                        }
                    });
                }
            }
        }

        $("input[name='" + u + "']").focus();
    });



    // Save Form on press CTRL + S

    $(window).bind('keydown', function (event) {
        if (event.ctrlKey || event.metaKey) {
            switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                    event.preventDefault();
                    $(".product-add-form-q").click();
                    break;
            }
        }
    });

    $("span.adm-prev a").html('<i class="fa fa-chevron-left"></i>');
    $("span.adm-next a").html('<i class="fa fa-chevron-right"></i>');

    // creating slug
    $("#title").keypress(function (e) {
        var replaceSpace = $("#title").val();
        var result = replaceSpace.replace(/\s/g, "-");
        $("#slug").val(result);
    });
    // sending request to add new product hardware
    $("#brand_btn_submit").click(function (e) {
        var brnad_name = $("#brand_name").val();
        var data = "action=";
        e.preventDefault();
    });

    $(".rptBtnPnd").click(function () {
        var c = window.confirm("Do you want to continue?");
        var _el = $(this);
        if (c) {
            var id = $(this).attr("data-id");
            var type = $(this).attr("data-type");
            var status = $(this).attr("data-status");
            var data = {
                id: id,
                status: status,
                type: type,
                _token: $(".tokenId").val(),
            };
            sendData(baseURL + "changeReportStatus", data).done(function () {
                _el.hide();
            });
        }
        return false;
    });

});
if (seg2 == "blogs" && seg3 == "") {
    $('form').bind("keypress", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
    $(document).ready(function () {
        _token = $('meta[name="csrf-token"]').attr('content');
        var pageURL = $(location).attr("href");
        var url = new URL(pageURL);
        var id = url.searchParams.get("id");
        var data = {};
        var data1 = {};
        data.id = id;
        data._token = _token;
        sendData(baseURL + "get-internal-links", data).done(function (resp) {
            var string = resp;
            var data1 = string.split(',');
			const data2 = [];
			data1.forEach(element => {
				  data2.push(element.toLowerCase());
				});
				$(".tags_input").tagComplete({
                keylimit: 5,
                hide: false,
                freeInput: true,
                freeEdit: false,
                autocomplete: {
                    data: data2
                }
            });
        });

    });
}
$(".schma_type .fa-edit").click(function () {
    var _this = $(this).closest("span");
    _this.css('display', 'none');
    _this.closest("div").find("input[type=text]").css('display', 'block');

});
$(".___vw_dsb").click(function () {
    $(".___vw_dsb").removeClass("active");
    $(this).addClass("active");
    var m = $(this).attr("data-m");
    var d = {};
    if (m === "current_month") {
        d = JSON.parse($(".vw-cr-mn").html());
    } else if (m === "monthly") {
        d = JSON.parse($(".vw-cr-yr").html());
    } else {
        d = JSON.parse($(".vw-cr-an").html());
    }
    _____vchart(d["labels"], d["data1"]);
});

$(document).ready(function () {
    var cloneSchema =
        '<div class="new-schema border row">' +
        '<span class="clear-data2">x</span>' +
        '<div class="col-lg-12">' +
        '<div class="form-row">' +
        '<div class="form-group col-lg-12">' +
        '<div class="flex-center"><b>  <span class="no"> </span> &nbsp; - &nbsp;</b> <input type="text" name="type[]" placeholder="schema name here" value=""  > </div> <br>' +
        '<textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Schema here..."  >  </textarea>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    $(".add-more-schema").click(function () {
        var html_obj = cloneSchema;
        $(".schema .schema-rows").append(html_obj);
        var n = $(".schema .schema-rows").find(".new-schema").length;
        var el = $(".schema .schema-rows .new-schema:nth-child(" + n + ")");
        el.find(".no").text(n);
        return false;
    });

    $(document).on("click", ".clear-data2", function () {
        var v = window.confirm("Do you want to delete data?");
        if (v) {
            $(this).closest(".row").remove();
        }
    });
});

$(document).ready(function() {
    checkWidth();
});
$(window).on("resize", function(){
    checkWidth();
});


function checkWidth(){
    $vWidth = $(window).width();
    $('#test').html($vWidth);

    //Check condition for screen width
    if($vWidth > 1100){
    if($('.fixme').length > 0){
      var fixmeTop = $('.fixme').offset().top;       // get initial position of the element
		$(window).scroll(function() {                  // assign scroll event listener
		var _wd = $("._Wd").width();
		var currentScroll = $(window).scrollTop(); // get current position
		if (currentScroll >= fixmeTop) {           // apply position: fixed if you
			$('.fixme').css({                      // scroll to that element or below it
				position: 'fixed',
				top: '75px',
				width: _wd,
			});
			$('#ui-datepicker-div').css({   
				top: '75',
			});
		} else {                                   // apply position: static
			$('.fixme').css({                      // if you scroll above it
				position: 'static'
			});
			$('#ui-datepicker-div').css({ 
				position: 'relative',
				top: '75',
				width: _wd,
			});
		}
		});
    }else{
		var _cls = $(".card");
		_cls.removeClass("fixme");
	}
    }
}

$('.copyboard').on('click', function(e) {
  e.preventDefault();

  var copyText = $(this).attr('data-text');

  var textarea = document.createElement("textarea");
  textarea.textContent = copyText;
  textarea.style.position = "fixed"; // Prevent scrolling to bottom of page in MS Edge.
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand("copy"); 

  document.body.removeChild(textarea);
  
    var $el = $(this),
    x = 2000,
    originalColor = $el.css("color");

$el.css("color", "#17a2b8");
setTimeout(function(){
  $el.css("color", originalColor);
}, x);
})
