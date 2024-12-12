<?php

namespace App\Http\Controllers;

abstract class Controller
{

    public function productStatus($products)
    {
        $statusMsg = '';
        if ($products->status == 1) {
            $statusMsg = 'pending';
        } elseif ($products->status == 2) {
            $statusMsg = 'approved';
        } else {
            $statusMsg = 'rejected';
        }
        return $statusMsg;
    }
    //
}
