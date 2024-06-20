<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->diffForHumans(),
            'updated_at' => optional($this->updated_at)->diffForHumans(),
            'creator_task' => $this->user->name,
            'assigned_to' => $this->assignedUser->name,

        ];
    }
}
