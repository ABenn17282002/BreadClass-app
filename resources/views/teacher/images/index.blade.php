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
                    <button onclick="location.href='{{ route('teacher.image.create')}}'" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                </div>
                {{-- 画像があるか確認 --}}
                @if (count($images) > 0)
                {{-- 画像をflexで横並びにする --}}
                <div class="flex flex-wrap">
                    {{-- foreach構文でimages_tableからデータを取得 --}}
                    @foreach ($images as $image)
                    {{-- width:1/2→1/4に変更, padding-2, md:p-4に変更 --}}
                        <div class="w-1/4 p-2 md:p-4">
                            {{-- images_id取得→編集ページ --}}
                            <a href="">
                                    <div class="border rounded-md p-2 md:p-4">
                                        {{-- 画像title取得 --}}
                                        <div class="text-gray-700">{{ $image->title }}</div>
                                        {{-- 画像取得 --}}
                                        <div>
                                            <img src="{{ asset('storage/common/' . $image -> filename)}}">
                                        </div>
                                    </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{-- ページネーション --}}
                {{ $images->links() }}
            </div>
            @else
            <div class="w-1/4 p-2 m-auto">
                <p class="text-center">画像がありません。登録をしてください</p>
                <img src="{{ asset('images/no_image.jpg')}}">
            </div>
            @endif
        </div>
    </div>
</div>
</x-teacher-layout>>
