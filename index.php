<?php

require_once "./vendor/autoload.php";

use Debenture\Helpers\Investment;
use Carbon\Carbon;

$now = Carbon::now();

$interest = 1.1;
$correction = 0.10;

$investment = [
    'value'=>  20058.67,
    'date'=> new Carbon('2017-07-31'),
    'months'=> 24
];

$listMonths = []; 

for($counter = 0;$counter < $investment['months'];$counter++){
    
    if($counter == 0){//a data inicial é baseada na data o investimento
        
        $listMonths[] = [
            'date'=> $investment['date']->toDateString(),
            'value'=> $investment['value'],
            'interest'=> Investment::interest($investment['value'], $interest, 0),
            'correction'=> 0,
            'value_final'=> Investment::calculate($investment['value'], $interest, 0)
        ];
        continue;
        
    }else if($counter == 1){//a data do segundo registro é o último dia do mês seguinte
        
        $lastItem = $listMonths[$counter - 1];
        $nextDate = new Carbon($lastItem['date']);
        $nextDate->addMonth();
        $nextDate->endOfMonth();
    
        $listMonths[] = [
            'date'=> $nextDate->toDateString(),
            'value'=> $lastItem['value_final'],
            'interest'=> Investment::interest($lastItem['value_final'], $interest, 0),
            'correction'=> 0,
            'value_final'=> Investment::calculate($lastItem['value_final'], $interest, 0)
        ];
        continue;
        
    }
    
    //as dastas subsequentes seguirão 30 dias após o registro anterior
    $lastItem = $listMonths[$counter - 1];
    $nextDate = new Carbon($lastItem['date']);
    $nextDate->addDays(30);

    $listMonths[] = [
        'date'=> $nextDate->toDateString(),
        'value'=> $lastItem['value_final'],
        'interest'=> Investment::interest($lastItem['value_final'], $interest, 0),
        'correction'=> 0,
        'value_final'=> Investment::calculate($lastItem['value_final'], $interest, 0)
    ];
    
}

echo "<pre>";
print_r($listMonths);