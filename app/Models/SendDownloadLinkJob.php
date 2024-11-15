<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendDownloadLinkJob extends Model
{
    //
    protected $table = "send_download_link_jobs";

    protected $fillable = [
        'email', 'file_path', 'status', 'date_process', 'send_type', 'email_template'
    ];
}
