<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class GenerateListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a list of nouns from a dictionary';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $filename = storage_path('list/list.txt');

        if (!file_exists($filename)) {
            die(sprintf('The word list %s does not exist!', $filename));
        }

        $nouns = [];

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

                // Convert to utf-8
                $line = iconv('ISO-8859-1', 'UTF-8', $line);

                // Skip empty lines
                if (strlen(trim($line)) <= 0)
                    continue;

                // Skip comments
                if (substr($line, 0, 1) === '#')
                    continue;

                // Only process nouns
                if (!ctype_upper(substr($line, 0, 1)))
                    continue;

                $word = strtok($line, ' ');

                // Only nouns larger than 10 chars
                if (strlen($word) < 10)
                    continue;

                try {
                    DB::table('words')->insert([
                        'word' => $word,
                    ]);
                } catch (\Exception $e) {
                    //$this->warn(sprintf('Could not insert: %s', $word));
                }
            }

            fclose($handle);
        } else {
            die(sprintf('Could not read file %s!', $filename));
        }

        $this->line('');
    }
}
