@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Log List</h6>
            </div>
            <div class="text-right">
              <div class="actions">
               
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table id="myTable" class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                <thead>
                  <tr>
                    <td><strong>#</strong></td>
                    <td><strong>Date</strong></td>
                    <td><strong>IP Address</strong></td>
                    <td><strong>IP Location</strong></td>
                    <td><strong>Browser</strong></td>
                  </tr>
                </thead>
                <tbody>
                  
                   @foreach($data as $key)
                    <tr>
                      <td>{{$key->id}}</td>
                      <td>{{ $key->time }} </td>
                      <td>{{ $key->ip}}</td>
                      <td>{{ $key->city}}</td>
                      <td><b>{{ $key->platform}}</b> - {{ $key->browser}}</td>
                    <!--   <td></td> -->
                    </tr>
                    @endforeach 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')