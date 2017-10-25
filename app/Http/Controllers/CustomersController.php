<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Customers;
use App\Teams;
use App\CustomersComments;
use App\Users;

class CustomersController extends Controller
{
    public function get($post = [])
    {
        $team = Teams::find(session('current_team'));
        $customer = ! empty($post['customer_id']) ? $team->customers()->wherePivot('customer_id', $post['customer_id'])->first() : [];
        if ( ! empty($customer))
        {
            $customer->users_ids = $customer->users()->get()->pluck('users_id')->toArray();
        }

        return $customer;
    }

    public function getList()
    {
        $team = Teams::find(session('current_team'));
        return $team->customers()->get();
    }

	public function save($post = [])
	{
        /*if (! empty($post['users_ids']))
        {
            $users = Users::whereIn('users_id', $post['users_ids'])->get();
            $ids = [];

            foreach ($users as $user) {
                $ids[] = $user->customers()->get()->pluck('customer_id')->toArray();
            }
        }*/
        $allow_duplicate = ! empty($post['allow_duplicate']) ? true : false;

        $duplicates =
        Customers::where('company_name', 'like', '%' . $post['company_name'] . '%')
            ->orWhere('contact_person', 'like', '%' . $post['contact_person'] . '%')
            ->orWhere('phone_number', 'like', '%' . $post['phone_number'] . '%')
            ->orWhere('extra_phone_number', 'like', '%' . $post['extra_phone_number'] . '%')
            ->orWhere('email', 'like', '%' . $post['email'] . '%')
            ->orWhere('extra_email', 'like', '%' . $post['extra_email'] . '%')
            ->orWhere('nip', 'like', '%' . $post['nip'] . '%')
            ->orWhere('bank_account', 'like', '%' . $post['bank_account'] . '%')
            ->orWhere('website', 'like', '%' . $post['website'] . '%')
            ->orWhere('fb_link', 'like', '%' . $post['fb_link'] . '%')
            ->get();
            //dd($post);
        if ($allow_duplicate)
        {
            $duplicates = false;
        }

        if ($duplicates)
        {
            $this->message(__('Wykryto duplikat'), 'error');
            $duplicates->put('duplicate', 1);
            return $duplicates;
        }
        else
        {
            $customer = Customers::firstOrNew(['customer_id' => empty($post['customer_id']) ? 0 : $post['customer_id']]);

            $customer->company_name = $post['company_name'];
            $customer->contact_person = empty($post['contact_person']) ? '' : $post['contact_person'];
            $customer->customer_type = empty($post['customer_type']) ? 0 : $post['customer_type'];
            $customer->phone_number = empty($post['phone_number']) ? 0 : $post['phone_number'];
            $customer->extra_phone_number = empty($post['extra_phone_number']) ? 0 : $post['extra_phone_number'];
            $customer->bank_account = empty($post['bank_account']) ? 0 : $post['bank_account'];
            $customer->nip = empty($post['nip']) ? '' : $post['nip'];
            $customer->email = empty($post['email']) ? '' : $post['email'];
            $customer->extra_email = empty($post['extra_email']) ? '' : $post['extra_email'];
            $customer->website = empty($post['website']) ? '' : $post['website'];
            $customer->fb_link =empty($post['fb_link']) ? '' : $post['fb_link'];
            $customer->invoice_street = empty($post['invoice_street']) ? '' : $post['invoice_street'];
            $customer->invoice_mailbox = empty($post['invoice_mailbox']) ? '' : $post['invoice_mailbox'];
            $customer->invoice_town = empty($post['invoice_town']) ? '' : $post['invoice_town'];
            $customer->invoice_province = empty($post['invoice_province']) ? '' : $post['invoice_province'];
            $customer->invoice_post_code = empty($post['invoice_post_code']) ? '' : $post['invoice_post_code'];
            $customer->invoice_region = empty($post['invoice_region']) ? '' : $post['invoice_region'];
            $customer->send_street = empty($post['send_street']) ? '' : $post['send_street'];
            $customer->send_mailbox = empty($post['send_mailbox']) ? '' : $post['send_mailbox'];
            $customer->send_town = empty($post['send_town']) ? '' : $post['send_town'];
            $customer->send_province = empty($post['send_province']) ? '' : $post['send_province'];
            $customer->send_post_code = empty($post['send_post_code']) ? '' : $post['send_post_code'];
            $customer->send_region = empty($post['send_region']) ? '' : $post['send_region'];
            $customer->description = empty($post['description']) ? '' : $post['description'];

            $customer->save();
            $customer->users()->sync($post['users_ids']);
            $customer->teams()->syncWithoutDetaching(session('current_team'));

            $this->message(__('Customer was successfully saved'), 'success');
            return $customer->customer_id;
        }
	}

    public function delete($post = [])
    {
        $customer = Customers::find($post['customer_id']);
        $customer->teams()->detach(session('current_team'));
        $customer->delete();

        $this->message(__('Record was successfully deleted'), 'success');
    }

    public function addComment($post = [])
    {
        $user_id = Auth::user()->users_id;
        $author = Auth::user()->users_first_name . ' ' . Auth::user()->users_last_name;
        $customers_comments = new CustomersComments();

        $customers_comments->customer_id = $post['customer_id'];
        $customers_comments->teams_id = session('current_team');
        $customers_comments->users_id = $user_id;
        $customers_comments->author = $author;
        $customers_comments->comment_text = $post['comment_text'];

        $customers_comments->save();
    }

    public function getComment($post = [])
    {
        $customers_comments = CustomersComments::where([['customer_id', '=', $post['customer_id']], ['teams_id', '=', session('current_team')]])->get();

        return $customers_comments;
    }
}