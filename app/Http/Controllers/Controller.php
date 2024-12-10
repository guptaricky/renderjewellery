<?php

namespace App\Http\Controllers;

abstract class Controller
{

    public function productStatus($products)
    {
        $statusMsg = '';
        if ($products->status == 1) {
            $statusMsg = 'approved';
        } elseif ($products->status == 2) {
            $statusMsg = 'pending';
        } else {
            $statusMsg = 'rejected';
        }
        return $statusMsg;
    }
    //
}
