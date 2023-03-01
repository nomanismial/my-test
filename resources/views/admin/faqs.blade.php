@include('admin.layout.header')
@php
tiny_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Add FAQs</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/faqs/meta')}}" class="btn btn-info float-right">FAQs Meta Settings</a>
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
          <form method="post" action="{{ route('admin-faqs') }}">
            @csrf
            <input type="hidden" name="id" value="{{$edit?$edit->id:''}}" >
            <div class="form-group">
              <label class="req">Question</label>
              <input type="text" name="question" value="{{$edit?$edit->question:''}}" class="form-control">
              @if ($errors->has('question'))
                <div class="text-danger">{{ $errors->first('question')}}</div>
              @endif
            </div>
            <div class="form-group">
              <label class="req">Answer</label><br>
              <textarea name="answer" class="form-control tinyeditor"  rows="10">{{$edit?$edit->answer:''}}</textarea>
              @if ($errors->has('answer'))
                <div class="text-danger">{{ $errors->first('answer')}}</div>
              @endif
            </div>
            <div class="form-group">
              <input type="submit" name="submit" value="Submit" class="btn btn-info float-right">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Please Select Order</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="/<?= admin ?>/faqs-list" class="btn btn-info">View All Faqs</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="/<?= admin ?>/faqs/order" method="post">
            @csrf
            <div class="row">
              <div class="col-lg-10 col-sm-12 col-lg-offset-1">
				 @if (Session::has('faqs_order'))
				  <div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{!! Session('faqs_order') !!}</strong>
				  </div>
				  @endif
                <div class="form-group">
                  <ol id="sortable" class="m-tbc todo-list msortable ui-sortable">
                    @foreach($faqs as $k => $faq)
                    <li title=""><input type="hidden" name="order[]" value="{{ $faq->id }}" class="form-control"/>
                    <b>{{$faq->question}}</b>
                  </li>
                  @endforeach
                </ol>
              </div>
              @if (count($faqs) > 0)
                <div class="form-group">
                <input type="submit" name="submit-order" value="submit" class="btn btn-info float-right"/>
              </div>
              @endif
              
            </div>
          </div>
          <br>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@include('admin.layout.footer')