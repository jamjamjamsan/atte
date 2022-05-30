<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <title>Atte</title>
</head>

<body>
  <style>
    h3 {
      margin-left: 30px;
    }

    .top {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar {
      display: flex;
      align-items: center;
    }

    .navbar a {
      margin: 0 10px;
    }

    .menu {
      display: inherit;
    }

    .logout {
      margin: 0 10px 0 0;
    }

    .main {
      width: 90%;
      background-color: whitesmoke;
      margin: 0 auto;
    }

    .arrow {
      position: relative;
      display: inline-block;
      padding: 10px;
      border: 1px solid #5070e3;
      margin: 0 10px;
      top: 5px;
    }

    .arrow::before {
      content: '';
      width: 8px;
      height: 8px;
      border-top: solid 2px #5070e3;
      border-right: solid 2px #5070e3;
      position: absolute;
      left: 5px;
      top: 5px;
    }

    .arrow.arrow-left::before {
      transform: rotate(-135deg);
      left: 7px;
    }

    .arrow.arrow-right::before {
      transform: rotate(45deg);
      left: 3px;
    }

    .days {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px auto;
      padding: 20px;
    }

    .days p {
      margin: 0;
    }

    table {
      border-top: 1px solid gray;
      margin: 0 auto;
      width: 80%;
      border-collapse: collapse;
      height: 300px;
    }

    th {
      margin: 0 5px;
    }

    td {
      margin: 0 5px;
      text-align: center;
    }

    tr {
      text-align: center;
      border-bottom: 1px solid gray;
    }

    .timelist {

      width: 100%;
      margin: 0 auto;
    }

    .pagelink {
      justify-content: center;
      margin-top: 10px;
      display: flex;
    }

    .footer {
      margin: 20px auto;
      font-size: 15px;
      display: table;
    }

    @media (max-width: 768px) {
      .top {
        display: flex;
        align-items: center;
        font-size: 15px;
      }

      .timelist {
        font-size: 10px;
      }

      table {
        height: 150px;
      }
      .navbar {
        font-size: 5px;
      }
    }
  </style>
  <div class="top">
    <h3>Atte</h3>
    <div class="navbar">
      @if (Route::has('login'))
      <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block menu">
        @auth
        <a href="{{ url('/') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ホーム</a>
        <a href="{{ url('/attendance') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">日付一覧</a>
        <a href="{{ url('/user') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ユーザー一覧</a>
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
  <div>
    <table class="main">
      <tr>
        <th>名前</th>
        <th>日付</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
      </tr>

      @foreach($user as $user)
      <tr>
        <td>{{$user->users->name}}</td>
        <td>{{$user->date}}</td>
        <td>{{$user->work_start}}</td>
        <td>{{$user->work_end}}</td>
        <td>{{$user->getRest()}}</td>
        <td>{{$user->workTimes()}}</td>
      </tr>
      @endforeach
    </table>


  </div>



  <footer>
    <h4 class="footer">Atte.inc</h4>
  </footer>

</body>

</html>