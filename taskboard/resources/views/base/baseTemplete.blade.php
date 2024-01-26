@extends('base.base')
@section('baseContent')
    <!--ヘッダー-->
    <header class="header sticky-top">
      <div class="row">
        <div class="col-xl-6"><h1>タスクボード管理</h1></div>
        <div class="col-xl-6">
          <nav class="navbar">
            <a href="{{ route('password.change') }}" class="nav-item nav-link">
              パスワード変更
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-item nav-link">
              アカウント設定
            </a>
            @if(Auth::user()->userType == config('user.type.admin'))
            <a href="{{ route('users.index') }}" class="nav-item nav-link">ユーザー管理</a>
            @endif
            <a href="{{ route('logout') }}" class="nav-item nav-link">ログアウト</a>
          </nav>
        </div>
      </div>
    </header>
    
    <div class="container-fluid pading-content">
        @yield('content')
    </div>
        
    <!--フッター-->
    <footer>
      @include('base.footer')
    </footer>
      
@endsection