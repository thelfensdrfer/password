<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ImportDictionary extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dict:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the dictionary into the database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $filename = storage_path('dict/german.dic');

        if (!file_exists($filename)) {
            $this->error(sprintf('The dictionary %s does not exist!', $filename));
            exit(1);
        }

        $words = [];

        $linecount = 0;
        $handle = fopen($filename, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $linecount++;
            }
        }

        $bar = $this->output->createProgressBar($linecount);

        $handle = fopen($filename, 'r');
        if ($handle) {
            DB::table('words')->truncate();

            while (($line = fgets($handle)) !== false) {
                $bar->advance();

                // Convert to utf8
                $word = trim(iconv('ISO-8859-1', 'UTF-8', $line));

                // Sort chars for sorted word
                $chars = preg_split('//u', strtolower($word), null, PREG_SPLIT_NO_EMPTY);
                sort($chars);

                DB::table('words')->insert([
                    'word' => $word,
                    'word_sorted' => implode('', $chars),
                ]);
            }

            fclose($handle);
        } else {
            die(sprintf('Could not read file %s!', $filename));
        }

        $this->line('');
    }
}
