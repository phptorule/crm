<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Customers;
use App\Teams;
use App\CustomersComments;

class CustomersController extends Controller
{
    public function get($post = [])
    {
        $team_id = empty($post['teams_id']) ? $post : $post['teams_id'];
        $customer_id = empty($post['customer_id']) ? 0 : $post['customer_id'];
        $team = Teams::find($team_id);

        if ($customer_id)
        {
            $customers = $team->customers()->wherePivot('customer_id', $customer_id)->get();
        }
        else
        {
            $customers = $team->customers()->get();
        }

        return $customers;
    }

	public function save($post = [])
	{
		$customer = Customers::firstOrNew(['customer_id' => empty($post['customer_id']) ? 0 : $post['customer_id']]);

    	$customer->company_name = $post['company_name'];
        $customer->contact_person = empty($post['contact_person']) ? '' : $post['contact_person'];
        $customer->customer_type = empty($post['customer_type']) ? 0 : $post['customer_type'];
        $customer->assign_to = empty($post['assign_to']) ? '' : $post['assign_to'];
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
        $customer->teams()->syncWithoutDetaching([$post['teams_id']]);

        $this->message(__('Customer was successfully saved'), 'success');
        return $customer->customer_id;
	}

    public function delete($post = [])
    {
        $customer = Customers::find($post['customer_id']);
        $customer->teams()->detach($post['teams_id']);
        $customer->delete();

        $this->message(__('Record was successfully deleted'), 'success');
        return $this->get($post['teams_id']);
    }

    public function addComment($post = [])
    {
        $user_id = Auth::user()->users_id;
        $author = Auth::user()->users_first_name . ' ' . Auth::user()->users_last_name;
        $customers_comments = new CustomersComments();

        $customers_comments->customer_id = $post['customer_id'];
        $customers_comments->teams_id = $post['teams_id'];
        $customers_comments->users_id = $user_id;
        $customers_comments->author = $author;
        $customers_comments->comment_text = $post['comment_text'];

        $customers_comments->save();
    }

    public function getComment($post = [])
    {
        $customers_comments = CustomersComments::where([['customer_id', '=', $post['customer_id']], ['teams_id', '=', $post['teams_id']]])->get();

        return $customers_comments;
    }
}