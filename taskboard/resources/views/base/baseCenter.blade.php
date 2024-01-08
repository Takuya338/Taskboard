@extends('base.base')
@section('baseContent')
    <div class="container">
        <!--中央に配置するコンテンツ-->
        <div class="center-content">
			@yield('content')
        </div>
    </div>

    <!--フッター-->
	<footer class="fixed-bottom">
		@include('base.footer')
	</footer>
@endsection