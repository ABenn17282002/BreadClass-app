<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者プロフィール編集画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
            @foreach ($administrator as $admin)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- 管理者編集用フォーム --}}
                <form method="POST" action="">
                    {{-- 編集→更新する場合はPUTメソッドを使用する。 --}}
                    @method('PUT')
                    @csrf
                    <div class="max-w-2xl py-4 mx-auto">
                        <x-jet-validation-errors class="mb-4" />
                        {{-- flassmessageの表示 --}}
                        <x-flash-message />

                        <div>
                            <x-jet-label for="name" value="{{ __('Name') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="$admin->name" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="$admin->email" required autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password"
                                required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                        </div>
                        @endforeach
                        <div class="p-3 w-full flex justify-around mb-3">
                            <button type="button" onclick="location.href='{{ route('admin.dashboard')}}'"
                                class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <button type="submit"
                                class="text-white bg-lime-500 border-0 py-2 px-8 focus:outline-none hover:bg-lime-400 rounded text-lg">更新する</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-admin-layout>
