@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Footer</h6>
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
          <form method="POST" action="/{{ admin }}/footer" enctype="multipart/form-data">
            @csrf
             @php
                $m_data = json_decode($data->footer);
                @endphp
            <div class="row">
              <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
              <div class="col-lg-6">
                @php
                $m_data = json_decode($data->copyrights);
                @endphp
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Copyright Text</label>
                    <div class="input-group">
                      <input type="text" class="form-control tcount" placeholder="All Rights Reserved By:" name="copyrights_title" value="{{ isset($m_data)?$m_data->copyrights_title:''}}" data-count="text">
                    </div>
                  </div>
                   <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">Company Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control tcount" placeholder="Digital Applications" name="company_name" value="{{ isset($m_data)?$m_data->company_name:''}}" data-count="text">
                    </div>
                  </div>
                  <div class="form-group col-md-12 p-0">
                    <label class="font-weight-600">URL</label>
                    <div class="input-group">
                      <input type="text" class="form-control tcount" placeholder="https://dgaps.com" name="company_url" value="{{ isset($m_data)?$m_data->company_url:''}}" data-count="text">
                    </div>
                  </div>
              </div>
              <div class="col-lg-12">
                @php
                  $social_links = ($data->social_links !="" )? json_decode($data->social_links , true) : array();
                @endphp
                <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Social Media Links</b>
                    </div>
                    <div class="card-body">
                      <div class="socialmedia">
                        <div class="form-rows">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>link</th>
                                <th>icon</th>
                              </tr>
                            </thead>
                            <tbody  id="sortable" class=" social m-tbc todo-list msortable ui-sortable">
                              
                              @php 
								 $ic = array("icon-twitter" , "icon-facebook","icon-instagram" , "icon-pintrest" , "icon-linkedin" , "icon-youtube" , "icon-reddit");
                              $res = $social_links; $rev_count = (count($res)==0) ? 0 : count($res) - 1; 
                              for ($n=0; $n<=6; $n++){ 
                                $link=( isset($res[$n][ "link"])) ? $res[$n][ "link"]: ""; 
                                $icon=( isset($res[$n][ "icon"])) ? $res[$n][ "icon"]: $ic[$n];
                            @endphp
                                  <tr class="tr-row">
                                <td>{{ $n+1 }}</td>
                                <td>
                                  <div class="form-group m-0">
                                    <input type="text" name="link[]" placeholder="social media link here" class="form-control" value="{{ $link }}"/>
                                    <div class="text-danger"> </div>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group m-0">
                                    <div class="input-group">
                                      <input type="text"  name="icon[]" placeholder="" class="form-control" value="{{ $icon }}" readonly />
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              @php } @endphp
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>                
              </div>
              <div class="col-lg-12">
                <br> <br>
                  <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Save Record </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
