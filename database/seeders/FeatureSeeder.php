<?php

namespace Database\Seeders;

use App\Models\Feature;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features =
            array(
                //Applicaiton Features
                array('name' => 'Applicaiton Feature', 'parent_id' => '0', 'unique_key' => 'APPLICATION_FEATURES', 'status' => '1',),
                array('name' => 'User', 'parent_id' => '1', 'unique_key' => 'USER', 'status' => '1',),
                array('name' => 'User restriction', 'parent_id' => '1', 'unique_key' => 'USER_RESTRICTION', 'status' => '1',),
                array('name' => 'Warehouse', 'parent_id' => '1', 'unique_key' => 'WAREHOUSE', 'status' => '1',),
                array('name' => 'Branches/Shop', 'parent_id' => '1', 'unique_key' => 'BRANCH_SHOP', 'status' => '1',),

                //product Features
                array('name' => 'Product Features', 'parent_id' => '0', 'unique_key' => 'PRODUCT_FEATURE', 'status' => '1',),
                array('name' => 'Manage items group', 'parent_id' => '6', 'unique_key' => 'MANAGE_ITEMS_GROUP', 'status' => 1),
                array('name' => 'Serialized item', 'parent_id' => '6', 'unique_key' => 'SERIALIZED_ITEM', 'status' => '1',),
                array('name' => 'Auto stock adjustment for sales, purchase', 'parent_id' => '6', 'unique_key' => 'STOCK_ADJUSTMENT', 'status' => '1',),
                array('name' => 'Manual stock adjustment (Addition / Deduction)', 'parent_id' => '6', 'unique_key' => 'MANUAL_STOCK_ADJUSTMENT', 'status' => '1',),
                array('name' => 'Low quantity item Notifiaction', 'parent_id' => '6', 'unique_key' => 'LOW_QUANTITY_NOTIFICATION', 'status' => '1',),
                array('name' => 'Generate Product Barcode Label', 'parent_id' => '6', 'unique_key' => 'PRODUCT_BARCODE', 'status' => '1',),
                // array('name' => 'Generate Product Barcode Label', 'parent_id' => '6', 'unique_key' => 'null', 'status' => '1' ,),
                array('name' => 'Item Inventory History', 'parent_id' => '6', 'unique_key' => 'ITEM_INVENTORY_HISTORY', 'status' => '1',),
                array('name' => 'Item Sales Report In Any Data Range', 'parent_id' => '6', 'unique_key' => 'ITEM_SALE_REPORT', 'status' => '1',),
                array('name' => 'Item Purchase Report In Any Data Range', 'parent_id' => '6', 'unique_key' => 'ITEM_PURCHASE_REPORT', 'status' => '1',),
                //Sale Features
                array('name' => 'Sale Features', 'parent_id' => '0', 'unique_key' => 'SALE_FEATURE', 'status' => '1',),
                array('name' => 'Sales Order Per Month', 'parent_id' => '17', 'unique_key' => 'SALE_ORDER_PER_MONTH', 'status' => '1',),
                array('name' => 'invoice Per Month', 'parent_id' => '17', 'unique_key' => 'INVOICE_PER_MONTH', 'status' => '1',),
                array('name' => 'Sales Return', 'parent_id' => '17', 'unique_key' => 'SALES_RETURN', 'status' => '1',),
                array('name' => 'Serialized Item Sales', 'parent_id' => '17', 'unique_key' => 'SERIALIZED_ITEM_SALE', 'status' => '1',),
                array('name' => 'Customer Portal', 'parent_id' => '17', 'unique_key' => 'CUSTOMER_PORTAL', 'status' => '1',),
                array('name' => 'Multi Currency', 'parent_id' => '17', 'unique_key' => 'MULTI_CURRENCY', 'status' => '1',),
                array('name' => 'Item Wise Sale Report', 'parent_id' => '17', 'unique_key' => 'ITEM_WISE_SALE', 'status' => '1',),
                array('name' => 'Customer Wise Sale Report', 'parent_id' => '17', 'unique_key' => 'CUSTOMER_WISE_SALE', 'status' => '1',),
                //Prucahse Features
                array('name' => 'Purchase Features', 'parent_id' => '0', 'unique_key' => 'PURCAHSE_FEATURE', 'status' => '1',),
                array('name' => 'Purchase Order Per Month', 'parent_id' => '26', 'unique_key' => 'PURCHASE_ORDER_PER_MONTH', 'status' => '1',),
                array('name' => 'Bill Per Month', 'parent_id' => '26', 'unique_key' => 'BILL_PER_MONTH', 'status' => '1',),
                array('name' => 'Vendor Credits', 'parent_id' => '26', 'unique_key' => 'VENDOR_CREDIT', 'status' => '1',),
                array('name' => 'Purchase Approval', 'parent_id' => '26', 'unique_key' => 'PURCHASE_APPROVAL', 'status' => '1',),
                array('name' => 'Vendor Payments', 'parent_id' => '26', 'unique_key' => 'VENDOR_PAYMENT', 'status' => '1',),
                //Add on options
                array('name' => 'Add On Options', 'parent_id' => '0', 'unique_key' => 'ADD_ON_OPTION', 'status' => '1',),
                array('name' => 'Additional 50 orders + 50 shipping labels', 'parent_id' => '32', 'unique_key' => 'ADDITIONAL_ORDER_SHIPPING', 'status' => '1',),
                array('name' => 'Additional Warehouse', 'parent_id' => '32', 'unique_key' => 'ADDITIONAL_WAREHOUSE', 'status' => '1',),
                array('name' => 'Additional Users', 'parent_id' => '32', 'unique_key' => 'ADDITIONAL_USER', 'status' => '1',),
                //Mobile App
                array('name' => 'Mobile App', 'parent_id' => '0', 'unique_key' => 'MOBILE_APP', 'status' => '1',),
                array('name' => 'Android', 'parent_id' => '36', 'unique_key' => 'ANDROID', 'status' => '1',),
                array('name' => 'Iphone', 'parent_id' => '36', 'unique_key' => 'IPHONE', 'status' => '1',),

                //Reminder & Notifiation
                array('name' => 'Reminder And Notifications', 'parent_id' => '0', 'unique_key' => 'REMINDER_AND_NOTIFICATION', 'status' => '1',),
                array('name' => 'Notifications', 'parent_id' => '39', 'unique_key' => 'NOTIFICATION', 'status' => '1',),
                array('name' => 'Payment Reminder', 'parent_id' => '39', 'unique_key' => 'PAYMENT_REMINDER', 'status' => '1',),
                array('name' => 'Delivery Reminder', 'parent_id' => '39', 'unique_key' => 'DELIVERY_REMINDER', 'status' => '1',),
                array('name' => 'Due invoice Reminder For Customer', 'parent_id' => '39', 'unique_key' => 'DUE_INVOICE_REMINDER', 'status' => '1',),
                array('name' => 'Overdue invoice Reminder For Customer', 'parent_id' => '39', 'unique_key' => 'OVERDUE_INVOICE_REMINDER', 'status' => '1',),
                //Support
                array('name' => 'Support', 'parent_id' => '0', 'unique_key' => 'SUPPORT', 'status' => '1',),
                array('name' => 'Knowledge Base Access', 'parent_id' => '45', 'unique_key' => 'KNOWLEDGE_BASE_ACCESS', 'status' => '1',),
                array('name' => 'Vedio Call With Product Expert', 'parent_id' => '45', 'unique_key' => 'VEDIO_CALL', 'status' => '1',),
                array('name' => '2 Hours Of Free Setup Assistance', 'parent_id' => '45', 'unique_key' => 'FREE_SETUP_ASSISTANCE', 'status' => '1',),
                array('name' => 'Live Chat', 'parent_id' => '45', 'unique_key' => 'LIVE_CHAT', 'status' => '1',),

            );


        Feature::truncate();
        Feature::insert($features);
    }
}
