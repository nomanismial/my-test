@include('admin.layout.header')
@php
full_editor();
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-md-10 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Contact Us</h6>
                        </div>
                        <div class="text-right">
                            <div class="actions">
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
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="/{{ admin }}/contact" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group col-lg-10 p-0">
                                            <label class="font-weight-600">Meta Title</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$data->meta_title:''}}" data-count="text">
                                                <div class="input-group-append">
                                                    <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_title):'0'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-10 p-0">
                                            <label class="font-weight-600">Meta Description</label>
                                            <div class="input-group">
                                                <textarea class="form-control tcount" id="exampleFormControlTextarea1" placeholder="meta description" rows="3" name="meta_description" data-count="text">{{ isset($data)?$data->meta_description:''}}</textarea>
                                                <div class="input-group-append">
                                                    <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_description):'0'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group col-lg-4">
                                            <label class="font-weight-600">OG Image</label> <br>
                                            <div class="uc-image mx-auto" style="width:150px;height:150px;">
                                                <span class="clear-image-x">x</span>
                                                <input type="hidden" name="og_image" value="{{ isset($data)?$data->og_image:''}}">
                                                <div id="og_image" class="image_display">
                                                    <img src="{{ isset($data)?$data->og_image:''}}" alt="">
                                                </div>
                                                <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-10 p-0">
                                    <label class="font-weight-600">Meta Tags</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ isset($data)?$data->meta_tags:''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->meta_tags)):'0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-10 p-0">
                                    <label class="font-weight-600">Google Map</label>
                                    <div class="input-group">
                                        <textarea class="form-control " id="exampleFormControlTextarea1" placeholder="google map" rows="6" name="google_map" data-count="text">{{ isset($data)?$data->google_map:''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group col-lg-10 p-0">
                                    <label class="font-weight-600">Page Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" placeholder="page title..." name="page_title" value="{{ isset($data)?$data->page_title:''}}" data-count="text">
                                    </div>
                                </div>
                                <div class="form-group col-lg-10 p-0">
                                    <label class="font-weight-600">Email <small>For Receiving</small></label>
                                    <input type="text" class="form-control " placeholder="receiving email" name="r_email" value="{{ isset($data)?$data->r_email:''}}" data-count="text">
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label class="font-weight-600">Phone Number</label>
                                        <input type="text" class="form-control " placeholder="contact number" name="phone" value="{{ isset($data)?$data->phone:''}}">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label class="font-weight-600">Email <small> For Display</small>:</label>
                                        <input type="text" class="form-control " placeholder="email@example.com" name="email" value="{{ isset($data)?$data->email:''}}">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="font-weight-600">Address:</label>
                                        <input type="text" class="form-control " placeholder="address" name="address" value="{{ isset($data)?$data->address:''}}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')
