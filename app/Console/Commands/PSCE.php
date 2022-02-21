<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PSCE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psce:ss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Acme Inc, suitability score';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return bool
     */
    public function handle()
    {
        $addresses_path = $this->ask('What is the address file path?');
        if( !file_exists($addresses_path) )
        {
            $this->error('The file address no exist or the path is incorrect.');
            return false;
        }

        $drivers_path = $this->ask('What is the drivers file path?');
        if( !file_exists($drivers_path) )
        {
            $this->error('The file drivers no exist or the path is incorrect.');
            return false;
        }

        $addresses  = $this->get_content_file($addresses_path);
        $drivers    = $this->get_content_file($drivers_path);

        if( !is_array($drivers) && count($drivers) )
        {
            $this->error('There are no records in the file of drivers.');
            return false;
        }

        if( !is_array($addresses)  && count($addresses))
        {
            $this->error('There are no records in the file of address.');
            return false;
        }

        $send_packages = $this->get_send_packages( $addresses, $drivers);

        if( !is_array($send_packages) && count($send_packages) <= 0 )
            return false;

        foreach ($send_packages as $key => $result)
        {
            $this->line("Driver: ". $key);
            $this->line("Address: ". $result['address']);
            $this->line("------------------------------------------------------");
        }

        return true;
    }

    /**
     * @param $filename
     * @return array
     * Returns an array of the original word and the clean word
     */
    private function get_content_file( $filename )
    {
        setlocale(LC_ALL, 'en_US.utf8');

        $buffer = [];

        if ($file = fopen($filename, "r"))
        {
            while(! feof($file))
            {
                $line = fgets($file);

                if( !empty($line) && strlen($line) > 0)
                {
                    $buffer [] = [
                        'word'          => trim($line),
                        'clean_word'    => $this->clean_string($line)
                    ];
                }
            }

            fclose($file);
        }

        return $buffer;
    }

    /**
     * @param string $string
     * @return string|null
     * Returns the clean string of numbers and special characters
     */
    private function clean_string( string $string )
    {
        $string = strtolower(
            iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$string)
        );

        $string = preg_replace('/[^a-z\-]/', '', $string);

        return $string;
    }

    /**
     * @param array $addresses
     * @param array $drivers
     * @return void
     * Returns the drivers and addresses where the deliveries will be made
     */
    private function get_send_packages( array $addresses , array $drivers)
    {

        $packages_array = [];

        foreach ( $drivers as $key => $driver )
        {
            foreach ( $addresses as $address)
            {
                $packages_array[$driver['word']][] = [
                    'address' => $address['word'],
                    'ss' => $this->get_ss($address['clean_word'],$driver['clean_word'])
                ];
            }

            $value_max = max(array_column($packages_array[$driver['word']], 'ss'));
            $key_item = array_search($value_max,array_column($packages_array[$driver['word']], 'ss'));
            $packages_array[$driver['word']]= $packages_array[$driver['word']][$key_item];
        }

        return $packages_array;
    }

    /**
     * @param string $address
     * @param string $driver
     * @return float|int
     * Return the base suitability score (SS)
     */
    private function get_ss( string $address, string $driver )
    {
        $driver_number_vowels       = $this->get_number_vowels($driver);
        $driver_number_constants    = $this->get_number_constants($driver);
        $address_number_vowels      = $this->get_number_vowels($address);
        $address_number_constants   = $this->get_number_constants($address);

        $ss = ((strlen($address) % 2) == 0) ? $driver_number_vowels  * 1.5 : $driver_number_constants * 1;

        if(
            strlen($address) == strlen($driver) ||
            $address_number_vowels  == $driver_number_vowels ||
            $address_number_constants  == $driver_number_constants
        )
            $ss = $ss + (0.5 * $ss);

        return $ss;
    }

    /**
     * @param string $string
     * @return false|int|null
     * Return the number of vowels in string
     */
    private function get_number_vowels( string $string)
    {
        return preg_match_all('/[aeiou]/i',$string,$matches);
    }

    /**
     * @param string $string
     * @return int
     * Return the number of constants in string
     */
    private function get_number_constants( string $string )
    {
        $consonant = 0;

        for ($i = 0; $i < strlen($string); $i++)
            if ($this->is_consonant($string[$i]))
                ++$consonant;

        return $consonant;
    }

    /**
     * @param string $char
     * @return bool
     * Check if string is consonant
     */
    private function is_consonant(string $char)
    {
        $char = strtoupper($char);

        return !($char == 'A' || $char == 'E' ||
                $char == 'I' || $char == 'O' ||
                $char == 'U') && ord($char) >= 65 && ord($char) <= 90;
    }
}
