<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!--ページタイトル-->
	<title>タスクボードシステム</title>
	
	<!--CSS-->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/style.css') }}"  />
	
	<!--CDN-->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/v5.15.4/css/all.css" />

	<!--Javascript-->
	<script src="{{ asset('js/jquery.min.js') }}" /></script>
	<script src="{{ asset('js/popper.min.js') }}" /></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" /></script>
	<script src="{{ asset('js/script.js') }}" /></script>
	
	<!--Awe icon-->
    <script
      src="https://kit.fontawesome.com/4792cf1691.js"
      crossorigin="anonymous"></script>
	
</head>
<body>
	@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
　　@endif
    @yield('baseContent')
</body>
</html>