<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ResponseResource",
 *     description="ResponseResource",
 *     @OA\Xml(
 *         name="ResponseResource"
 *     )
 * )
 */
class ResponseResource extends JsonResource
{

    // definisikan properti
    public $status;
    public $message;

    public function __construct($status, $message, $resource){
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
            ],
            'success'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource
        ];
    }
}
