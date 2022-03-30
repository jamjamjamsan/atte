<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>



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

        .navbar {
            display: flex;
            align-items: center;
        }

        .main {
            background: gray;
            display: flex;
            height: 50vh;
        }

        .form {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
        }

        form {
            width: 40%;
            display: flex;
            flex-wrap: wrap;
            margin: 10px auto;
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
            margin-left: 50%;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="top">
        <h3>Atte</h3>
        <div class="navbar">
            @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                <a href="{{ url('/attendance') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">日付一覧</a>
                <a href="/logout" class="text-sm text-gray-700 dark:text-gray-500 underline">ログアウト</a>
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
        <div class="form">

            <form method="POST" action="/workstart">
                @csrf
                <button type="submit" class="btn">勤務開始</button>
            </form>
            <form method="POST" action="/workend">
                @csrf
                <button type="submit" class="btn">勤務終了</button>
            </form>
            <form method="POST" action="/reststart">
                @csrf
                <button type="submit" class="btn">休憩開始</button>
            </form>
            <form method="POST" action="/restend">
                @csrf
                <button type="submit" class="btn">休憩終了</button>
            </form>
        </div>
        @else
        <div class="form">

            <form method="POST" action="/">
                @csrf
                <button type="submit" class="btn_else" disabled>勤務開始</button>
            </form>
            <form method="POST" action="/">
                @csrf
                <button type="submit" class="btn_else" disabled>勤務終了</button>
            </form>
            <form method="POST" action="/">
                @csrf
                <button type="submit" class="btn_else" disabled>休憩開始</button>
            </form>
            <form method="POST" action="/">
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