<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者一覧
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
                                <button onclick="location.href='{{ route('admin.show.create')}}'"
                                    class="text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                                    <a href="{{ route('expired-admins.index')}}"><img class="w-10 h-10 ml-5" src="{{ asset("images/trash.png") }}"></a>
                            </div>
                            <div class="lg:w-3/4 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="md:px-5 py-4 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                名前
                                            </th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                メールアドレス
                                            </th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                作成日
                                            </th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                更新日
                                            </th>
                                            {{-- buttonを同じ形に編集する --}}
                                            @can('admin')
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
                                        @foreach ($administrators as $administrator)
                                        <tr>
                                            <td class="md:px-2 py-3">{{ $administrator -> name }}</td>
                                            <td class="md:px-2 py-3">{{ $administrator-> email }}</td>
                                            <td class="md:px-2 py-3">{{ $administrator-> created_at->format('Y/m/d') }}
                                            </td>
                                            <td class="md:px-2 py-3">{{ $administrator-> updated_at->format('Y/m/d') }}
                                            </td>
                                            {{-- 管理者以外は表示されない --}}
                                            @can('admin')
                                            {{-- 編集ボタン作成 --}}
                                            <td class="md:px-4 py-3">
                                                <button onclick="location.href='{{ route('admin.show.edit', ['admin' => $administrator->id ])}}'" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-500 rounded ">編集</button>
                                            </td>
                                            {{-- ゴミ箱用ボタン(softdeleted) --}}
                                            <form id="delete_{{ $administrator->id }}" method="post" action="{{ route('admins.expired', ['admin' => $administrator->id ]) }}">
                                                @csrf
                                                {{-- 削除メソッド --}}
                                                @method('delete')
                                                <td class="md:px-4 py-3">
                                                    <a href="#" data-id="{{ $administrator->id }}" onclick="deletePost(this)"><img class="w-8 h-8" src="{{ asset("images/trash.png") }}"></a>
                                                </td>
                                            </form>
                                            @endcan
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
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
            if (confirm('この情報をゴミ箱へ移します。宜しいですか？')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-admin-layout>
