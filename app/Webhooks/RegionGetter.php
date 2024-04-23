<?php

namespace App\Webhooks;

use Illuminate\Support\Facades\Http;

class RegionGetter
{

  public static function handler(string $leadId, string $phone)
  {

    $responseDadata = Http::withHeaders([
      "Accept" => "application/json",
      "Content-Type" => "application/json",
      "Authorization" => "Token " . config("services.dadata.api_key"),
      "X-Secret" => config("services.dadata.secret_key")
    ])->post("https://cleaner.dadata.ru/api/v1/clean/phone", [
      $phone
    ]);

    switch ($responseDadata->status()) {
      case 429:
        return self::error("Превышино количество запросов в сутки или в секунду", 429);

      case 403:
        return self::error("На аккаунте dadata не достаточно средств");

      case 200:
        Http::post("https://vau.bitrix24.ru/rest/69337/" . config('services.bitrix.rest_key') . '/' . "crm.lead.update", [
          'id' => $leadId,
          'fields' => [
            "UF_CRM_1678353206" => $responseDadata->json()[0]['region'],
          ],
        ]);

        return self::success([
          "region" => $responseDadata->json()[0]['region'],
          "phone" => $responseDadata->json()[0]['phone']
        ]);
    }
  }

  private static function error(string $message)
  {
    return [
      "status" => "error",
      "error_message" => $message,
    ];
  }

  private static function success($data)
  {
    return [
      "status" => "success",
      "data" => $data,
    ];
  }
}
