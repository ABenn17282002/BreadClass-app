<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            講師情報新規登録確認画面
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- 新規管理者登録フォーム --}}
                <div class="max-w-2xl py-4 mx-auto">
                    <form method="POST" action="{{ route('teacher.store') }}">
                        @csrf
                        <div>
                            <x-jet-label for="name" value="講師名" />
                            {{ $input['name'] }}
                            <x-jet-input id="name" class="block mt-1 w-full" type="hidden" name="name" :value="$input['name']" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            {{ $input['email'] }}
                            <x-jet-input id="email" class="block mt-1 w-full" type="hidden" name="email" :value="$input['email']" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            {{ str_replace($input['password'], "", "**********") }}
                            <x-jet-input id="password" class="block mt-1 w-full" type="hidden" name="password" :value="$input['password']" required />
                        </div>
                        <div class="p-3 w-full flex justify-around mb-3">
                            <button type="button" onclick="location.href='{{ route('teacher.create')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <x-jet-button class="ml-4">登録する</x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-admin-layout>
