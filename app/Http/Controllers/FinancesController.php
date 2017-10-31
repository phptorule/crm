<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Finances;
use App\Balance;
use App\Services\CoursesService;
use Illuminate\Http\Request;
use App\Products;
use App\Teams;

class FinancesController extends Controller
{
    public function save($post = [])
    {
        $issue_date = date('Y-m-d', strtotime($post['issue_date']));
        $payment_date = date('Y-m-d', strtotime($post['payment_date']));

       // print_r($issue_date);


        $finances = Finances::firstOrNew(['finances_id' => empty($post['finances_id']) ? 0 : $post['finances_id']]);

        $finances->finances_customer_name = $post['company_name'];
        $finances->finances_payment_method = $post['pay_type'];
        $finances->finances_paid = $post['invoice_paid'];
        $finances->finances_issue_date = $issue_date;
        $finances->finances_payment_date = $payment_date;
        $finances->finances_assign_to = $post['contact_person'];
        $finances->finances_invoice_street = empty($post['invoice_street']) ? '' : $post['invoice_street'];
        $finances->finances_invoice_mailbox = empty($post['invoice_mailbox']) ? '' : $post['invoice_mailbox'];
        $finances->finances_invoice_town = empty($post['invoice_town']) ? '' : $post['invoice_town'];
        $finances->finances_invoice_province = empty($post['invoice_province']) ? '' : $post['invoice_province'];
        $finances->finances_invoice_post_code = empty($post['invoice_post_code']) ? '' : $post['invoice_post_code'];
        $finances->finances_invoice_region = empty($post['invoice_region']) ? '' : $post['invoice_region'];
        $finances->finances_send_street = empty($post['send_street']) ? '' : $post['send_street'];
        $finances->finances_send_mailbox = empty($post['send_mailbox']) ? '' : $post['send_mailbox'];
        $finances->finances_send_town = empty($post['send_town']) ? '' : $post['send_town'];
        $finances->finances_send_province = empty($post['send_province']) ? '' : $post['send_province'];
        $finances->finances_send_post_code = empty($post['send_post_code']) ? '' : $post['send_post_code'];
        $finances->finances_send_region = empty($post['send_region']) ? '' : $post['send_region'];

        $finances->save();
        $finances->products()->syncWithoutDetaching($post['products_ids']);
        $this->message(__('Faktura was successfully saved'), 'success');

        return $finances->finances_id;
    }

    public function saveProduct($post = [])
    {
        //dd($post);
        $product = Products::firstOrNew(['products_id' => empty($post['products_id']) ? 0 : $post['products_id']]);

        $product->products_type = $post['products_type'];
        $product->products_name = $post['products_name'];
        $product->products_amount = $post['products_amount'];
        $product->products_dimension = $post['products_dimension'];
        $product->products_cost = $post['products_cost'];
        $product->products_vat_percent = $post['products_vat_percent'];
        $product->products_vat_amount = $post['products_vat_amount'];
        $product->products_total_cost = $post['products_total_cost'];

        $product->save();
        $this->message(__('Product was successfully saved'), 'success');

        return $product->products_id;
    }
}
