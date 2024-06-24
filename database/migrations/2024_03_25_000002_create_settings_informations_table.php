<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings_informations', function (Blueprint $table) {
            $table->id();
            $table->string('address')->default('Mon adresse');
            $table->string('email')->default('adresse@mail.com');
            $table->string('phone')->default('12345');
            $table->string('fax')->nullable();
            $table->longText('legalnotice')->nullable();
            $table->longText('termsofservice')->nullable();
            $table->timestamps();
        });
        DB::table('settings_informations')->insert([
            'address' => 'Mon adresse',
        ]);

        /*** Ajout des permision **/
        $permissions = [
            [
                'category' => 'Settings',
                'group_name' => 'Information',
                'permissions' => [
                    'settings.information.update',
                ],
            ]
        ];
        addPermissions($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_informations');
    }
};
