@include('admin.layout.header')
<div class="body-content">
    <div class="row">
        @php
        $rows = \App\Models\Category::orderby('name', 'asc')->get();
        // echo "<pre>";
        // print_r($rows);
        // echo "</pre>";
        @endphp

        <div class="col-md-4">
                <form method="post" action="{{ route("menu") }}">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-600">Create Empty Link</label>
                        <input type="hidden" name="id" value="{{ isset($edit) ? $edit->id : "" }}">
                        <input type="text" name="empty_link" value="{{ isset($edit) ? $edit->name : "" }}" placeholder="Empty Link Name" class="form-control">
                        @if ($errors->has('empty_link'))
                            <div class="text-danger">{{ $errors->first('empty_link')}}</div>
                         @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info float-right" name="link-submit" value="{{ isset($edit) ? "Update" : "Submit" }}">
                        <div class="clear-both" style="clear: both;"></div>
                    </div>

                </form>
            <div class="card mb-4">
                <div class="card-header">
                    <b>Categories & Pages </b>
                </div>
                <div class="card-body">
                    <ul class="menu-cat todo-list m-t ui-sortable" style="margin-top:0px;">
                        @php
                                $link = route('HomeUrl')."/";
                                $name = "Home";
                                $page = "page";
                                echo "
                                    <li style='cursor:pointer;''
                                        data-title = '$name'
                                        data-type = '$page'
                                        data-link = '$link'
                                        class = 'menu-added'
                                        >" .
                                    ucwords($name) .
                                    "
                                                    </li>";
                            foreach ($rows as $k => $v) {
                                $link = route('HomeUrl') . '/' . $v->slug . '-1' . $v->id;
                                echo "
                                    <li style='cursor:pointer;'
                                        data-id = '$v->id'
                                        data-title = '$v->name'
                                        data-type = 'category'
                                        data-link = '$link'
                                        class = 'menu-added'
                                        >" .
                                    ucwords($v->name) .
                                    "
                                                    </li>";
                            }
                            $pre = json_decode(get("empty_links"));
                            foreach ($links as $k => $v) {
                                $url = route('menu')."?edit=".$v->id;
                                $name = $v->name;
                                $page = "empty-link";
                                echo "
                                    <li style='cursor:pointer;''
                                        data-title = '$name'
                                        data-type = '$page'
                                        data-link = ''
                                        class = 'menu-added'
                                        >" .
                                    ucwords($name) .
                                    "
                                    <a href='$url' class='float-right'><i class='fa fa-edit'></i></a>
                                                    </li>";
                            }
                             $pages = array(

                                0 => array (
                                    'name' => 'About Us',
                                    'link' => 'about',
                                    'type' => 'page'
                                ),
                                1 => array (
                                    'name' => 'Contact US',
                                    'link' => 'contact-us',
                                    'type' => 'page'
                                ),
                                2 => array (
                                    'name' => 'Write For Us',
                                    'link' => 'write-for-us',
                                    'type' => 'page'
                                ),
                                3 => array (
                                    'name' => 'FAQs',
                                    'link' => 'faqs',
                                    'type' => 'page'
                                ),
                                4 => array (
                                    'name' => 'Privacy Policy',
                                    'link' => 'privacy-policy',
                                    'type' => 'page'
                                ),
                                5 => array (
                                    'name' => 'Terms & Conditions',
                                    'link' => 'terms-conditions',
                                    'type' => 'page'
                                ),


                            );

                            foreach ($pages as $k => $v) {
                                $link = route('HomeUrl') . '/' . $v['link'];
                                $name = $v["name"];
                                $page = "page";
                                echo "
                                    <li style='cursor:pointer;''
                                        data-title = '$name'
                                        data-type = '$page'
                                        data-link = '$link'
                                        class = 'menu-added'
                                        >" .
                                    ucwords($name) .
                                    "
                                                    </li>";
                            }
                        @endphp
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <form method="post" action="{{ route("menu") }}">
                    @csrf
                    <div class="card-header">
                        <div class="pull-right">
                            <p class="m-b-lg"><b>Add items from the left column</b>.</p>
                        </div>
                    </div>
                    <div class="card-body">
					@if (Session::has('flash_message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session('flash_message') !!}</strong>
                    </div>
                    @endif

                        <div class="dd" id="nestable">
                            <ol class="dd-list main-dd-list">
                                @php
                                    function __has_children($arr = [])
                                    {
                                        $r = false;
                                        foreach ($arr as $k => $v) {
                                            if (isset($v['children'])) {
                                                $r = true;
                                            }
                                        }
                                        return $r;
                                    }
                                    function __menu($data, $level = 1)
                                    {
                                        foreach ($data as $k => $v) {
                                            if (isset($v['children'])) {
                                                $link = $v['link'];
                                                $title = $v['title'];
                                                $type = $v['type'];
                                                $class = __has_children($v['children'])
                                                    ? "main-menu-sub sub-1st sm-nowrap
                                                            "
                                                    : 'sm-nowrap';
                                                echo "
                                                            <li class= 'dd-item'
                                                                data-type = '$type'
                                                                data-title = '$title'
                                                                data-link = '$link'
                                                                >
                                                                <div class='dd-handle'> $title
                                                                    <span class='menu-del pull-right' data-id='x'>x</span>
                                                                    <span class='type pull-right'>$type</span>
                                                                </div>
                                                                <ol class='dd-list'>";
                                                __menu($v['children'], $level++);
                                                echo "</ol>
                                                            </li>";
                                            } else {
                                                $link = $v['link'];
                                                $title = $v['title'];
                                                $type = $v['type'];
                                                echo "
                                                            <li class= 'dd-item'
                                                                data-type = '$type'
                                                                data-title = '$title'
                                                                data-link = '$link'
                                                                >
                                                                <div class='dd-handle'> $title
                                                                    <span class='menu-del pull-right' data-id='x'>x</span>
                                                                    <span class='type pull-right'>$type</span>
                                                                </div>
                                                            </li>
                                                            ";
                                            }
                                        }
                                        //$data = $this->Interact->get_setting("menutop");
                                    }
                                    $data = $Options->get('menu');
                                    $data = $data == '' ? [] : json_decode($data, true);
                                    __menu($data);
                                @endphp

                            </ol>
                        </div>
                        <div class="text-right" style="margin-top:25px;">
                            <textarea id="nestable-output" name="data" style="display:none;"></textarea>
                            <button class="btn btn-info save-menu" type="submit" name="save">Save Menu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')
<script src="{{ asset('admin-assets/plugins/nestable/nestable.js') }}"></script>
<script>
    $(document).ready(function() {
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1,
            maxDepth: 3
        }).on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        function add_to_menu(type, title, slug) {
            var list = $(".main-dd-list");
            var data = "<li " +
                "class='dd-item' " +
                "data-type='" + type + "'" +
                "data-title='" + title + "'" +
                "data-link='" + slug + "'>" +
                "<div class='dd-handle'>" + title + "" +
                "<span class='menu-del pull-right' data-id='x'>x</span>" +
                "<span class='type pull-right'>" + type + "</span>" +
                "</div>" +
                "</li>";
            list.append(data);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        }

        $(".menu-added").click(function() {
            var type, id, title, slug;
            var type = $(this).data("type");
            if (type == "page" || type == "category" || type == "empty-link") {
                id = $(this).data("id");
                title = $(this).data("title");
                slug = $(this).data("link");
            } else {
                title = $("input[name='text']").val();
                slug = $("input[name='url']").val();
                slug = (slug == "") ? "#" : slug;
            }
            if (title == "") {
                alert("Please enter link title");
            } else {
                $("input[name='text']").val("");
                $("input[name='url']").val("");
                add_to_menu(type, title, slug);
            }

        });

        $(document).on("click", ".menu-del", function() {
            var s = window.confirm("Do you want to continue?");
            if (s) {
                $(this).closest(".dd-item").remove();
                updateOutput($('#nestable').data('output', $('#nestable-output')));
            }
        });

        $(".save-menu").click(function() {
            var data = $("#nestable-output").val();
            var d = JSON.parse(data);
            var r = "Enter menu item.";
            if (Object.keys(d).length > 0) {
                //window.location = "?menu="+check+"&sv=1";
                return true;
            }
            alert(r);
            return false;
        });

    });

</script>
