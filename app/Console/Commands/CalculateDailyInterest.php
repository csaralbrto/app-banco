<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\Profile;
use App\Models\Transaction;
use Carbon\Carbon;

class CalculateDailyInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate daily interest for accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now();
        if ($currentDate->isWeekend()) {
            $this->info('Hoy es fin de semana. No se calculan tasas de interés.');
            return;
        }

        $accounts = Account::all();

        foreach ($accounts as $account) {
            $profile = $account->profile;
            $interestRate = $profile->interest_rate;
            $saldo = $account->saldo;

            $interest = $saldo * ($interestRate / 100);
            $newSaldo = $saldo + $interest;


            $account->saldo = $newSaldo;
            $account->save();

            if($account->save()){
                Transaction::create([
                    'tipo' => 'Abono',
                    'monto' => $newSaldo,
                    'id_account' => $account->id,
                    'saldo' => $account->saldo,
                ]);
            }

            $this->info('Tasa de interés calculada para la cuenta: ' . $account->nombre);
        }

        $this->info('Tasas de interés calculadas exitosamente.');
    }
}
