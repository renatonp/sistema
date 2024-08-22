<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PagamentoController extends Controller
{
    public function listarDadosPagamento(){
        return View::make('dados_pagamento');
    }

    public function efetuarCobranca(Request $request){
        if($request->product_value == "" || $request->dueDate == "" || $request->description == "" || $request->daysAfterDueDateToRegistrationCancellation == "" || $request->discount_value == "" || $request->dueDateLimitDays == ""){
            $msg="Sua compra não foi realizada por falta de dados do produto. Favor preencher os dados novamente.";
            return View::make('dados_pagamento',compact('msg'));
        }
        else{
            if($request->meio_pagamento=='CreditCard'){
                if($request->card_number == "" || $request->cvv == "" || $request->mes == "" || $request->ano == ""){
                    $msg="Sua compra não foi realizada por falta de dados do Cartão de Crédito. Favor preencher todos os dados.";
                    return View::make('dados_pagamento',compact('msg'));
                }
                else{
                    //Criar nova cobrança
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => json_encode([
                        'billingType' => $request->meio_pagamento,
                        'customer' => $request->customer,
                        'dueDate' => $request->dueDate,
                        'value' => substr($request->product_value,3,strlen($request->product_value)),
                        'description' => $request->description,
                        'daysAfterDueDateToRegistrationCancellation' => $request->daysAfterDueDateToRegistrationCancellation,
                        'externalReference' => $request->externalReference,
                        'discount' => [
                            'value' => substr($request->product_value,-1),
                            'dueDateLimitDays' => $request->dueDateLimitDays
                        ],
                        'fine' => [
                            'value' => $request->fine_value
                        ],
                        'interest' => [
                            'value' => $request->interest_value
                        ],
                        'postalService' => false
                      ]),
                      CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "content-type: application/json"
                      ],
                    ]);
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    
                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      echo $response;
                    }

                    //Criar cobrança com cartão de crédito
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => json_encode([
                        'customer' => $request->customer,
                        'billingType' => 'CREDIT_CARD',
                        'dueDate' => $request->dueDate,
                        'value' => substr($request->product_value,3,strlen($request->product_value)),
                        'description' => $request->description,
                        'externalReference' => $request->externalReference,
                        'creditCard' => [
                            'holderName' => 'john doe',
                            'number' => $request->card_number,
                            'expiryMonth' => $request->mes,
                            'expiryYear' => $request-> ano,
                            'ccv' => $request->cvv
                        ],
                        'creditCardHolderInfo' => [
                            'name' => 'John Doe',
                            'email' => 'john.doe@asaas.com.br',
                            'cpfCnpj' => '24971563792',
                            'postalCode' => '89223-005',
                            'addressNumber' => '277',
                            'addressComplement' => null,
                            'phone' => '',
                            'mobilePhone' => ''
                        ]
                      ]),
                      CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "content-type: application/json"
                      ],
                    ]);
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    
                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      echo $response;
                    }
                    
                    //Pagar uma cobrança com cartão de crédito
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/id/payWithCreditCard",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => json_encode([
                        'creditCard' => [
                            'holderName' => 'john doe',
                            'number' => $request->card_number,
                            'expiryMonth' => $request->mes,
                            'expiryYear' => $request-> ano,
                            'ccv' => $request->cvv
                        ],
                        'creditCardHolderInfo' => [
                            'name' => 'John Doe',
                            'email' => 'john.doe@asaas.com.br',
                            'cpfCnpj' => '24971563792',
                            'postalCode' => '89223-005',
                            'addressNumber' => '277',
                            'addressComplement' => null,
                            'phone' => '',
                            'mobilePhone' => ''
                        ]
                      ]),
                      CURLOPT_HTTPHEADER => [
                        "accept: application/json",
                        "content-type: application/json"
                      ],
                    ]);
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    
                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      echo $response;
                    }
                }
            }
            else{
              if($request->meio_pagamento=='BOLETO'){
                  //Obter linha digitável do boleto
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/id/identificationField",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => [
                          "accept: application/json"
                        ],
                      ]);
                      
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                      
                    curl_close($curl);
                      
                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      return View::make('obrigado',compact('response'));
                    }
                }
                if($request->meio_pagamento=='PIX'){
                    //Obter QR Code para pagamentos via Pix
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://sandbox.asaas.com/api/v3/payments/id/pixQrCode",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => [
                        "accept: application/json"
                      ],
                    ]);
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    
                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      return View::make('obrigado',compact('response'));
                    }
                }
            }
       }
    }
}