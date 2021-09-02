<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParticipant;
use App\Http\Requests\DeleteParticipant;
use App\Http\Requests\GetParticipantId;
use App\Http\Requests\UpdateParticipant;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ParticipantsController extends Controller
{   
    /**
     * Create a new entry of participant
     *
     * @param CreateParticipant $request
     * @return JSON
     */
    public function create(CreateParticipant $request)
    {
        try {
            
            $participant = new Participant();

            $participant->fName = $request->firstName;
            $participant->lName = $request->lastName;
            $participant->phone = $request->phone;
            $participant->note = $request->note;

            $participant->save();

            return response()->json( [
                "success" => "true",
                "participant_id" => $participant->id
            ]);

        } catch (\Exception $e) {

            $error_id = base64_encode(now());
            
            Log::error( "ErrorID: $error_id. Line: " . $e->getLine() . " Details: " . $e->getMessage() ) ;

            $error = ["Error"=> "Something went wrong. Error_Id: $error_id"];

            return response()->json( $error, 500 );

        }
    }

    /**
     * Delete a participant
     *
     * @param DeleteParticipant $request
     * @return JSON
     */
    public function delete(DeleteParticipant $request)
    {
        try {

            Participant::where('id',$request->id)->delete();

            return response()->json( [
                "success" => "true"
            ]);

        } catch (\Exception $e) {

            $error_id = base64_encode(now());
            
            Log::error( "ErrorID: $error_id. Line: " . $e->getLine() . " Details: " . $e->getMessage() ) ;

            $error = ["Error"=> "Something went wrong. Error_Id: $error_id"];

            return response()->json( $error, 500 );

        }
    }

    /**
     * Get a participant by id 
     *
     * @param GetParticipantId $request
     * @return JSON
     */
    public function get(GetParticipantId $request)
    {
        try {
            
            $validated = $request->validated();

            $participant = Participant::find($request->id);

            return response()->json($participant);

        } catch (\Exception $e) {

            $error_id = base64_encode(now());
            
            Log::error( "ErrorID: $error_id. Line: " . $e->getLine() . " Details: " . $e->getMessage() ) ;

            $error = ["Error"=> "Something went wrong. Error id: $error_id"];

            return response()->json( $error, 500 );

        }
    }

    /**
     * Update participants by id
     *
     * @param UpdateParticipant $request
     * @return JSON
     */
    public function update(UpdateParticipant $request)
    {
        try {
            $all = $request->all();
            $updated = Participant::where('id', $request->id)
            ->update([
                "fName" => $request->fName,
                "lName" => $request->lName,
                "phone" => $request->phone,
                "note"  => $request->note
            ]);

            if( $updated ) {
                return response()->json( [
                    "success" => "true"
                ]);
            } else {
                return response()->json( [
                    "success" => "false"
                ]);
            }

        } catch (\Exception $e) {
            
            $error_id = base64_encode(now());
            
            Log::error( "ErrorID: $error_id. Line: " . $e->getLine() . " Details: " . $e->getMessage() ) ;

            $error = ["Error"=> "Something went wrong. Error_Id: $error_id"];

            return response()->json( $error, 500 );

        }
        
    }
}
