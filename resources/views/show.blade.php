<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <style>
    .top {
      display: flex;
      justify-content: space-between;
    }

    .navbar {
      display: flex;
      align-items: center;
    }

    .menu {
      display: inherit;
    }

    .logout {
      margin: 0 10px;
    }

    .date-change::before {
      box-sizing: border-box;
      width: 12px;
      height: 12px;
      border: 1px solid #7a0;
      -webkit-border-radius: 25%;
      border-radius: 25%;
    }

    .date-change::after {
      left: 3px;
      width: 3px;
      height: 3px;
      border-top: 1px solid #7a0;
      border-right: 1px solid #7a0;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .arrow {
      position: relative;
      display: inline-block;
      padding: 0 0 0 16px;
      color: #000;
      vertical-align: middle;
      text-decoration: none;
      font-size: 15px;
    }

    .arrow::before,
    .arrow::after {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      margin: auto;
      content: "";
      vertical-align: middle;
    }

    .days {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    table {
      border-top: 1px solid black;
      margin: 0 auto;
      width: 70%;
    }

    th {
      margin: 0 5px;
    }

    td {
      margin: 0 5px;
    }

    tr {
      text-align: center;
    }

    .timelist {
      background-color: gray;
      width: 90%;
      margin: 0 auto;
    }

    .footer {
      margin: 20px auto;
      font-size: 15px;
      display: table;
    }
  </style>
  <div class="top">
    <h3>Atte</h3>
    <div class="navbar">
      @if (Route::has('login'))
      <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block menu">
        @auth
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
  <div class="days">
    <form method="POST" name="back" action="{{url('/back')}}">
      @csrf
      <input type="hidden" name="back" value="{{$today}}">
      <a class="date-change arrow" href="javascript:back.submit()"></a>
    </form>
    <p>{{$today}}</p>
    <form method="POST" name="next" action="{{url('/next')}}">
      @csrf
      <input type="hidden" name="next" value="{{$today}}">
      <a class="date-change arrow" href="javascript:next.submit()"></a>
    </form>
  </div>
  <div class="timelist">
    
    <table>
      <tr>
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
      </tr>

      @foreach($works as $work)
      <tr>
        <td>{{$work->users->name}}</td>
        <td>{{$work->work_start}}</td>
        <td>{{$work->work_end}}</td>
        <td>{{$work->getRest()}}</td>
        <td>{{$work->workTimes()}}</td>
      </tr>
      @endforeach
    </table>
  </div>

</body>
<footer>
  <h4 class="footer">Atte.inc</h4>
</footer>

</html>