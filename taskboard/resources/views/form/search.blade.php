        <!--検索フォーム-->
        @if(isset($class))
        <div class="{{ 'col-xl-4' . $class }}">
        @else
        <div class="col-xl-4">
        @endif
          <form class="form-inline" method="get" action="{{ url()->current() }}">
            <input
              type="search"
              class="form-control"
              name="search"
              id="search"
              size="50"
              placeholder="{{ $placeholder }}" 
            　value ="{{ old('search') }}"/>
            <button class="btn btn-secondary">
              <i class="fab fa-sistrix"></i>
            </button>
          </form>
        </div>