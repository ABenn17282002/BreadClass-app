<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// 各モデルの追加
use App\Models\Administrator;
use App\Models\Teacher;
use App\Models\Image;
// DB::Hashクラスの追加(暗号化)
use Illuminate\Support\Facades\Hash;
// DB用Facadeをインポート
use Illuminate\Support\Facades\DB;

class MultiAuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者
        $init_administrators = [
            [
                'name' => '比嘉浩子',
                'email' => 'sctmsmhgwqtomoko24027@ruudcofapq.wk.rx',
                'password' => 'RAAv-aA',
                'role' => 1,  // Administrator
            ],
            [
                'name' => '神山志織',
                'email' => 'shiori066@vfiur.fom',
                'password' => 'QT6A5Ia7XWI,',
                'role' => 5,  // manager
            ],
        ];

        foreach($init_administrators as $init_administrator) {
            $administrator= new Administrator();
            $administrator->name = $init_administrator['name'];
            $administrator->email = $init_administrator['email'];
            $administrator->password = Hash::make($init_administrator['password']);
            $administrator->role = $init_administrator['role'];
            $administrator->save();
        }

        // 講師
        $init_teachers = [
            [
                'name' => '石本柚衣',
                'email' => 'yui171@fbjgnxiadm.orp',
                'password' => 'ojlczXKj',
            ],
            [
                'name' => '宮野年紀',
                'email' => 'toshinori4720@jrfxrf.cuz',
                'password' => 'UM9ny9Mc-bSk',
            ],
        ];

        foreach($init_teachers as $init_teacher) {
            $teacher = new Teacher();
            $teacher->name = $init_teacher['name'];
            $teacher->email = $init_teacher['email'];
            $teacher->password = Hash::make($init_teacher['password']);
            $teacher->save();
        }

        // 画像
        $init_images = [
            [
                'administrators_id' => 1,
                'filename' => 'sample1.jpg'
            ],
            [
                'administrators_id' => 1,
                'filename' => 'sample2.jpg'
            ],
            [
                'administrators_id' => 1,
                'filename' => 'sample3.jpg'
            ],
                        [
                'administrators_id' => 1,
                'filename' => 'sample4.jpg'
            ],
            [
                'administrators_id' => 1,
                'filename' => 'sample5.jpg'
            ],
            [
                'administrators_id' => 1,
                'filename' => 'sample6.jpg'
            ],
        ];

        foreach($init_images as $init_image) {
            $image= new Image();
            $image->administrators_id = $init_image['administrators_id'];
            $image->filename = $init_image['filename'];
            $image->save();
        }

    }
}
