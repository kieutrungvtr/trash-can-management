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

        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (1, 'red', 'Rác thải nhựa');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (2, 'orange', 'Rác thải giấy');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (3, 'yellow', 'Rác thải kim loại');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (4, 'green', 'Rác thải thực phẩm');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (5, 'blue', 'Rác thải sành sứ, thủy tinh');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (6, 'indigo', 'Rác thải từ vải – cao su – da');", []);
        DB::insert("insert into trash_type (trash_type_id, trash_type_color, trash_type_name) value (7, 'violet', 'Rác thải nguy hại');", []);

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
