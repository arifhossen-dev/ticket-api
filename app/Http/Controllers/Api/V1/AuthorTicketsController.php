<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends Controller
{
    use ApiResponses;

    public function index($authorId, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::whereUserId($authorId)->filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($authorId, StoreTicketRequest $request)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $authorId,
        ];

        return new TicketResource(Ticket::create($model));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($authorId, $ticketId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            if ($ticket->user_id == $authorId) {
                $ticket->delete();
                return $this->ok('Ticket successfully deleted.');
            }

            return $this->error('Ticket cannot be found.', 404);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }

}
