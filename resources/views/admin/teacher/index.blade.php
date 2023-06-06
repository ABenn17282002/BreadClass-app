<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            講師一覧
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 mx-auto">
                            {{-- flassmessageの表示 --}}
                            <x-flash-message />
                            {{-- 新規作成ボタン --}}
                            <div class="flex justify-end mb-4">
                                <button onclick="location.href='{{ route('teacher.create')}}'" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                                <a href="{{ route('expired-teachers.index')}}"><img class="w-10 h-10 ml-5" src="{{ asset("images/trash.png") }}"></a>
                            </div>
                            {{-- 講師情報はあるかの確認 --}}
                            @if (count($teachers) > 0)
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                                            {{-- buttonを同じ形に編集する --}}
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
                                        @foreach ($teachers as $teacher)
                                        <tr>
                                            <td class="md:px-4 py-3">{{ $teacher -> name }}</td>
                                            <td class="md:px-4 py-3">{{ $teacher -> email }}</td>
                                            <td class="md:px-4 py-3">{{ $teacher ->created_at->diffForHumans() }}
                                            </td>
                                            {{-- 編集ボタン作成 --}}
                                            <td class="md:px-4 py-3">
                                                <button onclick="location.href='{{ route('teacher.edit', ['teacher' => $teacher->id ])}}'" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-500 rounded ">編集</button>
                                            </td>
                                            {{-- 削除用ボタン --}}
                                            <form id="delete_{{ $teacher-> id }}" method="post" action="{{ route('teachers.expired', ['teacher' => $teacher->id ])}}">
                                                @csrf
                                                {{-- 削除メソッド --}}
                                                @method('delete')
                                                <td class="md:px-4 py-3">
                                                    <a href="#" data-id="{{ $teacher->id }}" onclick="deletePost(this)"><img class="w-8 h-8" src="{{ asset("images/trash.png") }}"></a>
                                                </td>
                                            </form>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            @else
                                <p class="text-center">講師情報はありません。<br>講師情報を作成してください。</p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    {{-- 削除確認用アラート --}}
    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('この情報をゴミ箱へ移します宜しいですか？')) {
            document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-admin-layout>
