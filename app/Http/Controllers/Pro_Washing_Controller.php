<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class Pro_Washing_Controller extends BaseController
{

    private function AutuIDWashing()
    {
        $oid = DB::select(
            'SELECT CONCAT("WAS-",LPAD(SUBSTRING(IFNULL(MAX(washing.Order_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM washing'
        );
        return $oid[0]->auto_id;
    }

    public function OnProcess_GetWashing_machine(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('machineswashing')
                ->select('machineswashing.*')
                ->get();

            $return_data->machineswashing = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function OnProcess_GetWashing_List(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('washing')
                ->select('*')
                ->where('Order_id', $data['OrderId'])
                ->get();

            $return_data->washing_List = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function OnProcess_Washing_newItem(Request $request)
    {

        $return_data = new \stdClass();

        try {

            $data = $request->all();
            $dateNow = Carbon::now();

            foreach ($data['WashingItem'] as $item) {

                $washing_id = $item['washing_id'];

                if($washing_id == 'null' || $washing_id == null || $washing_id == ''){
                    $washing_id = $this->AutuIDWashing();
                }
                // dd($item['washing_id']);

                DB::table('washing')
                    ->updateOrInsert(
                        [
                            'Order_id' => $data['OrderId'],
                            'item_id' => $item['item_id'],
                            'washing_id' => $washing_id,
                            'MachinesWashing_id' => $item['Machines_id'],
                            'Cycle' => null,
                            'QTY' => $item['QTY'],
                            'PassStatus' => $item['check'],
                            'Create_at' => $dateNow,
                        ],
                        ['washing_id' => $washing_id]
                    );
            }
        } catch (Exception $e) {

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }
}
