<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Capsule\Manager as Capsule;

class DbDataTransNkToXunRui extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voc:external-data-nk-to-xr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Db data trans NiuKe question to XunRuiCms plugin question format';

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
     *
     * @param Capsule $capsule
     *
     * @return int
     */
    public function handle()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1:33055',
            'database'  => 'question_a',
            'username'  => 'root',
            'password'  => '123456',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();

        Capsule::table('x2_questions_0')->orderBy('questionid')->chunk(100, function ($questions) {
            $batchDstValue = [];

            foreach ($questions as $question) {

                $tid = self::getTid($question->questiontype, $question->questionanswer);

                $value = [];
                if ($question->questionselectnumber > 0) {
                    $options = explode('<hr />', $question->questionselect);
                    if ($options) {
                        foreach ($options as $idx => $option) {
                            $value[$idx + 1] = $option;
                        }
                        $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }
                }
                $value = $value ?: '';

                $answer = self::getAnswerTrans($question->questionanswer);

                $dstValue = [
                    'cids' => '',
                    'catid' => 0,
                    'tid' => $tid,
                    'title' => $question->question,
                    'value' => $value,
                    'tips' => $question->questionintro,
                    'answer' => $answer,
                    'inputtime' => $question->questiontime ?: time(),
                ];

                $batchDstValue[] = $dstValue;
                // Capsule::table('dr_1_kaoshi_question')->insert($dstValue);
            }

            Capsule::table('dr_1_kaoshi_question')->insert($batchDstValue);
        });

        $this->info("Done\n");

        return 0;
    }

    public function getTid($questionType, $questionAnswer)
    {
        switch ($questionType) {
            // 单选题
            case 'DXT':
                return 1;
                break;
            // 多选题
            case 'MDXT':
                return 2;
                break;
            // 判断题
            case 'PDT':
                return 3;
                break;
            // 简答题
            case 'WDT':
                return 5;
            default:
                break;
        }

        // 答案大于1个，为多选
        if (mb_strlen($questionAnswer) > 1) {
            return 2;
        } else {
            return 1;
        }
    }

    public function getAnswerTrans($answer)
    {
        $map = [
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
            'E' => 5,
            'F' => 6,
            'G' => 7,
            'H' => 8,
            'I' => 9,
            'J' => 10,
            'K' => 11,
        ];

        if (! $answer) {
            return '';
        }

        if (($answerLen = mb_strlen($answer)) > 1) {
            $list = [];

            for ($i = 0; $i < $answerLen; $i++) {
                $option = $answer[$i];
                if (isset($map[$option])) {
                    $list[] = strval($map[$option]);
                }
            }

            return $list ? json_encode($list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '';
        } else {
            return $map[$answer] ?? '';
        }
    }
}
