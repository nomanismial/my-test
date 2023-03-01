@include('admin.layout.header')
<style type="text/css">
  @keyframes click-wave {
  0% {
    height: 40px;
    width: 40px;
    opacity: 0.35;
    position: relative;
  }
  100% {
    height: 200px;
    width: 200px;
    margin-left: -80px;
    margin-top: -80px;
    opacity: 0;
  }
}

.option-input {
  -webkit-appearance: none;
  -moz-appearance: none;
  -ms-appearance: none;
  -o-appearance: none;
  appearance: none;
  position: relative;
  top: 13.33333px;
  right: 0;
  bottom: 0;
  left: 0;
  height: 40px;
  width: 40px;
  transition: all 0.15s ease-out 0s;
  background: #cbd1d8;
  border: none;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  margin-right: 0.5rem;
  outline: none;
  position: relative;
  z-index: 1000;
}
.option-input:hover {
  background: #9faab7;
}
.option-input:checked {
  background: #32a248;
}
.option-input:checked::before {
  height: 40px;
  width: 40px;
  position: absolute;
  content: '✔';
  display: inline-block;
  font-size: 26.66667px;
  text-align: center;
  line-height: 40px;
}
.option-input:checked::after {
  -webkit-animation: click-wave 0.65s;
  -moz-animation: click-wave 0.65s;
  animation: click-wave 0.65s;
  background: #40e0d0;
  content: '';
  display: block;
  position: relative;
  z-index: 100;
}
.option-input.radio {
  border-radius: 50%;
}
.option-input.radio::after {
  border-radius: 50%;
}

</style>
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-10">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Internal Link Settings</h6>
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
          <form method="post" action="">
            @csrf
            @php
              $target = isset($data->target) ? $data->target : "";
                $type = isset($data->type)  ? $data->type : "";
                $max =  isset($data->max) ? $data->max : "";
                $max_f = isset($data->max_f) ? $data->max_f : "";
                $max_p = isset($data->max_p) ? $data->max_p : 5;
                $max_d = (isset($data->max_d)) ? $data->max_d : 5;
                $max_s = (isset($data->max_s)) ? $data->max_s : 5;
                $max_1 = (isset($data->max_1)) ? $data->max_1 : 5;
             @endphp            
            <div class="form-group">
              <label>Target</label><Br>
              <select class="form-control" name="target">
                <option value="">Select</option>
                <option value="_blank" <?php if ($target=="_blank"){echo "selected";} ?> >New Window</option>
                <option value="_self" <?php if ($target=="_self"){echo "selected";} ?>>Same Window</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Type of links</label><Br>
              <select class="form-control" name="type">
                <option value="">Select</option>
                <option value="nofollow" <?php if ($type=="nofollow"){echo "selected";} ?>>No Follow</option>
                <option value="" <?php if ($type==""){echo "selected";} ?>>Do Follow</option>
              </select>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Max No. of Internal Links in one article</label><Br>
                <input type="number" max="50" min="1" value="<?php echo $max; ?>" name="max" class="form-control">
              </div>
              <div class="form-group col-md-6 pt-3">
                <label>
                  <input class="form-control option-input radio" type="radio" value="fixed" name="fx" <?php if ($max_f=="fixed"){echo "checked";} ?> > Fixed </label> 
				  &nbsp; &nbsp; &nbsp;
                  <label><input class="form-control option-input radio" type="radio" value="per" name="fx" <?php if ($max_f=="per"){echo "checked";} ?> > Percentage (%) </label>
              </div>
            </div>

            <div class="form-group">
              <label>Maximum Number of Links of the One Article </label><Br>
              <input type="number" max="50" min="1" value="<?php echo $max_1; ?>" name="max_1" class="form-control">
            </div>
            
            <div class="form-group">
              <label>Maximum No of Links of 1 article on the same anchor text: </label><Br>
              <input type="number" max="50" min="1" value="<?php echo $max_p; ?>" name="max_p" class="form-control">
            </div>
            
            <div class="form-group">
              <label>Maximum Number of Links of 1 article on different anchor text: </label><Br>
              <input type="number" max="50" min="1" value="<?php echo $max_d; ?>" name="max_d" class="form-control">
            </div>
            
            <div class="form-group">
              <label>Maximum Number of Links of its own Article </label><Br>
              <input type="number" max="50" min="1" value="<?php echo $max_s; ?>" name="max_s" class="form-control">
            </div>
            
            <div class="form-group" style="text-align:right;">
              <input type="submit" name="submit" value="Submit"
              class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')