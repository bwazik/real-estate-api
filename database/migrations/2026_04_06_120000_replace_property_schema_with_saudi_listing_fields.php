<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dateTime('ad_date')->nullable()->index()->after('slug');
            $table->string('offer_type')->nullable()->after('ad_date');
            $table->string('listing_status')->nullable()->index()->after('offer_type');
            $table->string('property_category')->nullable()->after('listing_status');
            $table->string('offer_attribute')->nullable()->after('property_category');
            $table->string('offer_number')->nullable()->index()->after('offer_attribute');
            $table->string('property_name')->after('offer_number');
            $table->string('property_number')->nullable()->after('property_name');
            $table->string('property_area_text')->nullable()->after('property_number');
            $table->string('in_kind_registration')->nullable()->after('property_area_text');
            $table->string('platform_code')->nullable()->after('in_kind_registration');
            $table->string('plan_number')->nullable()->after('platform_code');
            $table->string('deed_number')->nullable()->after('plan_number');
            $table->date('deed_date')->nullable()->after('deed_number');
            $table->string('deed_status')->nullable()->after('deed_date');
            $table->string('facade_direction')->nullable()->after('deed_status');
            $table->unsignedInteger('facades_count')->default(0)->after('facade_direction');
            $table->string('advertiser_name')->nullable()->after('facades_count');
            $table->string('fal_license_number')->nullable()->after('advertiser_name');
            $table->string('advertising_license_number')->nullable()->after('fal_license_number');
            $table->string('property_address')->nullable()->after('advertising_license_number');
            $table->string('country')->nullable()->after('property_address');
            $table->string('city_name')->nullable()->index()->after('country');
            $table->string('district_name')->nullable()->index()->after('city_name');
            $table->string('street')->nullable()->after('district_name');
            $table->string('building_name')->nullable()->after('street');
            $table->unsignedInteger('floors_count')->nullable()->after('building_name');
            $table->unsignedInteger('apartment_number')->nullable()->after('floors_count');
            $table->text('map_location')->nullable()->after('apartment_number');
            $table->text('units_and_facilities')->nullable()->after('map_location');
            $table->unsignedInteger('apartments_count')->default(0)->after('units_and_facilities');
            $table->unsignedInteger('living_rooms_count')->default(0)->after('apartments_count');
            $table->unsignedInteger('kitchens_count')->default(0)->after('living_rooms_count');
            $table->unsignedInteger('parking_spaces')->default(0)->after('kitchens_count');
            $table->unsignedInteger('warehouses_count')->default(0)->after('parking_spaces');
            $table->boolean('has_maids_room')->default(false)->after('warehouses_count');
            $table->boolean('has_drivers_room')->default(false)->after('has_maids_room');
            $table->unsignedInteger('entrances_count')->default(0)->after('has_drivers_room');
            $table->unsignedInteger('annexes_count')->default(0)->after('entrances_count');
            $table->decimal('income', 15, 2)->default(0)->after('annexes_count');
            $table->decimal('highest_bid', 15, 2)->default(0)->after('income');
            $table->decimal('brokerage_fee', 15, 2)->default(0)->after('highest_bid');
            $table->decimal('insurance_amount', 15, 2)->default(0)->after('brokerage_fee');
            $table->text('obligations')->nullable()->after('insurance_amount');
            $table->text('advantages')->nullable()->after('obligations');
            $table->text('ad_information')->nullable()->after('advantages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'ad_date',
                'offer_type',
                'listing_status',
                'property_category',
                'offer_attribute',
                'offer_number',
                'property_name',
                'property_number',
                'property_area_text',
                'in_kind_registration',
                'platform_code',
                'plan_number',
                'deed_number',
                'deed_date',
                'deed_status',
                'facade_direction',
                'facades_count',
                'advertiser_name',
                'fal_license_number',
                'advertising_license_number',
                'property_address',
                'country',
                'city_name',
                'district_name',
                'street',
                'building_name',
                'floors_count',
                'apartment_number',
                'map_location',
                'units_and_facilities',
                'apartments_count',
                'living_rooms_count',
                'kitchens_count',
                'parking_spaces',
                'warehouses_count',
                'has_maids_room',
                'has_drivers_room',
                'entrances_count',
                'annexes_count',
                'income',
                'highest_bid',
                'brokerage_fee',
                'insurance_amount',
                'obligations',
                'advantages',
                'ad_information',
            ]);
        });
    }
};
