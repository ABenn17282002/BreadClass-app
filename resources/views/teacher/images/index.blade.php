<x-teacher-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">画像一覧<講師></h2>
  </x-slot>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
        {{-- flassmessageの表示 --}}
        <x-flash-message/>
        {{-- 画像新規作成 --}}
        <div class="flex justify-end mb-4">
            <button onclick="" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
        </div>
        {{-- width:1/4--}}
        <div class="w-1/4 p-4">
            <a href="">
                <div class="border rounded-md p-4">
                    {{-- image_title名 --}}
                    <div class="text-xl">画像タイトル</div>
                    <div>
                        <img src="{{ asset('images/no_image.jpg')}}">
                    </div>
                </div>
            </a>
        </div>
        </div>
    </div>
    </div>
</div>
</x-teacher-layout>>
