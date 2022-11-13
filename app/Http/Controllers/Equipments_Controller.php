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

    public function getEquipmentsDetail(Request $request)
    {

        $return_data = new \stdClass();
        $data = $request->all();

        $equipment = DB::table('equipments')
            ->select('equipments.*')
            ->where('equipment_id', $data['equipment_id'])
            ->first();
        
        $return_data->equipment = $equipment;
        return $return_data;
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
        $_equipment_sud = $recv['equipment_sud'];
        $_equipment_limit = $recv['equipment_limit'];

        DB::table('equipments')->insert([
            'Equipment_id' => $this->getAutoEquipmentsID(),
            'Name' => $_equipment_name,
            'Price' => $_equipment_price,
            'Process' => $_equipment_process,
            'Expire' => $_equipment_expire,
            'Descriptions' => $_equipment_descriptions,
            'Item_Type' => $_equipment_item_type,
            'Activate' => 'A',
            'SUD' => $_equipment_sud,
            'SUD_Limit' => $_equipment_limit,
        ]);
        return json_encode(TRUE);
    }

    public function deleteEquipments(Request $request)
    {
        $recv = $request->all();
        $_equipment_id = $recv['equipment_id'];
        DB::table('equipments')
            ->where('Equipment_id', $_equipment_id)
            ->delete();
        return json_encode(TRUE);
    }

    public function activateEquipments(Request $request)
    {
        $recv = $request->all();
        $_equipment_id = $recv['equipment_id'];
        $_equipment_activate = $recv['equipment_activate'];
        DB::table('equipments')
            ->where('Equipment_id', $_equipment_id)
            ->update([
                'Activate' => $_equipment_activate,
            ]);
        return json_encode(TRUE);
    }

    public function updateEquipments(Request $request)
    {
        $recv = $request->all();
        $_equipment_id = $recv['equipment_id'];
        $_equipment_name = $recv['equipment_name'];
        $_equipment_price = $recv['equipment_price'];
        $_equipment_expire = $recv['equipment_expire'];
        $_equipment_process = $recv['equipment_process'];
        $_equipment_item_type = $recv['equipment_item_type'];
        $_equipment_descriptions = $recv['equipment_descriptions'];
        $_equipment_sud = $recv['equipment_sud'];
        $_equipment_limit = $recv['equipment_limit'];

        DB::table('equipments')
            ->where('Equipment_id', $_equipment_id)
            ->update([
                'Name' => $_equipment_name,
                'Price' => $_equipment_price,
                'Process' => $_equipment_process,
                'Expire' => $_equipment_expire,
                'Descriptions' => $_equipment_descriptions,
                'Item_Type' => $_equipment_item_type,
                'SUD' => $_equipment_sud,
                'SUD_Limit' => $_equipment_limit
            ]);
        return json_encode(TRUE);
    }

    private function AutoIDImage()
    {
        $itm = DB::select(
            'SELECT CONCAT("IMG_EQP-",LPAD(SUBSTRING(IFNULL(MAX(equipmentsimages.Image_id), "0"), 9,6)+1, 6,"0")) as auto_id FROM equipmentsimages'
        );
        return $itm[0]->auto_id;
    }

    public function imagesUploadEquipment(Request $request)
    {
        $recv = $request->all();
        // $imageName = $image_id . '.' . $data['files']->getClientOriginalExtension();
        $images = $request->file('file');
        $equipment_id = $recv['equipment_id'];

        foreach ($images as $image) {
            $image_id = $this->AutoIDImage();
            $imageName = $image_id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/image/equipments'), $imageName);
            DB::table('equipmentsimages')->insert([
                'Image_id' => $image_id,
                'Equipment_id' => $equipment_id,
                'Image_path' => $imageName,
            ]);
        }
        return json_encode(TRUE);
    }

    public function getEquipImages(Request $request)
    {
        $recv = $request->all();
        $equipment_id = $recv['equipment_id'];
        $images = DB::table('equipmentsimages')
            ->select('equipmentsimages.*')
            ->where('Equipment_id', $equipment_id)
            ->get();
        return $images;
    }

    public function deleteImageEquipment(Request $request)
    {
        $recv = $request->all();
        $image_id = $recv['image_id'];
        $equipment_id = $recv['equipment_id'];
        $image_path = $recv['image_path'];
        $path = public_path('assets/image/equipments/' . $image_path);
        if (file_exists($path)) {
            unlink($path);
        }
        DB::table('equipmentsimages')
            ->where('Image_id', $image_id)
            ->where('Equipment_id', $equipment_id)
            ->delete();
        return json_encode(TRUE);
    }
}