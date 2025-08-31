<x-guest-layout>
    @if (Route::has('login'))
        @auth
            <a href="{{ url('/post') }}" class="border block w-auto text-center px-6 py-2 rounded-lg duration-200 font-semibold mb-4 w-full text-white bg-sky-400 hover:bg-orange-600">
                {{ Auth::user()->name }}のうたメモへ
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        @else
            <a href="{{ route('login') }}" class="block w-auto text-center px-6 py-2 rounded-lg duration-200 font-semibold mb-4 w-full bg-slate-600 text-white hover:bg-sky-400">
                ログイン
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="border block w-auto text-center px-6 py-2 rounded-lg duration-200 font-semibold mb-4 w-full hover:text-white hover:bg-orange-600">
                    新規アカウント登録
                </a>
            @endif
        @endauth
    @endif
</x-guest-layout>
