<x-guest-layout>
    <style>
        .footer {
            margin: 0 auto;
            font-size: 15px;
            display: table;
        }

        .head {
            margin-left: 10px;
            font-size: 30px;
        }

        .account {
            text-align: center;
        }

        .submit {
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
            <h1>ログイン</h1>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="メールアドレス" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="パスワード" required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>

            <div class="flex items-center justify-center mt-4">

                <button class=" submit">
                    {{ __('ログイン') }}
                </button>
            </div>
            <div class="account">
                <p>アカウントをお持ちでない方はこちらから</p>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('会員登録') }}
                </a>
            </div>
        </form>
    </x-auth-card>
    <footer>
        <h4 class="footer">Atte.inc</h4>
    </footer>
</x-guest-layout>