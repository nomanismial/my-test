@include('admin.layout.header')
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Blogs List</h6>
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{ url('/' . admin . '/blogs') }}"
                                    class="btn {{ Request::segment(2) == 'blogs' && Request::segment(3) == '' ? 'btn-inverse' : 'btn-info' }} pull-right">Add
                                    New</a>
                                <a href="{{ url('/' . admin . '/blogs/list') }}"
                                    class="btn {{ Request::segment(2) == 'blogs' && Request::segment(3) == 'list' ? 'btn-inverse' : 'btn-info' }} pull-right">Blogs
                                    List</a>
                                <a href="{{ url('/' . admin . '/blogs/category') }}"
                                    class="btn {{ Request::segment(2) == 'blogs' && Request::segment(3) == 'category' ? 'btn-inverse' : 'btn-info' }} pull-right">Add
                                    Category</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (Session::has('flash_message'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! Session('flash_message') !!}</strong>
                        </div>
                    @endif
                    @if (Session::has('flash_message2'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! Session('flash_message2') !!}</strong>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="" selected>Please Select Status</option>
                                        <option value="publish">Publish</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="author" id="author" class="form-control">
                                        <option value="" selected>Please Select Author</option>
                                        @foreach ($auth as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="category" id="category" class="form-control">
                                        <option value="" selected>Please Select Category</option>
                                        @foreach ($cats as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table
                                class="table display table-bordered table-striped table-hover bg-white m-0 card-table data-table">
                                <thead>
                                    <tr>
                                        <td><strong>Id</strong></td>
                                        <td><strong>Title</strong></td>
                                        <td><strong>Views</strong></td>
                                        <td><strong>Date</strong></td>
                                        <td><strong>Status</strong></td>
                                        <td><strong>Actions</strong></td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('list-data') }}",
                data: function(d) {
                    d.status = $('#status').val(),
                        d.author = $('#author').val(),
                        d.category = $('#category').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    title: 'title'
                },
                {
                    data: 'views',
                    title: 'views'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ]
        });
        $(document).on('change', '#status , #author , #category', function() {
            table.draw();
        })

    });
</script>
@include('admin.layout.footer')
