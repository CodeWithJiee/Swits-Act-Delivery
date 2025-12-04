<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Delivery;
use Validator;
use App\Http\Resources\DeliveryResource;

class DeliveryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::all();

        return $this->sendResponse(DeliveryResource::collection($deliveries), 'Deliveries retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'store_id' => 'nullable|integer',
            'rider_id' => 'nullable|integer',
            'pickup_address' => 'required|string|max:255',
            'dropoff_address' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,accepted,picked_up,in_transit,delivered,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $delivery = Delivery::create($input);

        return $this->sendResponse(new DeliveryResource($delivery), 'Delivery created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        return $this->sendResponse(new DeliveryResource($delivery), 'Delivery retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'store_id' => 'nullable|integer',
            'rider_id' => 'nullable|integer',
            'pickup_address' => 'sometimes|required|string|max:255',
            'dropoff_address' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'status' => 'nullable|in:pending,accepted,picked_up,in_transit,delivered,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $delivery->update($input);

        return $this->sendResponse(new DeliveryResource($delivery), 'Delivery updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        $delivery->delete();

        return $this->sendResponse([], 'Delivery deleted successfully.');
    }

    /**
     * Update delivery status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,accepted,picked_up,in_transit,delivered,cancelled'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $delivery->status = $request->status;
        $delivery->save();

        return $this->sendResponse(new DeliveryResource($delivery), 'Delivery status updated successfully.');
    }

    /**
     * Update payment status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:unpaid,paid'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $delivery->payment_status = $request->payment_status;
        $delivery->save();

        return $this->sendResponse(new DeliveryResource($delivery), 'Payment status updated successfully.');
    }

    /**
     * Assign a rider to the delivery.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignRider(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (is_null($delivery)) {
            return $this->sendError('Delivery not found.');
        }

        $validator = Validator::make($request->all(), [
            'rider_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $delivery->rider_id = $request->rider_id;
        $delivery->status = 'accepted';
        $delivery->save();

        return $this->sendResponse(new DeliveryResource($delivery), 'Rider assigned successfully.');
    }

    /**
     * Get deliveries by store.
     *
     * @param  int  $storeId
     * @return \Illuminate\Http\Response
     */
    public function getByStore($storeId)
    {
        $deliveries = Delivery::where('store_id', $storeId)->get();

        return $this->sendResponse(DeliveryResource::collection($deliveries), 'Store deliveries retrieved successfully.');
    }

    /**
     * Get deliveries by rider.
     *
     * @param  int  $riderId
     * @return \Illuminate\Http\Response
     */
    public function getByRider($riderId)
    {
        $deliveries = Delivery::where('rider_id', $riderId)->get();

        return $this->sendResponse(DeliveryResource::collection($deliveries), 'Rider deliveries retrieved successfully.');
    }
}