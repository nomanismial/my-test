    function sendData(url, obj) {
    return $.ajax({
        "type": "POST",
        "global": false,
        "dataType": "html",
        "url": url,
        "data": obj
    });
    }
    $("body").click(function (m) {
        var el = $(m.target);
        if (el.hasClass("dropdown-toggle")) { } else {
            $(".navbar-collapse").removeClass("show");
        }
    }),
    $(".searchbtn").click(function () {
        $(".navbar-collapse").removeClass("show");
    }),
    $(".searchbtn").click(function (t) {
        t.stopPropagation(), $(".searchContent").toggle(), $('input[type="search"]').focus();
        $(".searchContent").each(function (i) {
            if (i == 1) {
                $(this).hide();
                $('input[type="search"]').focus();
            }
        })
    }),
    $("body").click(function () {
        $(".searchContent").hide();
    }),
    $(".searchContent > *").click(function (t) {
        t.stopPropagation();
    }),
    $(".searchContent").click(function (t) {
        t.stopPropagation();
    }),
    $(document).ready(function () {
        $("#back-to-top").click(function () {
            $("html,body").animate({
                scrollTop: 0
            }, 100);
        }),
            $(window).scroll(function () {
                $(window).scrollTop() >= 450 ? $("#back-to-top").addClass("btn-active") : $("#back-to-top").removeClass("btn-active");
            });
    });

    
