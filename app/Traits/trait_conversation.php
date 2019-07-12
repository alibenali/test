<?php

namespace App\Traits;
use App\Conversation;
use App\Message;
use App\Payment;

trait trait_conversation {

	public function store_conversation($user_id, $service_id, $payment_id)
	{
    	$conversation = new Conversation;

    	$conversation->user_id = $user_id;
    	$conversation->service_id = $service_id;
    	$conversation->payment_id = $payment_id;
		$conversation->the_status = "open";

    	$conversation->save();

        $payment = Payment::where('id', $conversation->payment_id)->first();
        $payment->conversation_id = $conversation->id;
        $payment->save();

        // Create new mesasge
        $message = new Message;
        $message->user_id = 0;
        $message->conversation_id = $conversation->id;
        $message->content = "Payment has been created, we will respond to your payment in the coming 24 hours";
        $message->save();

    	return header("Location: conversation/".$conversation->id."");


    }

}