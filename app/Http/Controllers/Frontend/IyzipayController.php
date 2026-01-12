<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IyzipayController extends Controller
{
    public function Iyzipay() {
        if(Auth::check()) {
            return view('frontend.iyzipay.iyzipay');
        }
        else {
            return redirect()->back();
        }
    }

    public function Pay() {

        $options = new \Iyzipay\Options();
        $options->setApiKey("sandbox-zazVk3YQIcwv8XR8GcSDd6rSz6VRvaAl");
        $options->setSecretKey("sandbox-MYpnA7pBC2oBRQ7qVaoOeue3W6tcvGXH");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");


        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setPrice("50");
        $request->setPaidPrice("50");
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setBasketId("B67832");
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl("https://www.merchant.com/callback");
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");

        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("50");
        $basketItems[0] = $firstBasketItem;

        // $secondBasketItem = new \Iyzipay\Model\BasketItem();
        // $secondBasketItem->setId("BI102");
        // $secondBasketItem->setName("Game code");
        // $secondBasketItem->setCategory1("Game");
        // $secondBasketItem->setCategory2("Online Game Items");
        // $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        // $secondBasketItem->setPrice("0.5");

        // $basketItems[1] = $secondBasketItem;
        // $thirdBasketItem = new \Iyzipay\Model\BasketItem();
        // $thirdBasketItem->setId("BI103");
        // $thirdBasketItem->setName("Usb");
        // $thirdBasketItem->setCategory1("Electronics");
        // $thirdBasketItem->setCategory2("Usb / Cable");
        // $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        // $thirdBasketItem->setPrice("0.2");
        // $basketItems[2] = $thirdBasketItem;
        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

        //print_r($checkoutFormInitialize->getStatus()); 
        //print_r($checkoutFormInitialize->getErrorMessage());

        print_r($checkoutFormInitialize->getCheckoutFormContent());
       
        

        //$paymentResponse = (array)$checkoutFormInitialize;

        //echo "<pre>"; print_r($checkoutFormInitialize); die;

        //foreach($paymentResponse as $key => $response) {
            //$response_decode = json_decode($response);
            //return redirect($response);

            //echo "<pre>"; print_r($response_decode); die;

        //}

    }
}
