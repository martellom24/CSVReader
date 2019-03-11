<?php
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 10/1/18
 * Time: 9:23 PM
 */

main::start("example.csv");

class main  {

    static public function start($filename) {

        $records = csv::getRecords($filename);
        $table = html::generateTable($records);


    }
}

class html {

    public static function generateTable($records) {

        include 'includes/header.html';

        $count = 0;

        // start table
        $html = '<table class="table table-striped border my-5">';

        foreach ($records as $record) {

            if($count == 0) {

                // header row
                $html .= '<thead class="thead-dark"><tr>';

                $array = $record->returnArray();
                $fields = array_keys($array);

                foreach ( $fields as $key=>$values) {
                    $html .= '<th scope="col">' . htmlspecialchars($values) . '</th>';
                }

                $html .= '</tr></thead>';

            } else {
                $array = $record->returnArray();
                $values = array_values($array);
                //print_r($values);
            }
            $count++;
        }

        $html .= '<tbody><tr>';

        foreach( $records as $key=>$value ){



            $array = $value->returnArray();
            $values = array_values($array);

            foreach($values as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }

        }
        $html .= '</tr></tbody>';
        $html .= '</table>';
        echo $html;

        include 'includes/footer.html';
    }
}

class csv {


    static public function getRecords($filename) {

        $file = fopen($filename,"r");

        $fieldNames = array();

        $count = 0;


        while(! feof($file))
        {

            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;

    }

}

class record {

    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }

    }

    public function returnArray() {
        $array = (array) $this;

        return $array;
    }

    public function createProperty($name = 'first', $value = 'keith') {

        $this->{$name} = $value;

    }
}

class recordFactory {

    public static function create(Array $fieldNames = null, Array $values = null) {


        $record = new record($fieldNames, $values);

        return $record;

    }
}














