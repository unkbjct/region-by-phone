<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SetBitrixField implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */

  protected $leadId;

  protected $phone;

  public function __construct($leadId, $phone)
  {
    $this->phone = $phone;
    $this->leadId = $leadId;
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $response = Http::get("https://api.regius.name/iface/phone-number.php", [
      'token' => config('services.reqius_name.token'),
      'phone' => $this->phone
    ]);

    $responseBitrix = Http::post("https://vau.bitrix24.ru/rest/69337/" . config('services.bitrix.rest_key') . '/' . "crm.deal.update", [
      'id' => $this->leadId,
      'fields' => [
        "UF_CRM_1678353206" => $response->json()['region'],
      ],
    ]);
    Log::debug($responseBitrix->json());
    Log::debug(time());
  }
}
