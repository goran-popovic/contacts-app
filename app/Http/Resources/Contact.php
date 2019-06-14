<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Contact as ContactModel;

class Contact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($request->isMethod('delete')) {
            $group_id = $this->group_id;
            $group_name = $this->group_name;
        } else {
            $group = ContactModel::find($this->id)->group;
            $group_id = $group->id;
            $group_name = $group->name;
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'city' => $this->city,
            'zip' => $this->zip,
            'country' => $this->country,
            'email' => $this->email,
            'phone' => $this->phone,
            'note' => $this->note,
            'group_name' => $group_name,
            'group_id' => $group_id,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at,
        ];

    }
}
