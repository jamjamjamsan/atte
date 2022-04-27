<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Atte</title>



    <!-- Styles -->
    <style>

    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .top {
            display: flex;
            justify-content: space-between;
        }
        .top h3 {
            margin-left: 15px;
        }
        .navbar {
            display: flex;
            align-items: center;
        }
        .navbar a {
            margin: 0 10px;
        }

        .main {
            background-color: whitesmoke;
            display: block;
            height: 70vh;
            width: 95%;
            margin: 0 auto;
        }

        .work {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            height: 80%;
        }

        .form {
            width: 40%;
            display: flex;
            flex-wrap: wrap;
            margin: 10px auto;
        }

        .logout {
            display: inline;
        }

        .btn {
            width: 100%;

            background: white;
            color: black;
        }

        .btn_else {
            width: 100%;

            background: white;
            color: gray;
        }

        .footer {
            margin: 0 auto;
            font-size: 15px;
            display: table;
        }

        .alert {
            text-align: center;
            padding-top: 10px;
        }
        ul {
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="top">
        <h3>Atte</h3>
        <div class="navbar">
            @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block" id="menu">
                @auth
                <a href="{{ url('/') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ホーム</a>
                <a href="{{ url('/attendance') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">日付一覧</a>
                <form name="form_1" method="POST" action="logout" class="logout">
                    @csrf
                    <a href="javascript:form_1.submit()" class="text-sm text-gray-700 dark:text-gray-500 underline">ログアウト</a>
                </form>

                @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">会員登録</a>
                @endif
                @endauth
            </div>
            @endif
        </div>

    </div>

    <div class="main">

        @auth
        <div class="error">
            @if (session()->has('errors'))
            <div class="alert">
                <ul>
                    <li>{{session('errors')}}</li>
                </ul>
            </div>
            @endif

        </div>
        <div class="work">

            <form method="POST" action="/workstart" class="form">
                @csrf
                <button type="submit" class="btn">勤務開始</button>
            </form>
            <form method="POST" action="/workend" class="form">
                @csrf
                <button type="submit" class="btn">勤務終了</button>
            </form>
            <form method="POST" action="/reststart" class="form">
                @csrf
                <button type="submit" class="btn">休憩開始</button>
            </form>
            <form method="POST" action="/restend" class="form">
                @csrf
                <button type="submit" class="btn">休憩終了</button>
            </form>
        </div>
        @else
        <div class="work">

            <form method="POST" action="/" class="form">
                @csrf
                <button type="submit" class="btn_else" disabled>勤務開始</button>
            </form>
            <form method="POST" action="/" class="form">
                @csrf
                <button type="submit" class="btn_else" disabled>勤務終了</button>
            </form>
            <form method="POST" action="/" class="form">
                @csrf
                <button type="submit" class="btn_else" disabled>休憩開始</button>
            </form>
            <form method="POST" action="/" class="form">
                @csrf
                <button type="submit" class="btn_else" disabled>休憩終了</button>
            </form>
        </div>
        @endauth
    </div>

</body>
<footer>
    <h4 class="footer">Atte.inc</h4>
</footer>

</html>