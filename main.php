<?php
/**
 * Plugin Name: Custom Shipping Company For Woocommerce
 * Description: ระบบเลือกบริษัทขนส่งเองสำหรับลูกค้า ใช้ร่วมกับ Weight Based Shipping for WooCommerce
 * Version: 1.0
 * Author: Jirakit Pawnsakunrungrot
 * Author URI: https://www.linkedin.com/in/sunny-jirakit
 * Plugin URI: https://github.com/sunny420x/woocommerce-custom-shipping-company
 */

add_action('admin_menu', 'worldchem_custom_shipping_company_menu');

function worldchem_custom_shipping_company_menu() {
    add_menu_page(
        'จัดการค่าบริการบริษัทขนส่ง', // Title ของหน้า
        'จัดการค่าบริการบริษัทขนส่ง', // ชื่อเมนูที่โชว์ในแถบข้าง
        'manage_options', //สิทธิ์การเข้าถึง (Admin)
        'woocommerce-custom-shipping-settings', // Slug ของหน้า
        'woocommerce_custom_shipping_setting_page', // ฟังก์ชันที่ใช้พ่น HTML หน้า Setting
        'dashicons-airplane', // ไอคอน
        '80' // ตำแหน่งเมนู
    );
}

function woocommerce_custom_shipping_setting_page() {
    ?>
    <div class="wrap">
        <form action="options.php" method="post">
        <?php
        settings_fields('shipping_settings_group');
        ?>
        <h1>จัดการค่าบริการบริษัทขนส่ง</h1>
        <p>สำหรับระบบรองรับการเลือกบริษัทขนส่งเอง</p>
        <hr>
        <h2>ไปรษณีย์ไทย (EMS)</h2>
        <p>ถ้าของหนักเกิน 5 กิโล ให้บวกเพิ่มกิโลละกี่บาทจากฐานเดิม</p>
        <input type="number" name="ems_fee" value="<?php echo esc_attr(get_option('ems_fee', 30)); ?>" />
        <h2>Kerry Express</h2>
        <p>หากลูกค้าเลือกขนส่ง Kerry Express จะบวกเพิ่มเป็นจำนวนกี่บาท</p>
        <input type="number" name="kerry_express_fee" value="<?php echo esc_attr(get_option('kerry_express_fee', 30)); ?>" />
        <h2>ค่าแพ็ค</h2>
        <input type="number" name="packing_fee" value="<?php echo esc_attr(get_option('packing_fee', 60)); ?>" />
        <h2>พื้นที่ห่างไกล</h2>
        <p>หากลูกค้าอยู่ในพื้นที่ห่างไกล เช่น 85 อำเภอห่างไกล จะคิดค่าบริการเพิ่มกี่บาท</p>
        <input type="number" name="remote_surcharge" value="<?php echo esc_attr(get_option('remote_surcharge', 50)); ?>" />
        <?php submit_button('บันทึกการเปลี่ยนแปลง'); ?>
        </form>
        <hr>
        <p>Github Repository: <a href="https://github.com/sunny420x/woocommerce-custom-shipping-company" target="_blank">github.com/sunny420x/woocommerce-custom-shipping-company</a></p>
    </div>
    <?php
}

add_action('admin_init', 'woocommerce_custom_shipping_setting_init');
function woocommerce_custom_shipping_setting_init() {
    register_setting('shipping_settings_group', 'ems_fee');
    register_setting('shipping_settings_group', 'packing_fee');
    register_setting('shipping_settings_group', 'kerry_express_fee');
    register_setting('shipping_settings_group', 'remote_surcharge');
}

