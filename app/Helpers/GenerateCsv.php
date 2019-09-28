<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Response;
use League\Csv\Reader;
use League\Csv\Writer;

class GenerateCsv {

    public static function createCsv($entry,$nextdate = ""){
            if($nextdate == ""){
                $nextdate = date('d-m-Y');
            }
            $columns = array('#', 'Case Number', 'Next Date', 'Complainant Name', 'Coram', 'Stage', 'Client');
            $count = 0;
            foreach ($entry as $key => $value) {
                $count++;
                $data[] = array($count, ($value->cases) ? $value->cases->case_number : 'N/A', ($value->next_date) ? $value->next_date : 'N/A', ($value->cases) ? $value->cases->complainant_name : 'N/A', ($value->coram) ? $value->coram : 'N/A', ($value->stage) ? $value->stage : 'N/A', ($value->cases->client) ? $value->cases->client->name : 'N/A');
            }

            $file_name = 'Case-' . $nextdate . ".csv";
            $path = public_path('csv/entries/');
            $writer = Writer::createFromPath($path . $file_name, "w");
            $writer->insertOne($columns);
            $writer->insertAll($data);
            $paths['file'] = asset('csv/entries/'.$file_name);
            $paths['delete'] = 'csv/entries/'.$file_name;
            return $paths;

    }
}

?>
