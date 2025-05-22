@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-11/12 md:w-1/2 max-w-md mx-auto mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-blue-600">Sistema de Gestão de Creche</h1>
            <p class="mt-2 text-gray-600">Acesse sua conta para continuar</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input id="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="text-sm text-red-600 mt-1 block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input id="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="text-sm text-red-600 mt-1 block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <div class="flex items-center">
                    <input class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-700" for="remember">
                        Lembrar-me
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                    Entrar
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a class="text-sm text-blue-600 hover:text-blue-800 underline" href="{{ route('password.request') }}">
                        Esqueceu sua senha?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