add_filter( 'woocommerce_package_rates', 'worldchem_combined_shipping_methods', 10, 2 );
function worldchem_combined_shipping_methods( $rates, $package ) {
    $new_rates = array();
    $total_weight = WC()->cart->get_cart_contents_weight(); // กรัม
    $packing_fee = (float) get_option('packing_fee', 60); // ค่าแพ็ค

    // 1. ดึงรหัสไปรษณีย์
    $destination_zip = $package['destination']['postcode'];

    // 2. รายชื่อรหัสพื้นที่ห่างไกล (ก๊อปของพี่มาใส่ตรงนี้)
    $remote_areas = [
        '50240', '50250', '50260', '50270', '50310', '50350', '51160', '52160', '52180', '55220', '56160', '57170', '57180', '57260', '57310', '57340', '58000', '58110', '58120', '58130', '58140', '58150',
        '81150', '81210', '82130', '82150', '82160', '84170', '84280', '84310', '84320', '84330', '84360', '92110', '92140', '92150', '93120', '93130', '94120', '94130', '94140', '94150', '94160', '94170', '94180', '94190', '94220', '94230', '95110', '95120', '95130', '95140', '95150', '95160', '95170', '96110', '96120', '96130', '96140', '96150', '96160', '96170', '96180', '96190', '96210', '96220',
        '20120', '23000', '23120', '23170', '71180', '71240'
    ];

    // 3. เช็คว่าเป็นพื้นที่ห่างไกลไหม
    $is_remote = in_array($destination_zip, $remote_areas);
    $remote_surcharge = $is_remote ? (float) get_option('remote_surcharge', 60) : 0; // ถ้าใช่ บวก 50 ถ้าไม่ใช่ บวก 0

    foreach ( $rates as $rate_id => $rate ) {
        if ( strpos( $rate_id, 'wbs' ) !== false ) {

            $original_rate = clone $rate; 
            $original_rate->label = 'ค่าจัดส่ง (เลือกอัตโนมัติ)';
            $original_rate->cost += $remote_surcharge;
            $new_rates[$rate_id] = $original_rate;

            $kerry_rate = clone $rate; 
            $kerry_rate->id = $rate_id . '_kerry'; // เติม ID ต่อท้าย
            $kerry_rate->label = 'Kerry Express';
            $kerry_rate->cost += $remote_surcharge + (float) get_option('kerry_express_fee', 60) + $packing_fee;
            $new_rates[$kerry_rate->id] = $kerry_rate;

            //Thailand Post ส่งได้มากสุดแค่ 20kg
            if($total_weight <= 20000) {
                $ems = clone $rate;
                $ems->id = $rate_id . '_ems';
                $ems->label = 'ไปรษณีย์ไทย (EMS)';
                
                if ( $total_weight > 5000 ) { 
                    // ถ้าของหนักเกิน 5 กิโล ให้บวกเพิ่มกิโลละ 25 บาทจากฐานเดิม
                    $over_weight = ceil(($total_weight - 5000) / 1000);
                    $ems->cost = $rate->cost + ($over_weight * (float) get_option('ems_fee', 30)) + $packing_fee;
                    } else {
                        // ถ้าของเบา ใช้เรทปกติ
                        $ems->cost = $rate->cost + $packing_fee;
                }

                $ems->cost += $remote_surcharge;
                $new_rates[$ems->id] = $ems;
            }
        } else {
            // ถ้ามีขนส่งอื่นที่ไม่ใช่ Weight Based ให้โชว์ปกติ
            $new_rates[$rate_id] = $rate;
        }
    }

    return $new_rates;
}

/**
 * บันทึกชื่อบริษัทขนส่งลงใน Order Note หลังจากลูกค้าสั่งซื้อ
 */
add_action( 'woocommerce_checkout_update_order_meta', 'worldchem_save_shipping_label_to_order_note', 10, 2 );
function worldchem_save_shipping_label_to_order_note( $order_id, $data ) {
    // 1. ดึงข้อมูลการจัดส่งจากออเดอร์
    $order = wc_get_order( $order_id );
    $shipping_methods = $order->get_shipping_methods();

    foreach ( $shipping_methods as $method ) {
        // ดึงชื่อ Label ที่ลูกค้าเลือก (เช่น ไปรษณีย์ไทย (EMS))
        $method_name = $method->get_name(); 

        // 2. เขียนข้อความลงใน Order Note (หลังบ้านจะเห็นเป็นแถบสีม่วง/เทา)
        $note = "ประเภทการขนส่งที่ลูกค้าเลือก: " . $method_name;
        $order->add_order_note( $note );
    }
}