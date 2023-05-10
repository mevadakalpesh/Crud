<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CsvData;
class ImportCsvDataJob implements ShouldQueue
{
  use Batchable,Dispatchable,
  InteractsWithQueue,
  Queueable,
  SerializesModels;
  protected $header,
  $data;
  /**
  * Create a new job instance.
  */
  public function __construct($header, $data) {
    $this->header = $header;
    $this->data = $data;
  }

  /**
  * Execute the job.
  */
  public function handle(): void
  {
    if (!blank($this->data)) {
      $saveAbleData = array_chunk($this->data, 50);
      foreach ($saveAbleData as $key => $value) {
        if (!blank($value)) {
          foreach ($value as $key1 => $value2) {
            $keyPair = array_combine($this->header, $value2);
            CsvData::create($keyPair);
          }
        }
      }
    }
  }
}