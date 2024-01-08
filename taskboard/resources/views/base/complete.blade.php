{{-- resources/views/base/complete.blade.php --}}
@extends('base.baseTemplete')
@section('content')
      <!--メッセージ-->
      <div class="row">
        <div class="col-xl-5">
          <p>{{ $message }}</p>
        </div>
      </div>

      <!--移動ボタン-->
      <div class="row">
        <div class="col-xl-5">
          <div class="form-group">
            <a href="{{ isset($id) ? route($link, $id) : route($link) }}"
              ><input
                type="button"
                class="btn btn-secondary"
                value="{{ $button }}"
            /></a>
          </div>
        </div>
      </div>
@endsection