<?php

namespace App\Models;

use App\Notifications\Mentioned;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function noteof()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {   
        //TODO: in progress
        //send out a notification when saving
        static::saving(function($note)
        {
            //get all unique words from message
            $words = array_unique(explode(' ', trim($note->note)));
            
            //if (in_array("@all", $words))
            foreach($words as $word)
            {
                $word = strtolower($word);

                //send notification to everyone
                // if ($word == "@all")
                // {

                //     //don't need duplicate notifications for a comment
                //     return;
                // }
                
                //send notification to one person
                if ($word[0] == '@')
                {
                    $username = substr($word, 1);
                    
                    //found a user
                    if (User::where('name', $username)->count() == 1)
                    {
                        $user = User::where('name', $username)->first();
                        $user->notify(new Mentioned($user));
                    }
                }
            }
        });
    }
}
