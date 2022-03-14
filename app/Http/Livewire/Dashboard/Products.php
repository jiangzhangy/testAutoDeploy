<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Products extends Component
{
    public function render()
    {
        return view('livewire.dashboard.products');
    }

    public function getProductInfo($id)
    {
       $data = [
           1 => [
               'icon' => '图片地址',
               'name' => '傲梅轻松备份',
               'subscribe' => 'VIP 终身版',
               'orderNo' => '1115555226',
               'orderCreateDate' => '2022-4-21',
               'devicesNum' => 5,
               'expiryData' => '终身'
           ],
           2 => [
               'name' => 'name2',
           ],
       ];

       return json_encode($data[$id]);
    }
}
