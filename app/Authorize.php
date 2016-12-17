<?php

namespace App;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Exception;
class Authorize {
    
    public static function chargeCreditCard($ccNumber, $expirationDate, $cardCode, $amount){
      if(empty(config("authorize.APILoginID"))){
          throw new Exception("The variable 'authorize.APILoginID' must be set.");
      }
      $APILoginID = config("authorize.APILoginID");
      
      if(empty(config("authorize.TransactionKey"))){
          throw new Exception("The variable 'authorize.TransactionKey' must be set.");
      }
      $TransactionKey = config("authorize.TransactionKey");
      
      if(empty(config("authorize.baseURL"))){
          throw new Exception("The variable 'authorize.baseURL' must be set.");
      }
      $baseURL = config("authorize.baseURL");
      // Common setup for API credentials
      $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
      $merchantAuthentication->setName($APILoginID);
      $merchantAuthentication->setTransactionKey($TransactionKey);
      //$refId = 'ref' . time();
      
      // Create the payment data for a credit card
      $creditCard = new AnetAPI\CreditCardType();
      $creditCard->setCardNumber($ccNumber);
      $creditCard->setExpirationDate($expirationDate);
      $creditCard->setCardCode($cardCode);
      $paymentOne = new AnetAPI\PaymentType();
      $paymentOne->setCreditCard($creditCard);

      $order = new AnetAPI\OrderType();
      $order->setDescription("TRPZ purchase");
      
      //create a transaction
      $transactionRequestType = new AnetAPI\TransactionRequestType();
      $transactionRequestType->setTransactionType( "authCaptureTransaction"); 
      $transactionRequestType->setAmount($amount);
      $transactionRequestType->setOrder($order);
      $transactionRequestType->setPayment($paymentOne);
      
      $request = new AnetAPI\CreateTransactionRequest();
      $request->setMerchantAuthentication($merchantAuthentication);
      $request->setTransactionRequest( $transactionRequestType);
      $controller = new AnetController\CreateTransactionController($request);
      $response = $controller->executeWithApiResponse($baseURL);
      $data = [];
      if ($response != null){
        if($response->getMessages()->getResultCode() == "OK"){
          $tresponse = $response->getTransactionResponse();
        
        if ($tresponse != null && $tresponse->getMessages() != null){
            $data = [
                "success"=>true,
                "responseCode"=>$tresponse->getResponseCode(),
                "authCode" => $tresponse->getAuthCode(),
                "transID"=> $tresponse->getTransId(),
                "code"=> $tresponse->getMessages()[0]->getCode(),
                "description"=> $tresponse->getMessages()[0]->getDescription()
            ];
          }else{
            $data = ["success"=>false];
            if($tresponse->getErrors() != null){
                $data["errorCode"] = $tresponse->getErrors()[0]->getErrorCode();
                $data["errorMessage"] = $tresponse->getErrors()[0]->getErrorText();
            }
          }
        }else{
          $data = ["success"=>false];
          $tresponse = $response->getTransactionResponse();
          if($tresponse != null && $tresponse->getErrors() != null){
            $data["errorCode"] = $tresponse->getErrors()[0]->getErrorCode();
            $data["errorMessage"] = $tresponse->getErrors()[0]->getErrorText();
          }else{
            $data["errorCode"] = $response->getMessages()->getMessage()[0]->getCode();
            $data["errorMessage"] = $response->getMessages()->getMessage()[0]->getText();
          }
        }      
      }else{
        $data = ["success"=>false, "errorMessage"=>"No response returned."];
      }
      return $data;
    }
}
