<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;
use App\Models\Account;

class Common
{
    //
    public static function response( $output, $status=true, $message='', $format='json' ) {
        $response = [
                        'status'  => $status ? 200 : 400,
                        'message' => $status ? $message : (is_array($output) ? implode("\n", $output) : $output)
                    ];

		if ( !$status )
		{
			$response['error_code'] = $status ? 200 : 400;
			$response['message']    = is_array($output) ? implode("\n", $output) : $output;
		}
		else
		{
            $response['data']       = $output;
		}

	    return $response;
    }
    public static function getSumEosWallet() {
        $wallet_model = new Wallet();
        $balance = \DB::table( $wallet_model->getTableName() )
                    ->sum('balance');
        return $balance;
    }
    public static function getSumEosWalletOfUsers() {
        $account_model = new Account();
        $balance = \DB::table( $account_model->getTableName() )
                    ->sum('balance');
        return $balance;
    }
}
