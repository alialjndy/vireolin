<?php

namespace App\Http\Controllers;

use App\Models\ServiceBooking;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // #TODO كل الحجوزات فقط للأدمن
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // #TODO أي مستخدم يسطيع أن ينشئ حجز
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceBooking $serviceRequest)
    {
        // #TODO المستخدم يستطيع فقط أن يرى الحجز أو الطلب الخاص به أما الأدمن يستطيع أن يرى كل الطلبات
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceBooking $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceBooking $serviceRequest)
    {
        //
    }
}
