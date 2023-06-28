<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規画像登録画面（管理者用）
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Error_message --}}
                    <x-jet-validation-errors class="mb-4" />
                    {{-- 新規画像UPLoad --}}
                    <form method="post" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="-m-2">
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="image" class="leading-7 text-sm text-gray-600">画像を選択してください（複数可）</label>
                                        {{-- 画像を配列形式で複数受け取る--}}
                                        <input type="file" id="image" name="files[][image]" multiple accept=“image/png,image/jpeg,image/jpg” class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <label for="titles" class="leading-7 text-sm text-gray-600">タイトル</label>
                                        {{-- 画像タイトルを複数受け取る--}}
                                        <input type="text" id="titles" name="titles[]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <label for="alts" class="leading-7 text-sm text-gray-600">alt属性</label>
                                        {{-- 画像altを複数受け取る--}}
                                        <input type="text" id="alts" name="alts[]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full flex justify-around mt-4">
                                        {{-- 戻る --}}
                                        <button type="button" onclick="location.href='{{ route('admin.image.list')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                        {{-- 登録ボタン --}}
                                        <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
