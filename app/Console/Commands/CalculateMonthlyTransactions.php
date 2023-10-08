<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\Profile;
use App\Models\Transfer;
use App\Models\Transaction;
use Carbon\Carbon;

class CalculateMonthlyTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-monthly-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate monthly transactions per accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now();
        $lastMonth = $currentDate->subMonth();
        $startDate = $lastMonth->startOfMonth();
        $endDate = $lastMonth->endOfMonth();

        $accounts = Account::all();

        foreach ($accounts as $account) {
            $profile = $account->profile;
            $interestRate = $profile->interest_rate;
            $saldo = $account->saldo;

            $account_id = $account->id;
            $typeTransaction = ""; 

            $transacciones = Transfer::where('origin_account_id', $account_id)
                ->orWhere('destination_account_id', $account_id)
                ->whereBetween('created_at', [$startDate, $endDate])->count();

            if ($transacciones >= 10) {
                $interestRate += 0.2;
                $typeTransaction = 'Abono';
            } else {
                $interestRate -= 0.2; 
                $typeTransaction = 'Debito';
            }

            $interest = $saldo * ($interestRate / 100);
            $newSaldo = $saldo + $interest;
            $account->saldo = $newSaldo;
            $account->save();

            if($account->save()){
                Transaction::create([
                    'tipo' => $typeTransaction,
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
