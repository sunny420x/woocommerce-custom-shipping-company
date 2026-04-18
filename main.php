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

function worldchem_custom_shipping_company_menu()
{
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

function woocommerce_custom_shipping_setting_page()
{
    ?>
    <div class="wrap" style="background: #fff; padding: 20px; border-radius: 10px; margin-top: 20px;">
        <form action="options.php" method="post">
            <?php
            settings_fields('shipping_settings_group');
            ?>
            <h1>จัดการค่าบริการบริษัทขนส่ง</h1>
            <p>สำหรับระบบรองรับการเลือกบริษัทขนส่งเอง</p>
            <hr>
            
            <div style="
            display: flex; 
            gap: 20px;
            ">
                <div>
                    <h2>ไปรษณีย์ไทย (EMS)</h2>
                    <p>หากลูกค้าเลือกขนส่ง ไปรษณีย์ไทย (EMS) <br>ให้บวกเพิ่มกี่บาท</p>
                    <input type="number" name="ems_fee" value="<?php echo esc_attr(get_option('ems_fee', 20)); ?>" />
                    <h3>ค่าขนส่ง EMS</h3>
                    <h4>ไม่เกิน 20 กรัม</h4>
                    <input type="number" name="ems_fee_p1" value="<?php echo esc_attr(get_option('ems_fee_p1', 32)); ?>" />
                    <h4>20 - 100 กรัม</h4>
                    <input type="number" name="ems_fee_p2" value="<?php echo esc_attr(get_option('ems_fee_p2', 37)); ?>" />
                    <h4>100 - 250 กรัม</h4>
                    <input type="number" name="ems_fee_p3" value="<?php echo esc_attr(get_option('ems_fee_p3', 42)); ?>" />
                    <h4>250 - 500 กรัม</h4>
                    <input type="number" name="ems_fee_p4" value="<?php echo esc_attr(get_option('ems_fee_p4', 52)); ?>" />
                    <h4>500 กรัม - 1 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p5" value="<?php echo esc_attr(get_option('ems_fee_p5', 67)); ?>" />
                    <h4>1.001 กิโลกรัม - 1.5 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p6" value="<?php echo esc_attr(get_option('ems_fee_p6', 82)); ?>" />
                    <h4>1.501 กิโลกรัม - 2 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p7" value="<?php echo esc_attr(get_option('ems_fee_p7', 97)); ?>" />
                </div>
                <div>
                    <h4>2.001 กิโลกรัม - 2.5 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p8" value="<?php echo esc_attr(get_option('ems_fee_p8', 100)); ?>" />
                    <h4>2.501 กิโลกรัม - 3 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p9" value="<?php echo esc_attr(get_option('ems_fee_p9', 105)); ?>" />
                    <h4>3.001 กิโลกรัม - 3.5 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p10"
                        value="<?php echo esc_attr(get_option('ems_fee_p10', 110)); ?>" />
                    <h4>3.501 กิโลกรัม - 4 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p11"
                        value="<?php echo esc_attr(get_option('ems_fee_p11', 120)); ?>" />
                    <h4>4.001 กิโลกรัม - 4.5 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p12"
                        value="<?php echo esc_attr(get_option('ems_fee_p12', 120)); ?>" />
                    <h4>4.501 กิโลกรัม - 5 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p13"
                        value="<?php echo esc_attr(get_option('ems_fee_p13', 120)); ?>" />
                    <h4>5.001 กิโลกรัม - 5.5 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p14"
                        value="<?php echo esc_attr(get_option('ems_fee_p14', 130)); ?>" />
                    <h4>5.501 กิโลกรัม - 6 กิโลกรัม</h4>
                    <input type="number" name="ems_fee_p15"
                        value="<?php echo esc_attr(get_option('ems_fee_p15', 140)); ?>" />
                    <h4>6 กิโลกรัมขึ้นไป คิดเพิ่มกิโลกรัมละ</h4>
                    <input type="number" name="ems_fee_after_6kg"
                        value="<?php echo esc_attr(get_option('ems_fee_after_6kg', 35)); ?>" />
                </div>
                <div>
                    <h2>Kerry Express</h2>
                    <p>หากลูกค้าเลือกขนส่ง Kerry Express จะบวกเพิ่มเป็นจำนวนกี่บาท</p>
                    <input type="number" name="kerry_express_fee"
                        value="<?php echo esc_attr(get_option('kerry_express_fee', 30)); ?>" />
                    <h2>ค่าแพ็ค</h2>
                    <input type="number" name="packing_fee"
                        value="<?php echo esc_attr(get_option('packing_fee', 60)); ?>" />
                    <h2>พื้นที่ห่างไกล (Remote Areas)</h2>
                    <p>กรอกรหัสไปรษณีย์ที่ต้องการบวกค่าบริการเพิ่ม (แยกด้วยเครื่องหมายคอมม่า หรือขึ้นบรรทัดใหม่)</p>
                    <textarea name="remote_areas_list" rows="10" cols="50" class="large-text" style="font-family: monospace;"><?php 
                        echo esc_textarea(get_option('remote_areas_list', '50240, 50250, 50260')); 
                    ?></textarea>
                    <p>หากลูกค้าอยู่ในพื้นที่ห่างไกล เช่น 85 อำเภอห่างไกล จะคิดค่าบริการเพิ่มกี่บาท</p>
                    <input type="number" name="remote_surcharge"
                        value="<?php echo esc_attr(get_option('remote_surcharge', 50)); ?>" />
                </div>
            </div>
            <?php submit_button('บันทึกการเปลี่ยนแปลง'); ?>
        </form>
        <hr>
        <p>Github Repository: <a href="https://github.com/sunny420x/woocommerce-custom-shipping-company"
                target="_blank">github.com/sunny420x/woocommerce-custom-shipping-company</a></p>
    </div>
    <?php
}

add_action('admin_init', 'woocommerce_custom_shipping_setting_init');
function woocommerce_custom_shipping_setting_init()
{
    register_setting('shipping_settings_group', 'ems_fee');
    register_setting('shipping_settings_group', 'packing_fee');
    register_setting('shipping_settings_group', 'kerry_express_fee');
    register_setting('shipping_settings_group', 'remote_surcharge');

    register_setting('shipping_settings_group', 'ems_fee_p1');
    register_setting('shipping_settings_group', 'ems_fee_p2');
    register_setting('shipping_settings_group', 'ems_fee_p3');
    register_setting('shipping_settings_group', 'ems_fee_p4');
    register_setting('shipping_settings_group', 'ems_fee_p5');
    register_setting('shipping_settings_group', 'ems_fee_p6');
    register_setting('shipping_settings_group', 'ems_fee_p7');
    register_setting('shipping_settings_group', 'ems_fee_p8');
    register_setting('shipping_settings_group', 'ems_fee_p9');
    register_setting('shipping_settings_group', 'ems_fee_p10');
    register_setting('shipping_settings_group', 'ems_fee_p11');
    register_setting('shipping_settings_group', 'ems_fee_p12');
    register_setting('shipping_settings_group', 'ems_fee_p13');
    register_setting('shipping_settings_group', 'ems_fee_p14');
    register_setting('shipping_settings_group', 'ems_fee_p15');
    register_setting('shipping_settings_group', 'ems_fee_after_6kg');

    register_setting('shipping_settings_group', 'remote_areas_list');
}

add_filter('woocommerce_package_rates', 'worldchem_combined_shipping_methods', 10, 2);
function worldchem_combined_shipping_methods($rates, $package)
{
    $new_rates = array();
    $total_weight = WC()->cart->get_cart_contents_weight(); // กรัม
    $packing_fee = (float) get_option('packing_fee', 60); // ค่าแพ็ค

    // 1. ดึงรหัสไปรษณีย์
    $destination_zip = $package['destination']['postcode'];

    // 2. รายชื่อรหัสพื้นที่ห่างไกล (ก๊อปของพี่มาใส่ตรงนี้)
    $remote_areas_raw = get_option('remote_areas_list', '');
    $remote_areas = preg_split('/[\s,]+/', $remote_areas_raw, -1, PREG_SPLIT_NO_EMPTY);
    $remote_areas = array_map('trim', $remote_areas);

    // 3. เช็คว่าเป็นพื้นที่ห่างไกลไหม
    $is_remote = in_array($destination_zip, $remote_areas);
    $remote_surcharge = $is_remote ? (float) get_option('remote_surcharge', 60) : 0; // ถ้าใช่ บวก 50 ถ้าไม่ใช่ บวก 0

    foreach ($rates as $rate_id => $rate) {
        if (strpos($rate_id, 'wbs') !== false) {

            $original_rate = clone $rate;
            $original_rate->label = 'ค่าจัดส่ง (เลือกอัตโนมัติ)';
            $original_rate->cost += $remote_surcharge;
            $new_rates[$rate_id] = $original_rate;

            $kerry_rate = clone $rate;
            $kerry_rate->id = $rate_id . '_kerry'; // เติม ID ต่อท้าย
            $kerry_rate->label = 'Kerry Express';
            $kerry_rate->cost += $remote_surcharge + (float) get_option('kerry_express_fee', 30);
            $new_rates[$kerry_rate->id] = $kerry_rate;

            //Thailand Post ส่งได้มากสุดแค่ 20kg
            if ($total_weight <= 20000) {
                $ems = clone $rate;
                $ems->id = $rate_id . '_ems';
                $ems->label = 'ไปรษณีย์ไทย (EMS)';

                $w = $total_weight; // หน่วยเป็นกรัม
                $ems_cost = 0;

                if ($w <= 20) {
                    $ems_cost = (float) get_option('ems_fee_p1', 32);
                } elseif ($w <= 100) {
                    $ems_cost = (float) get_option('ems_fee_p2', 37);
                } elseif ($w <= 250) {
                    $ems_cost = (float) get_option('ems_fee_p3', 42);
                } elseif ($w <= 500) {
                    $ems_cost = (float) get_option('ems_fee_p4', 52);
                } elseif ($w <= 1000) {
                    $ems_cost = (float) get_option('ems_fee_p5', 67);
                } elseif ($w <= 1500) {
                    $ems_cost = (float) get_option('ems_fee_p6', 82);
                } elseif ($w <= 2000) {
                    $ems_cost = (float) get_option('ems_fee_p7', 97);
                } elseif ($w <= 2500) {
                    $ems_cost = (float) get_option('ems_fee_p8', 100);
                } elseif ($w <= 3000) {
                    $ems_cost = (float) get_option('ems_fee_p9', 105);
                } elseif ($w <= 3500) {
                    $ems_cost = (float) get_option('ems_fee_p10', 110);
                } elseif ($w <= 4000) {
                    $ems_cost = (float) get_option('ems_fee_p11', 120);
                } elseif ($w <= 4500) {
                    $ems_cost = (float) get_option('ems_fee_p12', 120);
                } elseif ($w <= 5000) {
                    $ems_cost = (float) get_option('ems_fee_p13', 120);
                } elseif ($w <= 5500) {
                    $ems_cost = (float) get_option('ems_fee_p14', 130);
                } elseif ($w <= 6000) {
                    $ems_cost = (float) get_option('ems_fee_p15', 140);
                } else {
                    // ถ้าเกิน 6 กิโล ให้ใช้เรทสุดท้าย หรือจะบวกเพิ่มกิโลละ 20 บาทก็ได้ครับ
                    $extra_kg = ceil(($w - 6000) / 1000);
                    $ems_cost = (float) get_option('ems_fee_p15', 140) + ($extra_kg * get_option('ems_fee_after_6kg', 35));
                }

                $ems->cost = $ems_cost + $packing_fee + $remote_surcharge;
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
add_action('woocommerce_checkout_update_order_meta', 'worldchem_save_shipping_label_to_order_note', 10, 2);
function worldchem_save_shipping_label_to_order_note($order_id, $data)
{
    // 1. ดึงข้อมูลการจัดส่งจากออเดอร์
    $order = wc_get_order($order_id);
    $shipping_methods = $order->get_shipping_methods();

    foreach ($shipping_methods as $method) {
        // ดึงชื่อ Label ที่ลูกค้าเลือก (เช่น ไปรษณีย์ไทย (EMS))
        $method_name = $method->get_name();

        // 2. เขียนข้อความลงใน Order Note (หลังบ้านจะเห็นเป็นแถบสีม่วง/เทา)
        $note = "ประเภทการขนส่งที่ลูกค้าเลือก: " . $method_name;
        $order->add_order_note($note);
    }
}