<?php namespace App\Repositories\Admin;

use DB;
use App\User;
use App\Jobs\SendForgotPasswordEmail;

class ForgotPasswordRepository 
{

    /**
     * Send User An Email Upon Request
     * 
     * @param  object $req 
     * @return boolean
     */
    public function handle($req)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $req->email)->first();
            if (!$user) {
                return false;
            }
    
            $rand = sha1(rand(100000000000, 999999999999));
    
            DB::table('reset_passwords')->insert([
                'user_id' => $user->id,
                'hash' => $rand,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ]);

            // Send Email
            $data = [
                'email' => $user->email,
                'url' => route('reset-password', ['id' => $user->id, 'hash' => $rand])
            ];
    
            SendForgotPasswordEmail::dispatch($data);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            
            return false;
        }
    }

    /**
     * Verify Link From Email And Redirect To Frontend
     * 
     * @param  int $id User ID
     * @param string $hash Random Hash
     * @return boolean
     */
    public function resetLink($id, $hash)
    {
        $data = DB::table('reset_passwords')
                ->where('user_id', $id)
                ->where('hash', $hash)
                ->where('flag', 0)
                ->first();
        
        return !is_null($data);
    }

}