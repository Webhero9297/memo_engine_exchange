<?php

namespace App\Http\Controllers\Services;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Memo;
use App\Models\Account;

class CoreProcessorController extends Controller
{
    //
    public function getAccount(Request $request) {
        $uid   = $request->get('uid', null);
        $email = $request->get('email', null);

        if ( is_null($uid) || is_null($email) ) {
            return response()->json(Common::response(["Invalid param"], false, "Invalid param"));
        }
        else {
            try{
                $records = app(Account::class)->where('uid', $uid)->first();
                if ( count($records)>0 ) {
                    return response()->json(Common::response("user already exists", false));
                }
                $records = app(Account::class)->where('email', $email)->first();
                if ( count($records)>0 ) {
                    return response()->json(Common::response("email already exists", false));
                }
                else{
                    $record = new Account();
                    $record->uid      = $uid;
                    $record->email    = $email;
                    $record->currency = 'eos';
                    $record->memo     = Memo::generateNewMemoCode('accounts', 'memo');
                    $record->save();
                    return response()->json(Common::response(['memo'=>$record->memo, 'address'=>'address'], true, 'success'));
                }
            }
            catch( Exception $e ) {
                return response()->json(Common::response([], false, $e->getMessage()));
            }
        }
    }
    public function getAddress($uid) {
        if ( strval($uid) !== strval(intval($uid)) || intval($uid) < 0 ) {
            return response()->json(Common::response(["INVALID PARAMETERS"], false, "UID is not an int"));
        }
        $records = app(Account::class)->where('uid', $uid)->first();
        if ( !$records ) {
            return response()->json(Common::response(" INVALID UID", false, "UID Doesn’t exist in database"));
        }
        return response()->json(Common::response($records->toArray(), true, 'success'));
    }
    public function getBalance($uid) {
        if ( strval($uid) !== strval(intval($uid)) || intval($uid) < 0 ) {
            return response()->json(Common::response(["INVALID PARAMETERS"], false, "UID is not an int"));
        }
        $records = app(Account::class)->where('uid', $uid)->first();
        if ( !$records ) {
            return response()->json(Common::response(" INVALID UID", false, "UID Doesn’t exist in database"));
        }
        return response()->json(Common::response(['balance'=>$records->balance], true, 'success'));
    }
    public function getBankRoll() {
        try{
            $sysBalance  = Common::getSumEosWallet();
            $userBalance = Common::getSumEosWalletOfUsers();
            $diff = $sysBalance - $userBalance;
            return response()->json(Common::response(['balance'=>$diff], true, 'success'));
        }
        catch(Exception $e) {
            return response()->json(Common::response(['Exception'], true, $e->getMessage()));
        }
        
    }
}

