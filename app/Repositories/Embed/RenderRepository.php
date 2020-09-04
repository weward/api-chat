<?php namespace App\Repositories\Embed;

use DB;
use App\Models\ChatApp;

class RenderRepository 
{

    /**
     * Get App Settings
     *  Nuxt connects here to get app settins 
     *  for validated hash
     */
    public function embedAppSettings($req)
    {
        // validate hash
        if (sha1($req->id) != $req->hash) {
            return [
                'response' => false,
                'message' => 'Failed validation'
            ];
        }

        $app = ChatApp::find($req->id);
            // load chat bot settings if has

        return [
            'response' => true,
            'app_settings' => $app,
        ];
    }

}