<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            講師情報＜ゴミ箱＞
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        {{-- flassmessageの表示 --}}
                        <x-flash-message />
                        <div class="container px-5 mx-auto">
                            {{-- 一覧へ戻る --}}
                            <div class="flex justify-end mb-4">
                                <button type="button" onclick="location.href='{{ route('admin.teacher')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">
                                    一覧へ戻る
                                </button>
                            </div>
                            {{-- ゴミ箱に情報があるかの確認 --}}
                            @if (count($expiredTeachers) > 0)
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除日</th>
                                            {{-- buttonを同じ形に編集する --}}
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
                                        @foreach ($expiredTeachers as $teacher)
                                        <tr>
                                            <td class="px-4 py-3">{{ $teacher->name }}</td>
                                            <td class="px-4 py-3">{{ $teacher->email }}</td>
                                            {{-- 削除済みの日に変更 --}}
                                            <td class="px-4 py-3">{{ $teacher->deleted_at->diffForHumans() }}</td>
                                            <form method="post" action="{{ route('teachers.restore', ['teacher' => $teacher->id ]) }}">
                                                @csrf
                                                @method('patch')
                                                <td class="px-4 py-3">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-400 text-white rounded py-2 px-4">復元</button>
                                                </td>
                                            </form>
                                            {{-- 削除用ボタン --}}
                                            <form id="delete_{{ $teacher-> id }}" method="post" action="{{ route('teachers.destroy', ['teacher' => $teacher->id]) }}">
                                                @csrf
                                                <td class="px-4 py-3">
                                                    {{-- data-id=>teachers_id取得 ==>onclickで削除実行 --}}
                                                    <a href="#" data-id="{{ $teacher-> id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                                                </td>
                                            </form>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                    <p class="text-center">ゴミ箱に情報はありません。</p>
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
        if (confirm('データを完全削除しますか?')) {
            document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
    </script>
</x-admin-layout>
