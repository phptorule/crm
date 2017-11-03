<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Finances;
use App\Balance;
use App\Services\CoursesService;
use Illuminate\Http\Request;
use App\Products;
use App\Teams;
use App\Users;

class FinancesController extends Controller
{
    public function getFinancesNumber()
    {
        $finances_last = Finances::orderBy('updated_at', 'desc')->first();
        $current_year = date('Y', time());
        if ( ! empty($finances_last))
        {
            $finances_number = ($finances_last->finances_id + 1) . '/' . $current_year;
        }
        else
        {
            $finances_number = '1/' . $current_year;
        }

        return $finances_number;
    }

    public function getList()
    {
        $team = Teams::find(session('current_team'));
        $finances = $team->finances()->get();

        foreach ($finances as $finance)
        {
            $finance->products_names = $finance->products()->pluck('products_name')->toArray();
            $users_first_name = Users::where('users_id', $finance['finances_assign_to'])->select('users_first_name')->get();
            $users_last_name = Users::where('users_id', $finance['finances_assign_to'])->select('users_last_name')->get();
            $finance->users_names = $users_first_name . ' ' . $users_last_name;
        }

        //dd($finances->users_names);

        return $finances;
    }

    public function save($post = [])
    {
        //dd($post);
        $issue_date = date('Y-m-d', strtotime($post['issue_date']));
        $payment_date = date('Y-m-d', strtotime($post['payment_date']));

        $finances = Finances::firstOrNew(['finances_id' => empty($post['finances_id']) ? 0 : $post['finances_id']]);

        $finances->finances_customer_name = $post['company_name'];
        $finances->finances_number = $post['finances_number'];
        $finances->finances_payment_method = $post['pay_type'];
        $finances->finances_paid = $post['invoice_paid'];
        $finances->finances_total_amount = $post['total_amount'];
        $finances->finances_issue_date = $issue_date;
        $finances->finances_payment_date = $payment_date;
        $finances->finances_assign_to = $post['assign_to'];
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
        $finances->products()->sync($post['products_ids']);
        $finances->teams()->syncWithoutDetaching(session('current_team'));
        $this->message(__('Faktura was successfully saved'), 'success');

        return $finances->finances_id;
    }

    public function saveProduct($post = [])
    {
        foreach ($post as $item)
        {
            $product_dimension = empty($item['products_dimension']) ? '' : $item['products_dimension'];

            $product = Products::firstOrNew(['products_id' => empty($item['products_id']) ? 0 : $item['products_id']]);
            $product->products_type = $item['products_type'];
            $product->products_name = $item['products_name'];
            $product->products_amount = $item['products_amount'];
            $product->products_dimension = $product_dimension;
            $product->products_cost = $item['products_cost'];
            $product->products_vat_percent = $item['products_vat_percent'];
            $product->products_vat_amount = $item['products_vat_amount'];
            $product->products_total_cost = $item['products_total_cost'];
            $product->save();

            $products_ids[] = $product->products_id;
        }

        return $products_ids;
    }
}
