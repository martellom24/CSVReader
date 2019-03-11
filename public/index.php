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
        $html = '<table class="table table-striped my-5">';

        // header row
        $html .= '<thead class="thead-dark"><tr>';

        foreach ($records as $record) {

            if($count == 0) {

                $array = $record->returnArray();
                $fields = array_keys($array);
                $values = array_values($array);

                $html .= '<th scope="col">' . htmlspecialchars($fields[0]) . '</th>';
                $html .= '<th scope="col">' . htmlspecialchars($fields[1]) . '</th>';
                $html .= '<th scope="col">' . htmlspecialchars($fields[2]) . '</th>';
                $html .= '<th scope="col">' . htmlspecialchars($fields[3]) . '</th>';
                $html .= '<th scope="col">' . htmlspecialchars($fields[4]) . '</th>';

            } else {
                $array = $record->returnArray();
                $values = array_values($array);
                //print_r($values);
            }
            $count++;
        }
        $html .= '</thead></tr>';
        $html .= '<tbody>';

//        foreach ($records as $key) {
//
//            $array = $key->returnArray();
//            $values = array_values($array);
//
//            // print_r($values);
//
//            $html .= '<td>' . htmlspecialchars($values[0]) . '</td>';
//            $html .= '<td>' . htmlspecialchars($values[1]) . '</td>';
//            $html .= '<td>' . htmlspecialchars($values[2]) . '</td>';
//            $html .= '<td>' . htmlspecialchars($values[3]) . '</td>';
//
//        }

        foreach( $records as $key=>$value ){
            $html .= '<tr>';

            $array = $value->returnArray();
            $values = array_values($array);

            foreach($values as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody>';
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














