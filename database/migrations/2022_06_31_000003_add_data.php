<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('INSERT INTO user (user_id, user_name, user_password, user_email, user_phone, user_address, user_admin, user_remember_token, user_created_at, user_updated_at) VALUES (1, \'tech\', \'$2y$10$oPQedncENOvkDzgLhyipb.Nll0J7RMxYPA/YJKVyywYwxUeCEjgCS\', \'tranphuchau3112@gmail.com\', null, null, 0, null, \'2022-06-25 11:12:30\', \'2022-06-25 11:12:30\');', []);
        DB::insert('INSERT INTO user (user_id, user_name, user_password, user_email, user_phone, user_address, user_admin, user_remember_token, user_created_at, user_updated_at) VALUES (2, \'admin\', \'$2y$10$O3eZ5G619h2X7.V2V4D1Vu6aVT7U2vcpi8N.HDlT2qPQxOvSx7R5m\', null, null, null, 0, null, \'2022-06-25 11:13:39\', \'2022-06-25 11:13:39\');', []);

        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (1, 'red', 'Rác thải nhựa', 'chai đựng (dầu gội đầu, sữa tắm, sữa dưỡng da, nước ngọt, nước khoáng, nước súc miệng, nước đóng chai …); hộp đựng (bột giặt, mỹ phẩm, nước xả vải...).');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (2, 'orange', 'Rác thải giấy', 'giấy báo, giấy viết, giấy in, giấy vàng mã, giấy bao gói, tờ rơi quảng cáo, hộp carton, bìa carton, bao bì carton.');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (3, 'yellow', 'Rác thải kim loại', 'sắt, thép, inox, lon rỗng (bia, rượu, nước giải khát, thực phẩm đóng hộp, hộp đựng sữa…).');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (4, 'green', 'Rác thải thực phẩm', 'thức ăn thừa; vỏ trái cây, bã trà, vỏ trứng; rau, củ, quả, xác động vật, thực vật thải bỏ...');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (5, 'blue', 'Rác thải sành sứ, thủy tinh, đồ gốm', 'chai, lọ, bình, bát, đĩa, đũa, thìa, chén, cốc, ly…; lọ, hộp đựng mỹ phẩm; kính, gương vỡ…');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (6, 'indigo', 'Rác thải từ vải – cao su – da', 'tã giấy, băng vệ sinh, quần áo, vải vụn thải bỏ, tất chân, găng tay… và giấy ăn, giấy vệ sinh, giấy lau, đầu mẩu thuốc lá, giấy bọc kẹo bánh…');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name, trash_type_description) value (7, 'violet', 'Rác thải nguy hại', 'pin, bình ắc quy, hoá chất, bóng đèn huỳnh quang, giẻ lau dính dầu, dính hóa chất…và các loại chất thải nguy hại khác.');", []);

        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (1, 'Cụm 1', '', 1);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (2, 'Cụm 2', '', 1);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (3, 'Cụm 3', '', 1);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (4, 'Cụm 4', '', 2);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (5, 'Cụm 5', '', 2);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (6, 'Cụm 6', '', 2);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (7, 'Cụm 7', '', 3);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (8, 'Cụm 8', '', 3);");
        DB::insert("insert into trash_group (trash_group_id, trash_group_name,trash_group_address,trash_location_index) value (9, 'Cụm 9', '', 3);");

        DB::insert("insert into trash_location(trash_location_id, trash_location_name) value (1, 'Phường 12 – Quận Gò Vấp');");
        DB::insert("insert into trash_location(trash_location_id, trash_location_name) value (2, 'Phường 13 – Quận Gò Vấp');");
        DB::insert("insert into trash_location(trash_location_id, trash_location_name) value (3, 'Phường 17 – Quận Gò Vấp');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('user')->truncate();
        DB::table('trash_type')->truncate();
        DB::table('trash_location')->truncate();
        DB::table('trash_group')->truncate();
    }
}
