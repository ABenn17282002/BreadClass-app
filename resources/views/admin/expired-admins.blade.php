<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者情報＜ゴミ箱＞
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
                                <button type="button" onclick="location.href='{{ route('admin.show')}}'"
                                    class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">一覧へ戻る</button>
                            </div>
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                名前</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                メールアドレス</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                期限切れ日時</th>
                                            {{-- buttonを同じ形に編集する --}}
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
                                        @foreach ($expiredAdmins as $admin)
                                        <tr>
                                            <td class="px-4 py-3">{{ $admin->name }}</td>
                                            <td class="px-4 py-3">{{ $admin->email }}</td>
                                            {{-- 削除済みの日に変更 --}}
                                            <td class="px-4 py-3">{{ $admin->deleted_at->diffForHumans() }}</td>
                                            {{-- 削除用ボタン --}}
                                            <form id="" method="post"
                                                action="">
                                                @csrf
                                                <td class="px-4 py-3">
                                                    {{-- data-id=>owner_id取得 ==>onclickで削除実行 --}}
                                                    <a href="#" data-id="" onclick=""
                                                        class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded ">削除</a>
                                                </td>
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
