<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

class ParticipantsViewController extends Controller
{
    /**
     * Rendering HTML List Participants
     *
     * @return view
     */
    public function show(Request $request)
    {
        $params = $request->all();
        $checked = array_key_exists( "note", $params ) && $params["note"] == "true";

        $participants = Participant::where(function ($query) use ($checked) {
            if($checked)
            {
                $query->whereRaw('note is not null');
            }
        })
        ->paginate(10);

        return view("show", [
            "title"=>"List of Participants",
            "participants" => $participants,
            "checked" => $checked
        ]);
    }
}
