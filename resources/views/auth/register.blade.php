<x-guest-layout>
    <style>
        .footer {
            display: table;
            margin: 0 auto;
        }

        .head {
            margin-left: 10px;
            font-size: 30px;
        }

        .login {
            text-align: center;
        }

        .button {
            background-color: blue;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            color: white;
            margin-bottom: 10px;
        }
    </style>

    <head>
        <h3 class="head">
            Atte
        </h3>
    </head>
    <x-auth-card>
        <x-slot name="logo">
            <h1>会員登録</h1>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('名前
                ')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="名前" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('メールアドレス')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="パスワード" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('確認用パスワード')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="確認用パスワード" required />
            </div>


            <div class="flex items-center justify-end mt-4">


                <button class="button">
                    {{ __('登録') }}
                    <button>
            </div>
            <div class="login">
                <p>アカウントをお持ちの方はこちらから</p>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('ログイン') }}
                </a>
            </div>
        </form>
    </x-auth-card>
    <footer>
        <h4 class="footer">Atte.inc</h4>
    </footer>
</x-guest-layout>