var fbComment = window.location.pathname.split("/")[1];
if (page_id === 2) {
    function loadPlugin() {
        var t = document.createElement("script");
        (t.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0"),
            (t.nounce = "WquAwtTH"),
            t.setAttribute("async", ""),
            t.setAttribute("defer", ""),
            t.setAttribute("crossorigin", "anonymous"),
            document.getElementById("fb-commentbox").appendChild(t);
    }
    setTimeout(loadPlugin, 9e3);
}
if (page_id === 2 || seg1 === "about") {
	var _blogHeight = $(".blog_detail").height();
	var _asideHeight = $(".side_bar").height();
	if(_blogHeight > _asideHeight){
	if($(".fixme").length > 0 ){
		if($('.fixme img._adsImage').length > 0){
			var stickitLeft1 = $('.fixme img').offset.left;
			var stickitWidth1 = $(".fixme img").width() + "px";
			var stickitHeight1 = $(".fixme img").height() + "px";
			var stickySidebarToTop1 = $('.fixme img').offset().top;
		   }else{
			var stickitLeft1 = $('.fixme ').offset.left;
			var stickitWidth1 = $(".side_bar ").width() + "px";
			var stickitHeight1 = $(".fixme ").height() + "px";
			var stickySidebarToTop1 = $('.fixme').offset().top;
		   }
		$(window).scroll(function () {
		var windowToTop1 = $(window).scrollTop();
		if (windowToTop1 + 10 > stickySidebarToTop1) {
		  var socialHeight1 = $(".newsletter").offset().top - 515;
		  if (windowToTop1 > socialHeight1) {
					$('.fixme').css({
						position: 'absolute',
						'top': 'auto',
						'left': stickitLeft1,
						'width': stickitWidth1,
						'height': stickitHeight1 ,
					});
		  } else {
					$('.fixme').css({
						position: 'fixed',
						'top': '70px',
						'bottom':'0px',
						'left': stickitLeft1,
						'width': stickitWidth1,
						'height': stickitHeight1 ,
					});
		  }
		} else {
				$('.fixme').css({
					'position': 'relative',
					'top': '0px',
					'width': stickitWidth1,
					'height': stickitHeight1,
				});
		}
		});
	}
	}
}

// Youtube Video Loader
if (page_id === 2) {
	$( 'p:empty' ).remove();
	$('img').unwrap("p");
	$('p').each(function() {
    const $this = $(this);
	if($this.html().replace(/\s|&nbsp;/g, '').length === 0)
			$this.remove();
	});
    $(document).ready(function () {
        // START Fast & Agile YouTube Embed by Schoberg.net
            $(".youtube").each(function() {
        // Set the BG image from the youtube ID
        $(this).css('background-image', 'url(https://img.youtube.com/vi/' + this.id + '/default.jpg');
        // Click the video div
        $(document).delegate('#' + this.id, 'click', function() {
            // Build embed URL
            var iframe_url = "//www.youtube.com/embed/" + this.id + "?autoplay=1&loop=1&autohide=1&border=0&wmode=opaque&enablejsapi=1&modestbranding=1&controls=1&showinfo=0";
            // Grab extra parameters set on div
            if ($(this).data('params')) iframe_url += '&' + $(this).data('params');
            // Build iframe tag
            var iframe = $('<iframe/>', {
                'allowfullscreen': 'allowfullscreen',
                'frameborder': '0',
                'src': iframe_url,
                'allow': 'autoplay'
            })
            // Replace the YouTube thumbnail with YouTube HTML5 Player
            $(this).append(iframe);
        }); // /click
    }); // /each video
	
	        // START Fast & Agile YouTube Embed by Schoberg.net
            $("._facebook").each(function() {
        // Set the BG image from the youtube ID
        // $(this).css('background-image', 'url(https://img.youtube.com/vi/' + this.id + '/default.jpg');
        // Click the video div
        $(document).delegate('#' + this.id, 'click', function() {
            // Build embed URL
            var _page = $(this).attr('data-page');
            var iframe = "<iframe src='http://www.facebook.com/plugins/video.php?href=https://www.facebook.com/"+_page+"/videos/"+ this.id +"'  width='560' height='314' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowfullscreen='true' allow='autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share' allowFullScreen='true'></iframe>";
            $(this).append(iframe);
        }); // /click
    }); // /each video
		
        // END Fast & Agile YouTube Embed by Schoberg.net
    }); // /document ready
	
}

jQuery(document).ready(function (e) {
    $('.newsletter__input input[name="email"]').keypress(function (e) {
        var _vl = $(this).val();

        var key = e.which;
        if (key == 13) {
            $('._sub_btn').click();
            return false;           
        }
    });
    $("._sub_btn").click(function (t) {
        t.preventDefault();
        var _this = $(this);
        $("#model .fw-bold").removeClass("text-success");
        $("#model .fw-bold").removeClass("text-danger");
        $("#model").removeClass("model-error");
        $("#model").removeClass("model-success");
        $("#model .text-black-50").text("");
        var _vl = $('.newsletter__input input[name="email"]').val();
            a = _this.closest("form").serializeArray();
                _this.attr("disabled", false);
                if(_vl == ""){
                _this.attr("disabled", true);
                $("#error .error_message").text("Please Enter Your Valid Email ID");
                $("#error").modal('show');
                _this.attr("disabled", false);
            }else{
                $("#model").modal('show');
                $("#model .fw-bold").text("Please Wait...");
                $("#model .text-black ").text("");
        e.ajax({
            headers: {
                "X-CSRF-TOKEN": _token
            },
            type: "post",
            global: "false",
            datatype: "html",
            url: "/subscriber",
            data: a
        })
            .done(function (e) {
                if (e.resp === "success") {
                    _this.closest("form").trigger("reset");
                    _this.closest("div").find("img").remove();
                    _this.attr("disabled", true);
                    $("#model").removeClass("model-error");
                    $("#model").addClass("model-success");
                    $("#model .fw-bold").removeClass("text-danger");
                    $("#model .fw-bold").addClass("text-success");
                    $("#model .fw-bold").html("Congratulations! <span class='icon-smile'></span>");
                    $("#model .text-black-50").text("You have subscribed for our "+site_name+ " NewsLetter");
                } else {
                    var error = e.msg;
                    _this.attr("disabled", true);
                    $("#model").removeClass("model-success");
                    $("#model").addClass("model-error");
                    $("#model .fw-bold").removeClass("text-success");
                    $("#model .fw-bold").addClass("text-danger");
                    $("#model .fw-bold").html("Oops! <span class='icon-sad'></span>");
                    $("#model .text-black-50 ").text(error.email);
                    _this.attr("disabled", false);
                }
            })
        t.preventDefault();
    }
    });
});

$(document).on("click", '#btn-load',function(){
        var id = $(this).data('id');
        var query = $(this).data('query');
        $("#btn-load").text("");
        $("#btn-load").css({"background":"white url(preeloader.gif) no-repeat center","background-size":"contain","padding":"23px 67px","border":"1px solid var(--site-color)"});
          $.ajax({
           url : "/more-post",
           method : "POST",
           data : {id:id, query:query , _token:_token},
           dataType : "text",
           success : function (data)
           {
              if(data != '') 
              {
               setTimeout(function () {
                    $('.button-column').remove();
                  }, 1e3);
                  $('.append-row').append(data);
              }
              else
              {
                  $('.append-row').append("No Data");
              }
           }
          });
      });

if (seg1 === "contact-us") {
	$('._showEmail').css( 'cursor', 'pointer' ); 
    $(document).ready(function () {
        $(".alert-success").hide();
        window._____ISERROR = true;
        _is_validate("#myForm", {
            name: {
                require: !0,
                min: 3,
                max: 50
            },
            subject: {
                require: !0,
                min: 3,
                max: 50
            },
            email: {
                require: !0,
                email: !0
            },
            message: {
                require: !0,
                min: 10,
                max: 5000
            }
        }),
    $(".mybtn1").click(function (e) {
        e.preventDefault();
        $(this).attr('disabled', true);
        var rText = $(this).text();
        var r = $(this);
        $(this).text('Sending.....');
        a = r.closest("form"),
            t = r.closest("form").serializeArray();
        r.attr("disabled", !0),
            $.ajax({

                headers: {
                    "X-CSRF-TOKEN": _token
                },
                type: "post",
                global: "false",
                datatype: "html",
                url: "/contactform",
                data: t
            }).done(function (e) {
                if (e.resp === "success") {
                    $("html").animate({
                        scrollTop: 100
                    }, "slow");
                    r.attr('disabled', false);
                    r.text(rText);
                    r.closest("form").trigger("reset");
                    r.closest("form").closest("div").find("img").remove();
                    $('.alert-success').text(' Your Message Has Been Submitted To Admin.');
                    $(".alert-success").show();
                    "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
                } else {
                    var error = e.msg;
                    r.text(rText);
                    var form = $("#myForm");
                    r.attr('disabled', false);
                    form.find("input").closest(".form-group").prevAll(".text-danger").remove(),
                        form.find("textarea").closest(".form-group").prevAll(".text-danger").remove(),
                        form.find("input[name='name']").addClass("dg-b-error");
                    form.find("textarea[name='content']").addClass("dg-b-error");
                    form.find("input[name='email']").addClass("dg-b-error");
                    if (error.hasOwnProperty("name")) {
                        $("<span class='d-block text-danger _errorText float-end font-size-12'>" + error.name + "</span>").insertBefore($("#myForm input[name='name']").closest(".form-group"));
                    }
                    if (error.hasOwnProperty("subject")) {
                        $("<span class='d-block text-danger _errorText float-end font-size-12'>" + error.subject + "</span>").insertBefore($("#myForm input[name='subject']").closest(".form-group"));
                    }
                    if (error.hasOwnProperty("message")) {
                        $("<span class='d-block text-danger _errorText  float-end font-size-12'>" + error.message + "</span>").insertBefore($("#myForm textarea[name='message']").closest(".form-group"));
                    }
                    if (error.hasOwnProperty("email")) {
                        $("<span class='d-block text-danger _errorText  float-end font-size-12'>" + error.email + "</span>").insertBefore($("#myForm input[name='email']").closest(".form-group"));
                    }
                    $("#errors").html("");
                }
            });
        });
    });

    $("._showEmail").on("click" , function(){
        var ist = $("._rec").attr("data-1st");
        var scnd = $("._rec").attr("data-2nd");
        var _email = ist+"@"+scnd;
        $("._showEmail").text(_email);
    return false;
    });
}

 !function(t){t.TableOfContents=function(e,n,i){var o=this;return o.$el=t(e),o.el=e,o.toc="",o.listStyle=null,o.tags=["h1","h2","h3","h4","h5","h6"],o.init=function(){if(o.options=t.extend({},t.TableOfContents.defaultOptions,i),void 0!==n&&null!=n||(n=document.body),o.$scope=t(n),1==o.$scope.find(o.tags.join(", ")).filter(":first").length){o.starting_depth=o.options.startLevel,o.options.depth<1&&(o.options.depth=1);var e=o.tags.splice(o.options.startLevel-1,o.options.depth);if(o.$headings=o.$scope.find(e.join(", ")),!1!==o.options.topLinks){var s=t(document.body).attr("id");""==s&&(s=o.options.topBodyId,document.body.id=s),o.topLinkId=s}return o.$el.is("ul")?o.listStyle="ul":o.$el.is("ol")&&(o.listStyle="ol"),o.buildTOC(),!0!==o.options.proportionateSpacing||o.tieredList()||o.addSpacing(),o}},o.tieredList=function(){return"ul"==o.listStyle||"ol"==o.listStyle},o.buildTOC=function(){o.current_depth=o.starting_depth,o.$headings.each(function(t,e){var n=this.nodeName.toLowerCase().substr(1,1);(t>0||0==t&&n!=o.current_depth)&&o.changeDepth(n),o.toc+=o.formatLink(this,n,t)+"\n",!1!==o.options.topLinks&&o.addTopLink(this)}),o.changeDepth(o.starting_depth,!0),o.tieredList()&&(o.toc="<li>\n"+o.toc+"</li>\n"),o.$el.html(o.toc)},o.addTopLink=function(e){var n=!0===o.options.topLinks?"Top":o.options.topLinks,i=t("<a href='#"+o.topLinkId+"' class='"+o.options.topLinkClass+"'></a>").html(n);t(e).append(i)},o.formatLink=function(e,n,i){var s=e.id;""==s&&(s=o.buildSlug(t(e).text()),e.id=s);var l="<a class='smooth-goto' href='#"+s+"'";return o.tieredList()||(l+=" class='"+o.depthClass(n)+"'"),l+=">"+o.options.levelText.replace("%",t(e).text())+"</a>"},o.changeDepth=function(t,e){if(!0!==e&&(e=!1),!o.tieredList())return o.current_depth=t,!0;if(t>o.current_depth){for(var n=[],i=o.current_depth;i<t;i++)n.push("<"+o.listStyle+">\n");o.toc+=n.join("<li>\n")+"<li>\n"}else if(t<o.current_depth){var s=[];for(i=o.current_depth;i>t;i--)s.push("</"+o.listStyle+">\n");o.toc+="</li>\n"+s.join("</li>\n"),e||(o.toc+="</li>\n<li>\n")}else e||(o.toc+="</li>\n<li>\n");o.current_depth=t},o.buildSlug=function(t){return t=(t=t.toLowerCase().replace(/[^a-z0-9 -]/gi,"").replace(/ /gi,"-")).substr(0,50)},o.depthClass=function(t){return o.options.levelClass.replace("%",t-(o.starting_depth-1))},o.addSpacing=function(){var e=o.$headings.filter(":first").position().top;o.$headings.each(function(n,i){var s=o.$el.find("a:eq("+n+")"),l=(t(this).position().top-e)/(o.$scope.height()-e)*o.$el.height();s.css({position:"absolute",top:l})})},o.init()},t.TableOfContents.defaultOptions={startLevel:1,depth:3,levelClass:"toc-depth-%",levelText:"%",topLinks:!1,topLinkClass:"toc-top-link",topBodyId:"toc-top",proportionateSpacing:!1},t.fn.tableOfContents=function(e,n){return this.each(function(){new t.TableOfContents(this,e,n)})}}(jQuery); 

$(document).ready(function(){
	$(".smooth-goto").hover(function () {
    $(this).closest("li").toggleClass("li_hover");
});
    $(".blog_detail .quest").each(function(i, e){
		var num = i+1;
        $(this).attr('data-counter',"Q"+num+": ");
    });
});

$(document).ready(function(){
	$(".nav-item.active").closest(".dropdown").addClass("active");
	$("input[type='search']").on(' keyup ,paste', function (event) {
		var t = $(this).val();
		t = t.replace("http://", "");
		t = t.replace("https://", "");
		t = t.replace("://", "");
		t = t.replace("//", "");
		t = t.replace("/", "");
		t = t.replace("https", "");
		t = t.replace("http", "");
		$(this).val(t);
	});
});



