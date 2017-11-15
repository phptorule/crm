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
use App\FinancesRegistered;

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

    public function get($post = [])
    {
        $team = Teams::find(session('current_team'));
        $finances = ! empty($post['finances_id']) ? $team->finances(function($r) { $r->with('users', 'products'); })->wherePivot('finances_id', $post['finances_id'])->first() : [];

        $finances->users;
        $finances->products;

        return $finances;
    }

    public function getRegisteredFinance($post = [])
    {
        $registered_finance = FinancesRegistered::where([['teams_id', '=', session('current_team')], ['registered_id', '=', $post['registered_id']]])->first();

        return $registered_finance;
    }

    public function getList()
    {
        $team = Teams::find(session('current_team'));
        $finances = $team->finances(function($r) { $r->with('users', 'products'); })->get();
        foreach ($finances as $finance)
        {
            $finance->users;
            $finance->products;
        }

        return $finances;
    }

    public function getRegisteredList()
    {
        $registered = FinancesRegistered::where('teams_id', session('current_team'))->get();

        return $registered;
    }

    public function save($post = [])
    {
        //dd($post);
        $issue_date = date('Y-m-d', strtotime($post['finances_issue_date']));
        $payment_date = date('Y-m-d', strtotime($post['finances_payment_date']));

        $finances = Finances::firstOrNew(['finances_id' => empty($post['finances_id']) ? 0 : $post['finances_id']]);

        $finances->finances_customer_name = $post['finances_customer_name'];
        $finances->finances_number = $post['finances_number'];
        $finances->finances_payment_method = $post['finances_payment_method'];
        $finances->finances_paid = $post['finances_paid'];
        $finances->finances_total_amount = $post['finances_total_amount'];
        $finances->finances_issue_date = $issue_date;
        $finances->finances_payment_date = $payment_date;
        $finances->finances_assign_to = $post['finances_assign_to'];
        $finances->finances_invoice_street = empty($post['finances_invoice_street']) ? '' : $post['finances_invoice_street'];
        $finances->finances_invoice_town = empty($post['finances_invoice_town']) ? '' : $post['finances_invoice_town'];
        $finances->finances_invoice_province = empty($post['finances_invoice_province']) ? '' : $post['finances_invoice_province'];
        $finances->finances_invoice_post_code = empty($post['finances_invoice_post_code']) ? '' : $post['finances_invoice_post_code'];
        $finances->finances_invoice_region = empty($post['finances_invoice_region']) ? '' : $post['finances_invoice_region'];
        $finances->finances_send_street = empty($post['finances_send_street']) ? '' : $post['finances_send_street'];
        $finances->finances_send_town = empty($post['finances_send_town']) ? '' : $post['finances_send_town'];
        $finances->finances_send_province = empty($post['finances_send_province']) ? '' : $post['finances_send_province'];
        $finances->finances_send_post_code = empty($post['finances_send_post_code']) ? '' : $post['finances_send_post_code'];
        $finances->finances_send_region = empty($post['finances_send_region']) ? '' : $post['finances_send_region'];

        $finances->save();
        $finances->products()->sync($post['products_ids']);
        $finances->teams()->syncWithoutDetaching(session('current_team'));
        $this->message(__('Faktura was successfully saved'), 'success');

        return $finances->finances_id;
    }

    public function saveProduct($post = [])
    {
        //dd($post);
        foreach ($post as $item)
        {
            $product_dimension = empty($item['products_dimension']) ? '' : $item['products_dimension'];
            $products_discount_percent = empty($item['products_discount_percent']) ? 0 : $item['products_discount_percent'];
            $products_discount_regular = empty($item['products_discount_regular']) ? 0 : $item['products_discount_regular'];
            $products_vat_shipping_percent = empty($item['products_vat_shipping_percent']) ? 0 : $item['products_vat_shipping_percent'];
            $products_shipping_price = empty($item['products_shipping_price']) ? 0 : $item['products_shipping_price'];

            $product = Products::firstOrNew(['products_id' => empty($item['products_id']) ? 0 : $item['products_id']]);
            $product->products_type = $item['products_type'];
            $product->products_name = $item['products_name'];
            $product->products_amount = $item['products_amount'];
            $product->products_dimension = $product_dimension;
            $product->products_cost = $item['products_cost'];
            $product->products_vat_percent = $item['products_vat_percent'];
            $product->products_vat_amount = $item['products_vat_amount'];
            $product->products_total_cost = $item['products_total_cost'];
            $product->products_discount_percent = $item['products_discount_percent'];
            $product->products_discount_regular = $item['products_discount_regular'];
            $product->products_vat_shipping_percent = $item['products_vat_shipping_percent'];
            $product->products_shipping_price = $item['products_shipping_price'];
            $product->save();

            $products_ids[] = $product->products_id;
        }

        return $products_ids;
    }

    public function registerFinance($post = [])
    {
        //dd($post);
        $issue_date = date('Y-m-d', strtotime($post['registered_issue_date']));
        $payment_date = date('Y-m-d', strtotime($post['registered_payment_date']));

        $register = FinancesRegistered::firstOrNew(['registered_id' => empty($post['registered_id']) ? 0 : $post['registered_id']]);

        $register->teams_id = session('current_team');
        $register->registered_finances_number = empty($post['registered_finances_number']) ? '' : $post['registered_finances_number'];
        $register->registered_customer_name = empty($post['registered_customer_name']) ? '' : $post['registered_customer_name'];
        $register->registered_subject = empty($post['registered_subject']) ? '' : $post['registered_subject'];
        $register->registered_finances_netto = empty($post['registered_finances_netto']) ? '' : $post['registered_finances_netto'];
        $register->registered_finances_brutto = empty($post['registered_finances_brutto']) ? '' : $post['registered_finances_brutto'];
        $register->registered_payment_method = empty($post['registered_payment_method']) ? '' : $post['registered_payment_method'];
        $register->registered_paid = empty($post['registered_paid']) ? '' : $post['registered_paid'];
        $register->registered_payment_date = $payment_date;
        $register->registered_assign_to = $post['registered_assign_to'];
        $register->registered_bank_account = empty($post['registered_bank_account']) ? '' : $post['registered_bank_account'];
        $register->registered_order_title = empty($post['registered_order_title']) ? '' : $post['registered_order_title'];
        $register->registered_bank_nip = empty($post['registered_bank_nip']) ? '' : $post['registered_bank_nip'];
        $register->registered_bank_name = empty($post['registered_bank_name']) ? '' : $post['registered_bank_name'];
        $register->registered_bank_street = empty($post['registered_bank_street']) ? '' : $post['registered_bank_street'];
        $register->registered_bank_town = empty($post['registered_bank_town']) ? '' : $post['registered_bank_town'];
        $register->registered_bank_postcode = empty($post['registered_bank_postcode']) ? '' : $post['registered_bank_postcode'];
        $register->registered_bank_region = empty($post['registered_bank_region']) ? '' : $post['registered_bank_region'];
        $register->registered_description = empty($post['registered_description']) ? '' : $post['registered_description'];

        $register->save();
        $this->message(__('Faktura was successfully registered'), 'success');
        dd($register);
        return $register->registered_id;
    }
}
