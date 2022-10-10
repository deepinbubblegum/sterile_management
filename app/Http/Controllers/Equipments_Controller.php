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

class Equipments_Controller extends BaseController
{
    public function getListEquipments(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();

            $equipments = DB::table('equipments')
                ->select('equipments.*')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('equipments.Name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('equipment_id', 'desc')
                ->paginate(8);
            
            $return_data->equipments = $equipments;
            return $return_data;
        } catch (Exception $e) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function getEquipment(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();

            $equipment = DB::table('equipments')
                ->select('equipments.*')
                ->where('equipment_id', $data['equipment_id'])
                ->first();
            
            $return_data->equipment = $equipment;
            return $return_data;
        } catch (Exception $e) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    private function getAutoEquipmentsID()
    {
        $itm = DB::select(
            'SELECT CONCAT("EMP-",LPAD(SUBSTRING(IFNULL(MAX(equipments.Equipment_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM equipments'
        );
        return $itm[0]->auto_id;
    }

    public function createEquipments(Request $request)
    {
        $recv = $request->all();
        $_equipment_name = $recv['equipment_name'];
        $_equipment_price = $recv['equipment_price'];
        $_equipment_expire = $recv['equipment_expire'];
        $_equipment_process = $recv['equipment_process'];
        $_equipment_item_type = $recv['equipment_item_type'];
        $_equipment_descriptions = $recv['equipment_descriptions'];

        DB::table('equipments')->insert([
            'Equipment_id' => $this->getAutoEquipmentsID(),
            'Name' => $_equipment_name,
            'Price' => $_equipment_price,
            'Process' => $_equipment_process,
            'Expire' => $_equipment_expire,
            'Descriptions' => $_equipment_descriptions,
            'Item_Type' => $_equipment_item_type,
            'Activate' => 'A',
        ]);
        return json_encode(TRUE);
    }

    
}
