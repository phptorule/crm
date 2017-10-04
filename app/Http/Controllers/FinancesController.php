<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Finances;
use App\Balance;
use App\Services\CoursesService;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    public function get($post = [])
    {
    	$query = Finances::where('teams_id', $post['teams_id']);
        if ($post['type'] <= 0)
        {
            $query = $query->whereYear('finances_date', $post['year']);
        }

        if ($post['type'] == 0)
        {
            $query = $query->whereMonth('finances_date', $post['month'] + 1);
        }

        if ($post['type'] == 2)
        {
            $query = $query->whereDate('finances_date', '>=', $post['from'])->whereDate('finances_date', '<', $post['to']);
        }

        if ( ! empty($post['payer']))
        {
            $query = $query->where('finances_payer', $post['payer']);
        }
        return $query->get();
    }

    public function getPayers($post = [])
    {
    	$finances = Finances::where('teams_id', $post['teams_id'])->get();
        $payers = [];
        foreach ($finances as $finance)
        {
            $payers[] = $finance->finances_payer;
        }
        $payers = array_unique($payers);
        sort($payers);
        return $payers;
    }

    public function getDescs($post = [])
    {
        $finances = Finances::where('teams_id', $post['teams_id'])->get();
        $descs = [];
        foreach ($finances as $finance)
        {
            if ( ! isset($descs[$finance->finances_desc]))
            {
                $descs[$finance->finances_desc] = 0;
            }
            $descs[$finance->finances_desc]++;
        }
        arsort($descs);
        $result = [];
        foreach ($descs as $key => $count)
        {
            if ($count > 2)
            {
                $result[] = $key;
            }
        }
        return $result;
    }

    public function getCurrency($post = [])
    {
    	return Currency::all();
    }

    public function save($post = [])
    {
        $finance = Finances::firstOrNew(['finances_id' => empty($post['finances_id']) ? 0 : $post['finances_id']]);
        $finance->teams_id = $post['teams_id'];

        $course = FALSE;
        if ( ! empty($finance->finances_id))
        {
            $this->recountBalance($finance->teams_id, $finance->finances_amount_uah, (1 - $finance->finances_type));

            $course = $finance->finances_course;
            if ($finance->currency_id != $post['currency_id'])
            {
                $course = FALSE;
            }
        }

        $finance->currency_id = $post['currency_id'];
        $finance->finances_amount = $post['finances_amount'];
        $finance->finances_amount_uah = CoursesService::convert($post['finances_amount'], $post['currency_id'], $course);
        $finance->finances_course = CoursesService::getCourse($course);
        $finance->finances_type = $post['finances_type'];
        $finance->finances_payer = $post['finances_payer'];
        $finance->finances_desc = $post['finances_desc'];
        $finance->finances_date = date('Y-m-d H:i:s', strtotime($post['finances_date']));
        $finance->save();

        $this->recountBalance($finance->teams_id, $finance->finances_amount_uah, $finance->finances_type);

        return $this->message(__('Record was successfully saved'), 'success');
    }

    public function remove($post = [])
    {
        $finance = Finances::find($post['finances_id']);
        $this->recountBalance($finance->teams_id, $finance->finances_amount_uah, (1 - $finance->finances_type));
        $teams_id = $finance->teams_id;
        $finance->delete();

        return $this->message(__('Record was successfully removed'), 'success');
    }

    public function recountBalance($teams_id, $amount, $operation)
    {
        $balance = Balance::firstOrNew(['teams_id' => $teams_id]);
        $balance->teams_id = $teams_id;
        $balance->balance_amount = empty($balance->balance_amount) ? 0 : $balance->balance_amount;
        if (empty($operation))
        {
            $balance->balance_amount -= $amount;
        }
        else
        {
            $balance->balance_amount += $amount;
        }
        $balance->save();

        return $balance->balance_amount;
    }

    public function getBalance($post = [])
    {
        $balance = Balance::where(['teams_id' => $post['teams_id']])->first();
        return ! empty($balance->balance_amount) ? $balance->balance_amount : 0;
    }
}
